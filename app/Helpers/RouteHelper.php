<?php

namespace App\Helpers;

use App\Models\Domain;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class RouteHelper
{
    /**
     * Generar URL para public.contact considerando el contexto de tenant.
     * Si estamos en un dominio de tenant (subdominio), usar /contacto directo.
     * Si estamos en el editor admin, usar la ruta preview con tenantId.
     */
    public static function publicContactRoute()
    {
        // Si estamos en un dominio de tenant, usar path directo
        if (static::isOnTenantDomain()) {
            return '/contacto';
        }

        $tenantId = static::getTenantId();
        if ($tenantId) {
            return route('public.contact.preview', ['tenantId' => $tenantId]);
        }
        return route('public.contact.preview', ['tenantId' => 'preview']);
    }

    /**
     * Generar URL para public.landing considerando el contexto de tenant
     */
    public static function publicLandingRoute()
    {
        $tenantId = static::getTenantId();
        if ($tenantId) {
            return route('public.landing.preview', ['tenantId' => $tenantId]);
        }
        return route('public.landing.preview', ['tenantId' => 'preview']);
    }

    /**
     * Detectar si estamos en un dominio de tenant (subdominio o dominio custom)
     */
    protected static function isOnTenantDomain()
    {
        $host = Request::getHost();
        $centralDomains = config('tenancy.central_domains', []);
        $domain = str_replace('www.', '', $host);

        // Si el dominio actual NO es un dominio central, es un dominio de tenant
        if (!in_array($domain, $centralDomains)) {
            return Domain::where('domain', $domain)->exists();
        }

        return false;
    }

    /**
     * Obtener el ID del tenant actual
     */
    protected static function getTenantId()
    {
        if (Auth::check() && Auth::user()->tenant) {
            return Auth::user()->tenant->id;
        }
        return null;
    }
}
