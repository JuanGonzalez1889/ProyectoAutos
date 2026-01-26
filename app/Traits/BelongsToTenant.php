<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

trait BelongsToTenant
{
    /**
     * Boot the trait
     */
    public static function bootBelongsToTenant()
    {
        // Scope automático: filtrar por tenant_id actual
        static::addGlobalScope('tenant', function (Builder $builder) {
            // Si hay un tenant activo, filtrar por él
            $tenantId = Auth::user()?->tenant_id;
            if ($tenantId) {
                $builder->where('tenant_id', $tenantId);
            }
        });

        // Cuando se crea un modelo, asignar el tenant_id automáticamente
        static::creating(function ($model) {
            if (!$model->tenant_id && Auth::check()) {
                $model->tenant_id = Auth::user()->tenant_id;
            }
        });
    }

    /**
     * Scope para obtener registros de un tenant específico
     */
    public function scopeForTenant(Builder $query, $tenantId = null)
    {
        return $query->where('tenant_id', $tenantId ?? Auth::user()?->tenant_id);
    }
}
