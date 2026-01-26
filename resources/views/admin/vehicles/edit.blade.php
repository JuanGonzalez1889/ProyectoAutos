@extends('layouts.admin')

@section('title', 'Editar Vehículo')
@section('page-title', 'Editar Vehículo')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.vehicles.index') }}" 
           class="p-2 hover:bg-[hsl(var(--muted))] rounded-lg transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
        <div>
            <h3 class="text-xl font-semibold text-white">Editar Vehículo</h3>
            <p class="text-sm text-[hsl(var(--muted-foreground))]">{{ $vehicle->title }}</p>
        </div>
    </div>

    <form action="{{ route('admin.vehicles.update', $vehicle) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Imágenes actuales -->
        @if($vehicle->images && count($vehicle->images) > 0)
        <div class="card">
            <h4 class="text-lg font-semibold mb-4">Imágenes Actuales</h4>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($vehicle->images as $index => $image)
                <div class="relative group">
                    <img src="{{ $image }}" alt="Imagen {{ $index + 1 }}" class="w-full h-32 object-cover rounded-lg">
                    <label class="absolute top-2 right-2 p-1 bg-red-500 hover:bg-red-600 rounded cursor-pointer opacity-0 group-hover:opacity-100 transition-opacity">
                        <input type="checkbox" name="existing_images[]" value="{{ $image }}" checked class="sr-only">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </label>
                </div>
                @endforeach
            </div>
            <p class="mt-2 text-xs text-[hsl(var(--muted-foreground))]">Haz clic en la X para eliminar una imagen</p>
        </div>
        @endif

        <!-- Información Básica -->
        <div class="card">
            <h4 class="text-lg font-semibold mb-4">Información Básica</h4>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium mb-2">Título del Anuncio</label>
                    <input type="text" name="title" value="{{ old('title', $vehicle->title) }}" required
                           class="w-full h-10 px-3 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))]">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Marca</label>
                    <input type="text" name="brand" value="{{ old('brand', $vehicle->brand) }}" required
                           class="w-full h-10 px-3 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))]">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Modelo</label>
                    <input type="text" name="model" value="{{ old('model', $vehicle->model) }}" required
                           class="w-full h-10 px-3 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))]">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Año</label>
                    <input type="number" name="year" value="{{ old('year', $vehicle->year) }}" required
                           min="1900" max="{{ date('Y') + 1 }}"
                           class="w-full h-10 px-3 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))]">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Precio</label>
                    <input type="number" name="price" value="{{ old('price', $vehicle->price) }}" required
                           min="0" step="0.01"
                           class="w-full h-10 px-3 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))]">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Precio Original (opcional)</label>
                    <input type="number" name="price_original" value="{{ old('price_original', $vehicle->price_original) }}"
                           min="0" step="0.01"
                           class="w-full h-10 px-3 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))]">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Kilómetros</label>
                    <input type="number" name="kilometers" value="{{ old('kilometers', $vehicle->kilometers) }}"
                           min="0"
                           class="w-full h-10 px-3 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))]">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Color</label>
                    <input type="text" name="color" value="{{ old('color', $vehicle->color) }}"
                           class="w-full h-10 px-3 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))]">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Combustible</label>
                    <select name="fuel_type"
                            class="w-full h-10 px-3 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))]">
                        <option value="">Seleccionar...</option>
                        <option value="Gasolina" {{ old('fuel_type', $vehicle->fuel_type) === 'Gasolina' ? 'selected' : '' }}>Gasolina</option>
                        <option value="Diesel" {{ old('fuel_type', $vehicle->fuel_type) === 'Diesel' ? 'selected' : '' }}>Diesel</option>
                        <option value="Eléctrico" {{ old('fuel_type', $vehicle->fuel_type) === 'Eléctrico' ? 'selected' : '' }}>Eléctrico</option>
                        <option value="Híbrido" {{ old('fuel_type', $vehicle->fuel_type) === 'Híbrido' ? 'selected' : '' }}>Híbrido</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Transmisión</label>
                    <select name="transmission"
                            class="w-full h-10 px-3 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))]">
                        <option value="">Seleccionar...</option>
                        <option value="Manual" {{ old('transmission', $vehicle->transmission) === 'Manual' ? 'selected' : '' }}>Manual</option>
                        <option value="Automático" {{ old('transmission', $vehicle->transmission) === 'Automático' ? 'selected' : '' }}>Automático</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Placa</label>
                    <input type="text" name="plate" value="{{ old('plate', $vehicle->plate) }}"
                           class="w-full h-10 px-3 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))]">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium mb-2">Descripción</label>
                    <textarea name="description" rows="5" required
                              class="w-full px-3 py-2 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))]">{{ old('description', $vehicle->description) }}</textarea>
                </div>
            </div>
        </div>

        <!-- Agregar más imágenes -->
        <div class="card">
            <h4 class="text-lg font-semibold mb-4">Agregar Más Imágenes</h4>
            
            <div>
                <input type="file" name="images[]" multiple accept="image/*"
                       class="w-full px-3 py-2 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))]">
                <p class="mt-2 text-xs text-[hsl(var(--muted-foreground))]">Formatos: JPG, PNG. Tamaño máximo: 5MB</p>
            </div>
        </div>

        <!-- Datos de Contacto -->
        <div class="card">
            <h4 class="text-lg font-semibold mb-4">Datos de Contacto</h4>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-2">Nombre de Contacto</label>
                    <input type="text" name="contact_name" value="{{ old('contact_name', $vehicle->contact_name) }}"
                           class="w-full h-10 px-3 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))]">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Teléfono</label>
                    <input type="text" name="contact_phone" value="{{ old('contact_phone', $vehicle->contact_phone) }}"
                           class="w-full h-10 px-3 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))]">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Email</label>
                    <input type="email" name="contact_email" value="{{ old('contact_email', $vehicle->contact_email) }}"
                           class="w-full h-10 px-3 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))]">
                </div>
            </div>
        </div>

        <!-- Estado -->
        <div class="card">
            <h4 class="text-lg font-semibold mb-4">Estado y Publicación</h4>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-2">Estado</label>
                    <select name="status" required
                            class="w-full h-10 px-3 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))]">
                        <option value="draft" {{ old('status', $vehicle->status) === 'draft' ? 'selected' : '' }}>Borrador</option>
                        <option value="published" {{ old('status', $vehicle->status) === 'published' ? 'selected' : '' }}>Publicado</option>
                        <option value="sold" {{ old('status', $vehicle->status) === 'sold' ? 'selected' : '' }}>Vendido</option>
                    </select>
                </div>

                <div>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="featured" value="1" {{ old('featured', $vehicle->featured) ? 'checked' : '' }}
                               class="w-4 h-4 rounded border-[hsl(var(--border))] bg-[hsl(var(--background))]">
                        <span class="text-sm">⭐ Marcar como destacado</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Botones -->
        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.vehicles.index') }}" 
               class="h-10 px-5 bg-[hsl(var(--secondary))] hover:bg-[hsl(var(--muted))] rounded-lg text-sm font-medium transition-colors flex items-center">
                Cancelar
            </a>
            <button type="submit" 
                    class="h-10 px-5 bg-[hsl(var(--primary))] hover:opacity-90 text-[#0a0f14] rounded-lg text-sm font-medium transition-opacity flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Actualizar Vehículo
            </button>
        </div>
    </form>
</div>
@endsection
