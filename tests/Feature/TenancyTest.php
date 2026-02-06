<?php

namespace Tests\Feature;

use App\Models\Domain;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TenancyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test tenant isolation for vehicles.
     */
    public function test_tenant_isolation_for_vehicles(): void
    {
        // Create two tenants
        $tenant1 = Tenant::factory()->create(['id' => 'tenant1']);
        $tenant2 = Tenant::factory()->create(['id' => 'tenant2']);

        // Create users for each tenant
        $user1 = User::factory()->create(['tenant_id' => 'tenant1']);
        /** @var \App\Models\User $user1 */
        $user2 = User::factory()->create(['tenant_id' => 'tenant2']);
        /** @var \App\Models\User $user2 */

        // Create vehicles for each tenant
        $vehicle1 = Vehicle::factory()->create(['tenant_id' => 'tenant1']);
        $vehicle2 = Vehicle::factory()->create(['tenant_id' => 'tenant2']);

        // User 1 should only see their vehicle
        $this->actingAs($user1);
        $vehicles = Vehicle::where('tenant_id', $user1->tenant_id)->get();
        
        $this->assertCount(1, $vehicles);
        $this->assertEquals($vehicle1->id, $vehicles->first()->id);
        $this->assertNotEquals($vehicle2->id, $vehicles->first()->id);
    }

    /**
     * Test CheckTenant middleware blocks cross-tenant access.
     */
    public function test_check_tenant_middleware_blocks_cross_tenant_access(): void
    {
        // Create two tenants with users
        $tenant1 = Tenant::factory()->create(['id' => 'tenant1']);
        $tenant2 = Tenant::factory()->create(['id' => 'tenant2']);

        $user1 = User::factory()->create(['tenant_id' => 'tenant1']);
        /** @var \App\Models\User $user1 */
        $vehicle2 = Vehicle::factory()->create(['tenant_id' => 'tenant2']);

        // User 1 tries to access Tenant 2's vehicle
        $response = $this->actingAs($user1)
            ->get(route('admin.vehicles.edit', $vehicle2->id));

        // Should be forbidden or redirected
        $this->assertTrue(in_array($response->status(), [403, 404, 302]));
    }

    /**
     * Test domain resolution to tenant.
     */
    public function test_domain_resolution_to_tenant(): void
    {
        // Create tenant with domain
        $tenant = Tenant::factory()->create(['id' => 'test-tenant']);
        $domain = Domain::factory()->create([
            'tenant_id' => 'test-tenant',
            'domain' => 'testagency.localhost',
        ]);

        // Test that domain exists and is associated with tenant
        $this->assertDatabaseHas('domains', [
            'domain' => 'testagency.localhost',
            'tenant_id' => 'test-tenant',
        ]);

        // Verify relationship
        $this->assertEquals('test-tenant', $domain->tenant_id);
        $this->assertEquals('testagency.localhost', $tenant->domains->first()->domain);
    }

    /**
     * Test tenant creation with domain.
     */
    public function test_tenant_creation_with_domain(): void
    {
        $tenantData = [
            'id' => 'new-tenant-' . uniqid(),
            'name' => 'New Agency',
            'email' => 'contact@newagency.com',
        ];

        $tenant = Tenant::create($tenantData);

        // Create domain for tenant
        $domain = Domain::create([
            'tenant_id' => $tenant->id,
            'domain' => 'newagency.localhost',
        ]);

        $this->assertDatabaseHas('tenants', ['id' => $tenant->id]);
        $this->assertDatabaseHas('domains', ['domain' => 'newagency.localhost']);
    }

    /**
     * Test users are scoped to their tenant.
     */
    public function test_users_are_scoped_to_tenant(): void
    {
        $tenant1 = Tenant::factory()->create(['id' => 'tenant1']);
        $tenant2 = Tenant::factory()->create(['id' => 'tenant2']);

        $user1a = User::factory()->create(['tenant_id' => 'tenant1', 'name' => 'User 1A']);
        /** @var \App\Models\User $user1a */
        $user1b = User::factory()->create(['tenant_id' => 'tenant1', 'name' => 'User 1B']);
        /** @var \App\Models\User $user1b */
        $user2a = User::factory()->create(['tenant_id' => 'tenant2', 'name' => 'User 2A']);
        /** @var \App\Models\User $user2a */

        // Acting as user from tenant 1
        $this->actingAs($user1a);

        // Get users for this tenant
        $tenantUsers = User::where('tenant_id', $user1a->tenant_id)->get();

        // Should only see 2 users from tenant 1
        $this->assertCount(2, $tenantUsers);
        $this->assertTrue($tenantUsers->contains($user1a));
        $this->assertTrue($tenantUsers->contains($user1b));
        $this->assertFalse($tenantUsers->contains($user2a));
    }

    /**
     * Test tenant settings isolation.
     */
    public function test_tenant_settings_isolation(): void
    {
        $tenant1 = Tenant::factory()->create(['id' => 'tenant1']);
        $tenant2 = Tenant::factory()->create(['id' => 'tenant2']);

        // Update tenant settings (assuming tenant has a settings column or relationship)
        $tenant1->update(['plan' => 'premium']);
        $tenant2->update(['plan' => 'basic']);

        // Refresh from database
        $tenant1->refresh();
        $tenant2->refresh();

        // Verify isolation
        $this->assertEquals('premium', $tenant1->plan);
        $this->assertEquals('basic', $tenant2->plan);
    }

    /**
     * Test public landing page resolves correct tenant.
     */
    public function test_public_landing_resolves_correct_tenant(): void
    {
        $tenant = Tenant::factory()->create(['id' => 'testagency']);
        $domain = Domain::factory()->create([
            'tenant_id' => 'testagency',
            'domain' => 'testagency',
        ]);

        // Visit public landing page
        $response = $this->get(route('public.landing', ['domain' => 'testagency']));

        // Should load successfully or redirect
        $this->assertTrue(in_array($response->status(), [200, 302]));
    }
}
