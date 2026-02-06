<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Services\StripeService;
use App\Services\MercadoPagoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function __construct(
        private StripeService $stripeService,
        private MercadoPagoService $mercadoPagoService
    ) {}

    /**
     * Show available plans
     */
    public function index()
    {
        $user = Auth::user();
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
                    'billing_cycle_days' => 30,
                ]
            );
            return redirect()->route('subscriptions.index')->with('success', 'Plan actualizado');
        }

        // Para otros planes, usar Stripe
        if (!$this->stripeService->isConfigured()) {
            return back()->with('error', 'Sistema de pagos no está configurado. Por favor, contacta al administrador.');
        }

        $successUrl = route('subscriptions.success', ['plan' => $validated['plan']]) . '?session_id={CHECKOUT_SESSION_ID}';
        $cancelUrl = route('subscriptions.index');

        return $this->stripeService->createCheckoutSession($tenant, $validated['plan'], $successUrl, $cancelUrl);
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

        if ($subscription->payment_method === 'stripe') {
            $this->stripeService->cancelSubscription($subscription);
        } else {
            $subscription->cancel();
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
