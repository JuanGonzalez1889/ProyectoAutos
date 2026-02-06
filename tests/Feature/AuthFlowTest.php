<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AuthFlowTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test full registration and login flow.
     */
    public function test_registration_login_and_dashboard_access(): void
    {
        // Create roles required by AuthController
        Role::create(['name' => 'ADMIN', 'guard_name' => 'web']);
        Role::create(['name' => 'AGENCIERO', 'guard_name' => 'web']);
        Role::create(['name' => 'COLABORADOR', 'guard_name' => 'web']);

        // Register
        $registerResponse = $this->post(route('register'), [
            'name' => 'Juan Tester',
            'email' => 'juan.tester@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'agency_name' => 'Agencia de Prueba',
            'terms_accepted' => true,
            'privacy_accepted' => true,
            'g-recaptcha-response' => 'test-token',
        ]);

        $registerResponse->assertRedirect(route('admin.dashboard'));

        // Logout
        $this->post(route('logout'));

        // Login
        $loginResponse = $this->post(route('login'), [
            'email' => 'juan.tester@example.com',
            'password' => 'Password123!',
        ]);

        $loginResponse->assertRedirect(route('admin.dashboard'));

        // Access dashboard
        $dashboardResponse = $this->get(route('admin.dashboard'));
        $dashboardResponse->assertStatus(200);
    }

    /**
     * Test normal authenticated flow (dashboard + vehicles index).
     */
    public function test_normal_authenticated_flow(): void
    {
        Role::firstOrCreate(['name' => 'ADMIN', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'AGENCIERO', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'COLABORADOR', 'guard_name' => 'web']);
        
        // Create a tenant first
        $tenant = \App\Models\Tenant::create([
            'id' => (string) \Illuminate\Support\Str::uuid(),
            'name' => 'Test Tenant',
            'email' => 'tenant@example.com',
            'is_active' => true,
        ]);
        
        $user = User::factory()->create([
            'email' => 'flow.user@example.com',
            'password' => bcrypt('Password123!'),
            'tenant_id' => $tenant->id,
        ]);
        $user->assignRole('ADMIN');

        $this->actingAs($user);

        $this->get(route('admin.dashboard'))
            ->assertStatus(200);

        $this->get(route('admin.vehicles.index'))
            ->assertStatus(200);
    }
}
