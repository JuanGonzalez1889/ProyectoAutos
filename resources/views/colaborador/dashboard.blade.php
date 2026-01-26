@extends('layouts.admin')

@section('title', 'Dashboard - Colaborador')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Header con saludo personalizado -->
    <div>
        <h1 class="text-3xl font-bold text-white mb-2">
            Hola, {{ auth()->user()->name }} 
            <span class="inline-block">👋</span>
        </h1>
        <p class="text-[hsl(var(--muted-foreground))]">
            Tienes <span class="text-[hsl(var(--primary))] font-semibold">{{ $stats['pending_tasks'] }} tareas pendientes</span> y 
            <span class="text-[hsl(var(--primary))] font-semibold">{{ $stats['events_today'] }} eventos</span> hoy
        </p>
    </div>

    <!-- Cards de métricas -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Tareas Pendientes -->
        <div class="p-5 bg-gradient-to-br from-green-500/10 to-green-600/10 border border-green-500/20 rounded-lg relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 -mr-8 -mt-8 opacity-10">
                <svg class="w-full h-full text-green-500" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="relative">
                <div class="flex items-center gap-2 mb-3">
                    <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-sm text-[hsl(var(--muted-foreground))]">Tareas Pendientes</p>
                </div>
                <p class="text-4xl font-bold text-white mb-2">{{ $stats['pending_tasks'] }}</p>
                <p class="text-xs text-green-500">{{ $stats['high_priority_tasks'] }} de alta prioridad</p>
            </div>
        </div>

        <!-- Citas Hoy -->
        <div class="p-5 bg-gradient-to-br from-orange-500/10 to-orange-600/10 border border-orange-500/20 rounded-lg relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 -mr-8 -mt-8 opacity-10">
                <svg class="w-full h-full text-orange-500" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
            <div class="relative">
                <div class="flex items-center gap-2 mb-3">
                    <svg class="w-5 h-5 text-orange-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <p class="text-sm text-[hsl(var(--muted-foreground))]">Eventos Hoy</p>
                </div>
                <p class="text-4xl font-bold text-white mb-2">{{ $stats['events_today'] }}</p>
                <p class="text-xs text-orange-500">
                    @if($stats['next_event'])
                        Próximo a las {{ $stats['next_event']->start_time->format('H:i') }}
                    @else
                        Sin eventos próximos
                    @endif
                </p>
            </div>
        </div>

        <!-- Autos Asignados -->
        <div class="p-5 bg-gradient-to-br from-purple-500/10 to-purple-600/10 border border-purple-500/20 rounded-lg relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 -mr-8 -mt-8 opacity-10">
                <svg class="w-full h-full text-purple-500" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2"></path>
                    <circle cx="7" cy="17" r="2"></circle>
                    <circle cx="17" cy="17" r="2"></circle>
                </svg>
            </div>
            <div class="relative">
                <div class="flex items-center gap-2 mb-3">
                    <svg class="w-5 h-5 text-purple-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2"></path>
                        <circle cx="7" cy="17" r="2"></circle>
                        <circle cx="17" cy="17" r="2"></circle>
                    </svg>
                    <p class="text-sm text-[hsl(var(--muted-foreground))]">Autos Asignados</p>
                </div>
                <p class="text-4xl font-bold text-white mb-2">{{ $stats['vehicles_assigned'] }}</p>
                <p class="text-xs text-purple-500">{{ $stats['active_negotiations'] }} en negociación activa</p>
            </div>
        </div>
    </div>

    <!-- Grid principal -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Columna izquierda (2/3) -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Mis Tareas Prioritarias -->
            <div class="card">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h2 class="text-base font-semibold">Mis Tareas Prioritarias</h2>
                    </div>
                    <a href="#" class="text-xs text-[hsl(var(--primary))] hover:underline">VER TODAS</a>
                </div>

                <div class="space-y-3">
                    @forelse($stats['priority_tasks'] as $task)
                    <div class="flex items-start gap-3 p-3 rounded-lg hover:bg-[hsl(var(--muted))]/50 transition-colors group">
                        <input type="checkbox" class="mt-1 w-4 h-4 rounded border-[hsl(var(--border))] bg-[hsl(var(--background))]">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-white group-hover:text-[hsl(var(--primary))]">
                                {{ $task->title }}
                            </p>
                            <p class="text-xs text-[hsl(var(--muted-foreground))] mt-0.5">
                                {{ $task->description ?? 'Sin descripción' }}
                            </p>
                        </div>
                        <span class="px-2 py-0.5 text-[10px] font-medium rounded 
                            @if($task->priority === 'high') bg-red-500/20 text-red-500
                            @elseif($task->priority === 'medium') bg-yellow-500/20 text-yellow-500
                            @else bg-blue-500/20 text-blue-500 @endif">
                            {{ ucfirst($task->priority) }}
                        </span>
                    </div>
                    @empty
                    <div class="text-center py-6">
                        <p class="text-sm text-[hsl(var(--muted-foreground))]">No tienes tareas pendientes</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Agenda de Hoy -->
            <div class="card">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-orange-500" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <h2 class="text-base font-semibold">Agenda de Hoy</h2>
                    </div>
                </div>

                <div class="space-y-4">
                    @forelse($stats['upcoming_events'] ?? [] as $event)
                    <div class="flex gap-4 p-4 rounded-lg border 
                        @if($event->type === 'meeting') border-blue-500/30 bg-blue-500/5
                        @elseif($event->type === 'delivery') border-green-500/30 bg-green-500/5
                        @elseif($event->type === 'test_drive') border-orange-500/30 bg-orange-500/5
                        @elseif($event->type === 'service') border-purple-500/30 bg-purple-500/5
                        @else border-gray-500/30 bg-gray-500/5 @endif">
                        <div class="text-center">
                            <p class="text-xs 
                                @if($event->type === 'meeting') text-blue-500
                                @elseif($event->type === 'delivery') text-green-500
                                @elseif($event->type === 'test_drive') text-orange-500
                                @elseif($event->type === 'service') text-purple-500
                                @else text-gray-500 @endif font-medium">
                                {{ $event->start_time->format('H:i') }}
                            </p>
                            <p class="text-xs text-[hsl(var(--muted-foreground))]">{{ $event->start_time->format('d/m') }}</p>
                        </div>
                        <div class="flex-1 border-l-2 
                            @if($event->type === 'meeting') border-blue-500
                            @elseif($event->type === 'delivery') border-green-500
                            @elseif($event->type === 'test_drive') border-orange-500
                            @elseif($event->type === 'service') border-purple-500
                            @else border-gray-500 @endif pl-4">
                            <p class="text-sm font-semibold text-white mb-1">{{ $event->title }}</p>
                            <p class="text-xs text-[hsl(var(--muted-foreground))]">
                                {{ $event->description ?? ($event->client_name ?? 'Sin descripción') }}
                            </p>
                        </div>
                    </div>
                    @empty
                    <div class="py-6 text-center">
                        <p class="text-sm text-[hsl(var(--muted-foreground))]">No hay eventos próximos</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Columna derecha (1/3) -->
        <div class="space-y-6">
            <!-- Inventario Asignado -->
            <div class="card">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-sm font-semibold">Inventario Asignado</h3>
                    <a href="{{ route('admin.vehicles.index') }}" class="text-xs text-[hsl(var(--primary))] hover:underline">Ver todo</a>
                </div>

                <div class="space-y-4">
                    @forelse($stats['recent_vehicles'] ?? [] as $vehicle)
                    <!-- Vehículo {{ $loop->iteration }} -->
                    <div class="flex gap-3 p-3 rounded-lg border border-[hsl(var(--border))] hover:border-[hsl(var(--primary))]/50 transition-colors">
                        <img src="{{ $vehicle->main_image ?? 'https://via.placeholder.com/64' }}" 
                             alt="{{ $vehicle->title }}" 
                             class="w-16 h-16 rounded-lg object-cover">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-2 mb-1">
                                <p class="text-sm font-semibold text-white truncate">{{ $vehicle->title ?? ($vehicle->year . ' ' . $vehicle->brand . ' ' . $vehicle->model) }}</p>
                                <span class="px-1.5 py-0.5 text-[10px] font-medium rounded 
                                    @if($vehicle->status === 'available') bg-green-500/20 text-green-500
                                    @elseif($vehicle->status === 'negotiation') bg-yellow-500/20 text-yellow-500
                                    @else bg-red-500/20 text-red-500 @endif shrink-0">
                                    @if($vehicle->status === 'available') Disponible
                                    @elseif($vehicle->status === 'negotiation') En Negociación
                                    @else Vendido @endif
                                </span>
                            </div>
                            <p class="text-xs text-[hsl(var(--muted-foreground))] mb-2">
                                {{ $vehicle->year }} • {{ $vehicle->brand }} {{ $vehicle->model }}
                            </p>
                            <p class="text-sm font-bold text-[hsl(var(--primary))]">${{ number_format($vehicle->price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    @empty
                    <!-- Sin vehículos -->
                    <div class="py-8 text-center">
                        <svg class="mx-auto w-12 h-12 text-[hsl(var(--muted-foreground))]/30 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        <p class="text-sm text-[hsl(var(--muted-foreground))]">No hay vehículos en el inventario</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Botón Nuevo Lead -->
            <a href="{{ route('admin.leads.create') }}" class="w-full h-12 bg-[hsl(var(--primary))] hover:opacity-90 text-[#0a0f14] rounded-lg font-semibold transition-opacity flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Nuevo Lead
            </a>
        </div>
    </div>
</div>
@endsection
