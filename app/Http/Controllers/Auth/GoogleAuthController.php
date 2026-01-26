<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    /**
     * Redirect to Google
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google callback
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Buscar usuario por Google ID o email
            $user = User::where('google_id', $googleUser->getId())
                       ->orWhere('email', $googleUser->getEmail())
                       ->first();

            if ($user) {
                // Actualizar información de Google si es necesario
                if (!$user->google_id) {
                    $user->update([
                        'google_id' => $googleUser->getId(),
                        'avatar' => $googleUser->getAvatar(),
                    ]);
                }
            } else {
                // Crear nuevo usuario con rol AGENCIERO por defecto
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'email_verified_at' => now(),
                    'is_active' => true,
                ]);

                // Asignar rol ADMIN al primer usuario registrado
                if (User::count() === 1) {
                    $user->assignRole('ADMIN');
                } else {
                    // Los siguientes se registran como AGENCIERO
                    $user->assignRole('AGENCIERO');
                }
            }

            // Verificar que el usuario esté activo
            if (!$user->is_active) {
                return redirect()->route('login')
                    ->withErrors(['email' => 'Tu cuenta está desactivada. Contacta al administrador.']);
            }

            Auth::login($user, true);

            return redirect()->intended(route('admin.dashboard'));

        } catch (\Exception $e) {
            return redirect()->route('login')
                ->withErrors(['email' => 'Error al autenticar con Google. Intenta nuevamente.']);
        }
    }
}
