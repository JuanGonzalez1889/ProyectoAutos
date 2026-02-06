<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\Domain;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class PublicLandingController extends Controller
{
    /**
     * Mostrar landing pública del tenant
     */
    public function show(Request $request)
    {
        // Obtener dominio actual
        $host = $request->getHost();
        $domain = str_replace('www.', '', $host);
        
        // En localhost/desarrollo, redirigir a login
        if (in_array($domain, ['localhost', '127.0.0.1'])) {
            return redirect()->route('login');
        }
        
        // Buscar si hay un registro de dominio
        $domainRecord = Domain::where('domain', $domain)->first();
        
        if (!$domainRecord || !$domainRecord->tenant) {
            abort(404, 'Dominio no encontrado. Por favor, registra un dominio en tu panel admin.');
        }

        $tenant = $domainRecord->tenant;
        $settings = $tenant->settings ?? null;
        
        // Obtener plantilla configurada
        $template = $settings && $settings->template ? $settings->template : 'moderno';
        
        // Obtener vehículos del tenant
        $vehicles = Vehicle::where('tenant_id', $tenant->id)
            ->where('status', 'published')
            ->latest()
            ->get();

        return view("public.templates.{$template}", compact('tenant', 'settings', 'vehicles'));
    }

    /**
     * Enviar mensaje de contacto desde la landing pública
     */
    public function submitContact(Request $request)
    {
        $host = $request->getHost();
        $domain = str_replace('www.', '', $host);
        
        $domainRecord = Domain::where('domain', $domain)->first();
        
        if (!$domainRecord || !$domainRecord->tenant) {
            abort(404, 'Dominio no encontrado');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'message' => 'required|string|max:1000',
            'vehicle_id' => 'nullable|exists:vehicles,id',
        ]);

        // Obtener agencia del tenant
        $agencia = $domainRecord->tenant->agencias()->first();

        // Crear un lead con la información de contacto
        \App\Models\Lead::create([
            'tenant_id' => $domainRecord->tenant->id,
            'agencia_id' => $agencia?->id,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'notes' => $validated['message'],
            'vehicle_id' => $validated['vehicle_id'],
            'status' => 'new',
            'source' => 'landing_publica',
        ]);

        return back()->with('success', '¡Gracias! Tu mensaje ha sido enviado correctamente. Nos contactaremos pronto.');
    }

    /**
     * Mostrar landing pública por tenant ID (para desarrollo)
     */
    public function showByTenantId($tenantId)
    {
        $tenant = Tenant::findOrFail($tenantId);
        $settings = $tenant->settings ?? null;
        
        // Obtener plantilla configurada
        $template = $settings && $settings->template ? $settings->template : 'moderno';
        
        // Obtener vehículos del tenant
        $vehicles = Vehicle::where('tenant_id', $tenant->id)
            ->where('status', 'published')
            ->latest()
            ->get();

        return view("public.templates.{$template}", compact('tenant', 'settings', 'vehicles'));
    }

    /**
     * Enviar mensaje de contacto desde landing preview (para desarrollo)
     */
    public function submitContactByTenantId(Request $request, $tenantId)
    {
        $tenant = Tenant::findOrFail($tenantId);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'message' => 'required|string|max:1000',
            'vehicle_id' => 'nullable|exists:vehicles,id',
        ]);

        // Obtener agencia del tenant
        $agencia = $tenant->agencias()->first();

        // Crear un lead con la información de contacto
        \App\Models\Lead::create([
            'tenant_id' => $tenant->id,
            'agencia_id' => $agencia?->id,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'notes' => $validated['message'],
            'vehicle_id' => $validated['vehicle_id'],
            'status' => 'new',
            'source' => 'landing_publica',
        ]);

        return back()->with('success', '¡Gracias! Tu mensaje ha sido enviado correctamente. Nos contactaremos pronto.');
    }

    /**
     * Enviar mensaje de contacto desde dominio directo del tenant
     */
    public function submitContactDirect(Request $request)
    {
        $host = $request->getHost();
        $domain = str_replace('www.', '', $host);
        
        $domainRecord = Domain::where('domain', $domain)->first();
        
        if (!$domainRecord || !$domainRecord->tenant) {
            abort(404, 'Dominio no encontrado');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'message' => 'required|string|max:1000',
            'vehicle_id' => 'nullable|exists:vehicles,id',
        ]);

        $agencia = $domainRecord->tenant->agencias()->first();

        \App\Models\Lead::create([
            'tenant_id' => $domainRecord->tenant->id,
            'agencia_id' => $agencia?->id,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'notes' => $validated['message'],
            'vehicle_id' => $validated['vehicle_id'],
            'status' => 'new',
            'source' => 'landing_publica',
        ]);

        return back()->with('success', '¡Gracias! Tu mensaje ha sido enviado correctamente. Nos contactaremos pronto.');
    }
}
