<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agencia;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
}
