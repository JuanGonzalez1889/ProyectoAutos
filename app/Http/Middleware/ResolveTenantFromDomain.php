<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Domain;
use Illuminate\Support\Facades\Session;

class ResolveTenantFromDomain
{
    public function handle(Request $request, Closure $next)
    {
        $host = $request->getHost();
        
        // Remover www
        $domain = str_replace('www.', '', $host);
        
        // Si no es el dominio principal, buscar tenant
        if ($domain !== env('APP_DOMAIN', 'localhost') && $domain !== 'localhost:8000') {
            $domainRecord = Domain::where('domain', $domain)->first();
            
            if ($domainRecord && $domainRecord->tenant) {
                // Guardar tenant en sesión
                Session::put('tenant_id', $domainRecord->tenant_id);
            }
        }
        
        return $next($request);
    }
}
