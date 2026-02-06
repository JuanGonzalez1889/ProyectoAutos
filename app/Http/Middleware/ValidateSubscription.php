<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateSubscription
{
    /**
     * Rutas excluidas de validación de suscripción
     */
    protected $except = [
        'login',
        'register',
        'password/*',
        'auth/google',
        'auth/google/callback',
        'logout',
        'subscriptions/*',
        'webhooks/*',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Excluir rutas específicas
        foreach ($this->except as $pattern) {
            if ($request->is($pattern)) {
                file_put_contents(storage_path('logs/google-callback.log'), "ValidateSubscription: Ruta excluida: {$request->path()}\n", FILE_APPEND);
                return $next($request);
            }
        }

        // Si no está autenticado, dejar pasar (login lo redirigirá)
        if (!auth()->check()) {
            file_put_contents(storage_path('logs/google-callback.log'), "ValidateSubscription: Usuario no autenticado\n", FILE_APPEND);
            return $next($request);
        }

        $user = auth()->user();
        $tenant = $user->tenant;

        // Si no tiene tenant, bloquear
        if (!$tenant) {
            return redirect()->route('login')->with('error', 'No tienes un tenant asociado');
        }

        // Obtener suscripción del tenant
        $subscription = $tenant->subscriptions()->latest()->first();

        // Si NO tiene suscripción, crear una FREE con 30 días de trial
        if (!$subscription) {
            $subscription = $tenant->subscriptions()->create([
                'plan' => 'free',
                'status' => 'active',
                'payment_method' => 'none',
                'amount' => 0,
                'currency' => 'USD',
                'current_period_start' => now(),
                'current_period_end' => now()->addDays(30),
                'trial_ends_at' => now()->addDays(30),
            ]);
        }

        // Verificar si la suscripción está activa O en trial
        if (!$subscription->isActive() && !$subscription->onTrial()) {
            // Si fue cancelada
            if ($subscription->canceled()) {
                return redirect()->route('subscriptions.upgrade')
                    ->with('error', 'Tu suscripción fue cancelada. Renuévala para continuar.');
            }
            
            // Si expiró
            return redirect()->route('subscriptions.upgrade')
                ->with('error', 'Tu suscripción ha expirado. Actualiza tu plan para continuar.');
        }

        // Pasar la suscripción al request
        $request->subscription = $subscription;

        return $next($request);
    }
}
