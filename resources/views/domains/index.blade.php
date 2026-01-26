@extends('layouts.admin')

@section('title', 'Mis Dominios')
@section('page-title', 'Gestión de Dominios')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-xl font-semibold text-white mb-1">Mis Dominios</h3>
            <p class="text-sm text-[hsl(var(--muted-foreground))]">Administra los dominios de tu agencia</p>
        </div>
        
        <a href="{{ route('admin.domains.create') }}" 
           class="h-10 px-5 bg-[hsl(var(--primary))] hover:opacity-90 text-[#0a0f14] rounded-lg text-sm font-medium transition-opacity flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Registrar Dominio
        </a>
    </div>

    <!-- Messages -->
    @if ($message = Session::get('success'))
        <div class="p-4 bg-green-500/10 border border-green-500/30 text-green-400 rounded-lg text-sm">
            {{ $message }}
        </div>
    @endif

    @if ($message = Session::get('error'))
        <div class="p-4 bg-red-500/10 border border-red-500/30 text-red-400 rounded-lg text-sm">
            {{ $message }}
        </div>
    @endif

    <!-- Tabla/Grid de Dominios -->
    @if($domains->count())
        <div class="card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-[hsl(var(--muted))] border-b border-[hsl(var(--border))]">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-[hsl(var(--muted-foreground))] uppercase tracking-wider">Dominio</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-[hsl(var(--muted-foreground))] uppercase tracking-wider">Tipo</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-[hsl(var(--muted-foreground))] uppercase tracking-wider">Registrado</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-[hsl(var(--muted-foreground))] uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[hsl(var(--border))]">
                        @foreach($domains as $domain)
                            <tr class="hover:bg-[hsl(var(--muted))]/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="p-2 bg-[hsl(var(--primary))]/20 rounded">
                                            <svg class="w-4 h-4 text-[hsl(var(--primary))]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-medium text-white">{{ $domain->domain }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($domain->type === 'new')
                                        <span class="inline-flex items-center gap-1 px-3 py-1 bg-green-500/20 text-green-400 rounded-full text-xs font-semibold border border-green-500/30">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                            Nuevo
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-3 py-1 bg-blue-500/20 text-blue-400 rounded-full text-xs font-semibold border border-blue-500/30">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                            Existente
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-[hsl(var(--muted-foreground))]">
                                    {{ $domain->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('admin.domains.show', $domain) }}" 
                                           class="px-3 py-1 text-[hsl(var(--primary))] hover:bg-[hsl(var(--primary))]/10 rounded text-sm font-medium transition-colors">
                                            Ver
                                        </a>
                                        <a href="{{ route('admin.domains.edit', $domain) }}" 
                                           class="px-3 py-1 text-blue-400 hover:bg-blue-500/10 rounded text-sm font-medium transition-colors">
                                            Editar
                                        </a>
                                        <form action="{{ route('admin.domains.destroy', $domain) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar este dominio?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1 text-red-400 hover:bg-red-500/10 rounded text-sm font-medium transition-colors">
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="card py-16 text-center">
            <svg class="mx-auto h-16 w-16 text-[hsl(var(--muted-foreground))]/50 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <p class="text-[hsl(var(--muted-foreground))] mb-4">Aún no tienes dominios registrados</p>
            <a href="{{ route('admin.domains.create') }}" 
               class="inline-flex items-center gap-2 px-4 py-2 bg-[hsl(var(--primary))] hover:opacity-90 text-[#0a0f14] rounded-lg text-sm font-medium transition-opacity">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Registra tu primer dominio aquí
            </a>
        </div>
    @endif
</div>
@endsection
