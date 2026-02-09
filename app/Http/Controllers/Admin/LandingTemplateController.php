<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\TenantSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LandingTemplateController extends Controller
{
    /**
     * Mostrar selector de plantillas
     */
    public function select()
    {
        $user = Auth::user();
        $tenant = Tenant::where('id', $user->tenant_id)->first();
        
        if (!$tenant) {
            abort(403, 'No tienes un tenant asociado');
        }

        return view('admin.landing-template.select', compact('tenant'));
    }

    /**
     * Guardar plantilla seleccionada
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $tenant = Tenant::where('id', $user->tenant_id)->first();
        
        if (!$tenant) {
            abort(403, 'No tienes un tenant asociado');
        }

        $validated = $request->validate([
            'template' => 'required|in:moderno,minimalista,clasico,deportivo,elegante,corporativo,tecnologico,innovador',
        ]);

        // Crear o actualizar settings
        $settings = TenantSetting::where('tenant_id', $tenant->id)->first();
        
        if ($settings) {
            $settings->update(['template' => $validated['template']]);
        } else {
            TenantSetting::create([
                'tenant_id' => $tenant->id,
                'template' => $validated['template'],
            ]);
        }

        return redirect()->route('admin.landing-template.edit', ['template' => $validated['template']])
                        ->with('success', '✅ Plantilla seleccionada. Ahora personaliza tu landing.');
    }

    /**
     * Editor visual de plantilla
     */
    public function edit($template)
    {
        $user = Auth::user();
        $tenant = Tenant::where('id', $user->tenant_id)->first();
        
        if (!$tenant) {
            abort(403, 'No tienes un tenant asociado');
        }

        // Validar template
        $validTemplates = ['moderno', 'minimalista', 'clasico', 'deportivo', 'elegante', 'corporativo', 'tecnologico', 'innovador'];
        if (!in_array($template, $validTemplates)) {
            abort(404);
        }

        // Obtener o crear settings
        $settings = TenantSetting::where('tenant_id', $tenant->id)->firstOrCreate(
            ['tenant_id' => $tenant->id],
            ['template' => $template]
        );

        $primaryDomain = $tenant->domains()->orderBy('created_at')->first();
        
        if ($primaryDomain) {
            $protocol = app()->environment('local') ? 'http://' : 'https://';
            $port = app()->environment('local') ? ':8000' : '';
            $previewUrl = $protocol . $primaryDomain->domain . $port;
        } else {
            $previewUrl = route('public.landing.preview', ['tenantId' => $tenant->id]);
        }

        return view('admin.landing-template.edit', compact('tenant', 'settings', 'template', 'previewUrl', 'primaryDomain'));
    }

    /**
     * Preview de una plantilla
     */
    public function preview($template)
    {
        $user = Auth::user();
        $tenant = Tenant::where('id', $user->tenant_id)->first();
        
        if (!$tenant) {
            abort(403);
        }

        // Validar template
        $validTemplates = ['moderno', 'minimalista', 'clasico', 'deportivo', 'elegante', 'corporativo', 'tecnologico', 'innovador'];
        if (!in_array($template, $validTemplates)) {
            abort(404);
        }

        // Detectar si está en modo edición (se llama desde el iframe del editor)
        $editMode = request()->get('edit', true); // Por defecto en modo edición para el iframe

        // Colores predefinidos para cada plantilla
        $templateColors = [
            'moderno' => ['primary_color' => '#8b5cf6', 'secondary_color' => '#1e293b'], // Púrpura y gris oscuro
            'minimalista' => ['primary_color' => '#10b981', 'secondary_color' => '#1f2937'], // Verde y gris oscuro
            'clasico' => ['primary_color' => '#3b82f6', 'secondary_color' => '#1e3a8a'], // Azul y azul oscuro
            'deportivo' => ['primary_color' => '#ef4444', 'secondary_color' => '#0f172a'], // Rojo y casi negro
            'elegante' => ['primary_color' => '#c9a96e', 'secondary_color' => '#0a0a0a'], // Dorado y negro
            'corporativo' => ['primary_color' => '#1e3a5f', 'secondary_color' => '#f8fafc'], // Azul marino y blanco
            'tecnologico' => ['primary_color' => '#2563eb', 'secondary_color' => '#0B1120'], // Azul tech y navy oscuro
            'innovador' => ['primary_color' => '#2563eb', 'secondary_color' => '#fafbff'], // Azul y blanco lavanda
        ];

        // Obtener settings reales del tenant
        $dbSettings = TenantSetting::where('tenant_id', $tenant->id)->first();
        
        // Si hay settings en DB, usar esos, sino crear defaults
        if ($dbSettings) {
            $settings = $dbSettings;
        } else {
            $settings = (object)[
                'template' => $template,
                'primary_color' => $templateColors[$template]['primary_color'],
                'secondary_color' => $templateColors[$template]['secondary_color'],
                'logo_url' => null,
                'banner_url' => 'https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?w=1200&h=600&fit=crop',
                'home_description' => 'AGENCIA DE AUTOS USADOS Y 0KM... FINANCIACION HASTA EL 70% DEL VALOR DEL VEHICULO. LOS MEJORES AUTOS DE LA CIUDAD 100% VERIFICADOS',
                'contact_message' => '¿Listo para encontrar tu próximo vehículo? Contáctanos y te ayudaremos a encontrar la mejor opción.',
                'phone' => '+54 9 11 1234-5678',
                'email' => 'contacto@ejemplo.com',
                'whatsapp' => '+54 9 11 1234-5678',
                'facebook_url' => 'https://facebook.com',
                'instagram_url' => 'https://instagram.com',
                'linkedin_url' => null,
                'show_vehicles' => true,
                'show_contact_form' => true,
            ];
        }

        // Vehículos de prueba con imágenes reales
        $vehicles = collect([
            (object)[
                'id' => 3,
                'title' => 'Volkswagen Tiguan 2023',
                'brand' => 'Volkswagen',
                'model' => 'Tiguan',
                'year' => 2023,
                'price' => 42000,
                'kilometers' => 15000,
                'main_image' => 'https://images.unsplash.com/photo-1581540222194-0def2dda95b8?w=400&h=300&fit=crop',
                'description' => 'SUV familiar con 7 asientos, tracción 4x4, ideal para viajes largos y aventuras en familia.'
            ],
            (object)[
                'id' => 4,
                'title' => 'BMW Serie 3 2022',
                'brand' => 'BMW',
                'model' => 'Serie 3',
                'year' => 2022,
                'price' => 52000,
                'kilometers' => 18000,
                'main_image' => 'https://images.unsplash.com/photo-1555215695-3004980ad54e?w=400&h=300&fit=crop',
                'description' => 'Sedán premium con tecnología de punta, motor turbo, asientos de cuero y sistema de navegación.'
            ],
            (object)[
                'id' => 5,
                'title' => 'Chevrolet Camaro SS 2023',
                'brand' => 'Chevrolet',
                'model' => 'Camaro SS',
                'year' => 2023,
                'price' => 58000,
                'kilometers' => 5000,
                'main_image' => 'https://images.unsplash.com/photo-1552519507-da3b142c6e3d?w=400&h=300&fit=crop',
                'description' => 'Muscle car icónico con diseño agresivo, motor V8 y sonido inconfundible. Casi sin uso.'
            ],
            (object)[
                'id' => 6,
                'title' => 'Audi A4 2023',
                'brand' => 'Audi',
                'model' => 'A4',
                'year' => 2023,
                'price' => 48000,
                'kilometers' => 10000,
                'main_image' => 'https://images.unsplash.com/photo-1606664515524-ed2f786a0bd6?w=400&h=300&fit=crop',
                'description' => 'Elegancia alemana con tecnología quattro, interior premium y asistentes de manejo avanzados.'
            ],
        ]);

        return view("public.templates.{$template}", compact('tenant', 'settings', 'vehicles', 'editMode', 'template'));
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
