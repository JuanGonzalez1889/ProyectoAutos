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
        $mainDomain = 'autowebpro.com.ar';
        
        // Si es un dominio central o el dominio principal, permitir acceso completo
        if (in_array($host, $centralDomains) || $host === $mainDomain) {
            return $next($request);
        }

        // SUBDOMINIOS: solo rutas públicas permitidas
        $domain = Domain::where('domain', $host)->first();
        if (!$domain) {
            // Si es localhost o IP, permitir para desarrollo
            if ($host === 'localhost' || $host === '127.0.0.1') {
                return $next($request);
            }
            abort(404, 'Agencia no encontrada');
        }
        $tenant = Tenant::find($domain->tenant_id);
        if (!$tenant || !$tenant->is_active) {
            abort(403, 'Esta agencia no está activa');
        }
        app()->instance('tenant', $tenant);

        // Solo permitir rutas públicas en subdominios
        $publicPaths = ['/','/agencia','/agencia-preview','/contacto','/vehiculos','/newsletter','/precios','/nosotros','/proximamente'];
        $isPublic = false;
        foreach ($publicPaths as $p) {
            if (str_starts_with($path, $p)) {
                $isPublic = true;
                break;
            }
        }
        if ($isPublic) {
            return $next($request);
        }
        // Si no es ruta pública, bloquear acceso
        abort(403, 'Solo rutas públicas permitidas en subdominios');
    }
}
