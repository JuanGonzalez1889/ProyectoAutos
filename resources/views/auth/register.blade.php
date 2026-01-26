@extends('layouts.guest')

@section('title', 'Registro')

@section('content')
<div class="min-h-screen flex">
    <!-- Left side - Car image -->
    <div class="hidden lg:flex lg:w-1/2 relative bg-[#0a0f14]">
        <img src="https://images.unsplash.com/photo-1503376780353-7e6692767b70?w=1200&h=1200&fit=crop" 
             alt="Luxury Car" 
             class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>

        <!-- AutoManager branding -->
        <div class="absolute bottom-12 left-12 right-12 z-10">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 bg-[hsl(var(--primary))] rounded-md flex items-center justify-center">
                    <svg class="w-6 h-6 text-[#0a0f14]" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2" />
                        <circle cx="7" cy="17" r="2" />
                        <circle cx="17" cy="17" r="2" />
                    </svg>
                </div>
                <span class="text-white font-bold text-xl">{{ config('app.name') }}</span>
            </div>
            <p class="text-white/90 text-base leading-relaxed border-l-2 border-[hsl(var(--primary))] pl-4">
                "Comienza hoy mismo a transformar la gestión de tu inventario. Únete a miles de agencieros que confían en nosotros."
            </p>
            <div class="flex gap-2 mt-4">
                <div class="w-2 h-1 bg-white/30 rounded-full"></div>
                <div class="w-10 h-1 bg-[hsl(var(--primary))] rounded-full"></div>
                <div class="w-2 h-1 bg-white/30 rounded-full"></div>
            </div>
        </div>
    </div>

    <!-- Right side - Register form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center bg-[hsl(var(--background))] p-8">
        <div class="w-full max-w-md space-y-6">
            <!-- Header -->
            <div class="space-y-2 text-center">
                <h1 class="text-3xl font-bold text-white">Crear una cuenta</h1>
                <p class="text-sm text-[hsl(var(--muted-foreground))]">Regístrate y comienza a gestionar tu agencia en minutos.</p>
            </div>

            <!-- Tabs -->
            <div class="flex border-b border-[hsl(var(--border))]">
                <a href="{{ route('login') }}" class="flex-1 pb-3 text-sm font-medium text-[hsl(var(--muted-foreground))] hover:text-white text-center">
                    Iniciar Sesión
                </a>
                <button class="flex-1 pb-3 text-sm font-medium text-[hsl(var(--primary))] border-b-2 border-[hsl(var(--primary))]">
                    Registrarse
                </button>
            </div>

            <!-- Google Button -->
            <a href="{{ route('auth.google') }}" class="w-full flex items-center justify-center px-4 py-3 bg-[#1a1f26] border border-[hsl(var(--border))] hover:bg-[#252b34] rounded-lg transition-colors">
                <svg class="mr-2 h-4 w-4" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                </svg>
                <span class="text-white text-sm font-medium">Registrarse con Google</span>
            </a>

            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <span class="w-full border-t border-[hsl(var(--border))]"></span>
                </div>
                <div class="relative flex justify-center text-xs uppercase">
                    <span class="bg-[hsl(var(--background))] px-2 text-[hsl(var(--muted-foreground))]">O con tus datos</span>
                </div>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                @if($errors->any())
                    <div class="bg-red-500/20 border border-red-500/50 text-red-500 px-4 py-3 rounded-lg text-sm">
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <div class="space-y-2">
                    <label for="name" class="text-sm text-[hsl(var(--muted-foreground))]">Nombre Completo</label>
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-[hsl(var(--muted-foreground))]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required
                               class="w-full pl-10 pr-4 py-3 bg-[#1a1f26] border border-[hsl(var(--border))] rounded-lg text-white placeholder-[hsl(var(--muted-foreground))] focus:outline-none focus:ring-2 focus:ring-[hsl(var(--ring))]"
                               placeholder="Juan Pérez">
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="email" class="text-sm text-[hsl(var(--muted-foreground))]">Correo Electrónico</label>
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-[hsl(var(--muted-foreground))]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                               class="w-full pl-10 pr-4 py-3 bg-[#1a1f26] border border-[hsl(var(--border))] rounded-lg text-white placeholder-[hsl(var(--muted-foreground))] focus:outline-none focus:ring-2 focus:ring-[hsl(var(--ring))]"
                               placeholder="ejemplo@agencia.com">
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="password" class="text-sm text-[hsl(var(--muted-foreground))]">Contraseña</label>
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-[hsl(var(--muted-foreground))]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        <input type="password" id="password" name="password" required
                               class="w-full pl-10 pr-4 py-3 bg-[#1a1f26] border border-[hsl(var(--border))] rounded-lg text-white placeholder-[hsl(var(--muted-foreground))] focus:outline-none focus:ring-2 focus:ring-[hsl(var(--ring))]"
                               placeholder="••••••••">
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="password_confirmation" class="text-sm text-[hsl(var(--muted-foreground))]">Confirmar Contraseña</label>
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-[hsl(var(--muted-foreground))]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                               class="w-full pl-10 pr-4 py-3 bg-[#1a1f26] border border-[hsl(var(--border))] rounded-lg text-white placeholder-[hsl(var(--muted-foreground))] focus:outline-none focus:ring-2 focus:ring-[hsl(var(--ring))]"
                               placeholder="••••••••">
                    </div>
                </div>

                <div class="flex items-start space-x-2">
                    <input type="checkbox" id="terms" required class="w-4 h-4 mt-1 rounded border-[hsl(var(--border))] text-[hsl(var(--primary))] focus:ring-[hsl(var(--ring))]">
                    <label for="terms" class="text-sm text-[hsl(var(--muted-foreground))] cursor-pointer leading-relaxed">
                        Acepto los 
                        <a href="#" class="text-[hsl(var(--primary))] hover:underline">Términos y Condiciones</a> 
                        y la 
                        <a href="#" class="text-[hsl(var(--primary))] hover:underline">Política de Privacidad</a>.
                    </label>
                </div>

                <button type="submit" class="w-full bg-[hsl(var(--primary))] hover:opacity-90 text-[#0a0f14] font-medium py-3 rounded-lg transition-opacity">
                    Crear Cuenta
                </button>
            </form>

            <!-- Footer -->
            <div class="space-y-3 text-center text-xs text-[hsl(var(--muted-foreground))]">
                <p>© {{ date('Y') }} {{ config('app.name') }} Inc. Todos los derechos reservados.</p>
            </div>
        </div>
    </div>
</div>
@endsection
