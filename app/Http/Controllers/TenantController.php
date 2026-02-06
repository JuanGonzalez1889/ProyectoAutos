<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\Domain;
use App\Models\User;
use App\Models\Agencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TenantController extends Controller
{
    /**
     * Mostrar formulario de registro de nuevo tenant
     */
    public function showRegisterForm()
    {
        return view('tenants.register');
    }

    /**
     * Registrar un nuevo tenant (agencia)
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'agencia_name' => 'required|string|max:255',
            'admin_name' => 'required|string|max:255',
            'admin_email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'domain' => 'required|string|max:255|unique:domains,domain|regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            // Construir dominio completo
            $fullDomain = $validated['domain'] . '.misaas.com';

            // 1. Crear el Tenant
            $tenant = Tenant::create([
                'id' => Str::uuid()->toString(),
                'name' => $validated['agencia_name'],
                'email' => $validated['admin_email'],
                'phone' => $validated['phone'] ?? null,
                'address' => $validated['address'] ?? null,
                'plan' => 'basic',
                'is_active' => true,
                'trial_ends_at' => now()->addDays(30), // 30 días de prueba
            ]);

            // 2. Crear el Dominio asociado
            Domain::create([
                'domain' => $fullDomain,
                'tenant_id' => $tenant->id,
            ]);

            // 3. Crear la Agencia con tenant_id
            $agencia = Agencia::create([
                'tenant_id' => $tenant->id,
                'nombre' => $validated['agencia_name'],
                'ubicacion' => $validated['address'] ?? '',
                'telefono' => $validated['phone'] ?? '',
            ]);

            // 4. Crear el usuario administrador
            $admin = User::create([
                'tenant_id' => $tenant->id,
                'agencia_id' => $agencia->id,
                'name' => $validated['admin_name'],
                'email' => $validated['admin_email'],
                'password' => Hash::make($validated['password']),
                'is_active' => true,
            ]);

            // 5. Asignar rol de AGENCIERO usando Spatie Permission
            $admin->assignRole('AGENCIERO');

            DB::commit();

            // Redirigir al login del tenant
            return redirect()->route('login')
                ->with('success', "¡Agencia creada exitosamente! Puedes iniciar sesión con tu cuenta en {$fullDomain}");

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()
                ->withInput()
                ->withErrors(['error' => 'Error al crear la agencia: ' . $e->getMessage()]);
        }
    }

    /**
     * Panel de administración de tenants (Super Admin)
     */
    public function index()
    {
        $tenants = Tenant::with('domains')->latest()->paginate(20);
        
        return view('tenants.index', compact('tenants'));
    }

    /**
     * Ver detalles de un tenant
     */
    public function show(Tenant $tenant)
    {
        $tenant->load(['domains', 'users']);
        
        return view('tenants.show', compact('tenant'));
    }

    /**
     * Mostrar formulario de edición de tenant
     */
    public function edit(Tenant $tenant)
    {
        return view('tenants.edit', compact('tenant'));
    }

    /**
     * Actualizar configuración del tenant
     */
    public function update(Request $request, Tenant $tenant)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'plan' => 'required|in:basic,premium,enterprise',
            'is_active' => 'nullable|boolean',
            'trial_ends_at' => 'nullable|date',
            'subscription_ends_at' => 'nullable|date',
        ]);

        // Convertir checkbox a boolean
        $validated['is_active'] = isset($validated['is_active']) ? true : false;

        $tenant->update($validated);

        return redirect()->route('tenants.show', $tenant)
            ->with('success', 'Configuración actualizada exitosamente');
    }

    /**
     * Desactivar/Activar tenant
     */
    public function toggleStatus(Tenant $tenant)
    {
        $tenant->update([
            'is_active' => !$tenant->is_active
        ]);

        $status = $tenant->is_active ? 'activado' : 'desactivado';
        
        return back()->with('success', "Tenant {$status} exitosamente");
    }

    /**
     * Eliminar tenant
     */
    public function destroy(Tenant $tenant)
    {
        try {
            DB::beginTransaction();

            // Eliminar todos los datos relacionados
            $tenant->users()->delete();
            $tenant->domains()->delete();
            $tenant->delete();

            DB::commit();

            return redirect()->route('tenants.index')
                ->with('success', 'Tenant eliminado exitosamente');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()->withErrors(['error' => 'Error al eliminar el tenant: ' . $e->getMessage()]);
        }
    }

    /**
     * Validar disponibilidad de dominio (API pública)
     */
    public function validateDomain(Request $request)
    {
        $domain = $request->get('domain');

        if (!$domain) {
            return response()->json([
                'available' => false,
                'message' => 'Dominio requerido',
            ]);
        }

        // Construcción del dominio completo
        $fullDomain = $domain . '.misaas.com';

        // Verificar si ya existe
        $exists = Domain::where('domain', $fullDomain)->exists();

        if ($exists) {
            return response()->json([
                'available' => false,
                'message' => '❌ Este dominio ya está en uso',
            ]);
        }

        // Validar formato
        if (!preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $domain)) {
            return response()->json([
                'available' => false,
                'message' => '❌ Dominio inválido (solo letras, números y guiones)',
            ]);
        }

        // Validar longitud
        if (strlen($domain) < 3 || strlen($domain) > 63) {
            return response()->json([
                'available' => false,
                'message' => '❌ Dominio debe tener entre 3 y 63 caracteres',
            ]);
        }

        return response()->json([
            'available' => true,
            'message' => '✓ Dominio disponible',
            'domain' => $fullDomain,
        ]);
    }
}
