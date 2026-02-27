<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UpdateUserPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Crear permisos si no existen
        $viewAll = Permission::firstOrCreate(['name' => 'users.view_all']);
        $viewAgency = Permission::firstOrCreate(['name' => 'users.view_agency']);
        $editAll = Permission::firstOrCreate(['name' => 'users.edit_all']);
        $editAgency = Permission::firstOrCreate(['name' => 'users.edit_agency']);

        // Asignar permisos a roles
        $admin = Role::where('name', 'ADMIN')->first();
        $agenciero = Role::where('name', 'AGENCIERO')->first();

        if ($admin) {
            $admin->givePermissionTo([$viewAll, $editAll]);
        }
        if ($agenciero) {
            $agenciero->givePermissionTo([$viewAgency, $editAgency]);
        }
    }
}
