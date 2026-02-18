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
        $planName = $planDetails['name'];

        // 3. Crear preferencia MercadoPago
        $preference = $this->mercadoPagoService->createPreference(
            $planName,
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

        return redirect()->back()->with('error', 'No se pudo iniciar el pago.');
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
