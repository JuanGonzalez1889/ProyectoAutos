@extends('layouts.admin')

@section('title', 'Mi Agencia')
@section('page-title', 'Mi Agencia')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="card">
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('admin.agencia.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- Nombre de la Agencia -->
                <div>
                    <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2">
                        Nombre de la Agencia <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="nombre" 
                        name="nombre" 
                        value="{{ old('nombre', $agencia->nombre) }}"
                        class="input-field @error('nombre') border-red-500 @enderror"
                        required
                    >
                    @error('nombre')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Ubicación -->
                <div>
                    <label for="ubicacion" class="block text-sm font-medium text-gray-700 mb-2">
                        Ubicación
                    </label>
                    <input 
                        type="text" 
                        id="ubicacion" 
                        name="ubicacion" 
                        value="{{ old('ubicacion', $agencia->ubicacion) }}"
                        class="input-field @error('ubicacion') border-red-500 @enderror"
                        placeholder="Ej: Buenos Aires, Argentina"
                    >
                    @error('ubicacion')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Teléfono -->
                <div>
                    <label for="telefono" class="block text-sm font-medium text-gray-700 mb-2">
                        Teléfono
                    </label>
                    <input 
                        type="text" 
                        id="telefono" 
                        name="telefono" 
                        value="{{ old('telefono', $agencia->telefono) }}"
                        class="input-field @error('telefono') border-red-500 @enderror"
                        placeholder="Ej: +54 11 1234-5678"
                    >
                    @error('telefono')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Botones -->
                <div class="flex justify-end space-x-3 pt-4">
                    <a href="{{ route('admin.dashboard') }}" class="btn-secondary">
                        Cancelar
                    </a>
                    <button type="submit" class="btn-primary">
                        Guardar Cambios
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
