<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agencia;
use App\Models\Domain;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AgenciaController extends Controller
{
    /**
     * Mostrar información de la agencia del usuario autenticado
     */
    public function show()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        if (!$user->isAgenciero()) {
            abort(403, 'Solo los agencieros pueden acceder a esta sección');
        }

        $agencia = $user->agencia;
        
        if (!$agencia) {
            // Si el agenciero no tiene agencia, crear una
            $agencia = Agencia::create([
                'nombre' => 'Agencia de ' . $user->name,
                'ubicacion' => '',
                'telefono' => '',
            ]);
            
            $user->update(['agencia_id' => $agencia->id]);
        }

        // Si el agenciero no tiene tenant, crearlo y asociarlo a la agencia
        if (!$user->tenant_id) {
            $tenant = Tenant::create([
                'id' => (string) Str::uuid(),
                'name' => $agencia->nombre,
                'email' => $user->email,
                'phone' => $agencia->telefono,
                'address' => $agencia->ubicacion,
                'plan' => 'basic',
                'is_active' => true,
                'trial_ends_at' => now()->addDays(30),
            ]);

            $user->update(['tenant_id' => $tenant->id]);

            // Asociar la agencia al tenant recién creado
            if (!$agencia->tenant_id) {
                $agencia->update(['tenant_id' => $tenant->id]);
            }
        } elseif (!$agencia->tenant_id) {
            // Si el usuario ya tiene tenant pero la agencia no, vincularla
            $agencia->update(['tenant_id' => $user->tenant_id]);
        }

        return view('admin.agencia.show', compact('agencia'));
    }

    /**
     * Actualizar información de la agencia
     */
    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        if (!$user->isAgenciero()) {
            abort(403, 'Solo los agencieros pueden actualizar agencias');
        }

        $agencia = $user->agencia;
        
        if (!$agencia) {
            return redirect()->back()->with('error', 'No tienes una agencia asignada');
        }

        $validated = $this->validate($request, [
            'nombre' => 'required|string|max:255',
            'ubicacion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:50',
        ]);

        $agencia->update($validated);

        return redirect()->back()->with('success', 'Agencia actualizada correctamente');
    }

    /**
     * Completar onboarding inicial del agenciero
     */
    public function completeOnboarding(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user->isAgenciero()) {
            abort(403, 'Solo los agencieros pueden completar el onboarding');
        }

        $currentTenant = $user->tenant;

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'agencia_name' => 'required|string|max:255',
            'domain' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                function ($attribute, $value, $fail) use ($currentTenant) {
                    $fullDomain = strtolower(trim($value)) . '.autowebpro.com.ar';
                    $query = Domain::where('domain', $fullDomain);
                    if ($currentTenant) {
                        $query->where('tenant_id', '!=', $currentTenant->id);
                    }
                    if ($query->exists()) {
                        $fail('El dominio ya está en uso.');
                    }
                },
            ],
        ], [
            'domain.regex' => 'El dominio solo puede contener letras minúsculas, números y guiones.',
        ]);

        try {
            DB::transaction(function () use ($validated, $user) {
                \Log::info('Onboarding: Iniciando para usuario', ['user_id' => $user->id, 'email' => $user->email]);
                
                $agencia = $user->agencia;

                if (!$agencia) {
                    $agencia = Agencia::create([
                        'nombre' => $validated['agencia_name'],
                        'ubicacion' => '',
                        'telefono' => '',
                    ]);

                    $user->update(['agencia_id' => $agencia->id]);
                    $user->refresh();
                    $agencia = $user->agencia;
                    \Log::info('Onboarding: Agencia creada', ['agencia_id' => $agencia->id, 'nombre' => $agencia->nombre]);
                } else {
                    $agencia->update(['nombre' => $validated['agencia_name']]);
                    $agencia->refresh();
                    
                    // Verificar que se guardó
                    $dbCheck = Agencia::find($agencia->id);
                    \Log::info('Onboarding: Agencia actualizada', [
                        'agencia_id' => $agencia->id, 
                        'nombre_objeto' => $agencia->nombre,
                        'nombre_bd' => $dbCheck->nombre,
                        'valor_enviado' => $validated['agencia_name']
                    ]);
                }

                $tenant = $user->tenant;

                if (!$tenant) {
                    $tenant = Tenant::create([
                        'id' => (string) Str::uuid(),
                        'name' => $validated['agencia_name'],
                        'email' => $user->email,
                        'phone' => $agencia->telefono,
                        'address' => $agencia->ubicacion,
                        'plan' => 'basic',
                        'is_active' => true,
                        'trial_ends_at' => now()->addDays(30),
                    ]);

                    $user->update(['tenant_id' => $tenant->id]);
                    \Log::info('Onboarding: Tenant creado', ['tenant_id' => $tenant->id]);
                } else {
                    $tenant->update([
                        'name' => $validated['agencia_name'],
                        'email' => $user->email,
                    ]);
                    \Log::info('Onboarding: Tenant actualizado', ['tenant_id' => $tenant->id]);
                }

                if (!$agencia->tenant_id) {
                    $agencia->tenant_id = $tenant->id;
                    $agencia->save();
                }

                $fullDomain = strtolower(trim($validated['domain'])) . '.misaas.com';

                // Mantener solo el dominio elegido por el usuario
                Domain::where('tenant_id', $tenant->id)
                    ->where('domain', '!=', $fullDomain)
                    ->delete();

                $domainExists = Domain::where('domain', $fullDomain)
                    ->where('tenant_id', $tenant->id)
                    ->exists();

                if (!$domainExists) {
                    Domain::create([
                        'domain' => $fullDomain,
                        'tenant_id' => $tenant->id,
                    ]);
                    \Log::info('Onboarding: Dominio creado', ['domain' => $fullDomain]);
                } else {
                    \Log::info('Onboarding: Dominio ya existe', ['domain' => $fullDomain]);
                }

                $user->update(['name' => $validated['full_name']]);
                $user->refresh();
                \Log::info('Onboarding: Usuario actualizado', ['user_id' => $user->id, 'name' => $user->name]);
            });

            // Forzar recarga del usuario para limpiar cache de relaciones
            $user->load(['tenant', 'agencia']);
            
            \Log::info('Onboarding: Completado exitosamente', ['user_id' => $user->id]);

            return redirect()->route('admin.dashboard')
                ->with('success', '¡Listo! Tu agencia quedó configurada.');
        } catch (\Exception $e) {
            \Log::error('Onboarding: Error', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()
                ->withErrors(['error' => 'Hubo un error al guardar. Por favor intentá de nuevo.'])
                ->withInput();
        }
    }

    /**
     * Mostrar formulario de configuración avanzada
     */
    public function advancedSettings()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        if (!$user->isAgenciero()) {
            abort(403, 'Solo los agencieros pueden acceder a esta sección');
        }

        $tenant = $user->tenant;
        
        if (!$tenant) {
            return redirect()->route('admin.agencia.show')
                ->with('error', 'Debes configurar tu agencia primero');
        }

        return view('admin.agencia.advanced-settings', compact('tenant'));
    }

    /**
     * Actualizar configuración avanzada
     */
    public function updateAdvancedSettings(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        if (!$user->isAgenciero()) {
            abort(403, 'Solo los agencieros pueden actualizar la configuración');
        }

        $tenant = $user->tenant;
        
        if (!$tenant) {
            return redirect()->back()->with('error', 'Debes configurar tu agencia primero');
        }

        // Validar datos
        $validated = $request->validate([
            'business_hours' => 'nullable|array',
            'social_media' => 'nullable|array',
            'payment_methods' => 'nullable|array',
            'phone' => 'nullable|string|max:50',
            'whatsapp' => 'nullable|string|max:50',
            'commission_percentage' => 'nullable|numeric|min:0|max:100',
            'commission_currency' => 'nullable|string|max:3',
            'business_registration' => 'nullable|string|max:255',
            'tax_id' => 'nullable|string|max:255',
            'business_type' => 'nullable|string|max:50',
            'bank_name' => 'nullable|string|max:255',
            'bank_account' => 'nullable|string|max:255',
            'bank_account_holder' => 'nullable|string|max:255',
            'bank_routing_number' => 'nullable|string|max:50',
            'billing_address' => 'nullable|string|max:500',
            'billing_notes' => 'nullable|string|max:1000',
            'auto_approve_leads' => 'nullable|boolean',
            'response_time_hours' => 'nullable|integer|min:1|max:168',
        ]);

        // Procesar business_hours para solo guardar valores no vacíos
        if (isset($validated['business_hours'])) {
            $processedHours = [];
            foreach ($validated['business_hours'] as $day => $hours) {
                if (isset($hours['closed']) && $hours['closed']) {
                    $processedHours[$day] = ['closed' => true];
                } else {
                    $processedHours[$day] = [
                        'open' => $hours['open'] ?? '09:00',
                        'close' => $hours['close'] ?? '18:00',
                        'closed' => false,
                    ];
                }
            }
            $validated['business_hours'] = $processedHours;
        }

        // Procesar social_media para solo guardar URLs no vacías
        if (isset($validated['social_media'])) {
            $validated['social_media'] = array_filter($validated['social_media']);
        }

        // Procesar payment_methods
        if (isset($validated['payment_methods'])) {
            $processedMethods = [];
            foreach ($validated['payment_methods'] as $method => $value) {
                $processedMethods[$method] = true;
            }
            $validated['payment_methods'] = $processedMethods ?: null;
        }

        // Actualizar el tenant
        $tenant->update($validated);

        return redirect()->back()->with('success', '✓ Configuración guardada correctamente');
    }

    /**
     * Validar disponibilidad de dominio
     */
    public function checkDomainAvailability(Request $request)
    {
        $domain = $request->query('domain');
        
        if (!$domain) {
            return response()->json(['available' => false, 'message' => 'Dominio requerido']);
        }

        // Validar que el dominio no tenga caracteres inválidos
        if (!preg_match('/^[a-z0-9]([a-z0-9-]*[a-z0-9])?$/', $domain)) {
            return response()->json(['available' => false, 'message' => 'Dominio con formato inválido']);
        }

        // Construir el dominio completo como se guarda en la BD
        $fullDomain = strtolower(trim($domain)) . '.misaas.com';

        // Verificar si el dominio existe en la base de datos
        $existingDomain = Domain::where('domain', $fullDomain)->first();

        if ($existingDomain) {
            // Si el dominio existe y pertenece al usuario actual, está disponible (es el existente)
            $currentUserTenantId = auth()->user()->tenant_id;
            if ($currentUserTenantId && $existingDomain->tenant_id === $currentUserTenantId) {
                return response()->json(['available' => true, 'message' => 'Este es tu dominio actual']);
            }
            // Si existe pero es de otro tenant, no está disponible
            return response()->json(['available' => false, 'message' => 'Este dominio ya está en uso']);
        }

        // Si no existe, está disponible
        return response()->json(['available' => true, 'message' => 'Dominio disponible']);
    }
}
