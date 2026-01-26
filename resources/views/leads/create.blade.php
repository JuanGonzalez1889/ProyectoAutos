@extends('layouts.admin')

@section('title', 'Nuevo Lead')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm text-[hsl(var(--muted-foreground))] mb-2">
            <a href="{{ route('admin.leads.index') }}" class="hover:text-[hsl(var(--foreground))]">Leads</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <span class="text-[hsl(var(--foreground))]">Nuevo Lead</span>
        </div>
        <h1 class="text-2xl font-bold text-[hsl(var(--foreground))]">Crear Nuevo Lead</h1>
    </div>

    <!-- Formulario -->
    <div class="max-w-4xl">
        <form action="{{ route('admin.leads.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="bg-[hsl(var(--card))] border border-[hsl(var(--border))] rounded-lg p-6">
                <h2 class="text-lg font-semibold text-[hsl(var(--foreground))] mb-4">Información del Cliente</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Nombre -->
                    <div class="md:col-span-2">
                        <label for="name" class="block text-sm font-medium text-[hsl(var(--foreground))] mb-1">
                            Nombre Completo <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="name" 
                               id="name" 
                               required
                               value="{{ old('name') }}"
                               class="w-full px-3 py-2 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))] focus:outline-none focus:ring-2 focus:ring-[hsl(var(--primary))] focus:border-transparent"
                               placeholder="Juan Pérez">
                        @error('name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Teléfono -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-[hsl(var(--foreground))] mb-1">
                            Teléfono <span class="text-red-500">*</span>
                        </label>
                        <input type="tel" 
                               name="phone" 
                               id="phone" 
                               required
                               value="{{ old('phone') }}"
                               class="w-full px-3 py-2 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))] focus:outline-none focus:ring-2 focus:ring-[hsl(var(--primary))] focus:border-transparent"
                               placeholder="+54 9 11 1234-5678">
                        @error('phone')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-[hsl(var(--foreground))] mb-1">
                            Email
                        </label>
                        <input type="email" 
                               name="email" 
                               id="email"
                               value="{{ old('email') }}"
                               class="w-full px-3 py-2 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))] focus:outline-none focus:ring-2 focus:ring-[hsl(var(--primary))] focus:border-transparent"
                               placeholder="juan@example.com">
                        @error('email')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Presupuesto -->
                    <div>
                        <label for="budget" class="block text-sm font-medium text-[hsl(var(--foreground))] mb-1">
                            Presupuesto
                        </label>
                        <input type="number" 
                               name="budget" 
                               id="budget"
                               min="0"
                               step="0.01"
                               value="{{ old('budget') }}"
                               class="w-full px-3 py-2 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))] focus:outline-none focus:ring-2 focus:ring-[hsl(var(--primary))] focus:border-transparent"
                               placeholder="10000000">
                        @error('budget')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Fuente -->
                    <div>
                        <label for="source" class="block text-sm font-medium text-[hsl(var(--foreground))] mb-1">
                            Fuente del Lead
                        </label>
                        <select name="source" 
                                id="source"
                                class="w-full px-3 py-2 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))] focus:outline-none focus:ring-2 focus:ring-[hsl(var(--primary))] focus:border-transparent">
                            <option value="">Seleccionar...</option>
                            <option value="web" {{ old('source') === 'web' ? 'selected' : '' }}>Sitio Web</option>
                            <option value="phone" {{ old('source') === 'phone' ? 'selected' : '' }}>Teléfono</option>
                            <option value="social_media" {{ old('source') === 'social_media' ? 'selected' : '' }}>Redes Sociales</option>
                            <option value="referral" {{ old('source') === 'referral' ? 'selected' : '' }}>Referido</option>
                            <option value="walk_in" {{ old('source') === 'walk_in' ? 'selected' : '' }}>Visita Directa</option>
                            <option value="other" {{ old('source') === 'other' ? 'selected' : '' }}>Otro</option>
                        </select>
                        @error('source')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="bg-[hsl(var(--card))] border border-[hsl(var(--border))] rounded-lg p-6">
                <h2 class="text-lg font-semibold text-[hsl(var(--foreground))] mb-4">Detalles del Lead</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Estado -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-[hsl(var(--foreground))] mb-1">
                            Estado <span class="text-red-500">*</span>
                        </label>
                        <select name="status" 
                                id="status"
                                required
                                class="w-full px-3 py-2 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))] focus:outline-none focus:ring-2 focus:ring-[hsl(var(--primary))] focus:border-transparent">
                            <option value="new" {{ old('status', 'new') === 'new' ? 'selected' : '' }}>Nuevo</option>
                            <option value="contacted" {{ old('status') === 'contacted' ? 'selected' : '' }}>Contactado</option>
                            <option value="interested" {{ old('status') === 'interested' ? 'selected' : '' }}>Interesado</option>
                            <option value="negotiating" {{ old('status') === 'negotiating' ? 'selected' : '' }}>Negociando</option>
                            <option value="won" {{ old('status') === 'won' ? 'selected' : '' }}>Ganado</option>
                            <option value="lost" {{ old('status') === 'lost' ? 'selected' : '' }}>Perdido</option>
                        </select>
                        @error('status')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Vehículo de Interés -->
                    <div>
                        <label for="vehicle_id" class="block text-sm font-medium text-[hsl(var(--foreground))] mb-1">
                            Vehículo de Interés
                        </label>
                        <select name="vehicle_id" 
                                id="vehicle_id"
                                class="w-full px-3 py-2 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))] focus:outline-none focus:ring-2 focus:ring-[hsl(var(--primary))] focus:border-transparent">
                            <option value="">Sin vehículo específico</option>
                            @foreach($vehicles as $vehicle)
                            <option value="{{ $vehicle->id }}" {{ old('vehicle_id') == $vehicle->id ? 'selected' : '' }}>
                                {{ $vehicle->brand }} {{ $vehicle->model }} ({{ $vehicle->year }})
                            </option>
                            @endforeach
                        </select>
                        @error('vehicle_id')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Próximo Seguimiento -->
                    <div class="md:col-span-2">
                        <label for="next_follow_up" class="block text-sm font-medium text-[hsl(var(--foreground))] mb-1">
                            Próximo Seguimiento
                        </label>
                        <input type="datetime-local" 
                               name="next_follow_up" 
                               id="next_follow_up"
                               value="{{ old('next_follow_up') }}"
                               class="w-full px-3 py-2 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))] focus:outline-none focus:ring-2 focus:ring-[hsl(var(--primary))] focus:border-transparent">
                        @error('next_follow_up')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Notas -->
                    <div class="md:col-span-2">
                        <label for="notes" class="block text-sm font-medium text-[hsl(var(--foreground))] mb-1">
                            Notas / Observaciones
                        </label>
                        <textarea name="notes" 
                                  id="notes"
                                  rows="4"
                                  class="w-full px-3 py-2 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))] focus:outline-none focus:ring-2 focus:ring-[hsl(var(--primary))] focus:border-transparent resize-none"
                                  placeholder="Información adicional sobre el lead...">{{ old('notes') }}</textarea>
                        @error('notes')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Botones -->
            <div class="flex items-center gap-3">
                <button type="submit" 
                        class="px-6 py-2.5 bg-[hsl(var(--primary))] hover:opacity-90 text-[#0a0f14] rounded-lg font-semibold transition-opacity">
                    Crear Lead
                </button>
                <a href="{{ route('admin.leads.index') }}" 
                   class="px-6 py-2.5 bg-[hsl(var(--secondary))] hover:bg-[hsl(var(--secondary))]/80 text-[hsl(var(--foreground))] rounded-lg font-semibold transition-colors">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
