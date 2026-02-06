<?php

namespace Tests\Feature;

use App\Models\Domain;
use App\Models\Tenant;
use App\Models\User;
use App\Services\DomainValidationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class DomainValidationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create roles
        Role::firstOrCreate(['name' => 'ADMIN', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'AGENCIERO', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'COLABORADOR', 'guard_name' => 'web']);
    }

    /**
     * Test domain format validation
     */
    public function test_validate_domain_format(): void
    {
        // Valid domains
        $validDomains = [
            'ejemplo.com',
            'mi-agencia.es',
            'domain123.co.uk',
            'subdomain.example.com',
        ];

        foreach ($validDomains as $domain) {
            $result = DomainValidationService::validateFormat($domain);
            $this->assertTrue($result['valid'], "Domain '{$domain}' should be valid");
            $this->assertEmpty($result['errors']);
        }
    }

    /**
     * Test invalid domain formats
     */
    public function test_validate_invalid_domain_format(): void
    {
        // Invalid domains
        $invalidDomains = [
            'invalid..com',
            '-invalid.com',
            'invalid-.com',
            'local.test',  // Reserved TLD
        ];

        foreach ($invalidDomains as $domain) {
            $result = DomainValidationService::validateFormat($domain);
            $this->assertFalse($result['valid'], "Domain '{$domain}' should be invalid");
            $this->assertNotEmpty($result['errors']);
        }
    }

    /**
     * Test DNS records checking
     */
    public function test_check_dns_records(): void
    {
        // Use a real domain that has DNS records
        $result = DomainValidationService::checkDnsRecords('google.com');

        $this->assertIsArray($result['records']);
        $this->assertIsArray($result['records']['A']);
        $this->assertIsArray($result['records']['MX']);
        $this->assertTrue($result['has_records']);
    }

    /**
     * Test DNS suggestions generation
     */
    public function test_get_dns_suggestions(): void
    {
        $domain = 'ejemplo.com';
        $suggestions = DomainValidationService::getDnsSuggestions($domain);

        $this->assertArrayHasKey('A', $suggestions);
        $this->assertArrayHasKey('MX', $suggestions);
        $this->assertArrayHasKey('CNAME', $suggestions);
        $this->assertArrayHasKey('TXT', $suggestions);
        $this->assertArrayHasKey('NS', $suggestions);

        // Check A record is required
        $this->assertTrue($suggestions['A']['required']);
    }

    /**
     * Test SSL certificate validation
     */
    public function test_validate_ssl_certificate(): void
    {
        // Use a domain with valid SSL
        $result = DomainValidationService::validateSslCertificate('google.com');

        $this->assertIsArray($result);
        $this->assertArrayHasKey('valid', $result);
        $this->assertArrayHasKey('expires_at', $result);
        $this->assertArrayHasKey('issuer', $result);
    }

    /**
     * Test domain availability check
     */
    public function test_check_domain_availability(): void
    {
        // google.com is registered
        $result = DomainValidationService::checkDomainAvailability('google.com');

        $this->assertIsArray($result);
        $this->assertArrayHasKey('available', $result);
        $this->assertArrayHasKey('registered', $result);
        $this->assertTrue($result['registered']); // Google.com should be registered
    }

    /**
     * Test comprehensive domain report
     */
    public function test_generate_domain_report(): void
    {
        $domain = 'google.com';
        $report = DomainValidationService::generateDomainReport($domain);

        $this->assertArrayHasKey('domain', $report);
        $this->assertArrayHasKey('format_valid', $report);
        $this->assertArrayHasKey('dns_records', $report);
        $this->assertArrayHasKey('ssl_certificate', $report);
        $this->assertArrayHasKey('dns_suggestions', $report);
        $this->assertArrayHasKey('overall_status', $report);

        $this->assertEquals($domain, $report['domain']);
        $this->assertTrue($report['format_valid']);
    }

    /**
     * Test domain creation with validation
     */
    public function test_create_domain_with_validation(): void
    {
        // Create tenant and user
        $tenant = Tenant::create([
            'id' => (string) \Illuminate\Support\Str::uuid(),
            'name' => 'Test Agencia',
            'email' => 'agencia@example.com',
        ]);

        $user = User::create([
            'tenant_id' => $tenant->id,
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'is_active' => true,
        ]);

        $user->assignRole('AGENCIERO');

        // Authenticate user
        $this->actingAs($user);

        // Create domain
        $response = $this->post(route('admin.domains.store'), [
            'domain' => 'ejemplo.com',
            'type' => 'existing',
        ]);

        // Should redirect to show
        $response->assertStatus(302);

        // Check domain was created
        $this->assertDatabaseHas('domains', [
            'domain' => 'ejemplo.com',
            'tenant_id' => $tenant->id,
            'type' => 'existing',
        ]);

        // Check domain has validation attributes
        $domain = Domain::where('domain', 'ejemplo.com')->first();
        $this->assertNotNull($domain);
        $this->assertTrue($domain->is_active);
        $this->assertNotNull($domain->metadata);
    }

    /**
     * Test domain validation API endpoint
     */
    public function test_domain_validation_api(): void
    {
        // Create tenant and user
        $tenant = Tenant::create([
            'id' => (string) \Illuminate\Support\Str::uuid(),
            'name' => 'Test Agencia',
            'email' => 'agencia@example.com',
        ]);

        $user = User::create([
            'tenant_id' => $tenant->id,
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'is_active' => true,
        ]);

        $user->assignRole('AGENCIERO');
        $this->actingAs($user);

        // Test validation endpoint
        $response = $this->get('/admin/domains/api/validate?domain=ejemplo.com');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'domain',
            'format_valid',
            'format_errors',
            'available',
            'registered',
            'dns_configured',
            'ssl_valid',
            'overall_status',
        ]);
    }

    /**
     * Test DNS suggestions API endpoint
     */
    public function test_dns_suggestions_api(): void
    {
        // Create tenant, user, and domain
        $tenant = Tenant::create([
            'id' => (string) \Illuminate\Support\Str::uuid(),
            'name' => 'Test Agencia',
            'email' => 'agencia@example.com',
        ]);

        $user = User::create([
            'tenant_id' => $tenant->id,
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'is_active' => true,
        ]);

        $user->assignRole('AGENCIERO');

        $domain = Domain::create([
            'domain' => 'ejemplo.com',
            'tenant_id' => $tenant->id,
            'type' => 'existing',
        ]);

        $this->actingAs($user);

        // Test DNS suggestions endpoint
        $response = $this->get(route('admin.domains.dns-suggestions', $domain));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'domain',
            'suggestions',
            'current_records',
        ]);
    }

    /**
     * Test domain cannot be created with invalid format
     */
    public function test_cannot_create_domain_with_invalid_format(): void
    {
        // Create tenant and user
        $tenant = Tenant::create([
            'id' => (string) \Illuminate\Support\Str::uuid(),
            'name' => 'Test Agencia',
            'email' => 'agencia@example.com',
        ]);

        $user = User::create([
            'tenant_id' => $tenant->id,
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'is_active' => true,
        ]);

        $user->assignRole('AGENCIERO');
        $this->actingAs($user);

        // Try to create invalid domain
        $response = $this->post(route('admin.domains.store'), [
            'domain' => 'invalid..com',
            'type' => 'existing',
        ]);

        // Should have validation errors
        $response->assertSessionHasErrors('domain');

        // Domain should not be created
        $this->assertDatabaseMissing('domains', [
            'domain' => 'invalid..com',
        ]);
    }

    /**
     * Test domain duplication is prevented
     */
    public function test_cannot_create_duplicate_domain(): void
    {
        // Create tenant and user
        $tenant = Tenant::create([
            'id' => (string) \Illuminate\Support\Str::uuid(),
            'name' => 'Test Agencia',
            'email' => 'agencia@example.com',
        ]);

        $user = User::create([
            'tenant_id' => $tenant->id,
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'is_active' => true,
        ]);

        $user->assignRole('AGENCIERO');

        // Create first domain
        Domain::create([
            'domain' => 'ejemplo.com',
            'tenant_id' => $tenant->id,
            'type' => 'existing',
        ]);

        $this->actingAs($user);

        // Try to create duplicate
        $response = $this->post(route('admin.domains.store'), [
            'domain' => 'ejemplo.com',
            'type' => 'existing',
        ]);

        // Should have validation errors
        $response->assertSessionHasErrors('domain');
    }

    /**
     * Test domain model methods
     */
    public function test_domain_model_methods(): void
    {
        $tenant = Tenant::create([
            'id' => (string) \Illuminate\Support\Str::uuid(),
            'name' => 'Test Agencia',
            'email' => 'agencia@example.com',
        ]);

        // Create partially configured domain
        $domain = Domain::create([
            'domain' => 'ejemplo.com',
            'tenant_id' => $tenant->id,
            'type' => 'existing',
            'is_active' => true,
            'registration_status' => 'registered',
            'dns_configured' => true,
            'ssl_verified' => false,
        ]);

        // Test isFullyConfigured
        $this->assertFalse($domain->isFullyConfigured());

        // Test getNextConfigurationStep
        $this->assertEquals('verify_ssl', $domain->getNextConfigurationStep());

        // Mark SSL as verified
        $domain->update(['ssl_verified' => true]);
        $this->assertTrue($domain->isFullyConfigured());
        $this->assertNull($domain->getNextConfigurationStep());
    }
}
