<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Services\MercadoPagoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function __construct(
        private MercadoPagoService $mercadoPagoService
    ) {}

    /**
     * Handle failed subscription (MercadoPago)
     */
    public function failure()
    {
        return view('subscriptions.failure');
    }

    /**
     * Show available plans
     */
    public function index(Request $request)
    {
        $this->mercadoPagoService->syncFromCheckoutReturn($request);

        $user = Auth::user();
        if ($user->isAdmin()) {
            $tenants = Tenant::with('subscription')->get();
            return view('subscriptions.index', [
                'tenants' => $tenants,
                'adminView' => true
            ]);
        }
        if (!$user || !isset($user->tenant_id)) {
            return response()->json(['error' => 'Usuario no autenticado o sin tenant_id'], 401);
        }
        $tenant = Tenant::find($user->tenant_id);
        $currentSubscription = $tenant?->activeSubscription();
        return view('subscriptions.index', [
            'tenant' => $tenant,
            'currentSubscription' => $currentSubscription,
            'currentPlan' => $tenant?->getPlanInfo() ?? ['plan' => 'free', 'name' => 'Gratuito'],
            'adminView' => false
        ]);
    }

    /**
     * Start checkout process
     */
    public function checkout(Request $request)
    {
        // 1. Validamos con tus 4 planes reales
        $validated = $request->validate([
            'plan' => 'required|in:basico,profesional,premium,premium_plus,test100',
        ]);

        $user = Auth::user();
        $tenant = Tenant::find($user->tenant_id);

        if (!$tenant) {
            return redirect()->back()->with('error', 'No tienes un tenant asociado');
        }

        // 2. Obtenemos los detalles directamente del Service para no repetir precios
        $planDetails = $this->mercadoPagoService->getPlanDetails($validated['plan']);
        $price = $planDetails['price'];

        // 3. Crear preferencia MercadoPago
        $preference = $this->mercadoPagoService->createPreference(
            $validated['plan'],
            $price,
            $user->email
        );

        if (isset($preference['init_point'])) {
            // Recordá que config('app.env') en tu .env dice 'local', así que esto te mandará a sandbox en tu PC
            if (config('app.env') === 'local' && isset($preference['sandbox_init_point'])) {
                return redirect()->to($preference['sandbox_init_point']);
            }
            return redirect()->to($preference['init_point']);
        }

        $errorMessage = $preference['error'] ?? 'No se pudo iniciar el pago.';

        return redirect()->back()->with('error', $errorMessage);
    }

    /**
     * Adherir una suscripción activa de MercadoPago a renovación automática (PreApproval)
     */
    public function enableAutoRenew()
    {
        $user = Auth::user();
        $tenant = Tenant::find($user->tenant_id);

        if (!$tenant) {
            return redirect()->route('subscriptions.billing')
                ->with('error', 'No tienes un tenant asociado.');
        }

        $subscription = $tenant->subscription;

        if (!$subscription || !$subscription->isActive()) {
            return redirect()->route('subscriptions.billing')
                ->with('error', 'No tienes una suscripción activa para adherir a renovación automática.');
        }

        if ($subscription->payment_method !== 'mercadopago') {
            return redirect()->route('subscriptions.billing')
                ->with('error', 'La adhesión automática solo aplica a suscripciones de Mercado Pago.');
        }

        if (!$subscription->current_period_end || !$subscription->current_period_end->isFuture()) {
            return redirect()->route('subscriptions.billing')
                ->with('error', 'No se pudo adherir automáticamente sin riesgo de doble cobro porque el período actual no está vigente. Contacta soporte para activarlo de forma segura.');
        }

        $hasAutoRenewEnabled = !empty($subscription->mercadopago_id)
            && !is_numeric((string) $subscription->mercadopago_id)
            && $subscription->status === 'active'
            && in_array((string) $subscription->mercadopago_status, ['authorized', 'pending_auto_renew'], true);

        if ($hasAutoRenewEnabled) {
            return redirect()->route('subscriptions.billing')
                ->with('success', 'Tu renovación automática ya está activa.');
        }

        $plan = (string) ($subscription->plan ?: 'basico');
        $planDetails = $this->mercadoPagoService->getPlanDetails($plan);
        $amount = (float) ($subscription->amount ?: $planDetails['price']);

        $startAt = $subscription->current_period_end->copy()->addMinutes(5);

        $preference = $this->mercadoPagoService->createPreference(
            $plan,
            $amount,
            $user->email,
            $startAt
        );

        if (isset($preference['init_point'])) {
            return redirect()->to($preference['init_point']);
        }

        return redirect()->route('subscriptions.billing')
            ->with('error', $preference['error'] ?? 'No se pudo iniciar la adhesión a renovación automática.');
    }
    /**
     * Handle successful subscription
     */
    public function success(Request $request)
    {
        $this->mercadoPagoService->syncFromCheckoutReturn($request);

        return view('subscriptions.success');
    }

    /**
     * Handle canceled subscription
     */
    public function cancel()
    {
        return view('subscriptions.cancel');
    }

    /**
     * Handle pending subscription (MercadoPago)
     */
    public function pending()
    {
        return view('subscriptions.pending');
    }

    /**
     * Pantalla de pago rechazado con motivo y reintento
     */
    public function rejected()
    {
        $user = Auth::user();
        $tenant = Tenant::find($user->tenant_id);
        $subscription = $tenant?->subscriptions()->latest('updated_at')->first();
        $lastFailedInvoice = $tenant?->invoices()
            ->where('status', 'failed')
            ->latest()
            ->first();

        $reason = $lastFailedInvoice?->notes;

        if (!$reason && $subscription) {
            $mpStatus = (string) $subscription->mercadopago_status;
            if (str_starts_with($mpStatus, 'paused:')) {
                $reason = trim(str_replace('paused:', '', $mpStatus));
            } elseif (str_starts_with($mpStatus, 'rejected:')) {
                $reason = trim(str_replace('rejected:', '', $mpStatus));
            }
        }

        return view('subscriptions.rejected', [
            'tenant' => $tenant,
            'subscription' => $subscription,
            'reason' => $reason ?: 'No se pudo renovar tu suscripción.',
        ]);
    }

    /**
     * Reintentar cobro con el último plan contratado
     */
    public function retry()
    {
        $user = Auth::user();
        $tenant = Tenant::find($user->tenant_id);

        if (!$tenant) {
            return redirect()->route('subscriptions.index')->with('error', 'No tienes un tenant asociado');
        }

        $subscription = $tenant->subscriptions()->latest('updated_at')->first();
        $plan = $subscription?->plan ?: 'basico';
        $planDetails = $this->mercadoPagoService->getPlanDetails($plan);

        $preference = $this->mercadoPagoService->createPreference(
            $plan,
            $planDetails['price'],
            $user->email
        );

        if (isset($preference['init_point'])) {
            return redirect()->to($preference['init_point']);
        }

        return redirect()->route('subscriptions.rejected')
            ->with('error', $preference['error'] ?? 'No se pudo iniciar el reintento de pago.');
    }

    /**
     * Cancel current subscription
     */
    public function destroy()
    {
        $user = Auth::user();
        $tenant = Tenant::find($user->tenant_id);

        $subscription = $tenant?->subscription;

        if (!$subscription) {
            return redirect()->back()->with('error', 'No tienes una suscripción activa');
        }

        try {
            if ($subscription->payment_method === 'mercadopago') {
                $this->mercadoPagoService->cancelSubscription($subscription);
            } else {
                $subscription->cancel();
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'No se pudo cancelar en Mercado Pago: ' . $e->getMessage());
        }

        return redirect()->route('subscriptions.index')
            ->with('success', 'Suscripción cancelada correctamente');
    }

    /**
     * Show billing history
     */
    public function billing()
    {
        $user = Auth::user();
        $tenant = Tenant::find($user->tenant_id);

        $invoices = $tenant?->invoices()->latest()->paginate(20);
        $subscription = $tenant?->subscription;

        return view('subscriptions.billing', compact('invoices', 'subscription', 'tenant'));
    }
}
