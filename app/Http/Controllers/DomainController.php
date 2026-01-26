<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DomainController extends Controller
{
    /**
     * Mostrar listado de dominios del tenant actual
     */
    public function index()
    {
        $user = Auth::user();
        $tenant = Tenant::where('id', $user->tenant_id)->first();
        
        if (!$tenant && $user->agencia) {
            // Intentar obtener tenant desde la agencia (fallback)
            $tenant = Tenant::where('id', $user->agencia->tenant_id)->first();
        }
        
        if (!$tenant) {
            abort(403, 'No tienes una agencia asociada');
        }
        
        $domains = $tenant->domains;
        
        return view('domains.index', compact('domains', 'tenant'));
    }

    /**
     * Mostrar formulario para crear nuevo dominio
     */
    public function create()
    {
        $user = Auth::user();
        $tenant = Tenant::where('id', $user->tenant_id)->first();
        
        if (!$tenant && $user->agencia) {
            $tenant = Tenant::where('id', $user->agencia->tenant_id)->first();
        }
        
        if (!$tenant) {
            abort(403, 'No tienes una agencia asociada');
        }
        
        return view('domains.create', compact('tenant'));
    }

    /**
     * Guardar nuevo dominio
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $tenant = Tenant::where('id', $user->tenant_id)->first();
        
        if (!$tenant && $user->agencia) {
            $tenant = Tenant::where('id', $user->agencia->tenant_id)->first();
        }
        
        if (!$tenant) {
            abort(403, 'No tienes una agencia asociada');
        }

        $validated = $request->validate([
            'domain' => 'required|string|unique:domains,domain|regex:/^([a-z0-9](-?[a-z0-9])*\.)?[a-z0-9](-?[a-z0-9])*\.[a-z]{2,}$/',
            'type' => 'required|in:new,existing', // new = registrar dominio nuevo, existing = dominio ya existente
        ], [
            'domain.unique' => 'Este dominio ya está registrado en el sistema.',
            'domain.regex' => 'El formato del dominio no es válido. Ejemplo: ejemplo.com',
        ]);

        try {
            Domain::create([
                'domain' => $validated['domain'],
                'tenant_id' => $tenant->id,
                'type' => $validated['type'], // Para diferenciar si es nuevo o existente
            ]);

            return redirect()->route('admin.domains.index')
                ->with('success', "Dominio '{$validated['domain']}' registrado exitosamente");

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'Error al registrar el dominio: ' . $e->getMessage()]);
        }
    }

    /**
     * Mostrar detalles de un dominio
     */
    public function show(Domain $domain)
    {
        $user = Auth::user();
        $tenant = Tenant::where('id', $user->tenant_id)->first();
        
        if (!$tenant && $user->agencia) {
            $tenant = Tenant::where('id', $user->agencia->tenant_id)->first();
        }
        
        if (!$tenant || $domain->tenant_id !== $tenant->id) {
            abort(403, 'No tienes acceso a este dominio');
        }

        return view('domains.show', compact('domain', 'tenant'));
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(Domain $domain)
    {
        $user = Auth::user();
        $tenant = Tenant::where('id', $user->tenant_id)->first();
        
        if (!$tenant && $user->agencia) {
            $tenant = Tenant::where('id', $user->agencia->tenant_id)->first();
        }
        
        if (!$tenant || $domain->tenant_id !== $tenant->id) {
            abort(403, 'No tienes acceso a este dominio');
        }

        return view('domains.edit', compact('domain', 'tenant'));
    }

    /**
     * Actualizar dominio
     */
    public function update(Request $request, Domain $domain)
    {
        $user = Auth::user();
        $tenant = Tenant::where('id', $user->tenant_id)->first();
        
        if (!$tenant && $user->agencia) {
            $tenant = Tenant::where('id', $user->agencia->tenant_id)->first();
        }
        
        if (!$tenant || $domain->tenant_id !== $tenant->id) {
            abort(403, 'No tienes acceso a este dominio');
        }

        $validated = $request->validate([
            'domain' => 'required|string|unique:domains,domain,' . $domain->id . '|regex:/^([a-z0-9](-?[a-z0-9])*\.)?[a-z0-9](-?[a-z0-9])*\.[a-z]{2,}$/',
        ], [
            'domain.unique' => 'Este dominio ya está registrado en el sistema.',
            'domain.regex' => 'El formato del dominio no es válido.',
        ]);

        try {
            $domain->update(['domain' => $validated['domain']]);

            return redirect()->route('admin.domains.show', $domain)
                ->with('success', 'Dominio actualizado exitosamente');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'Error al actualizar: ' . $e->getMessage()]);
        }
    }

    /**
     * Eliminar dominio
     */
    public function destroy(Domain $domain)
    {
        $tenant = Tenant::where('id', Auth::user()->tenant_id)->first();
        
        if (!$tenant || $domain->tenant_id !== $tenant->id) {
            abort(403, 'No tienes acceso a este dominio');
        }

        try {
            $domainName = $domain->domain;
            $domain->delete();

            return redirect()->route('admin.domains.index')
                ->with('success', "Dominio '{$domainName}' eliminado exitosamente");

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al eliminar: ' . $e->getMessage()]);
        }
    }
}
