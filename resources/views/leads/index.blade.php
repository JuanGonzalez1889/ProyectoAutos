@extends('layouts.admin')

@section('title', 'Gestión de Leads')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-[hsl(var(--foreground))]">Leads / Prospectos</h1>
            <p class="text-sm text-[hsl(var(--muted-foreground))] mt-1">Gestiona tus clientes potenciales</p>
        </div>
        <a href="{{ route('admin.leads.create') }}" 
           class="px-4 py-2 bg-[hsl(var(--primary))] hover:opacity-90 text-[#0a0f14] rounded-lg font-semibold transition-opacity flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Nuevo Lead
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-3 mb-6">
        <div class="bg-[hsl(var(--card))] border border-[hsl(var(--border))] rounded-lg p-3">
            <p class="text-xs text-[hsl(var(--muted-foreground))] mb-1">Total</p>
            <p class="text-xl font-bold text-[hsl(var(--foreground))]">{{ $stats['total'] }}</p>
        </div>

        <div class="bg-[hsl(var(--card))] border border-[hsl(var(--border))] rounded-lg p-3">
            <p class="text-xs text-[hsl(var(--muted-foreground))] mb-1">Nuevos</p>
            <p class="text-xl font-bold text-blue-500">{{ $stats['new'] }}</p>
        </div>

        <div class="bg-[hsl(var(--card))] border border-[hsl(var(--border))] rounded-lg p-3">
            <p class="text-xs text-[hsl(var(--muted-foreground))] mb-1">Activos</p>
            <p class="text-xl font-bold text-yellow-500">{{ $stats['active'] }}</p>
        </div>

        <div class="bg-[hsl(var(--card))] border border-[hsl(var(--border))] rounded-lg p-3">
            <p class="text-xs text-[hsl(var(--muted-foreground))] mb-1">Ganados</p>
            <p class="text-xl font-bold text-emerald-500">{{ $stats['won'] }}</p>
        </div>

        <div class="bg-[hsl(var(--card))] border border-[hsl(var(--border))] rounded-lg p-3">
            <p class="text-xs text-[hsl(var(--muted-foreground))] mb-1">Perdidos</p>
            <p class="text-xl font-bold text-red-500">{{ $stats['lost'] }}</p>
        </div>
    </div>

    <!-- Tabla de Leads -->
    <div class="bg-[hsl(var(--card))] border border-[hsl(var(--border))] rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-[hsl(var(--muted))] border-b border-[hsl(var(--border))]">
                    <tr>
                        <th class="text-left px-4 py-3 text-xs font-medium text-[hsl(var(--muted-foreground))] uppercase tracking-wider">Nombre</th>
                        <th class="text-left px-4 py-3 text-xs font-medium text-[hsl(var(--muted-foreground))] uppercase tracking-wider">Contacto</th>
                        <th class="text-left px-4 py-3 text-xs font-medium text-[hsl(var(--muted-foreground))] uppercase tracking-wider">Vehículo</th>
                        <th class="text-left px-4 py-3 text-xs font-medium text-[hsl(var(--muted-foreground))] uppercase tracking-wider">Estado</th>
                        <th class="text-left px-4 py-3 text-xs font-medium text-[hsl(var(--muted-foreground))] uppercase tracking-wider">Fuente</th>
                        <th class="text-left px-4 py-3 text-xs font-medium text-[hsl(var(--muted-foreground))] uppercase tracking-wider">Asignado</th>
                        <th class="text-left px-4 py-3 text-xs font-medium text-[hsl(var(--muted-foreground))] uppercase tracking-wider">Próximo Seguimiento</th>
                        <th class="text-right px-4 py-3 text-xs font-medium text-[hsl(var(--muted-foreground))] uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[hsl(var(--border))]">
                    @forelse($leads as $lead)
                    <tr class="hover:bg-[hsl(var(--muted))] transition-colors">
                        <td class="px-4 py-3">
                            <div class="font-medium text-[hsl(var(--foreground))]">{{ $lead->name }}</div>
                            @if($lead->budget)
                            <div class="text-xs text-[hsl(var(--muted-foreground))]">Presupuesto: ${{ number_format($lead->budget, 0, ',', '.') }}</div>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="text-sm text-[hsl(var(--foreground))]">{{ $lead->phone }}</div>
                            @if($lead->email)
                            <div class="text-xs text-[hsl(var(--muted-foreground))]">{{ $lead->email }}</div>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            @if($lead->vehicle)
                            <div class="text-sm text-[hsl(var(--foreground))]">{{ $lead->vehicle->brand }} {{ $lead->vehicle->model }}</div>
                            <div class="text-xs text-[hsl(var(--muted-foreground))]">{{ $lead->vehicle->year }}</div>
                            @else
                            <span class="text-sm text-[hsl(var(--muted-foreground))]">Sin vehículo</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 text-xs font-medium rounded-full 
                                @if($lead->getStatusBadgeColor() === 'blue') bg-blue-500/20 text-blue-500
                                @elseif($lead->getStatusBadgeColor() === 'yellow') bg-yellow-500/20 text-yellow-500
                                @elseif($lead->getStatusBadgeColor() === 'green') bg-green-500/20 text-green-500
                                @elseif($lead->getStatusBadgeColor() === 'purple') bg-purple-500/20 text-purple-500
                                @elseif($lead->getStatusBadgeColor() === 'emerald') bg-emerald-500/20 text-emerald-500
                                @elseif($lead->getStatusBadgeColor() === 'red') bg-red-500/20 text-red-500
                                @else bg-gray-500/20 text-gray-500
                                @endif">
                                {{ $lead->getStatusLabel() }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="text-sm text-[hsl(var(--foreground))] capitalize">
                                @if($lead->source === 'web') Web
                                @elseif($lead->source === 'phone') Teléfono
                                @elseif($lead->source === 'social_media') Redes Sociales
                                @elseif($lead->source === 'referral') Referido
                                @elseif($lead->source === 'walk_in') Visita
                                @else {{ $lead->source ?? 'N/A' }}
                                @endif
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="text-sm text-[hsl(var(--foreground))]">{{ $lead->user->name }}</div>
                        </td>
                        <td class="px-4 py-3">
                            @if($lead->next_follow_up)
                            <div class="text-sm text-[hsl(var(--foreground))]">{{ $lead->next_follow_up->format('d/m/Y') }}</div>
                            <div class="text-xs text-[hsl(var(--muted-foreground))]">{{ $lead->next_follow_up->format('H:i') }}</div>
                            @else
                            <span class="text-sm text-[hsl(var(--muted-foreground))]">Sin programar</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.leads.edit', $lead) }}" 
                                   class="p-1.5 hover:bg-[hsl(var(--muted))] rounded transition-colors"
                                   title="Editar">
                                    <svg class="w-4 h-4 text-[hsl(var(--muted-foreground))]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <form action="{{ route('admin.leads.destroy', $lead) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="p-1.5 hover:bg-red-500/20 rounded transition-colors"
                                            onclick="return confirm('¿Estás seguro de eliminar este lead?')"
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
                        <td colspan="8" class="px-4 py-12 text-center text-[hsl(var(--muted-foreground))]">
                            <svg class="w-12 h-12 mx-auto mb-4 text-[hsl(var(--muted-foreground))]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <p class="font-medium">No hay leads registrados</p>
                            <p class="text-sm mt-1">Crea tu primer lead para comenzar</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($leads->hasPages())
        <div class="px-4 py-3 border-t border-[hsl(var(--border))]">
            {{ $leads->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
