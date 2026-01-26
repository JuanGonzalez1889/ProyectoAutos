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
        return view('admin.vehicles.create');
    }

    public function store(Request $request)
    {
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

        /** @var \App\Models\User $user */
        $user = Auth::user();
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
}
