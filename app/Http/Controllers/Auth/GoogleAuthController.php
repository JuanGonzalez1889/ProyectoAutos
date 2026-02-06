<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Tenant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;

class GoogleUser
{
    protected $data;
    
    public function __construct($data)
    {
        $this->data = $data;
    }
    
    public function getId()
    {
        return $this->data['id'] ?? null;
    }
    
    public function getEmail()
    {
        return $this->data['email'] ?? null;
    }
    
    public function getName()
    {
        return $this->data['name'] ?? null;
    }
    
    public function getAvatar()
    {
        return $this->data['picture'] ?? null;
    }
}

class GoogleAuthController extends Controller
{
    /**
     * Redirect to Google OAuth
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->scopes(['profile', 'email'])
            ->redirect();
    }

    /**
     * Handle Google OAuth callback
     */
    public function handleGoogleCallback()
    {
        try {
            \Log::info('Google callback: Iniciado');
            
            // Si es desarrollo, bypass SSL verification para obtener el token
            if (app()->environment('local') && request('code')) {
                \Log::info('Google callback: Ambiente local, obteniendo token manualmente');
                
                // Obtener token manualmente sin verificación SSL
                $response = \Illuminate\Support\Facades\Http::withoutVerifying()
                    ->post('https://www.googleapis.com/oauth2/v4/token', [
                        'client_id' => config('services.google.client_id'),
                        'client_secret' => config('services.google.client_secret'),
                        'code' => request('code'),
                        'grant_type' => 'authorization_code',
                        'redirect_uri' => config('services.google.redirect'),
                    ]);
                
                if (!$response->successful()) {
                    \Log::error('Google: Token request failed', ['status' => $response->status()]);
                    return redirect()->route('login')
                        ->with('error', 'Error al obtener token de Google.');
                }
                
                $token = $response->json('access_token');
                
                // Obtener datos del usuario
                $userResponse = \Illuminate\Support\Facades\Http::withoutVerifying()
                    ->withToken($token)
                    ->get('https://www.googleapis.com/oauth2/v2/userinfo');
                
                if (!$userResponse->successful()) {
                    \Log::error('Google: User info request failed', ['status' => $userResponse->status()]);
                    return redirect()->route('login')
                        ->with('error', 'Error al obtener datos de usuario de Google.');
                }
                
                $userData = $userResponse->json();
                $googleUser = new GoogleUser($userData);
                
                \Log::info('Google callback: Usuario obtenido (manual)', ['email' => $googleUser->getEmail()]);
            } else {
                \Log::info('Google callback: Usando Socialite');
                $googleUser = Socialite::driver('google')->user();
                \Log::info('Google callback: Usuario obtenido (Socialite)', ['email' => $googleUser->getEmail()]);
            }
            
        } catch (InvalidStateException $e) {
            \Log::error('Google callback: InvalidStateException', ['error' => $e->getMessage()]);
            return redirect()->route('login')
                ->with('error', 'Estado inválido. Por favor, intenta nuevamente.');
        } catch (\Exception $e) {
            \Log::error('Google callback: Exception', [
                'error' => $e->getMessage(),
                'code' => $e->getCode()
            ]);
            return redirect()->route('login')
                ->with('error', 'Error al conectar con Google. Intenta nuevamente.');
        }

        return $this->authenticateOrRegisterUser($googleUser);
    }

    /**
     * Authenticate existing user or register new one
     */
    private function authenticateOrRegisterUser($googleUser)
    {
        // Check for existing user by Google ID
        $user = User::where('google_id', $googleUser->getId())->first();

        if ($user) {
            return $this->loginUser($user, $googleUser);
        }

        // Check for existing user by email
        $existingUser = User::where('email', $googleUser->getEmail())->first();

        if ($existingUser) {
            return $this->linkGoogleAccountToExisting($existingUser, $googleUser);
        }

        // Create new user
        return $this->createNewUserFromGoogle($googleUser);
    }

    /**
     * Login existing user
     */
    private function loginUser($user, $googleUser)
    {
        \Log::info('Google login: loginUser called', ['user_id' => $user->id, 'email' => $user->email]);
        
        if (!$user->is_active) {
            \Log::warning('Google login: User inactive', ['user_id' => $user->id]);
            return redirect()->route('login')
                ->with('error', 'Tu cuenta está desactivada. Contacta al administrador.');
        }

        // Update avatar if changed
        if ($googleUser->getAvatar() && $user->avatar !== $googleUser->getAvatar()) {
            $user->update(['avatar' => $googleUser->getAvatar()]);
        }

        \Log::info('Google login: About to Auth::login', ['user_id' => $user->id]);
        Auth::login($user, true);
        \Log::info('Google login: Auth::login done', ['user_id' => $user->id]);

        return redirect()->intended(route('admin.dashboard'));
    }

    /**
     * Link Google account to existing user
     */
    private function linkGoogleAccountToExisting($user, $googleUser)
    {
        // If user already has Google linked, just login
        if ($user->google_id) {
            return $this->loginUser($user, $googleUser);
        }

        // Check if user is authenticated
        if (!Auth::check()) {
            // Redirect to login asking user to authenticate first
            session(['pending_google_link' => [
                'google_id' => $googleUser->getId(),
                'email' => $googleUser->getEmail(),
                'name' => $googleUser->getName(),
                'avatar' => $googleUser->getAvatar(),
            ]]);

            return redirect()->route('login')
                ->with('info', 'Por favor, inicia sesión para vincular tu cuenta de Google.');
        }

        // Link the Google account to authenticated user
        $authenticatedUser = Auth::user();
        $authenticatedUser->update([
            'google_id' => $googleUser->getId(),
            'avatar' => $googleUser->getAvatar(),
        ]);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Cuenta de Google vinculada correctamente.');
    }

    /**
     * Create new user from Google
     */
    private function createNewUserFromGoogle($googleUser)
    {
        \Log::info('Google login: createNewUserFromGoogle called', ['email' => $googleUser->getEmail()]);
        
        try {
            $newUser = DB::transaction(function () use ($googleUser) {
                \Log::info('Google login: Creating tenant', ['email' => $googleUser->getEmail()]);
                
                // Create a new tenant for the user
                $tenant = Tenant::create([
                    'id' => (string) Str::uuid(),
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'is_active' => true,
                ]);

                \Log::info('Google login: Tenant created', ['tenant_id' => $tenant->id]);

                // Create user
                $user = User::create([
                    'tenant_id' => $tenant->id,
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'email_verified_at' => now(),
                    'is_active' => true,
                ]);

                \Log::info('Google login: User created', ['user_id' => $user->id, 'tenant_id' => $tenant->id]);

                // Assign AGENCIERO role (owner of the tenant)
                $user->assignRole('AGENCIERO');

                \Log::info('Google login: AGENCIERO role assigned', ['user_id' => $user->id]);

                return $user;
            });

            \Log::info('Google login: About to Auth::login', ['user_id' => $newUser->id]);
            Auth::login($newUser, true);
            \Log::info('Google login: Auth::login done', ['user_id' => $newUser->id]);

            return redirect()->route('admin.dashboard')
                ->with('success', 'Bienvenido ' . $newUser->name . '! Tu agencia ha sido creada.');

        } catch (\Exception $e) {
            \Log::error('Google login: Exception in createNewUserFromGoogle', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('login')
                ->with('error', 'Error al crear tu cuenta. Por favor, intenta nuevamente.');
        }
    }

    /**
     * Confirm Google link after user authentication
     */
    public function confirmGoogleLink()
    {
        $pendingLink = session('pending_google_link');

        if (!$pendingLink || !Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        $user = Auth::user();
        $user->update([
            'google_id' => $pendingLink['google_id'],
            'avatar' => $pendingLink['avatar'],
        ]);

        session()->forget('pending_google_link');

        return redirect()->route('admin.dashboard')
            ->with('success', 'Cuenta de Google vinculada correctamente.');
    }
}
