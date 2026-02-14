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
        // Crear roles requeridos
        Role::create(['name' => 'ADMIN', 'guard_name' => 'web']);
        Role::create(['name' => 'AGENCIERO', 'guard_name' => 'web']);
        Role::create(['name' => 'COLABORADOR', 'guard_name' => 'web']);

        // Registro de agencia (flujo real)
        $registerResponse = $this->post(route('tenants.register'), [
            'admin_name' => 'Juan Tester',
            'admin_email' => 'juan.tester@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'agencia_name' => 'Agencia de Prueba',
            'domain' => 'agencia-prueba',
            'terms_accepted' => true,
            'privacy_accepted' => true,
            'g-recaptcha-response' => 'test-token',
        ]);
        $registerResponse->assertRedirect(route('login'));

        // Login
        $loginResponse = $this->post(route('login'), [
            'email' => 'juan.tester@example.com',
            'password' => 'Password123!',
        ]);
        $loginResponse->assertRedirect(route('admin.dashboard'));

        // Acceso al dashboard
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
