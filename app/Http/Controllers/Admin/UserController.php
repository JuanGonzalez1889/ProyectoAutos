<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $query = User::with('roles', 'agencia');
        
        // Si es ADMIN, ver todos los usuarios y permitir filtrar por agencia
        if ($user->isAdmin()) {
            // Filtro por agencia
            if ($request->filled('agencia_id')) {
                if ($request->agencia_id === 'sin_agencia') {
                    $query->whereNull('agencia_id');
                } else {
                    $query->where('agencia_id', $request->agencia_id);
                }
            }
            
            // Cargar agencias para el filtro
            $agencias = \App\Models\Agencia::orderBy('nombre')->get();
        } 
        // Si es AGENCIERO, ver solo usuarios de su agencia
        elseif ($user->isAgenciero()) {
            $query->where('agencia_id', $user->agencia_id);
            $agencias = collect();
        } 
        else {
            abort(403, 'No tienes permiso para ver usuarios');
        }
        
        $users = $query->latest()->paginate(15);
        
        return view('admin.users.index', compact('users', 'agencias'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $roles = Role::all();
        $agencias = \App\Models\Agencia::orderBy('nombre')->get();
        
        // Si es AGENCIERO, solo puede crear AGENCIERO o COLABORADOR
        if ($user->isAgenciero()) {
            $roles = Role::whereIn('name', ['AGENCIERO', 'COLABORADOR'])->get();
        }
        
        return view('admin.users.create', compact('roles', 'agencias'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        /** @var \App\Models\User $currentUser */
        $currentUser = Auth::user();
        
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'exists:roles,name'],
            'agencia_id' => ['nullable', 'exists:agencias,id'],
            'is_active' => ['boolean'],
        ]);

        // Validar que AGENCIERO solo pueda crear AGENCIERO o COLABORADOR
        if ($currentUser->isAgenciero()) {
            if (!in_array($request->role, ['AGENCIERO', 'COLABORADOR'])) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Solo puedes crear usuarios con rol AGENCIERO o COLABORADOR');
            }
        }

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_active' => $request->boolean('is_active', true),
        ];
        
        // Si es ADMIN, usar la agencia seleccionada en el formulario
        if ($currentUser->isAdmin()) {
            $userData['agencia_id'] = $request->agencia_id;
        }
        // Si es AGENCIERO, asignar su agencia_id automáticamente
        elseif ($currentUser->isAgenciero()) {
            $userData['agencia_id'] = $currentUser->agencia_id;
        }

        $user = User::create($userData);
        $user->assignRole($request->role);

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario creado exitosamente.');
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        $user->load('roles', 'permissions');
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        $agencias = \App\Models\Agencia::orderBy('nombre')->get();
        $user->load('roles');
        return view('admin.users.edit', compact('user', 'roles', 'agencias'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        /** @var \App\Models\User $currentUser */
        $currentUser = Auth::user();
        
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'exists:roles,name'],
            'agencia_id' => ['nullable', 'exists:agencias,id'],
            'is_active' => ['boolean'],
        ]);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'is_active' => $request->boolean('is_active', true),
        ];
        
        // Si es ADMIN, permitir cambiar la agencia
        if ($currentUser->isAdmin()) {
            $updateData['agencia_id'] = $request->agencia_id;
        }
        
        $user->update($updateData);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        $user->syncRoles([$request->role]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario actualizado exitosamente.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        // Evitar que el usuario se elimine a sí mismo
        if ($user->id === Auth::id()) {
            return back()->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario eliminado exitosamente.');
    }

    /**
     * Toggle user active status
     */
    public function toggleStatus(User $user)
    {
        // Evitar que el usuario se desactive a sí mismo
        if ($user->id === Auth::id()) {
            return back()->with('error', 'No puedes desactivar tu propia cuenta.');
        }

        $user->update(['is_active' => !$user->is_active]);

        $status = $user->is_active ? 'activado' : 'desactivado';
        return back()->with('success', "Usuario {$status} exitosamente.");
    }
}
