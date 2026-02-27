<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        Log::info('[DEBUG USERS] Entrando al constructor de UserController');
    }

    /**
     * Display a listing of users.
     */
    public function index(Request $request)
    {
        Log::info('[DEBUG USERS] Entrando al método index de UserController');
        /** @var \App\Models\User $user */
        $user = Auth::user();
        Log::info('[DEBUG USERS] User index', [
            'id' => $user->id,
            'roles' => $user->roles->pluck('name')->toArray(),
            'agencia_id' => $user->agencia_id,
        ]);
        if (!function_exists('canSeeMenu')) {
            require_once base_path('app/Helpers/plan_menu.php');
        }
        if (!canSeeMenu('usuarios')) {
            Log::warning('[DEBUG USERS] User sin permisos para ver usuarios (canSeeMenu)', ['id' => $user->id]);
            abort(403, 'No tienes permiso para ver usuarios');
        }
        $query = User::with('roles', 'agencia');
        if ($user->isAdmin()) {
            Log::info('[DEBUG USERS] User is ADMIN');
            if ($request->filled('agencia_id')) {
                if ($request->agencia_id === 'sin_agencia') {
                    $query->whereNull('agencia_id');
                } else {
                    $query->where('agencia_id', $request->agencia_id);
                }
            }
            $agencias = \App\Models\Agencia::orderBy('nombre')->get();
        } elseif ($user->isAgenciero()) {
            Log::info('[DEBUG USERS] User is AGENCIERO');
            $query->where('agencia_id', $user->agencia_id);
            $agencias = collect();
        } else {
            Log::warning('[DEBUG USERS] User sin permisos para ver usuarios (rol)', ['id' => $user->id]);
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
            // Asignar tenant_id de la agencia seleccionada
            $agencia = \App\Models\Agencia::find($request->agencia_id);
            if ($agencia && $agencia->tenant_id) {
                $userData['tenant_id'] = $agencia->tenant_id;
            }
        }
        // Si es AGENCIERO, asignar su agencia_id y tenant_id automáticamente
        elseif ($currentUser->isAgenciero()) {
            $userData['agencia_id'] = $currentUser->agencia_id;
            $userData['tenant_id'] = $currentUser->tenant_id;
        }

        // Validar que no se pueda crear colaborador sin agencia o en agencia sin agenciero
        if ($request->role === 'COLABORADOR') {
            if (empty($userData['agencia_id'])) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'No se puede crear un colaborador sin agencia.');
            }
            $agencia = \App\Models\Agencia::find($userData['agencia_id']);
            if ($agencia && $agencia->agencieros()->count() === 0) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'No se puede crear un colaborador en una agencia sin agenciero.');
            }
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
        /** @var \App\Models\User $currentUser */
        $currentUser = Auth::user();
        Log::info('User show', ['id' => $currentUser->id, 'roles' => $currentUser->roles->pluck('name')->toArray()]);
        if ($currentUser->isAdmin()) {
            Log::info('User is ADMIN');
            $this->authorize('users.view_all');
        } elseif ($currentUser->isAgenciero()) {
            Log::info('User is AGENCIERO');
            $this->authorize('users.view_agency');
            if ($user->agencia_id !== $currentUser->agencia_id) {
                Log::warning('Agenciero intentando ver usuario de otra agencia', ['user_id' => $user->id, 'agencia_id' => $user->agencia_id]);
                abort(403, 'No tienes permiso para ver este usuario');
            }
        } else {
            Log::warning('User sin permisos para ver usuarios', ['id' => $currentUser->id]);
            abort(403, 'No tienes permiso para ver usuarios');
        }
        $user->load('roles', 'permissions');
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        /** @var \App\Models\User $currentUser */
        $currentUser = Auth::user();
        Log::info('User edit', ['id' => $currentUser->id, 'roles' => $currentUser->roles->pluck('name')->toArray()]);
        if ($currentUser->isAdmin()) {
            Log::info('User is ADMIN');
            $this->authorize('users.edit_all');
        } elseif ($currentUser->isAgenciero()) {
            Log::info('User is AGENCIERO');
            $this->authorize('users.edit_agency');
            if ($user->agencia_id !== $currentUser->agencia_id) {
                Log::warning('Agenciero intentando editar usuario de otra agencia', ['user_id' => $user->id, 'agencia_id' => $user->agencia_id]);
                abort(403, 'No tienes permiso para editar este usuario');
            }
        } else {
            Log::warning('User sin permisos para editar usuarios', ['id' => $currentUser->id]);
            abort(403, 'No tienes permiso para editar usuarios');
        }
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
        Log::info('User update', ['id' => $currentUser->id, 'roles' => $currentUser->roles->pluck('name')->toArray()]);
        if ($currentUser->isAdmin()) {
            Log::info('User is ADMIN');
            $this->authorize('users.edit_all');
        } elseif ($currentUser->isAgenciero()) {
            Log::info('User is AGENCIERO');
            $this->authorize('users.edit_agency');
            if ($user->agencia_id !== $currentUser->agencia_id) {
                Log::warning('Agenciero intentando editar usuario de otra agencia', ['user_id' => $user->id, 'agencia_id' => $user->agencia_id]);
                abort(403, 'No tienes permiso para editar este usuario');
            }
        } else {
            Log::warning('User sin permisos para editar usuarios', ['id' => $currentUser->id]);
            abort(403, 'No tienes permiso para editar usuarios');
        }
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
        /** @var \App\Models\User $currentUser */
        $currentUser = Auth::user();
        Log::info('[DEBUG USERS] Entrando a destroy', [
            'current_user_id' => $currentUser->id,
            'current_user_roles' => $currentUser->roles->pluck('name')->toArray(),
            'current_user_permissions' => method_exists($currentUser, 'getAllPermissions') ? $currentUser->getAllPermissions()->pluck('name')->toArray() : [],
            'target_user_id' => $user->id,
            'target_user_agencia_id' => $user->agencia_id,
            'current_user_agencia_id' => $currentUser->agencia_id,
        ]);

        if ($currentUser->isAdmin()) {
            // Admin puede eliminar cualquier usuario excepto a sí mismo
            Log::info('[DEBUG USERS] ADMIN eliminando usuario');
        } elseif ($currentUser->isAgenciero()) {
            // Agenciero solo puede eliminar usuarios de su agencia
            if ($user->agencia_id !== $currentUser->agencia_id) {
                Log::warning('[DEBUG USERS] Agenciero intentando eliminar usuario de otra agencia', [
                    'user_id' => $user->id,
                    'user_agencia_id' => $user->agencia_id,
                    'current_user_agencia_id' => $currentUser->agencia_id,
                ]);
                abort(403, 'No tienes permiso para eliminar este usuario');
            }
            // Además, debe tener el permiso granular
            if (!$currentUser->can('users.delete.agencia')) {
                Log::warning('[DEBUG USERS] Agenciero SIN permiso users.delete.agencia', [
                    'user_id' => $currentUser->id
                ]);
                abort(403, 'No tienes permiso para eliminar usuarios de tu agencia');
            }
        } else {
            Log::warning('[DEBUG USERS] User sin permisos para eliminar usuarios', ['id' => $currentUser->id]);
            abort(403, 'No tienes permiso para eliminar usuarios');
        }
        // Evitar que el usuario se elimine a sí mismo
        if ($user->id === $currentUser->id) {
            Log::warning('[DEBUG USERS] Intento de auto-eliminación', ['id' => $currentUser->id]);
            return back()->with('error', 'No puedes eliminar tu propia cuenta.');
        }
        $user->delete();
        Log::info('[DEBUG USERS] Usuario eliminado correctamente', ['deleted_user_id' => $user->id]);
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
