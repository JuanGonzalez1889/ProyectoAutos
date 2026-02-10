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
            $agencia = Agencia::create([
                'nombre' => 'Agencia de ' . $user->name,
                'ubicacion' => '',
                'telefono' => '',
            ]);

            $user->update(['agencia_id' => $agencia->id]);
        }

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

            if (!$agencia->tenant_id) {
                $agencia->update(['tenant_id' => $tenant->id]);
            }
        } elseif (!$agencia->tenant_id) {
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

        $validated = $request->validate([
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
                    // MODIFICADO: Uso de config central_domain
                    $fullDomain = strtolower(trim($value)) . '.' . config('app.central_domain');
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
                } else {
                    $agencia->update(['nombre' => $validated['agencia_name']]);
                    $agencia->refresh();
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
                } else {
                    $tenant->update([
                        'name' => $validated['agencia_name'],
                        'email' => $user->email,
                    ]);
                }

                if (!$agencia->tenant_id) {
                    $agencia->tenant_id = $tenant->id;
                    $agencia->save();
                }

                // MODIFICADO: Uso de config central_domain
                $fullDomain = strtolower(trim($validated['domain'])) . '.' . config('app.central_domain');

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
                }

                $user->update(['name' => $validated['full_name']]);
                $user->refresh();
            });

            $user->load(['tenant', 'agencia']);

            return redirect()->route('admin.dashboard')
                ->with('success', '¡Listo! Tu agencia quedó configurada.');
        } catch (\Exception $e) {
            \Log::error('Onboarding: Error', ['error' => $e->getMessage()]);
            return redirect()->back()
                ->withErrors(['error' => 'Hubo un error al guardar.'])
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

        if (isset($validated['social_media'])) {
            $validated['social_media'] = array_filter($validated['social_media']);
        }

        if (isset($validated['payment_methods'])) {
            $processedMethods = [];
            foreach ($validated['payment_methods'] as $method => $value) {
                $processedMethods[$method] = true;
            }
            $validated['payment_methods'] = $processedMethods ?: null;
        }

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

        if (!preg_match('/^[a-z0-9]([a-z0-9-]*[a-z0-9])?$/', $domain)) {
            return response()->json(['available' => false, 'message' => 'Dominio con formato inválido']);
        }

        // MODIFICADO: Uso de config central_domain
        $fullDomain = strtolower(trim($domain)) . '.' . config('app.central_domain');

        $existingDomain = Domain::where('domain', $fullDomain)->first();

        if ($existingDomain) {
            $currentUserTenantId = auth()->user()->tenant_id;
            if ($currentUserTenantId && $existingDomain->tenant_id === $currentUserTenantId) {
                return response()->json(['available' => true, 'message' => 'Este es tu dominio actual']);
            }
            return response()->json(['available' => false, 'message' => 'Este dominio ya está en uso']);
        }

        return response()->json(['available' => true, 'message' => 'Dominio disponible']);
    }
}
