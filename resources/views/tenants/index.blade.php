@extends('layouts.admin')

@section('title', 'Gestión de Tenants SaaS')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-[hsl(var(--foreground))]">Configuración Multi-Tenant</h1>
            <p class="text-sm text-[hsl(var(--muted-foreground))] mt-1">Gestiona las agencias registradas en el sistema SaaS</p>
        </div>
        <div class="px-4 py-2 bg-[hsl(var(--secondary))] text-[hsl(var(--muted-foreground))] rounded-lg font-semibold flex items-center gap-2 select-none">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Registro de agencias vía /register
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
        <div class="bg-[hsl(var(--card))] border border-[hsl(var(--border))] rounded-lg p-3">
            <p class="text-xs text-[hsl(var(--muted-foreground))] mb-1">Total Agencias</p>
            <p class="text-xl font-bold text-[hsl(var(--foreground))]">{{ $tenants->total() }}</p>
        </div>

        <div class="bg-[hsl(var(--card))] border border-[hsl(var(--border))] rounded-lg p-3">
            <p class="text-xs text-[hsl(var(--muted-foreground))] mb-1">Activas</p>
            <p class="text-xl font-bold text-green-500">{{ $tenants->where('is_active', true)->count() }}</p>
        </div>

        <div class="bg-[hsl(var(--card))] border border-[hsl(var(--border))] rounded-lg p-3">
            <p class="text-xs text-[hsl(var(--muted-foreground))] mb-1">En Prueba</p>
            <p class="text-xl font-bold text-yellow-500">{{ $tenants->filter(fn($t) => $t->isOnTrial())->count() }}</p>
        </div>

        <div class="bg-[hsl(var(--card))] border border-[hsl(var(--border))] rounded-lg p-3">
            <p class="text-xs text-[hsl(var(--muted-foreground))] mb-1">Inactivas</p>
            <p class="text-xl font-bold text-red-500">{{ $tenants->where('is_active', false)->count() }}</p>
        </div>
    </div>

    <!-- Tabla de Tenants -->
    <div class="bg-[hsl(var(--card))] border border-[hsl(var(--border))] rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-[hsl(var(--muted))] border-b border-[hsl(var(--border))]">
                    <tr>
                        <th class="text-left px-4 py-3 text-xs font-medium text-[hsl(var(--muted-foreground))] uppercase tracking-wider">Agencia</th>
                        <th class="text-left px-4 py-3 text-xs font-medium text-[hsl(var(--muted-foreground))] uppercase tracking-wider">Dominio</th>
                        <th class="text-left px-4 py-3 text-xs font-medium text-[hsl(var(--muted-foreground))] uppercase tracking-wider">Plan</th>
                        <th class="text-left px-4 py-3 text-xs font-medium text-[hsl(var(--muted-foreground))] uppercase tracking-wider">Estado</th>
                        <th class="text-left px-4 py-3 text-xs font-medium text-[hsl(var(--muted-foreground))] uppercase tracking-wider">Usuarios</th>
                        <th class="text-left px-4 py-3 text-xs font-medium text-[hsl(var(--muted-foreground))] uppercase tracking-wider">Creado</th>
                        <th class="text-right px-4 py-3 text-xs font-medium text-[hsl(var(--muted-foreground))] uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[hsl(var(--border))]">
                    @forelse($tenants as $tenant)
                    <tr class="hover:bg-[hsl(var(--muted))] transition-colors">
                        <td class="px-4 py-3">
                            <div class="font-medium text-[hsl(var(--foreground))]">{{ $tenant->name }}</div>
                            <div class="text-xs text-[hsl(var(--muted-foreground))]">{{ $tenant->email }}</div>
                        </td>
                        <td class="px-4 py-3">
                            @foreach($tenant->domains as $domain)
                            <div class="text-sm text-[hsl(var(--foreground))] font-mono">{{ $domain->domain }}</div>
                            @endforeach
                        </td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 text-xs font-medium rounded-full 
                                @if($tenant->plan === 'basic') bg-blue-500/20 text-blue-500
                                @elseif($tenant->plan === 'premium') bg-purple-500/20 text-purple-500
                                @else bg-yellow-500/20 text-yellow-500
                                @endif">
                                {{ strtoupper($tenant->plan) }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            @if($tenant->is_active)
                                @if($tenant->isOnTrial())
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-500/20 text-yellow-500">
                                    Prueba ({{ $tenant->trial_ends_at->diffForHumans() }})
                                </span>
                                @else
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-500/20 text-green-500">
                                    Activo
                                </span>
                                @endif
                            @else
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-500/20 text-red-500">
                                Inactivo
                            </span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <span class="text-sm text-[hsl(var(--foreground))]">{{ $tenant->users()->count() }} usuarios</span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="text-sm text-[hsl(var(--foreground))]">{{ $tenant->created_at->format('d/m/Y') }}</div>
                            <div class="text-xs text-[hsl(var(--muted-foreground))]">{{ $tenant->created_at->diffForHumans() }}</div>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-2">
                                          <a href="{{ route('admin.tenants.show', $tenant) }}" 
                                   class="p-1.5 hover:bg-[hsl(var(--muted))] rounded transition-colors"
                                   title="Ver detalles">
                                    <svg class="w-4 h-4 text-[hsl(var(--muted-foreground))]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                                <form action="{{ route('admin.tenants.toggle-status', $tenant) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="p-1.5 hover:bg-[hsl(var(--muted))] rounded transition-colors"
                                            title="{{ $tenant->is_active ? 'Desactivar' : 'Activar' }}">
                                        @if($tenant->is_active)
                                        <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        @else
                                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        @endif
                                    </button>
                                </form>
                                <form action="{{ route('admin.tenants.destroy', $tenant) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="p-1.5 hover:bg-red-500/20 rounded transition-colors"
                                            onclick="return confirm('¿Estás seguro de eliminar este tenant? Esta acción eliminará todos sus datos.')"
                                            title="Eliminar">
                                        <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-12 text-center text-[hsl(var(--muted-foreground))]">
                            <svg class="w-12 h-12 mx-auto mb-4 text-[hsl(var(--muted-foreground))]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <p class="font-medium">No hay agencias registradas</p>
                            <p class="text-sm mt-1">Crea la primera agencia para comenzar</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($tenants->hasPages())
        <div class="px-4 py-3 border-t border-[hsl(var(--border))]">
            {{ $tenants->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
