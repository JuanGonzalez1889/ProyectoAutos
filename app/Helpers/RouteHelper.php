<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class RouteHelper
{
    /**
     * Generar URL para public.contact considerando el contexto de tenant
     */
    public static function publicContactRoute()
    {
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
