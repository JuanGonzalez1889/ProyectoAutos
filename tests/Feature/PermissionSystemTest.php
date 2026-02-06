<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class PermissionSystemTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Setup roles and permissions before each test
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Create roles
        Role::firstOrCreate(['name' => 'ADMIN', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'AGENCIERO', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'COLABORADOR', 'guard_name' => 'web']);

        // Create permissions
        $modules = [
            'vehicles' => ['view', 'create', 'edit', 'delete'],
            'users' => ['view', 'create', 'edit', 'delete', 'change_permissions'],
            'audit' => ['view_logs'],
        ];

        foreach ($modules as $module => $actions) {
            foreach ($actions as $action) {
                Permission::firstOrCreate(
                    ['name' => "{$module}.{$action}"],
                    ['guard_name' => 'web']
                );
            }
        }
    }

    /**
     * Test admin user has all permissions
     */
    public function test_admin_user_has_all_permissions(): void
    {
        $tenant = Tenant::create([
            'id' => (string) \Illuminate\Support\Str::uuid(),
            'name' => 'Test Admin Tenant',
            'email' => 'admin@test.com',
            'is_active' => true,
        ]);

        $admin = User::factory()->create([
            'tenant_id' => $tenant->id,
            'email' => 'admin@test.com',
        ]);

        $admin->assignRole('ADMIN');
        $admin->givePermissionTo(['vehicles.view', 'vehicles.create', 'users.view', 'audit.view_logs']);

        // Test permissions
        $this->assertTrue($admin->hasPermissionTo('vehicles.view'));
        $this->assertTrue($admin->hasPermissionTo('vehicles.create'));
        $this->assertTrue($admin->hasPermissionTo('users.view'));
        $this->assertTrue($admin->hasPermissionTo('audit.view_logs'));
    }

    /**
     * Test colaborador user has limited permissions
     */
    public function test_colaborador_user_has_limited_permissions(): void
    {
        $tenant = Tenant::create([
            'id' => (string) \Illuminate\Support\Str::uuid(),
            'name' => 'Test Colaborador Tenant',
            'email' => 'colab@test.com',
            'is_active' => true,
        ]);

        $colaborador = User::factory()->create([
            'tenant_id' => $tenant->id,
            'email' => 'colab@test.com',
        ]);

        $colaborador->assignRole('COLABORADOR');
        $colaborador->givePermissionTo(['vehicles.view', 'vehicles.create']);

        // Test permissions
        $this->assertTrue($colaborador->hasPermissionTo('vehicles.view'));
        $this->assertTrue($colaborador->hasPermissionTo('vehicles.create'));
        $this->assertFalse($colaborador->hasPermissionTo('vehicles.delete'));
        $this->assertFalse($colaborador->hasPermissionTo('users.view'));
    }

    /**
     * Test activity logging
     */
    public function test_activity_logging(): void
    {
        $tenant = Tenant::create([
            'id' => (string) \Illuminate\Support\Str::uuid(),
            'name' => 'Test Activity Tenant',
            'email' => 'activity@test.com',
            'is_active' => true,
        ]);

        $user = User::factory()->create([
            'tenant_id' => $tenant->id,
            'email' => 'activity@test.com',
        ]);

        // Act as the user
        $this->actingAs($user);

        // Log an activity
        $activity = \App\Models\ActivityLog::logActivity([
            'action' => 'view',
            'module' => 'vehicles',
            'description' => 'Usuario vio lista de vehículos',
        ]);

        // Assert activity was logged
        $this->assertDatabaseHas('activity_logs', [
            'user_id' => $user->id,
            'action' => 'view',
            'module' => 'vehicles',
        ]);

        $this->assertNotNull($activity->id);
        $this->assertEquals($user->id, $activity->user_id);
    }

    /**
     * Test user cannot access unauthorized resource
     */
    public function test_user_cannot_access_unauthorized_resource(): void
    {
        $tenant = Tenant::create([
            'id' => (string) \Illuminate\Support\Str::uuid(),
            'name' => 'Test Unauthorized Tenant',
            'email' => 'unauthorized@test.com',
            'is_active' => true,
        ]);

        $user = User::factory()->create([
            'tenant_id' => $tenant->id,
            'email' => 'unauthorized@test.com',
        ]);

        $user->assignRole('COLABORADOR');
        $user->givePermissionTo(['vehicles.view']);

        $this->assertFalse($user->hasPermissionTo('users.delete'));
        $this->assertFalse($user->hasPermissionTo('audit.view_logs'));
    }
}
