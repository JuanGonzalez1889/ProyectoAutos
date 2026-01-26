@extends('layouts.admin')

@section('title', 'Editar Agencia - ' . $tenant->name)

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-2xl mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Editar Agencia</h1>
            <p class="text-gray-600 mt-1">{{ $tenant->name }}</p>
        </div>

        <!-- Formulario -->
        <div class="bg-white rounded-lg shadow">
            <form action="{{ route('admin.tenants.update', $tenant) }}" method="POST" class="p-6 space-y-6">
                @csrf
                @method('PATCH')

                <!-- Nombre -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">
                        Nombre de la Agencia <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name', $tenant->name) }}"
                           class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                           required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="{{ old('email', $tenant->email) }}"
                           class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror"
                           required>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Teléfono -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">
                        Teléfono
                    </label>
                    <input type="tel" 
                           id="phone" 
                           name="phone" 
                           value="{{ old('phone', $tenant->phone) }}"
                           class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('phone') border-red-500 @enderror"
                           placeholder="+34 900 000 000">
                    @error('phone')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Dirección -->
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700">
                        Dirección
                    </label>
                    <input type="text" 
                           id="address" 
                           name="address" 
                           value="{{ old('address', $tenant->address) }}"
                           class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('address') border-red-500 @enderror"
                           placeholder="Calle, número, ciudad, país">
                    @error('address')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Plan -->
                <div>
                    <label for="plan" class="block text-sm font-medium text-gray-700">
                        Plan <span class="text-red-500">*</span>
                    </label>
                    <select id="plan" 
                            name="plan"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('plan') border-red-500 @enderror"
                            required>
                        <option value="">Selecciona un plan</option>
                        <option value="basic" @selected(old('plan', $tenant->plan) === 'basic')>Básico - $29/mes</option>
                        <option value="premium" @selected(old('plan', $tenant->plan) === 'premium')>Premium - $79/mes</option>
                        <option value="enterprise" @selected(old('plan', $tenant->plan) === 'enterprise')>Enterprise - $199/mes</option>
                    </select>
                    @error('plan')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Estado de Prueba -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <p class="text-sm font-medium text-blue-900 mb-3">Período de Prueba</p>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="trial_ends_at" class="block text-sm text-blue-800">
                                Fin de Prueba (Opcional)
                            </label>
                            <input type="date" 
                                   id="trial_ends_at" 
                                   name="trial_ends_at" 
                                   value="{{ old('trial_ends_at', $tenant->trial_ends_at?->format('Y-m-d')) }}"
                                   class="mt-1 block w-full px-4 py-2 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>
                    
                    @if($tenant->isOnTrial())
                        <p class="text-sm text-blue-800 mt-3">
                            ✅ Actualmente en período de prueba. Vence el {{ $tenant->trial_ends_at->format('d/m/Y') }}
                        </p>
                    @endif
                </div>

                <!-- Estado de Suscripción -->
                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <p class="text-sm font-medium text-green-900 mb-3">Suscripción</p>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="subscription_ends_at" class="block text-sm text-green-800">
                                Fin de Suscripción (Opcional)
                            </label>
                            <input type="date" 
                                   id="subscription_ends_at" 
                                   name="subscription_ends_at" 
                                   value="{{ old('subscription_ends_at', $tenant->subscription_ends_at?->format('Y-m-d')) }}"
                                   class="mt-1 block w-full px-4 py-2 border border-green-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        </div>
                    </div>

                    @if($tenant->hasActiveSubscription())
                        <p class="text-sm text-green-800 mt-3">
                            ✅ Suscripción activa. Vence el {{ $tenant->subscription_ends_at->format('d/m/Y') }}
                        </p>
                    @endif
                </div>

                <!-- Estado Activo -->
                <div class="flex items-center space-x-3 bg-gray-50 border border-gray-200 rounded-lg p-4">
                    <input type="checkbox" 
                           id="is_active" 
                           name="is_active" 
                           value="1"
                           @checked(old('is_active', $tenant->is_active))
                           class="w-5 h-5 text-blue-600 rounded focus:ring-2 focus:ring-blue-500">
                    <label for="is_active" class="text-gray-900 font-medium cursor-pointer">
                        Agencia Activa
                    </label>
                </div>

                <!-- Errores Globales -->
                @if($errors->any())
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                        <p class="text-red-800 font-medium mb-2">Errores en el formulario:</p>
                        <ul class="text-red-700 text-sm list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Botones -->
                <div class="flex gap-3 pt-6 border-t border-gray-200">
                    <button type="submit" class="flex-1 px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                        💾 Guardar Cambios
                    </button>
                    <a href="{{ route('admin.tenants.show', $tenant) }}" class="flex-1 px-6 py-2 bg-gray-200 text-gray-900 rounded-lg hover:bg-gray-300 transition font-medium text-center">
                        ✕ Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
