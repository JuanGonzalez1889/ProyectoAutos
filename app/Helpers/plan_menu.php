<?php

use App\Models\PlanRolPermiso;

if (!function_exists('canSeeMenu')) {
    /**
     * Verifica si el usuario puede ver un menú/módulo según su plan y rol.
     * @param string $permiso Nombre del permiso/módulo (ej: 'Inventario', 'Usuarios', etc)
     * @return bool
     */
    function canSeeMenu(string $permiso): bool
    {
        $user = auth()->user();
        if (!$user) return false;
        // Excepción: superadmin siempre ve todo
        if ($user->email === 'superadmin@autos.com') {
            \Log::channel('single')->info('[canSeeMenu-superadmin]', [
                'user_id' => $user->id,
                'email' => $user->email,
                'permiso' => $permiso,
                'resultado' => true
            ]);
            return true;
        }
        // Buscar tenant y plan activo desde suscripción
        $tenantId = $user->tenant_id ?? null;
        $planSlug = null;
        if ($tenantId) {
            $subscription = \DB::table('subscriptions')
                ->where('tenant_id', $tenantId)
                ->where('status', 'active')
                ->orderByDesc('created_at')
                ->first();
            if ($subscription && $subscription->plan) {
                $planSlug = $subscription->plan;
            }
        }
        // Fallback: si no hay tenant o suscripción, usar agencia/usuario
        if (!$planSlug) {
            if (method_exists($user, 'isAgenciero') && $user->isAgenciero()) {
                if (!$user->relationLoaded('agencia')) {
                    $user->load('agencia');
                }
                $planSlug = isset($user->agencia) ? $user->agencia->plan_id : null;
            } elseif (method_exists($user, 'isAdmin') && $user->isAdmin()) {
                $planSlug = isset($user->plan_id) ? $user->plan_id : null;
            } elseif (method_exists($user, 'isColaborador') && $user->isColaborador()) {
                if (!$user->relationLoaded('agencia')) {
                    $user->load('agencia');
                }
                $planSlug = isset($user->agencia) ? $user->agencia->plan_id : null;
            }
        }
        // Normalizar planSlug a slug si es nombre o id numérico
        if ($planSlug) {
            $planModel = \App\Models\Plan::where('slug', $planSlug)
                ->orWhere('nombre', $planSlug)
                ->orWhere('id', $planSlug)
                ->first();
            if ($planModel) {
                $planSlug = $planModel->id; // Usar siempre el id numérico para la consulta
            }
        }
        $rolId = $user->roles->first()->id ?? null;
        $logData = [
            'user_id' => $user->id,
            'email' => $user->email,
            'plan_id' => $planSlug,
            'rol_id' => $rolId,
            'permiso' => $permiso,
        ];
        if (!$planSlug || !$rolId) {
            $logData['perm_db'] = null;
            $logData['resultado'] = false;
            \Log::channel('single')->info('[canSeeMenu]', $logData);
            return false;
        }
        $perm = PlanRolPermiso::where('plan_id', $planSlug)
            ->where('rol_id', $rolId)
            ->where('permiso', $permiso)
            ->first();
        $logData['perm_db'] = $perm ? $perm->toArray() : null;
        $logData['visible'] = $perm ? $perm->visible : null;
        $logData['resultado'] = $perm ? (bool)$perm->visible : false;
        \Log::channel('single')->info('[canSeeMenu]', $logData);
        return $perm ? (bool)$perm->visible : false;
    }
}
