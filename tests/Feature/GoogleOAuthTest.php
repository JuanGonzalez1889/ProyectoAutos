<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Socialite\Two\User as SocialiteUser;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class GoogleOAuthTest extends TestCase
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
     * Test redirecting to Google OAuth
     */
    public function test_redirect_to_google(): void
    {
        $this->get('/auth/google')
            ->assertStatus(302)
            ->assertRedirect();
    }

    /**
     * Test creating new user from Google
     */
    public function test_create_new_user_from_google(): void
    {
        $googleUser = new SocialiteUser();
        $googleUser->id = 'google-123';
        $googleUser->name = 'John Doe';
        $googleUser->email = 'john@gmail.com';
        $googleUser->avatar = 'https://example.com/avatar.jpg';

        // Mock Socialite
        \Socialite::shouldReceive('driver')
            ->with('google')
            ->andReturn($mock = \Mockery::mock())
            ->once();

        $mock->shouldReceive('user')
            ->andReturn($googleUser);

        // Assert no user exists before
        $this->assertDatabaseMissing('users', ['email' => 'john@gmail.com']);

        $response = $this->get('/auth/google/callback');

        // Assert user was created
        $this->assertDatabaseHas('users', [
            'email' => 'john@gmail.com',
            'google_id' => 'google-123',
            'name' => 'John Doe',
        ]);

        // Assert tenant was created
        $user = User::where('email', 'john@gmail.com')->first();
        $this->assertDatabaseHas('tenants', [
            'id' => $user->tenant_id,
            'email' => 'john@gmail.com',
        ]);

        // Assert user has AGENCIERO role
        $this->assertTrue($user->hasRole('AGENCIERO'));

        // Assert user is logged in
        $this->assertAuthenticatedAs($user);

        // Assert redirect to dashboard
        $response->assertRedirect(route('admin.dashboard'));
    }

    /**
     * Test authenticating existing user with Google
     */
    public function test_authenticate_existing_user_with_google(): void
    {
        // Create existing user with Google ID
        $tenant = Tenant::create([
            'id' => (string) \Illuminate\Support\Str::uuid(),
            'name' => 'Test Tenant',
            'email' => 'jane@gmail.com',
        ]);

        $existingUser = User::create([
            'tenant_id' => $tenant->id,
            'name' => 'Jane Doe',
            'email' => 'jane@gmail.com',
            'google_id' => 'google-456',
            'is_active' => true,
        ]);

        $existingUser->assignRole('AGENCIERO');

        // Create mock Google user
        $googleUser = new SocialiteUser();
        $googleUser->id = 'google-456';
        $googleUser->name = 'Jane Doe Updated';
        $googleUser->email = 'jane@gmail.com';
        $googleUser->avatar = 'https://example.com/new-avatar.jpg';

        // Mock Socialite
        \Socialite::shouldReceive('driver')
            ->with('google')
            ->andReturn($mock = \Mockery::mock())
            ->once();

        $mock->shouldReceive('user')
            ->andReturn($googleUser);

        $response = $this->get('/auth/google/callback');

        // Assert user is logged in
        $this->assertAuthenticatedAs($existingUser);

        // Assert user count didn't increase
        $this->assertEquals(1, User::count());
    }

    /**
     * Test linking Google to existing email
     */
    public function test_link_google_to_existing_email(): void
    {
        // Create existing user without Google ID first
        $tenant = Tenant::create([
            'id' => (string) \Illuminate\Support\Str::uuid(),
            'name' => 'Test Tenant 2',
            'email' => 'bob@example.com',
        ]);

        $existingUser = User::create([
            'tenant_id' => $tenant->id,
            'name' => 'Bob Smith',
            'email' => 'bob@example.com',
            'google_id' => null,
            'is_active' => true,
        ]);

        $existingUser->assignRole('COLABORADOR');

        // Create mock Google user with specific data
        $googleUser = new SocialiteUser();
        $googleUser->id = 'google-789';
        $googleUser->name = 'Bob Smith';
        $googleUser->email = 'bob@example.com';
        $googleUser->avatar = 'https://example.com/bob-avatar.jpg';

        // Mock Socialite BEFORE authenticating
        \Socialite::shouldReceive('driver')
            ->with('google')
            ->andReturn($mock = \Mockery::mock())
            ->once();

        $mock->shouldReceive('user')
            ->andReturn($googleUser);

        // Authenticate after mock setup
        $this->actingAs($existingUser);

        $response = $this->get('/auth/google/callback');

        // Check response
        $response->assertStatus(302);
        $response->assertRedirect(route('admin.dashboard'));

        // Refresh from DB to get latest data
        $updated = User::find($existingUser->id);

        // Assert Google ID was linked
        $this->assertEquals('google-789', $updated->google_id);
        
        // Assert user is still logged in
        $this->assertAuthenticatedAs($existingUser);
    }

    /**
     * Test user cannot login if account is deactivated
     */
    public function test_cannot_login_if_deactivated(): void
    {
        // Create deactivated user with Google ID
        $tenant = Tenant::create([
            'id' => (string) \Illuminate\Support\Str::uuid(),
            'name' => 'Inactive Tenant',
            'email' => 'inactive@gmail.com',
        ]);

        $inactiveUser = User::create([
            'tenant_id' => $tenant->id,
            'name' => 'Inactive User',
            'email' => 'inactive@gmail.com',
            'google_id' => 'google-inactive',
            'is_active' => false,
        ]);

        // Create mock Google user
        $googleUser = new SocialiteUser();
        $googleUser->id = 'google-inactive';
        $googleUser->name = 'Inactive User';
        $googleUser->email = 'inactive@gmail.com';
        $googleUser->avatar = 'https://example.com/inactive.jpg';

        // Mock Socialite
        \Socialite::shouldReceive('driver')
            ->with('google')
            ->andReturn($mock = \Mockery::mock())
            ->once();

        $mock->shouldReceive('user')
            ->andReturn($googleUser);

        $response = $this->get('/auth/google/callback');

        // Assert user is not logged in
        $this->assertGuest();

        // Assert redirect with error
        $response->assertRedirect(route('login'));
    }

    /**
     * Test handling Google authentication errors
     */
    public function test_handle_google_auth_error(): void
    {
        // Mock Socialite to throw exception
        \Socialite::shouldReceive('driver')
            ->with('google')
            ->andReturn($mock = \Mockery::mock())
            ->once();

        $mock->shouldReceive('user')
            ->andThrow(new \Exception('Google API Error'));

        $response = $this->get('/auth/google/callback');

        // Assert user is not logged in
        $this->assertGuest();

        // Assert redirect with error
        $response->assertRedirect(route('login'));
        $response->assertSessionHas('error');
    }

    /**
     * Test user count after Google registration
     */
    public function test_user_count_after_google_registration(): void
    {
        $googleUser = new SocialiteUser();
        $googleUser->id = 'google-new-1';
        $googleUser->name = 'New User 1';
        $googleUser->email = 'newuser1@gmail.com';
        $googleUser->avatar = 'https://example.com/avatar1.jpg';

        \Socialite::shouldReceive('driver')
            ->with('google')
            ->andReturn($mock = \Mockery::mock())
            ->once();

        $mock->shouldReceive('user')
            ->andReturn($googleUser);

        // Assert no users exist
        $this->assertEquals(0, User::count());
        $this->assertEquals(0, Tenant::count());

        $this->get('/auth/google/callback');

        // Assert one user and one tenant created
        $this->assertEquals(1, User::count());
        $this->assertEquals(1, Tenant::count());

        // Assert tenant has the user
        $user = User::first();
        $tenant = Tenant::first();
        $this->assertEquals($user->tenant_id, $tenant->id);
    }
}
