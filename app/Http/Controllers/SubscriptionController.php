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
    public function index()
    {
        $user = Auth::user();
        if (!$user || !isset($user->tenant_id)) {
            // Manejo de error: usuario no autenticado o sin tenant_id
            return response()->json(['error' => 'Usuario no autenticado o sin tenant_id'], 401);
        }
        $tenant = Tenant::find($user->tenant_id);

        $currentSubscription = $tenant?->activeSubscription();

        return view('subscriptions.index', [
            'tenant' => $tenant,
            'currentSubscription' => $currentSubscription,
            'currentPlan' => $tenant?->getPlanInfo() ?? ['plan' => 'free', 'name' => 'Gratuito']
        ]);
    }

    /**
     * Start checkout process
     */
    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'plan' => 'required|in:free,starter,professional,enterprise',
        ]);

        $user = Auth::user();
        $tenant = Tenant::find($user->tenant_id);

        if (!$tenant) {
            return redirect()->back()->with('error', 'No tienes un tenant asociado');
        }

        // Si es plan free, solo actualizar
        if ($validated['plan'] === 'free') {
            $tenant->subscriptions()->updateOrCreate(
                ['plan' => 'free'],
                [
                    'status' => 'active',
                    'started_at' => now(),
                    'trial_ends_at' => now()->addDays(30),
                ]
            );
            return redirect()->route('subscriptions.index')->with('success', 'Plan actualizado a Gratuito');
        }

        // Lógica de precios por plan
        $planPrices = [
            'starter' => 1000,
            'professional' => 2500,
            'enterprise' => 5000,
        ];
        $planName = ucfirst($validated['plan']);
        $price = $planPrices[$validated['plan']] ?? 0;

        // Crear preferencia MercadoPago
        $preference = $this->mercadoPagoService->createPreference(
            $planName,
            $price,
            $user->email
        );

        if (isset($preference['init_point'])) {
            // Redirigir al checkout de MercadoPago en modo sandbox
            if (isset($preference['sandbox_init_point'])) {
                return redirect($preference['sandbox_init_point']);
            }
            return redirect($preference['init_point']);
        } else {
            return redirect()->back()->with('error', 'No se pudo iniciar el pago.');
        }
    }

    /**
     * Handle successful subscription
     */
    public function success(Request $request)
    {
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

        $subscription->cancel();

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
