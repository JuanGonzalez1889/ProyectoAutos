@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                Editar Evento
            </h1>
            <p class="text-gray-600 dark:text-gray-400 mt-2">
                Actualiza los detalles del evento
            </p>
        </div>

        <form action="{{ route('admin.events.update', $event) }}" method="POST" class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 space-y-6">
            @csrf
            @method('PATCH')

            {{-- Título --}}
            <div>
                <label for="title" class="block text-sm font-medium text-gray-900 dark:text-white mb-2">
                    Título del Evento <span class="text-red-600">*</span>
                </label>
                <input 
                    type="text" 
                    id="title" 
                    name="title" 
                    value="{{ old('title', $event->title) }}"
                    placeholder="Ej: Prueba de manejo" 
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white @error('title') border-red-500 @enderror"
                    required
                >
                @error('title')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Descripción --}}
            <div>
                <label for="description" class="block text-sm font-medium text-gray-900 dark:text-white mb-2">
                    Descripción
                </label>
                <textarea 
                    id="description" 
                    name="description" 
                    rows="4"
                    placeholder="Detalles adicionales del evento..."
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white @error('description') border-red-500 @enderror"
                >{{ old('description', $event->description) }}</textarea>
                @error('description')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tipo de Evento --}}
            <div>
                <label for="type" class="block text-sm font-medium text-gray-900 dark:text-white mb-2">
                    Tipo de Evento <span class="text-red-600">*</span>
                </label>
                <select 
                    id="type" 
                    name="type"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white @error('type') border-red-500 @enderror"
                    required
                >
                    <option value="">Selecciona un tipo</option>
                    <option value="meeting" {{ old('type', $event->type) === 'meeting' ? 'selected' : '' }}>Reunión</option>
                    <option value="delivery" {{ old('type', $event->type) === 'delivery' ? 'selected' : '' }}>Entrega</option>
                    <option value="test_drive" {{ old('type', $event->type) === 'test_drive' ? 'selected' : '' }}>Prueba de Manejo</option>
                    <option value="service" {{ old('type', $event->type) === 'service' ? 'selected' : '' }}>Servicio</option>
                    <option value="other" {{ old('type', $event->type) === 'other' ? 'selected' : '' }}>Otro</option>
                </select>
                @error('type')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Fecha y Hora de Inicio --}}
            <div>
                <label for="start_time" class="block text-sm font-medium text-gray-900 dark:text-white mb-2">
                    Fecha y Hora de Inicio <span class="text-red-600">*</span>
                </label>
                <input 
                    type="datetime-local" 
                    id="start_time" 
                    name="start_time"
                    value="{{ old('start_time', $event->start_time?->format('Y-m-d\TH:i')) }}"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white @error('start_time') border-red-500 @enderror"
                    required
                >
                @error('start_time')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Fecha y Hora de Fin --}}
            <div>
                <label for="end_time" class="block text-sm font-medium text-gray-900 dark:text-white mb-2">
                    Fecha y Hora de Fin
                </label>
                <input 
                    type="datetime-local" 
                    id="end_time" 
                    name="end_time"
                    value="{{ old('end_time', $event->end_time?->format('Y-m-d\TH:i')) }}"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white @error('end_time') border-red-500 @enderror"
                >
                @error('end_time')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Ubicación --}}
            <div>
                <label for="location" class="block text-sm font-medium text-gray-900 dark:text-white mb-2">
                    Ubicación
                </label>
                <input 
                    type="text" 
                    id="location" 
                    name="location" 
                    value="{{ old('location', $event->location) }}"
                    placeholder="Ej: Sucursal Centro" 
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white @error('location') border-red-500 @enderror"
                >
                @error('location')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Nombre del Cliente --}}
            <div>
                <label for="client_name" class="block text-sm font-medium text-gray-900 dark:text-white mb-2">
                    Nombre del Cliente
                </label>
                <input 
                    type="text" 
                    id="client_name" 
                    name="client_name" 
                    value="{{ old('client_name', $event->client_name) }}"
                    placeholder="Ej: Juan Pérez" 
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white @error('client_name') border-red-500 @enderror"
                >
                @error('client_name')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Teléfono del Cliente --}}
            <div>
                <label for="client_phone" class="block text-sm font-medium text-gray-900 dark:text-white mb-2">
                    Teléfono del Cliente
                </label>
                <input 
                    type="tel" 
                    id="client_phone" 
                    name="client_phone" 
                    value="{{ old('client_phone', $event->client_phone) }}"
                    placeholder="Ej: +1 234 567 8900" 
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white @error('client_phone') border-red-500 @enderror"
                >
                @error('client_phone')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Botones de Acción --}}
            <div class="flex gap-4 pt-4">
                <button 
                    type="submit" 
                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200"
                >
                    Actualizar Evento
                </button>
                <a 
                    href="{{ route('admin.events.calendar') }}" 
                    class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-900 font-semibold py-2 px-4 rounded-lg text-center transition duration-200"
                >
                    Cancelar
                </a>
            </div>
        </form>

        {{-- Botón para Eliminar --}}
        <div class="mt-8 p-6 bg-red-50 dark:bg-red-900/20 rounded-lg border border-red-200 dark:border-red-800">
            <h3 class="text-lg font-semibold text-red-900 dark:text-red-200 mb-4">Zona de Peligro</h3>
            <form 
                action="{{ route('admin.events.destroy', $event) }}" 
                method="POST" 
                onsubmit="return confirm('¿Estás seguro de que deseas eliminar este evento? Esta acción no se puede deshacer.')"
            >
                @csrf
                @method('DELETE')
                <button 
                    type="submit" 
                    class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200"
                >
                    Eliminar Evento
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
