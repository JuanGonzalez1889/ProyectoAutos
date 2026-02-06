<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use App\Models\Tenant;
use App\Services\DomainValidationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DomainController extends Controller
{
    /**
     * Get tenant for authenticated user
     */
    private function getTenant()
    {
        $user = Auth::user();
        $tenant = Tenant::where('id', $user->tenant_id)->first();
        
        if (!$tenant && $user->agencia) {
            $tenant = Tenant::where('id', $user->agencia->tenant_id)->first();
        }
        
        return $tenant;
    }

    /**
     * Mostrar listado de dominios del tenant actual
     */
    public function index()
    {
        $tenant = $this->getTenant();
        
        if (!$tenant) {
            abort(403, 'No tienes una agencia asociada');
        }
        
        $domains = $tenant->domains()->with('tenant')->get();
        
        // Add validation status to each domain
        $domains = $domains->map(function ($domain) {
            $domain->validation_status = DomainValidationService::validateFormat($domain->domain);
            $domain->dns_records = DomainValidationService::checkDnsRecords($domain->domain);
            return $domain;
        });
        
        return view('domains.index', compact('domains', 'tenant'));
    }

    /**
     * Mostrar formulario para crear nuevo dominio
     */
    public function create()
    {
        $tenant = $this->getTenant();
        
        if (!$tenant) {
            abort(403, 'No tienes una agencia asociada');
        }
        
        return view('domains.create', compact('tenant'));
    }

    /**
     * Guardar nuevo dominio con validaciones
     */
    public function store(Request $request)
    {
        $tenant = $this->getTenant();
        
        if (!$tenant) {
            abort(403, 'No tienes una agencia asociada');
        }

        // First, validate domain format
        $domainName = strtolower(trim($request->input('domain')));
        $formatValidation = DomainValidationService::validateFormat($domainName);

        if (!$formatValidation['valid']) {
            return back()
                ->withInput()
                ->withErrors(['domain' => implode(' ', $formatValidation['errors'])]);
        }

        // Standard validation
        $validated = $request->validate([
            'domain' => 'required|string|unique:domains,domain|lowercase',
            'type' => 'required|in:new,existing',
        ], [
            'domain.unique' => 'Este dominio ya está registrado en el sistema.',
        ]);

        try {
            // Check availability and DNS records
            $availability = DomainValidationService::checkDomainAvailability($domainName);
            $dnsRecords = DomainValidationService::checkDnsRecords($domainName);
            $sslStatus = DomainValidationService::validateSslCertificate($domainName);

            $domain = Domain::create([
                'domain' => $domainName,
                'tenant_id' => $tenant->id,
                'type' => $validated['type'],
                'is_active' => true,
                'registration_status' => $availability['registered'] ? 'registered' : 'available',
                'dns_configured' => $dnsRecords['has_records'],
                'ssl_verified' => $sslStatus['valid'] ?? false,
                'metadata' => [
                    'availability' => $availability,
                    'dns_records' => $dnsRecords,
                    'ssl_status' => $sslStatus,
                ],
            ]);

            return redirect()->route('admin.domains.show', $domain)
                ->with('success', "Dominio '{$domainName}' registrado exitosamente")
                ->with('info', $this->getDomainConfigurationHint($domain));

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'Error al registrar el dominio: ' . $e->getMessage()]);
        }
    }

    /**
     * Mostrar detalles de un dominio con validaciones completas
     */
    public function show(Domain $domain)
    {
        $tenant = $this->getTenant();
        
        if (!$tenant || $domain->tenant_id !== $tenant->id) {
            abort(403, 'No tienes acceso a este dominio');
        }

        // Get comprehensive domain report
        $domainReport = DomainValidationService::generateDomainReport($domain->domain);
        
        return view('domains.show', compact('domain', 'tenant', 'domainReport'));
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(Domain $domain)
    {
        $tenant = $this->getTenant();
        
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
        $tenant = $this->getTenant();
        
        if (!$tenant || $domain->tenant_id !== $tenant->id) {
            abort(403, 'No tienes acceso a este dominio');
        }

        $domainName = strtolower(trim($request->input('domain')));
        $formatValidation = DomainValidationService::validateFormat($domainName);

        if (!$formatValidation['valid']) {
            return back()
                ->withInput()
                ->withErrors(['domain' => implode(' ', $formatValidation['errors'])]);
        }

        $validated = $request->validate([
            'domain' => 'required|string|unique:domains,domain,' . $domain->id . '|lowercase',
        ]);

        try {
            $domain->update(['domain' => $domainName]);

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
        $tenant = $this->getTenant();
        
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

    /**
     * API endpoint para validar dominio en tiempo real
     */
    public function validateDomain(Request $request)
    {
        $domainName = strtolower(trim($request->input('domain', '')));

        if (empty($domainName)) {
            return response()->json([
                'valid' => false,
                'errors' => ['El dominio no puede estar vacío'],
            ]);
        }

        $formatValidation = DomainValidationService::validateFormat($domainName);
        $availability = DomainValidationService::checkDomainAvailability($domainName);
        $dnsRecords = DomainValidationService::checkDnsRecords($domainName);
        $sslStatus = DomainValidationService::validateSslCertificate($domainName);

        return response()->json([
            'domain' => $domainName,
            'format_valid' => $formatValidation['valid'],
            'format_errors' => $formatValidation['errors'],
            'available' => $availability['available'],
            'registered' => $availability['registered'],
            'dns_configured' => $dnsRecords['has_records'],
            'ssl_valid' => $sslStatus['valid'],
            'overall_status' => $this->determineStatus($formatValidation, $availability, $dnsRecords, $sslStatus),
        ]);
    }

    /**
     * API endpoint para obtener sugerencias de DNS
     */
    public function dnsSuggestions(Domain $domain)
    {
        $tenant = $this->getTenant();
        
        if (!$tenant || $domain->tenant_id !== $tenant->id) {
            abort(403, 'No tienes acceso a este dominio');
        }

        $suggestions = DomainValidationService::getDnsSuggestions($domain->domain);
        $currentRecords = DomainValidationService::checkDnsRecords($domain->domain);

        return response()->json([
            'domain' => $domain->domain,
            'suggestions' => $suggestions,
            'current_records' => $currentRecords['records'],
        ]);
    }

    /**
     * Helper method to determine overall domain status
     */
    private function determineStatus($format, $availability, $dns, $ssl): string
    {
        if (!$format['valid']) {
            return 'invalid_format';
        }

        if (!$availability['registered']) {
            return 'not_registered';
        }

        if (!$dns['has_records']) {
            return 'no_dns_records';
        }

        if (!$ssl['valid']) {
            return 'no_ssl';
        }

        return 'fully_configured';
    }

    /**
     * Get domain configuration hint based on status
     */
    private function getDomainConfigurationHint(Domain $domain): string
    {
        $status = $domain->metadata['availability'] ?? [];
        
        if (!($status['registered'] ?? false)) {
            return 'El dominio no está registrado. Por favor completa el registro antes de usarlo.';
        }

        if (!($domain->dns_configured ?? false)) {
            return 'Por favor configura los registros DNS para que el dominio funcione correctamente.';
        }

        if (!($domain->ssl_verified ?? false)) {
            return 'Se recomienda activar un certificado SSL para mayor seguridad.';
        }

        return 'El dominio está completamente configurado.';
    }
}

