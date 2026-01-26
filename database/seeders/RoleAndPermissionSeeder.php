<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Crear permisos
        $permissions = [
            // Usuarios
            'users.view',
            'users.create',
            'users.edit',
            'users.delete',
            
            // Roles
            'roles.view',
            'roles.assign',
            
            // Dashboard
            'dashboard.access',
            'dashboard.stats',
            
            // Agencieros
            'agencieros.view',
            'agencieros.create',
            'agencieros.edit',
            'agencieros.delete',
            
            // Colaboradores
            'colaboradores.view',
            'colaboradores.create',
            'colaboradores.edit',
            'colaboradores.delete',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Crear roles y asignar permisos

        // Rol ADMIN - Tiene todos los permisos
        $adminRole = Role::create(['name' => 'ADMIN']);
        $adminRole->givePermissionTo(Permission::all());

        // Rol AGENCIERO - Puede gestionar colaboradores
        $agencieroRole = Role::create(['name' => 'AGENCIERO']);
        $agencieroRole->givePermissionTo([
            'dashboard.access',
            'dashboard.stats',
            'colaboradores.view',
            'colaboradores.create',
            'colaboradores.edit',
            'colaboradores.delete',
        ]);

        // Rol COLABORADOR - Permisos limitados
        $colaboradorRole = Role::create(['name' => 'COLABORADOR']);
        $colaboradorRole->givePermissionTo([
            'dashboard.access',
        ]);

        $this->command->info('Roles y permisos creados exitosamente!');
    }
}
