@extends('layouts.guest')

@section('title', 'Aceptar Invitación')

@section('content')
<div class="min-h-screen flex">
    <!-- Left side - Image -->
    <div class="hidden lg:flex lg:w-1/2 relative bg-[#0a0f14]">
        <img src="https://images.unsplash.com/photo-1553531889-e6cf91d9372d?w=1200&h=1200&fit=crop" 
             alt="Team" 
             class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>

        <!-- Branding -->
        <div class="absolute bottom-12 left-12 right-12 z-10">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 bg-[hsl(var(--primary))] rounded-md flex items-center justify-center">
                    <span class="text-white font-bold">🚗</span>
                </div>
                <span class="text-white font-bold text-lg">ProyectoAutos</span>
            </div>
            <h2 class="text-3xl font-bold text-white mb-2">Te damos la bienvenida</h2>
            <p class="text-gray-300">Completa tu registro para acceder a la agencia</p>
        </div>
    </div>

    <!-- Right side - Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-[hsl(var(--background))]">
        <div class="w-full max-w-md space-y-6">
            <!-- Header -->
            <div class="space-y-2">
                <h1 class="text-3xl font-bold text-[hsl(var(--foreground))]">Crear Cuenta</h1>
                <p class="text-sm text-[hsl(var(--muted-foreground))]">
                    Has sido invitado a la agencia <strong>{{ $invitation->tenant->name }}</strong>
                </p>
            </div>

            @if ($errors->any())
                <div class="p-4 bg-red-500/10 border border-red-500/20 rounded-lg">
                    <p class="text-red-400 font-semibold mb-2 text-sm">Errores encontrados:</p>
                    <ul class="text-red-400 text-xs space-y-1">
                        @foreach($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('invitations.accept', $invitation->token) }}" method="POST" class="space-y-4">
                @csrf

                <!-- Email (Read-only) -->
                <div>
                    <label class="block text-sm font-medium text-[hsl(var(--foreground))] mb-2">
                        Email
                    </label>
                    <input 
                        type="email" 
                        value="{{ $invitation->email }}" 
                        disabled
                        class="w-full px-4 py-2 bg-[hsl(var(--muted))]/30 border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--muted-foreground))] cursor-not-allowed"
                    >
                    <p class="mt-1 text-xs text-[hsl(var(--muted-foreground))]">
                        No puedes cambiar el email de la invitación
                    </p>
                </div>

                <!-- Nombre Completo -->
                <div>
                    <label class="block text-sm font-medium text-[hsl(var(--foreground))] mb-2">
                        Nombre Completo
                    </label>
                    <input 
                        type="text" 
                        name="name" 
                        required
                        class="w-full px-4 py-2 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))] placeholder-[hsl(var(--muted-foreground))] focus:outline-none focus:ring-2 focus:ring-[hsl(var(--primary))] focus:border-transparent"
                        placeholder="Tu nombre completo"
                        value="{{ old('name') }}"
                    >
                </div>

                <!-- Contraseña -->
                <div>
                    <label class="block text-sm font-medium text-[hsl(var(--foreground))] mb-2">
                        Contraseña
                    </label>
                    <input 
                        type="password" 
                        name="password" 
                        required
                        class="w-full px-4 py-2 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))] placeholder-[hsl(var(--muted-foreground))] focus:outline-none focus:ring-2 focus:ring-[hsl(var(--primary))] focus:border-transparent"
                        placeholder="Mínimo 8 caracteres"
                    >
                    <p class="mt-1 text-xs text-[hsl(var(--muted-foreground))]">
                        Incluye mayúsculas, minúsculas, números y caracteres especiales
                    </p>
                </div>

                <!-- Confirmar Contraseña -->
                <div>
                    <label class="block text-sm font-medium text-[hsl(var(--foreground))] mb-2">
                        Confirmar Contraseña
                    </label>
                    <input 
                        type="password" 
                        name="password_confirmation" 
                        required
                        class="w-full px-4 py-2 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))] placeholder-[hsl(var(--muted-foreground))] focus:outline-none focus:ring-2 focus:ring-[hsl(var(--primary))] focus:border-transparent"
                        placeholder="Repite tu contraseña"
                    >
                </div>

                <!-- Info del Rol -->
                <div class="p-3 bg-[hsl(var(--muted))]/20 border border-[hsl(var(--border))] rounded-lg">
                    <p class="text-xs text-[hsl(var(--muted-foreground))]">
                        <strong>Tu Rol:</strong> 
                        <span class="capitalize">
                            {{ $invitation->role === 'admin' ? 'Administrador de Agencia' : 'Colaborador' }}
                        </span>
                    </p>
                </div>

                <!-- Submit -->
                <button 
                    type="submit"
                    class="w-full py-2 bg-[hsl(var(--primary))] hover:bg-[hsl(var(--primary))]/80 text-[hsl(var(--primary-foreground))] rounded-lg font-semibold transition">
                    Crear Cuenta
                </button>

                <!-- Login Link -->
                <div class="text-center pt-2">
                    <p class="text-sm text-[hsl(var(--muted-foreground))]">
                        ¿Ya tienes cuenta? 
                        <a href="{{ route('login') }}" class="text-[hsl(var(--primary))] hover:underline">
                            Inicia sesión
                        </a>
                    </p>
                </div>
            </form>

            <!-- Footer -->
            <div class="text-center text-xs text-[hsl(var(--muted-foreground))]">
                <p>Al registrarte, aceptas nuestros Términos de Servicio y Política de Privacidad</p>
            </div>
        </div>
    </div>
</div>
@endsection
