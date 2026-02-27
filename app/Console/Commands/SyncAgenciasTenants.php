<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Agencia;
use App\Models\Tenant;

class SyncAgenciasTenants extends Command
{
    protected $signature = 'sync:agencias-tenants';
    protected $description = 'Sincroniza tenant_id y plan_id entre agencias y usuarios según la relación con tenants y suscripciones.';

    public function handle()
    {
        $this->info('Sincronizando agencias y usuarios con tenants...');
        $users = User::with(['agencia', 'tenant'])->get();
        $count = 0;
        foreach ($users as $user) {
            if ($user->tenant_id && $user->agencia) {
                $agencia = $user->agencia;
                $updated = false;
                if ($agencia->tenant_id !== $user->tenant_id) {
                    $agencia->tenant_id = $user->tenant_id;
                    $updated = true;
                }
                // Opcional: sincronizar plan_id si tienes esa lógica
                // $planId = ... obtener plan_id desde tenant o suscripción
                // if ($agencia->plan_id !== $planId) { $agencia->plan_id = $planId; $updated = true; }
                if ($updated) {
                    $agencia->save();
                    $count++;
                }
            }
        }
        $this->info("Agencias sincronizadas: $count");
        $this->info('¡Sincronización completa!');
        return 0;
    }
}
