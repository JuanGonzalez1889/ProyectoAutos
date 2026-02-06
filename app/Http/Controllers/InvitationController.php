<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class InvitationController extends Controller
{
    /**
     * Mostrar formulario para invitar colaborador (en dashboard de agencia)
     */
    public function create()
    {
        $this->authorize('users.create');
        
        return view('invitations.create', [
            'roles' => [
                'collaborator' => 'Colaborador',
                'admin' => 'Administrador de Agencia',
            ]
        ]);
    }

    /**
     * Enviar invitación a un colaborador
     */
    public function store(Request $request)
    {
        $this->authorize('users.create');

        $validated = $request->validate([
            'email' => 'required|email',
            'role' => 'required|in:collaborator,admin',
            'permissions' => 'nullable|array',
        ]);

        // Verificar que el email no esté ya registrado en esta agencia
        $tenant = Auth::user()->tenant;
        
        if ($tenant->users()->where('email', $validated['email'])->exists()) {
            return back()->with('error', 'Este usuario ya pertenece a tu agencia.');
        }

        // Crear invitación
        $invitation = Invitation::create_for_collaborator(
            $tenant->id,
            $validated['email'],
            $validated['role'],
            $validated['permissions'] ?? null
        );

        // Enviar email con link de invitación
        try {
            Mail::send('emails.invitation', [
                'tenantName' => $tenant->name,
                'link' => route('invitations.accept-form', ['token' => $invitation->token]),
                'expiresIn' => '7 días',
            ], function ($message) use ($validated, $tenant) {
                $message->to($validated['email'])
                    ->subject("¡Fuiste invitado a {$tenant->name}!");
            });
        } catch (\Exception $e) {
            // Log silencioso en desarrollo
            \Log::warning('Email no enviado: ' . $e->getMessage());
        }

        return back()->with('success', 'Invitación enviada a ' . $validated['email']);
    }

    /**
     * Mostrar formulario de aceptación de invitación (público)
     */
    public function acceptForm($token)
    {
        $invitation = Invitation::findByToken($token);

        if (!$invitation) {
            return redirect('/')->with('error', 'Invitación no encontrada');
        }

        if (!$invitation->isValid()) {
            return redirect('/')->with('error', 'Invitación expirada o ya aceptada');
        }

        return view('invitations.accept', ['invitation' => $invitation]);
    }

    /**
     * Aceptar invitación y registrar usuario (POST)
     */
    public function accept(Request $request, $token)
    {
        $invitation = Invitation::findByToken($token);

        if (!$invitation || !$invitation->isValid()) {
            return redirect('/login')->with('error', 'Invitación inválida o expirada');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'required|confirmed|min:8',
        ]);

        // Crear usuario
        $user = \App\Models\User::create([
            'tenant_id' => $invitation->tenant_id,
            'name' => $validated['name'],
            'email' => $invitation->email,
            'password' => bcrypt($validated['password']),
        ]);

        // Asignar rol
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
            ->withProperties(['action' => 'accepted_invitation'])
            ->log('Usuario ' . $user->name . ' aceptó invitación a agencia');

        return redirect('/login')->with('success', 'Cuenta creada exitosamente. ¡Bienvenido! Inicia sesión para comenzar.');
    }

    /**
     * Listar invitaciones pendientes (en dashboard)
     */
    public function index()
    {
        $this->authorize('users.view');

        $tenant = Auth::user()->tenant;
        $invitations = $tenant->invitations()->valid()->get();

        return view('invitations.index', compact('invitations'));
    }

    /**
     * Cancelar una invitación
     */
    public function destroy($id)
    {
        $this->authorize('users.edit');

        $invitation = Invitation::findOrFail($id);
        
        // Verificar que pertenezca al tenant actual
        if ($invitation->tenant_id !== Auth::user()->tenant_id) {
            abort(403);
        }

        $invitation->delete();

        return back()->with('success', 'Invitación cancelada');
    }
}
