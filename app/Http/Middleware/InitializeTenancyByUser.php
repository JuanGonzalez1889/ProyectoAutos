<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InitializeTenancyByUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Excluir rutas de autenticación
        $path = $request->getPathInfo();
        if (str_starts_with($path, '/auth/') || str_starts_with($path, '/login') || str_starts_with($path, '/register') || 
            str_starts_with($path, '/logout') || str_starts_with($path, '/password/') || str_starts_with($path, '/subscriptions') ||
            str_starts_with($path, '/webhooks')) {
            return $next($request);
        }

        // Si el usuario está autenticado y tiene un tenant_id, inicializar el tenant
        if (Auth::check() && Auth::user()->tenant_id) {
            try {
                tenancy()->initialize(Auth::user()->tenant_id);
            } catch (\Exception $e) {
                \Log::error('InitializeTenancyByUser: Failed to initialize tenancy', [
                    'user_id' => Auth::id(),
                    'tenant_id' => Auth::user()->tenant_id,
                    'error' => $e->getMessage()
                ]);
                // Continuar sin inicializar tenancy para no romper el flujo
            }
        }

        return $next($request);
    }
}
