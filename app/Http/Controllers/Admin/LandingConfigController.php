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
                'home_description_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
                'nosotros_description' => 'nullable|string|max:2000',
                'nosotros_description_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
                'agency_name_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
                'nosotros_url' => 'nullable|string',
                'contact_message' => 'nullable|string|max:500',
                'primary_color' => 'nullable|string',
                'secondary_color' => 'nullable|string',
                'tertiary_color' => 'nullable|string',
                'phone' => 'nullable|string|max:20',
                'email' => 'nullable|string',
                'whatsapp' => 'nullable|string|max:20',
                'facebook_url' => 'nullable|string',
                'instagram_url' => 'nullable|string',
                'linkedin_url' => 'nullable|string',
                'show_contact_form' => 'nullable',
                'show_vehicles' => 'nullable',
                'logo_url' => 'nullable|string',
                'banner_url' => 'nullable|string',
                'template' => 'nullable|in:moderno,minimalista,clasico,deportivo',
                'agency_name' => 'nullable|string|max:255',
                'stat1' => 'nullable|string|max:100',
                'stat2' => 'nullable|string|max:100',
                'stat3' => 'nullable|string|max:100',
                'stat1_label' => 'nullable|string|max:100',
                'stat2_label' => 'nullable|string|max:100',
                'stat3_label' => 'nullable|string|max:100',
            ]);

            // Si se está actualizando el nombre de la agencia, actualizar en la tabla tenants
            if (array_key_exists('agency_name', $validated)) {
                $name = trim($validated['agency_name']);
                $tenant->update(['name' => $name === '' ? null : $name]);
                unset($validated['agency_name']); // Remover del array para no intentar guardarlo en tenant_settings
            }

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
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
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
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB máximo
            'field' => 'required|string',
        ]);

        $user = Auth::user();
        $tenant = Tenant::where('id', $user->tenant_id)->first();
        
        if (!$tenant) {
            return response()->json(['success' => false, 'message' => 'No tienes un tenant asociado'], 403);
        }

        try {
            // Guardar la imagen en storage/app/public/landing-images
            $path = $request->file('image')->store('landing-images', 'public');
            
            // Generar la URL pública
            $url = asset('storage/' . $path);

            return response()->json([
                'success' => true,
                'url' => $url,
                'path' => $path
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al subir la imagen: ' . $e->getMessage()
            ], 500);
        }
    }
}
