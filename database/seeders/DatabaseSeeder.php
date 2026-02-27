<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // 1. Cargamos los Planes (Vital para que aparezca la tabla)
            PlanSeeder::class,

            // 2. Creamos Roles y Permisos básicos
            RoleAndPermissionSeeder::class,

            // 3. Sincronizamos permisos de usuarios existentes
            UpdateUserPermissionsSeeder::class,
        ]);
    }
}