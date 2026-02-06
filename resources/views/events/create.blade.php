@extends('layouts.admin')

@section('title', 'Crear Nueva Cita')
@section('page-title', 'Agregar Cita')

@section('content')
<div class="space-y-6">
    <!-- Formulario de Creación de Evento -->
    <div class="bg-[hsl(var(--card))] border border-[hsl(var(--border))] rounded-lg p-6">
        <form action="{{ route('admin.events.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Título -->
            <div>
                <label for="title" class="block text-sm font-medium text-[hsl(var(--foreground))] mb-2">
                    Título de la Cita *
                </label>
                <input type="text" 
                       id="title" 
                       name="title" 
                       value="{{ old('title') }}"
                       placeholder="ej: Prueba de Manejo"
                       class="w-full px-4 py-2 bg-[hsl(var(--secondary))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))] focus:outline-none focus:border-[hsl(var(--primary))] @error('title') border-red-500 @enderror">
                @error('title')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Descripción -->
            <div>
                <label for="description" class="block text-sm font-medium text-[hsl(var(--foreground))] mb-2">
                    Descripción
                </label>
                <textarea id="description" 
                          name="description" 
                          rows="4"
                          placeholder="Detalles adicionales de la cita"
                          class="w-full px-4 py-2 bg-[hsl(var(--secondary))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))] focus:outline-none focus:border-[hsl(var(--primary))] @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tipo de Evento -->
            <div>
                <label for="type" class="block text-sm font-medium text-[hsl(var(--foreground))] mb-2">
                    Tipo de Evento *
                </label>
                <select id="type" 
                        name="type"
                        class="w-full px-4 py-2 bg-[hsl(var(--secondary))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))] focus:outline-none focus:border-[hsl(var(--primary))] @error('type') border-red-500 @enderror">
                    <option value="">Selecciona un tipo</option>
                    <option value="meeting" {{ old('type') === 'meeting' ? 'selected' : '' }}>Reunión</option>
                    <option value="delivery" {{ old('type') === 'delivery' ? 'selected' : '' }}>Entrega</option>
                    <option value="test_drive" {{ old('type') === 'test_drive' ? 'selected' : '' }}>Prueba de Manejo</option>
                    <option value="service" {{ old('type') === 'service' ? 'selected' : '' }}>Servicio</option>
                    <option value="other" {{ old('type') === 'other' ? 'selected' : '' }}>Otro</option>
                </select>
                @error('type')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Fecha y Hora -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="start_time" class="block text-sm font-medium text-[hsl(var(--foreground))] mb-2">
                        Fecha y Hora de Inicio *
                    </label>
                    <input type="datetime-local" 
                           id="start_time" 
                           name="start_time" 
                           value="{{ old('start_time') }}"
                           class="w-full px-4 py-2 bg-[hsl(var(--secondary))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))] focus:outline-none focus:border-[hsl(var(--primary))] @error('start_time') border-red-500 @enderror">
                    @error('start_time')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="end_time" class="block text-sm font-medium text-[hsl(var(--foreground))] mb-2">
                        Fecha y Hora de Fin
                    </label>
                    <input type="datetime-local" 
                           id="end_time" 
                           name="end_time" 
                           value="{{ old('end_time') }}"
                           class="w-full px-4 py-2 bg-[hsl(var(--secondary))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))] focus:outline-none focus:border-[hsl(var(--primary))] @error('end_time') border-red-500 @enderror">
                    @error('end_time')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Ubicación -->
            <div>
                <label for="location" class="block text-sm font-medium text-[hsl(var(--foreground))] mb-2">
                    Ubicación
                </label>
                <input type="text" 
                       id="location" 
                       name="location" 
                       value="{{ old('location') }}"
                       placeholder="ej: Agencia Principal"
                       class="w-full px-4 py-2 bg-[hsl(var(--secondary))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))] focus:outline-none focus:border-[hsl(var(--primary))] @error('location') border-red-500 @enderror">
                @error('location')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nombre del Cliente -->
            <div>
                <label for="client_name" class="block text-sm font-medium text-[hsl(var(--foreground))] mb-2">
                    Nombre del Cliente
                </label>
                <input type="text" 
                       id="client_name" 
                       name="client_name" 
                       value="{{ old('client_name') }}"
                       placeholder="ej: Juan Pérez"
                       class="w-full px-4 py-2 bg-[hsl(var(--secondary))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))] focus:outline-none focus:border-[hsl(var(--primary))] @error('client_name') border-red-500 @enderror">
                @error('client_name')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Teléfono del Cliente -->
            <div>
                <label for="client_phone" class="block text-sm font-medium text-[hsl(var(--foreground))] mb-2">
                    Teléfono del Cliente
                </label>
                <input type="tel" 
                       id="client_phone" 
                       name="client_phone" 
                       value="{{ old('client_phone') }}"
                       placeholder="ej: +1 234 567 8900"
                       class="w-full px-4 py-2 bg-[hsl(var(--secondary))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))] focus:outline-none focus:border-[hsl(var(--primary))] @error('client_phone') border-red-500 @enderror">
                @error('client_phone')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Botones de Acción -->
            <div class="flex gap-4 justify-end pt-6 border-t border-[hsl(var(--border))]">
                <a href="{{ route('admin.events.index') }}" 
                   class="px-6 py-2 bg-[hsl(var(--secondary))] hover:opacity-80 text-[hsl(var(--foreground))] rounded-lg font-medium transition-opacity">
                    Cancelar
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-[hsl(var(--primary))] hover:opacity-90 text-[#0a0f14] rounded-lg font-medium transition-opacity">
                    Crear Cita
                </button>
            </div>
        </form>
    </div>

    <!-- Información de Ayuda -->
    <div class="bg-blue-500/10 border border-blue-500/20 rounded-lg p-4">
        <p class="text-sm text-[hsl(var(--muted-foreground))]">
            <strong class="text-blue-500">Tip:</strong> Completa todos los campos obligatorios (marcados con *) para crear una nueva cita. Puedes editar o cancelar eventos existentes desde la sección de Calendario.
        </p>
    </div>
</div>
@endsection
