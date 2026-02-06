<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Domain;
use App\Models\Tenant;

class IdentifyTenant
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        file_put_contents(storage_path('logs/google-callback.log'), "IdentifyTenant START - Path: {$request->getPathInfo()}\n", FILE_APPEND);
        
        // Excluir rutas de autenticación y callbacks
        $path = $request->getPathInfo();
        if (in_array($path, ['/auth/google', '/auth/google/callback', '/login', '/register', '/logout', '/password/reset', '/password/forgot', '/subscriptions', '/webhooks'])) {
            file_put_contents(storage_path('logs/google-callback.log'), "IdentifyTenant: Ruta exacta excluida\n", FILE_APPEND);
            return $next($request);
        }
        if (str_starts_with($path, '/auth/') || str_starts_with($path, '/password/') || str_starts_with($path, '/subscriptions') || str_starts_with($path, '/webhooks')) {
            file_put_contents(storage_path('logs/google-callback.log'), "IdentifyTenant: Ruta con prefijo excluida\n", FILE_APPEND);
            return $next($request);
        }

        file_put_contents(storage_path('logs/google-callback.log'), "IdentifyTenant: Procesando normalmente\n", FILE_APPEND);

        // Obtener el host actual (dominio)
        $host = $request->getHost();
        
        // Dominios centrales (sin tenant)
        $centralDomains = config('tenancy.central_domains', []);
        
        // Si es un dominio central, permitir acceso sin tenant
        if (in_array($host, $centralDomains)) {
            return $next($request);
        }

        // Buscar el tenant por dominio
        $domain = Domain::where('domain', $host)->first();

        if (!$domain) {
            // Si es localhost o IP, permitir para desarrollo
            if ($host === 'localhost' || $host === '127.0.0.1') {
                return $next($request);
            }
            
            abort(404, 'Agencia no encontrada');
        }

        // Obtener el tenant
        $tenant = Tenant::find($domain->tenant_id);

        if (!$tenant || !$tenant->is_active) {
            abort(403, 'Esta agencia no está activa');
        }

        // Guardar el tenant en la aplicación
        app()->instance('tenant', $tenant);

        // Si el usuario está autenticado, verificar que pertenezca a este tenant
        if (Auth::check()) {
            if (Auth::user()->tenant_id !== $tenant->id) {
                Auth::logout();
                abort(403, 'No tienes acceso a esta agencia');
            }
        }

        return $next($request);
    }
}
