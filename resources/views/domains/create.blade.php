@extends('layouts.admin')

@section('title', 'Registrar Nuevo Dominio')
@section('page-title', 'Registrar Nuevo Dominio')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.domains.index') }}" 
           class="p-2 hover:bg-[hsl(var(--muted))] rounded-lg transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
        <div>
            <h3 class="text-xl font-semibold text-white">Registrar Nuevo Dominio</h3>
            <p class="text-sm text-[hsl(var(--muted-foreground))]">Agrega un dominio nuevo o uno ya existente</p>
        </div>
    </div>

    <form action="{{ route('admin.domains.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Información de ayuda -->
        <div class="card border-l-4 border-l-[hsl(var(--primary))] bg-[hsl(var(--primary))]/5">
            <p class="text-sm text-[hsl(var(--foreground))]">
                <strong>💡 Información:</strong> Registra un dominio nuevo que vas a comprar, o uno que ya tienes con otra empresa.
            </p>
        </div>

        <!-- Campo: Dominio -->
        <div class="card">
            <label for="domain" class="block text-sm font-semibold text-white mb-3">
                Dominio <span class="text-red-400">*</span>
            </label>
            <input type="text" 
                   id="domain" 
                   name="domain" 
                   value="{{ old('domain') }}"
                   placeholder="ejemplo.com"
                   class="w-full h-10 px-3 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))] @error('domain') border-red-500 @enderror"
                   required>
            <p class="text-xs text-[hsl(var(--muted-foreground))] mt-2">Ejemplo: midominio.com, ejemplo.com.ar, negocio.co</p>
            @error('domain')
                <p class="text-red-400 text-xs mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- Campo: Tipo de Dominio -->
        <div class="card">
            <label class="block text-sm font-semibold text-white mb-4">
                ¿De dónde es el dominio? <span class="text-red-400">*</span>
            </label>
            
            <div class="space-y-3">
                <!-- Opción 1: Dominio Nuevo -->
                <div class="flex items-start p-4 border border-[hsl(var(--border))] bg-[hsl(var(--muted))]/30 rounded-lg hover:bg-[hsl(var(--muted))]/50 cursor-pointer transition-colors" 
                     onclick="document.getElementById('type_new').checked = true;">
                    <input type="radio" 
                           id="type_new" 
                           name="type" 
                           value="new" 
                           @checked(old('type') === 'new')
                           class="mt-1 text-[hsl(var(--primary))]" required>
                    <label for="type_new" class="ml-3 cursor-pointer flex-1">
                        <p class="font-medium text-white">🆕 Dominio Nuevo</p>
                        <p class="text-xs text-[hsl(var(--muted-foreground))] mt-1">Voy a comprar un dominio nuevo para mi agencia</p>
                    </label>
                </div>

                <!-- Opción 2: Dominio Existente -->
                <div class="flex items-start p-4 border border-[hsl(var(--border))] bg-[hsl(var(--muted))]/30 rounded-lg hover:bg-[hsl(var(--muted))]/50 cursor-pointer transition-colors" 
                     onclick="document.getElementById('type_existing').checked = true;">
                    <input type="radio" 
                           id="type_existing" 
                           name="type" 
                           value="existing" 
                           @checked(old('type') === 'existing')
                           class="mt-1 text-[hsl(var(--primary))]" required>
                    <label for="type_existing" class="ml-3 cursor-pointer flex-1">
                        <p class="font-medium text-white">📎 Dominio Existente</p>
                        <p class="text-xs text-[hsl(var(--muted-foreground))] mt-1">Ya tengo un dominio comprado en otra empresa</p>
                    </label>
                </div>
            </div>

            @error('type')
                <p class="text-red-400 text-xs mt-3">{{ $message }}</p>
            @enderror
        </div>

        <!-- Información adicional según el tipo -->
        <div id="info_new" class="hidden card border-l-4 border-l-green-500 bg-green-500/5">
            <p class="text-sm text-[hsl(var(--foreground))]">
                <strong>✅ Dominios Nuevos:</strong> Podemos ayudarte a registrar tu dominio en plataformas como GoDaddy, Namecheap, o similar.
            </p>
        </div>

        <div id="info_existing" class="hidden card border-l-4 border-l-blue-500 bg-blue-500/5">
            <p class="text-sm text-[hsl(var(--foreground))]">
                <strong>ℹ️ Dominios Existentes:</strong> Necesitarás cambiar los DNS o configurar un CNAME hacia nuestros servidores.
            </p>
        </div>

        <!-- Botones -->
        <div class="flex gap-3 pt-4">
            <button type="submit" class="flex-1 h-10 px-6 bg-[hsl(var(--primary))] hover:opacity-90 text-[#0a0f14] rounded-lg transition font-semibold">
                ✓ Registrar Dominio
            </button>
            <a href="{{ route('admin.domains.index') }}" class="flex-1 h-10 px-6 bg-[hsl(var(--muted))] hover:bg-[hsl(var(--muted))]/80 text-[hsl(var(--muted-foreground))] rounded-lg transition font-semibold text-center flex items-center justify-center">
                Cancelar
            </a>
        </div>

            <!-- Errores globales -->
            @if($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                    <p class="text-red-800 font-medium mb-2">Errores encontrados:</p>
                    <ul class="text-red-700 text-sm list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </form>
    </div>
</div>

<script>
    // Mostrar/ocultar información según el tipo seleccionado
    document.querySelectorAll('input[name="type"]').forEach(radio => {
        radio.addEventListener('change', function() {
            document.getElementById('info_new').classList.add('hidden');
            document.getElementById('info_existing').classList.add('hidden');
            
            if (this.value === 'new') {
                document.getElementById('info_new').classList.remove('hidden');
            } else {
                document.getElementById('info_existing').classList.remove('hidden');
            }
        });
    });

    // Mostrar información inicial
    window.addEventListener('load', function() {
        const selectedType = document.querySelector('input[name="type"]:checked')?.value;
        if (selectedType === 'new') {
            document.getElementById('info_new').classList.remove('hidden');
        } else if (selectedType === 'existing') {
            document.getElementById('info_existing').classList.remove('hidden');
        }
    });
</script>
@endsection
