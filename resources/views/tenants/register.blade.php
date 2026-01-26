@extends('layouts.public')

@section('title', 'Registrar Nueva Agencia - ProyectoAutos SaaS')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[hsl(var(--background))] to-[hsl(var(--secondary))] flex items-center justify-center p-4">
    <div class="w-full max-w-2xl">
        <!-- Logo/Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-[hsl(var(--foreground))] mb-2">ProyectoAutos SaaS</h1>
            <p class="text-[hsl(var(--muted-foreground))]">Registra tu agencia y comienza tu prueba gratuita</p>
        </div>

        <!-- Tarjeta de Registro -->
        <div class="bg-[hsl(var(--card))] border border-[hsl(var(--border))] rounded-lg shadow-lg p-8">
            <form action="javascript:void(0);" method="POST" class="space-y-5">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Nombre de la Agencia -->
                    <div class="md:col-span-2">
                        <label for="agencia_name" class="block text-sm font-medium text-[hsl(var(--foreground))] mb-2">
                            Nombre de la Agencia <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="agencia_name" 
                               id="agencia_name"
                               required
                               value="{{ old('agencia_name') }}"
                               class="w-full px-4 py-2.5 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))] focus:outline-none focus:ring-2 focus:ring-[hsl(var(--primary))] focus:border-transparent"
                               placeholder="Agencia Mi Auto">
                        @error('agencia_name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nombre del Administrador -->
                    <div>
                        <label for="admin_name" class="block text-sm font-medium text-[hsl(var(--foreground))] mb-2">
                            Tu Nombre Completo <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="admin_name" 
                               id="admin_name"
                               required
                               value="{{ old('admin_name') }}"
                               class="w-full px-4 py-2.5 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))] focus:outline-none focus:ring-2 focus:ring-[hsl(var(--primary))] focus:border-transparent"
                               placeholder="Juan Pérez">
                        @error('admin_name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email del Administrador -->
                    <div>
                        <label for="admin_email" class="block text-sm font-medium text-[hsl(var(--foreground))] mb-2">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" 
                               name="admin_email" 
                               id="admin_email"
                               required
                               value="{{ old('admin_email') }}"
                               class="w-full px-4 py-2.5 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))] focus:outline-none focus:ring-2 focus:ring-[hsl(var(--primary))] focus:border-transparent"
                               placeholder="tu@email.com">
                        @error('admin_email')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Contraseña -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-[hsl(var(--foreground))] mb-2">
                            Contraseña <span class="text-red-500">*</span>
                        </label>
                        <input type="password" 
                               name="password" 
                               id="password"
                               required
                               class="w-full px-4 py-2.5 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))] focus:outline-none focus:ring-2 focus:ring-[hsl(var(--primary))] focus:border-transparent"
                               placeholder="Mínimo 8 caracteres">
                        @error('password')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirmar Contraseña -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-[hsl(var(--foreground))] mb-2">
                            Confirmar Contraseña <span class="text-red-500">*</span>
                        </label>
                        <input type="password" 
                               name="password_confirmation" 
                               id="password_confirmation"
                               required
                               class="w-full px-4 py-2.5 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))] focus:outline-none focus:ring-2 focus:ring-[hsl(var(--primary))] focus:border-transparent"
                               placeholder="Repetir contraseña">
                    </div>

                    <!-- Dominio -->
                    <div class="md:col-span-2">
                        <label for="domain" class="block text-sm font-medium text-[hsl(var(--foreground))] mb-2">
                            Dominio <span class="text-red-500">*</span>
                        </label>
                        <div class="flex items-center gap-2">
                            <input type="text" 
                                   name="domain" 
                                   id="domain"
                                   required
                                   value="{{ old('domain') }}"
                                   class="flex-1 px-4 py-2.5 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))] focus:outline-none focus:ring-2 focus:ring-[hsl(var(--primary))] focus:border-transparent"
                                   placeholder="miagencia">
                            <span class="text-[hsl(var(--muted-foreground))] font-medium">.misaas.com</span>
                        </div>
                        <p class="mt-1 text-xs text-[hsl(var(--muted-foreground))]">
                            Ej: Si pones "miagencia", tu URL será miagencia.misaas.com
                        </p>
                        @error('domain')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Teléfono -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-[hsl(var(--foreground))] mb-2">
                            Teléfono
                        </label>
                        <input type="tel" 
                               name="phone" 
                               id="phone"
                               value="{{ old('phone') }}"
                               class="w-full px-4 py-2.5 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))] focus:outline-none focus:ring-2 focus:ring-[hsl(var(--primary))] focus:border-transparent"
                               placeholder="+54 9 11 1234-5678">
                        @error('phone')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Dirección -->
                    <div>
                        <label for="address" class="block text-sm font-medium text-[hsl(var(--foreground))] mb-2">
                            Dirección
                        </label>
                        <input type="text" 
                               name="address" 
                               id="address"
                               value="{{ old('address') }}"
                               class="w-full px-4 py-2.5 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))] focus:outline-none focus:ring-2 focus:ring-[hsl(var(--primary))] focus:border-transparent"
                               placeholder="Calle Principal 123">
                        @error('address')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Aviso de Términos -->
                <div class="bg-blue-500/10 border border-blue-500/20 rounded-lg p-3">
                    <p class="text-sm text-[hsl(var(--foreground))]">
                        <span class="font-medium">Prueba Gratuita:</span> 
                        Obtén 30 días de acceso completo sin necesidad de tarjeta de crédito.
                    </p>
                </div>

                <!-- Botones -->
                <div class="flex gap-3 pt-4">
                    <button type="submit" 
                            class="flex-1 px-6 py-3 bg-[hsl(var(--primary))] hover:opacity-90 text-[#0a0f14] rounded-lg font-semibold transition-opacity">
                        Registrar Agencia
                    </button>
                    <a href="{{ route('login') }}" 
                       class="flex-1 px-6 py-3 bg-[hsl(var(--secondary))] hover:bg-[hsl(var(--secondary))]/80 text-[hsl(var(--foreground))] rounded-lg font-semibold transition-colors text-center">
                        Ya tengo cuenta
                    </a>
                </div>
            </form>
        </div>

        <!-- Footer -->
        <div class="text-center mt-8 text-sm text-[hsl(var(--muted-foreground))]">
            <p>¿Preguntas? <a href="mailto:soporte@proyectoautos.com" class="text-[hsl(var(--primary))] hover:underline">Contacta con soporte</a></p>
        </div>
    </div>
</div>
@endsection
