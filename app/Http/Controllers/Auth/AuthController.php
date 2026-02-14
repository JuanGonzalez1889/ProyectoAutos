<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Tenant;
use App\Models\Domain;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    /**
     * Mostrar formulario de registro (SOLO para invitaciones)
     * Si no hay token, redirige a tenants/register para crear nueva agencia
     */
    public function showRegisterForm(Request $request)
    {
        // Validar que existe un token de invitación válido
        $token = $request->get('token');
        
        if (!$token) {
            // Si no hay token, redirije a registrar una NUEVA AGENCIA
            return redirect()->route('tenants.register');
        }

        $invitation = Invitation::findByToken($token);

        if (!$invitation || !$invitation->isValid()) {
            return redirect('/login')->with('error', 'Invitación inválida o expirada');
        }

        return view('auth.register', ['invitation' => $invitation]);
    }

    /**
     * Procesar registro (SOLO para colaboradores invitados)
     */
    public function register(Request $request)
    {
        // Validar token de invitación
        $token = $request->get('token');
        
        if (!$token) {
            return redirect('/login')->with('error', 'Se requiere invitación para registrarse.');
        }

        $invitation = Invitation::findByToken($token);

        if (!$invitation || !$invitation->isValid()) {
            return redirect('/login')->with('error', 'Invitación inválida o expirada');
        }

        // Validar datos del registro
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Crear usuario en el tenant de la invitación
        $user = User::create([
            'name' => $request->name,
            'email' => $invitation->email,
            'password' => Hash::make($request->password),
            'tenant_id' => $invitation->tenant_id,
            'is_active' => true,
        ]);

        // Asignar rol basado en la invitación
        $user->assignRole($invitation->role);

        // Asignar permisos específicos si los hay
        if ($invitation->permissions) {
            $user->givePermissionTo($invitation->permissions);
        }

        // Marcar invitación como aceptada
        $invitation->accept($user);

        // Registrar en audit log
        activity()
            ->causedBy($user)
            ->performedOn($user)
            ->withProperties(['action' => 'accepted_invitation', 'tenant_id' => $invitation->tenant_id])
            ->log('Usuario ' . $user->name . ' aceptó invitación a agencia');

        Auth::login($user);
        // Redirigir al dashboard (el tenant se inicializa automáticamente desde el usuario autenticado)
        return redirect()->route('admin.dashboard');
    }

    /**
     * Mostrar formulario de login
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Procesar login
     */
    public function login(Request $request)
    {
        $credentials = $this->validate($request, [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !$user->is_active) {
            return back()->withErrors([
                'email' => 'Tu cuenta está desactivada. Contacta al administrador.',
            ])->onlyInput('email');
        }

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    /**
     * Cerrar sesión
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login');
    }
}
