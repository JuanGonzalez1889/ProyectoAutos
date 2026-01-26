@extends('layouts.admin')

@section('title', 'Editar Dominio - ' . $domain->domain)
@section('page-title', 'Editar Dominio')

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
            <h3 class="text-xl font-semibold text-white">Editar Dominio</h3>
            <p class="text-sm text-[hsl(var(--muted-foreground))]">{{ $domain->domain }}</p>
        </div>
    </div>

    <form action="{{ route('admin.domains.update', $domain) }}" method="POST" class="space-y-6">
        @csrf
        @method('PATCH')

        <!-- Campo: Dominio -->
        <div class="card">
            <label for="domain" class="block text-sm font-semibold text-white mb-3">
                Dominio <span class="text-red-400">*</span>
            </label>
            <input type="text" 
                   id="domain" 
                   name="domain" 
                   value="{{ old('domain', $domain->domain) }}"
                   placeholder="ejemplo.com"
                   class="w-full h-10 px-3 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))] @error('domain') border-red-500 @enderror"
                   required>
            <p class="text-xs text-[hsl(var(--muted-foreground))] mt-2">Ejemplo: midominio.com</p>
            @error('domain')
                <p class="text-red-400 text-xs mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- Información del dominio -->
        <div class="card border-l-4 border-l-[hsl(var(--primary))] bg-[hsl(var(--primary))]/5">
            <p class="text-sm font-semibold text-white mb-3">Información actual:</p>
            <ul class="text-xs text-[hsl(var(--muted-foreground))] space-y-2">
                <li>• <strong>Tipo:</strong> {{ $domain->type === 'new' ? 'Dominio Nuevo' : 'Dominio Existente' }}</li>
                <li>• <strong>Registrado:</strong> {{ $domain->created_at->format('d/m/Y H:i') }}</li>
            </ul>
        </div>

        <!-- Botones -->
        <div class="flex gap-3 pt-4">
            <button type="submit" class="flex-1 h-10 px-6 bg-[hsl(var(--primary))] hover:opacity-90 text-[#0a0f14] rounded-lg transition font-semibold">
                💾 Guardar Cambios
            </button>
            <a href="{{ route('admin.domains.show', $domain) }}" class="flex-1 h-10 px-6 bg-[hsl(var(--muted))] hover:bg-[hsl(var(--muted))]/80 text-[hsl(var(--muted-foreground))] rounded-lg transition font-semibold text-center flex items-center justify-center">
                Cancelar
            </a>
        </div>

        <!-- Errores globales -->
        @if($errors->any())
            <div class="card border-l-4 border-l-red-500 bg-red-500/5">
                <p class="text-red-400 font-semibold mb-2">Errores encontrados:</p>
                <ul class="text-red-400 text-xs list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </form>
</div>
@endsection
