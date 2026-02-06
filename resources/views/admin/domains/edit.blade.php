@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('admin.domains.index') }}" class="text-blue-600 hover:text-blue-900">← Volver</a>
            <h1 class="mt-2 text-3xl font-bold text-gray-900">Editar Dominio</h1>
        </div>

        <!-- Edit Form -->
        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ route('admin.domains.update', $domain) }}" method="POST">
                @csrf
                @method('PATCH')

                <!-- Domain Input -->
                <div class="mb-6">
                    <label for="domain" class="block text-sm font-medium text-gray-700">Nombre del Dominio</label>
                    <input 
                        type="text" 
                        id="domain" 
                        name="domain" 
                        value="{{ old('domain', $domain->domain) }}"
                        class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('domain') border-red-500 @else border-gray-300 @enderror"
                    >
                    @error('domain')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Type Display (read-only) -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700">Tipo de Dominio</label>
                    <div class="mt-2 px-4 py-2 bg-gray-100 rounded-lg border border-gray-300">
                        <p class="text-gray-900">{{ ucfirst($domain->type) }}</p>
                        <p class="text-xs text-gray-500 mt-1">No se puede modificar después de crear el dominio</p>
                    </div>
                </div>

                <!-- Status Display -->
                <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                        <p class="text-xs text-gray-600">DNS Configurado</p>
                        <p class="text-lg font-medium text-gray-900 mt-1">
                            {{ $domain->dns_configured ? '✓ Sí' : '✗ No' }}
                        </p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                        <p class="text-xs text-gray-600">SSL Verificado</p>
                        <p class="text-lg font-medium text-gray-900 mt-1">
                            {{ $domain->ssl_verified ? '✓ Sí' : '✗ No' }}
                        </p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                        <p class="text-xs text-gray-600">Estado de Registro</p>
                        <p class="text-lg font-medium text-gray-900 mt-1">
                            {{ ucfirst($domain->registration_status) }}
                        </p>
                    </div>
                </div>

                <!-- Information -->
                <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <h3 class="text-sm font-medium text-blue-900">Información</h3>
                    <p class="mt-2 text-sm text-blue-700">
                        Los cambios en el dominio se aplicarán inmediatamente. Si necesitas cambiar la configuración completa, considera eliminar y recrear el dominio.
                    </p>
                </div>

                <!-- Buttons -->
                <div class="flex gap-3">
                    <button 
                        type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500"
                    >
                        Actualizar Dominio
                    </button>
                    <a 
                        href="{{ route('admin.domains.show', $domain) }}" 
                        class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50"
                    >
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
