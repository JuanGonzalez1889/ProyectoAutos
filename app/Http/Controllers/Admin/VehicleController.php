<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VehicleController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $query = Vehicle::with(['user', 'agencia'])->latest();
        
        // Si es agenciero, filtrar por agencia
        if ($user->isAgenciero() && $user->agencia_id) {
            $query->where('agencia_id', $user->agencia_id);
        }
        
        $vehicles = $query->paginate(12);
        
        return view('admin.vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $tenant = $user->tenant;
        $subscription = $tenant->activeSubscription();
        $plan = $subscription ? $subscription->plan : 'free';
        $limits = [
            'basic' => 10,
            'professional' => 30,
            'premium' => 50,
            'enterprise' => null,
        ];
        $maxVehicles = $limits[$plan] ?? null;
        // Detectar planes de test por nombre
        if (stripos($plan, 'test') !== false) {
            $maxVehicles = 1;
        }

        $vehicleQuery = \App\Models\Vehicle::query();
        if ($user->isAgenciero() && $user->agencia_id) {
            $vehicleQuery->where('agencia_id', $user->agencia_id);
        } else {
            $vehicleQuery->where('tenant_id', $tenant->id);
        }
        $vehicleQuery->where('status', 'published');
        $currentVehicles = $vehicleQuery->count();

        if ($maxVehicles !== null && $currentVehicles >= $maxVehicles) {
            return redirect()->route('admin.vehicles.index')
                ->with('error', 'Has alcanzado el límite de vehículos publicados para tu plan actual. Si deseas publicar más autos, por favor actualiza tu plan.');
        }

        // Log después de definir variables
        \Log::info('[DEBUG] Entrando a create vehicle', [
            'user_id' => $user->id,
            'plan' => $plan,
            'maxVehicles' => $maxVehicles,
            'currentVehicles' => $currentVehicles
        ]);

        // Log después de definir variables
        \Log::info('[DEBUG] Entrando a create vehicle', [
            'user_id' => $user->id,
            'plan' => $plan,
            'maxVehicles' => $maxVehicles,
            'currentVehicles' => $currentVehicles
        ]);

        if ($maxVehicles !== null && $currentVehicles >= $maxVehicles) {
            return redirect()->route('admin.vehicles.index')
                ->with('error', 'Has alcanzado el límite de vehículos publicados para tu plan actual. Si deseas publicar más autos, por favor actualiza tu plan.');
        }

        return view('admin.vehicles.create');
    }

    public function store(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $tenant = $user->tenant;
        $subscription = $tenant->activeSubscription();
        $plan = $subscription ? $subscription->plan : 'free';
        $planDetails = $subscription && method_exists($subscription, 'getPlanDetails') ? $subscription->getPlanDetails() : [];

        // Definir límites por plan
        $limits = [
            'basic' => 10,
            'professional' => 30,
            'premium' => 50,
            'enterprise' => null, // Ilimitado
            'test' => 1, // Solo 1 auto para el plan de test
        ];
        $maxVehicles = $limits[$plan] ?? null;

        // Contar vehículos publicados por la agencia/tenant
        $vehicleQuery = \App\Models\Vehicle::query();
        if ($user->isAgenciero() && $user->agencia_id) {
            $vehicleQuery->where('agencia_id', $user->agencia_id);
        } else {
            $vehicleQuery->where('tenant_id', $tenant->id);
        }

        // Determinar el status que tendrá el nuevo vehículo
        $newStatus = $request->input('status', 'published');
        if ($newStatus === 'published') {
            $vehicleQuery->where('status', 'published');
            $currentVehicles = $vehicleQuery->count();
            if ($maxVehicles !== null && $currentVehicles >= $maxVehicles) {
                return redirect()->back()->withInput()->with('error', 'Has alcanzado el límite de vehículos publicados para tu plan actual. Si deseas publicar más autos, por favor actualiza tu plan.');
            }
        }

        if ($maxVehicles !== null && $currentVehicles >= $maxVehicles) {
            return redirect()->back()->withInput()->with('error', 'Has alcanzado el límite de vehículos para tu plan actual. Si deseas publicar más autos, por favor actualiza tu plan.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'price' => 'required|numeric|min:0',
            'price_original' => 'nullable|numeric|min:0',
            'description' => 'required|string',
            'fuel_type' => 'nullable|string',
            'transmission' => 'nullable|string',
            'kilometers' => 'nullable|integer|min:0',
            'color' => 'nullable|string|max:50',
            'plate' => 'nullable|string|max:20',
            'contact_name' => 'nullable|string|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'contact_email' => 'nullable|email|max:255',
            'status' => 'required|in:draft,published,sold',
            'featured' => 'boolean',
            'images.*' => 'nullable|image|max:5120', // 5MB max
            'features' => 'nullable|array',
        ]);

        $validated['user_id'] = $user->id;
        $validated['agencia_id'] = $user->agencia_id;

        // Procesar imágenes
        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('vehicles', 'public');
                $images[] = '/storage/' . $path;
            }
        }
        $validated['images'] = $images;

        Vehicle::create($validated);

        return redirect()->route('admin.vehicles.index')
            ->with('success', 'Vehículo creado exitosamente');
    }

    public function show(Vehicle $vehicle)
    {
        return view('admin.vehicles.show', compact('vehicle'));
    }

    public function edit(Vehicle $vehicle)
    {
        return view('admin.vehicles.edit', compact('vehicle'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'price' => 'required|numeric|min:0',
            'price_original' => 'nullable|numeric|min:0',
            'sold_price' => 'nullable|numeric|min:0',
            'description' => 'required|string',
            'fuel_type' => 'nullable|string',
            'transmission' => 'nullable|string',
            'kilometers' => 'nullable|integer|min:0',
            'color' => 'nullable|string|max:50',
            'plate' => 'nullable|string|max:20',
            'contact_name' => 'nullable|string|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'contact_email' => 'nullable|email|max:255',
            'status' => 'required|in:draft,published,sold',
            'featured' => 'boolean',
            'images.*' => 'nullable|image|max:5120',
            'features' => 'nullable|array',
            'existing_images' => 'nullable|array',
        ]);

        // Si el estado es "sold", el precio de venta real es obligatorio
        if ($validated['status'] === 'sold' && (empty($validated['sold_price']) || $validated['sold_price'] <= 0)) {
            return redirect()->back()->withInput()->withErrors(['sold_price' => 'El precio de venta real es obligatorio cuando el vehículo está vendido.']);
        }

        // Mantener imágenes existentes
        $images = $validated['existing_images'] ?? [];
        
        // Agregar nuevas imágenes
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('vehicles', 'public');
                $images[] = '/storage/' . $path;
            }
        }
        $validated['images'] = $images;
        unset($validated['existing_images']);

        $vehicle->update($validated);

        return redirect()->route('admin.vehicles.index')
            ->with('success', 'Vehículo actualizado exitosamente');
    }

    public function destroy(Vehicle $vehicle)
    {
        // Eliminar imágenes del storage
        if ($vehicle->images) {
            foreach ($vehicle->images as $image) {
                $path = str_replace('/storage/', '', $image);
                Storage::disk('public')->delete($path);
            }
        }

        $vehicle->delete();

        return redirect()->route('admin.vehicles.index')
            ->with('success', 'Vehículo eliminado exitosamente');
    }

    /**
     * Marcar vehículo como vendido vía AJAX
     */
    public function markAsSold(Request $request, Vehicle $vehicle)
    {
        $validated = $request->validate([
            'sold_price' => 'required|numeric|min:1',
        ]);

        $vehicle->sold_price = $validated['sold_price'];
        $vehicle->status = 'sold';
        $vehicle->save();

        return response()->json([
            'success' => true,
            'sold_price' => $vehicle->sold_price,
            'vehicle_id' => $vehicle->id,
        ]);
    }
}
