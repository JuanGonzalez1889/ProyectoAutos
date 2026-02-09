<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TenantSetting;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LandingConfigController extends Controller
{
    /**
     * Mostrar formulario de configuración de landing
     */
    public function show()
    {
        $user = Auth::user();

        $tenant = Tenant::where('id', $user->tenant_id)->first();
        
        if (!$tenant) {
            abort(403, 'No tienes un tenant asociado');
        }

        $settings = $tenant->settings ?? new TenantSetting(['tenant_id' => $tenant->id]);

        return view('admin.landing-config.show', compact('settings', 'tenant'));
    }

    /**
     * Actualizar configuración de landing
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $tenant = Tenant::where('id', $user->tenant_id)->first();
        
        if (!$tenant) {
            return response()->json(['success' => false, 'message' => 'No tienes un tenant asociado'], 403);
        }

        try {
            $validated = $request->validate([
                'home_description' => 'nullable|string|max:1000',
                'home_description_color' => ['nullable', 'string', 'regex:/^#?([0-9A-Fa-f]{3}|[0-9A-Fa-f]{6})$/'],
                'nosotros_description' => 'nullable|string|max:2000',
                'nosotros_description_color' => ['nullable', 'string', 'regex:/^#?([0-9A-Fa-f]{3}|[0-9A-Fa-f]{6})$/'],
                'hero_title' => 'nullable|string|max:255',
                'hero_title_color' => ['nullable', 'string', 'regex:/^#?([0-9A-Fa-f]{3}|[0-9A-Fa-f]{6})$/'],
                'font_family' => 'nullable|string|max:100',
                'agency_name_color' => ['nullable', 'string', 'regex:/^#?([0-9A-Fa-f]{3}|[0-9A-Fa-f]{6})$/'],
                'nosotros_url' => 'nullable|string',
                'contact_message' => 'nullable|string|max:500',
                'primary_color' => ['nullable', 'string', 'regex:/^#?([0-9A-Fa-f]{3}|[0-9A-Fa-f]{6})$/'],
                'secondary_color' => ['nullable', 'string', 'regex:/^#?([0-9A-Fa-f]{3}|[0-9A-Fa-f]{6})$/'],
                'tertiary_color' => ['nullable', 'string', 'regex:/^#?([0-9A-Fa-f]{3}|[0-9A-Fa-f]{6})$/'],
                'phone' => 'nullable|string|max:20',
                'email' => 'nullable|email|max:255',
                'whatsapp' => 'nullable|string|max:20',
                'facebook_url' => 'nullable|string|max:255',
                'instagram_url' => 'nullable|string|max:255',
                'linkedin_url' => 'nullable|string|max:255',
                'show_contact_form' => 'nullable|boolean',
                'show_vehicles' => 'nullable|boolean',
                'logo_url' => 'nullable|string|max:255',
                'banner_url' => 'nullable|string|max:255',
                'template' => 'nullable|in:moderno,minimalista,clasico,deportivo,elegante,corporativo,tecnologico,innovador',
                'agency_name' => 'nullable|string|max:255',
                'navbar_agency_name' => 'nullable|string|max:255',
                'navbar_agency_name_color' => ['nullable', 'string', 'regex:/^#?([0-9A-Fa-f]{3}|[0-9A-Fa-f]{6})$/'],
                'stat1' => 'nullable|string|max:100',
                'stat2' => 'nullable|string|max:100',
                'stat3' => 'nullable|string|max:100',
                'stat1_label' => 'nullable|string|max:100',
                'stat2_label' => 'nullable|string|max:100',
                'stat3_label' => 'nullable|string|max:100',
                'navbar_links_color' => ['nullable', 'string', 'regex:/^#?([0-9A-Fa-f]{3}|[0-9A-Fa-f]{6})$/'],
            ]);

            // Si se está actualizando el nombre de la agencia, actualizar en la tabla tenants
            if (array_key_exists('agency_name', $validated)) {
                $name = trim($validated['agency_name']);
                $tenant->update(['name' => $name === '' ? null : $name]);
                unset($validated['agency_name']); // Remover del array para no intentar guardarlo en tenant_settings
            }
            // navbar_agency_name solo se guarda en settings, nunca en tenants

            $settings = TenantSetting::updateOrCreate(
                ['tenant_id' => $tenant->id],
                $validated
            );

            return response()->json([
                'success' => true,
                'message' => 'Configuración actualizada correctamente',
                'settings' => $settings
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::warning('Landing config validation error', [
                'tenant_id' => $tenant->id,
                'user_id' => Auth::id(),
                'errors' => $e->errors(),
                'input' => $request->all()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Error de validación: ' . implode(', ', collect($e->errors())->flatten()->all()),
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Landing config save error', [
                'tenant_id' => $tenant->id,
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Upload de imagen
     */
    public function uploadImage(Request $request)
    {
        try {
            $validated = $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB máximo
                'field' => 'required|string',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Image upload validation failed', [
                'errors' => $e->errors(),
                'user_id' => Auth::id()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Validación fallida: ' . implode(', ', collect($e->errors())->flatten()->all())
            ], 422);
        }

        $user = Auth::user();
        
        // Intentar obtener tenant del usuario primero, luego del contexto multitenant
        $tenant = null;
        if ($user->tenant_id) {
            $tenant = Tenant::where('id', $user->tenant_id)->first();
        }
        
        // Si no encontramos tenant por ID, intentar desde tenancy context
        if (!$tenant && function_exists('tenancy')) {
            $tenant = tenancy()->tenant;
        }
        
        if (!$tenant) {
            \Log::error('Upload image: No tenant found', [
                'user_id' => Auth::id(),
                'user_tenant_id' => $user->tenant_id,
            ]);
            return response()->json([
                'success' => false,
                'message' => 'No tienes un tenant asociado'
            ], 403);
        }

        try {
            // Guardar la imagen en storage/app/public/landing-images
            $path = $request->file('image')->store('landing-images', 'public');
            
            // Generar la URL pública relativa (para que funcione en cualquier dominio)
            $url = '/storage/' . $path;
            
            \Log::info('Image uploaded successfully', [
                'tenant_id' => $tenant->id,
                'path' => $path,
                'url' => $url,
                'user_id' => Auth::id()
            ]);

            return response()->json([
                'success' => true,
                'url' => $url,
                'path' => $path
            ]);
        } catch (\Exception $e) {
            \Log::error('Image upload error', [
                'error' => $e->getMessage(),
                'tenant_id' => $tenant->id,
                'user_id' => Auth::id()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Error al subir la imagen: ' . $e->getMessage()
            ], 500);
        }
    }
}
