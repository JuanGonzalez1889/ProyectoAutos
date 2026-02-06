<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define modules and actions
        $modules = [
            'vehicles' => ['view', 'create', 'edit', 'delete', 'export'],
            'leads' => ['view', 'create', 'edit', 'delete', 'export', 'assign'],
            'tasks' => ['view', 'create', 'edit', 'delete', 'complete'],
            'events' => ['view', 'create', 'edit', 'delete'],
            'users' => ['view', 'create', 'edit', 'delete', 'assign_roles', 'change_permissions'],
            'settings' => ['view', 'edit', 'manage_payment', 'manage_domain'],
            'reports' => ['view', 'export'],
            'audit' => ['view_logs'],
        ];

        // Create all permissions
        foreach ($modules as $module => $actions) {
            foreach ($actions as $action) {
                Permission::firstOrCreate(
                    ['name' => "{$module}.{$action}"],
                    ['guard_name' => 'web']
                );
            }
        }

        // Get or create roles
        $adminRole = Role::firstOrCreate(['name' => 'ADMIN', 'guard_name' => 'web']);
        $agencieroRole = Role::firstOrCreate(['name' => 'AGENCIERO', 'guard_name' => 'web']);
        $colaboradorRole = Role::firstOrCreate(['name' => 'COLABORADOR', 'guard_name' => 'web']);

        // Assign all permissions to ADMIN
        $adminPermissions = Permission::all();
        $adminRole->syncPermissions($adminPermissions);

        // Assign permissions to AGENCIERO (can manage most things)
        $agencieroPermissions = Permission::whereIn('name', [
            // Own vehicles
            'vehicles.view', 'vehicles.create', 'vehicles.edit', 'vehicles.delete', 'vehicles.export',
            // Own leads
            'leads.view', 'leads.create', 'leads.edit', 'leads.delete', 'leads.export', 'leads.assign',
            // Own tasks
            'tasks.view', 'tasks.create', 'tasks.edit', 'tasks.delete', 'tasks.complete',
            // Own events
            'events.view', 'events.create', 'events.edit', 'events.delete',
            // User management for own agency
            'users.view', 'users.create', 'users.edit', 'users.delete', 'users.assign_roles', 'users.change_permissions',
            // Own settings
            'settings.view', 'settings.edit', 'settings.manage_payment', 'settings.manage_domain',
            // Reports
            'reports.view', 'reports.export',
            // Audit
            'audit.view_logs',
        ])->get();
        $agencieroRole->syncPermissions($agencieroPermissions);

        // Assign basic permissions to COLABORADOR
        $colaboradorPermissions = Permission::whereIn('name', [
            'vehicles.view', 'vehicles.create', 'vehicles.edit',
            'leads.view', 'leads.create', 'leads.edit',
            'tasks.view', 'tasks.create', 'tasks.edit', 'tasks.complete',
            'events.view', 'events.create', 'events.edit',
            'reports.view',
        ])->get();
        $colaboradorRole->syncPermissions($colaboradorPermissions);
    }
}

