@extends('layouts.admin')

@section('title', 'Calendario')
@section('page-title', 'Calendario de Eventos')

@section('content')
<div class="space-y-6">
    <!-- Header con opciones -->
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm text-[hsl(var(--muted-foreground))]">Gestiona tus citas, entregas y reuniones</p>
        </div>
        <a href="{{ route('admin.events.create') }}" class="px-4 py-2 bg-[hsl(var(--primary))] hover:opacity-90 text-[#0a0f14] rounded-lg font-medium transition-opacity">
            + Nuevo Evento
        </a>
    </div>

    <!-- Estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-[hsl(var(--card))] border border-[hsl(var(--border))] rounded-lg p-4">
            <p class="text-sm text-[hsl(var(--muted-foreground))]">Eventos Totales</p>
            <p class="text-2xl font-bold text-[hsl(var(--foreground))]">{{ $stats['total'] }}</p>
        </div>
        <div class="bg-[hsl(var(--card))] border border-[hsl(var(--border))] rounded-lg p-4">
            <p class="text-sm text-[hsl(var(--muted-foreground))]">Hoy</p>
            <p class="text-2xl font-bold text-green-500">{{ $stats['today'] }}</p>
        </div>
        <div class="bg-[hsl(var(--card))] border border-[hsl(var(--border))] rounded-lg p-4">
            <p class="text-sm text-[hsl(var(--muted-foreground))]">Próximos</p>
            <p class="text-2xl font-bold text-orange-500">{{ $stats['upcoming'] }}</p>
        </div>
    </div>

    <!-- Vista de Calendario -->
    <div class="bg-[hsl(var(--card))] border border-[hsl(var(--border))] rounded-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-semibold">Mis Eventos</h3>
            <div class="flex items-center gap-4">
                <!-- Selector de vista -->
                <div class="flex gap-2 bg-[hsl(var(--secondary))] rounded-lg p-1">
                    <button onclick="toggleView('grid')" id="gridBtn" class="view-toggle px-3 py-1 text-sm rounded transition-colors bg-[hsl(var(--primary))] text-[#0a0f14] font-medium">
                        📅 Cuadrícula
                    </button>
                    <button onclick="toggleView('list')" id="listBtn" class="view-toggle px-3 py-1 text-sm rounded transition-colors text-[hsl(var(--muted-foreground))]">
                        📋 Lista
                    </button>
                </div>
            </div>
        </div>

        <!-- VISTA DE CUADRÍCULA (calendario mes) -->
        <div id="gridView" class="view-content">
            <div class="space-y-6">
                <div class="text-center mb-6">
                    <h4 class="text-2xl font-semibold">Febrero 2026</h4>
                </div>

                <!-- Cabecera de días de la semana -->
                <div class="grid grid-cols-7 gap-1">
                    <div class="text-center font-semibold text-[hsl(var(--muted-foreground))] text-sm py-3 border-b border-[hsl(var(--border))]">Lunes</div>
                    <div class="text-center font-semibold text-[hsl(var(--muted-foreground))] text-sm py-3 border-b border-[hsl(var(--border))]">Martes</div>
                    <div class="text-center font-semibold text-[hsl(var(--muted-foreground))] text-sm py-3 border-b border-[hsl(var(--border))]">Miércoles</div>
                    <div class="text-center font-semibold text-[hsl(var(--muted-foreground))] text-sm py-3 border-b border-[hsl(var(--border))]">Jueves</div>
                    <div class="text-center font-semibold text-[hsl(var(--muted-foreground))] text-sm py-3 border-b border-[hsl(var(--border))]">Viernes</div>
                    <div class="text-center font-semibold text-[hsl(var(--muted-foreground))] text-sm py-3 border-b border-[hsl(var(--border))]">Sábado</div>
                    <div class="text-center font-semibold text-[hsl(var(--muted-foreground))] text-sm py-3 border-b border-[hsl(var(--border))]">Domingo</div>
                </div>

                <!-- Calendario grid 7 columnas -->
                <div class="grid grid-cols-7 gap-1">
                    <!-- Día vacío antes del 1ro (domingo 1ro) -->
                    <div class="bg-[hsl(var(--secondary))] rounded-lg min-h-32 opacity-30"></div>

                    <!-- Días del mes (1-28) -->
                    @for ($day = 1; $day <= 28; $day++)
                        @php
                            $date = \Carbon\Carbon::create(2026, 2, $day);
                            $isToday = $date->isToday();
                            $dayEvents = [];
                            
                            // Buscar eventos para este día
                            foreach($allEvents as $event) {
                                if ($event->start_time->day == $day) {
                                    $dayEvents[] = $event;
                                }
                            }
                        @endphp
                        <div class="bg-[hsl(var(--card))] border border-[hsl(var(--border))] rounded-lg min-h-32 p-2 {{ $isToday ? 'ring-2 ring-[hsl(var(--primary))] ring-offset-1 ring-offset-[hsl(var(--background))]' : '' }}">
                            <div class="text-sm font-bold {{ $isToday ? 'text-[hsl(var(--primary))]' : 'text-[hsl(var(--muted-foreground))]' }} mb-1.5">
                                {{ $day }}
                            </div>
                            <div class="space-y-0.5">
                                @forelse($dayEvents as $event)
                                    <a href="{{ route('admin.events.edit', $event->id) }}" class="block text-xs bg-[hsl(var(--primary))] text-[#0a0f14] rounded px-1 py-0.5 truncate hover:opacity-80 transition-opacity" title="{{ $event->title }}">
                                        {{ $event->start_time->format('H:i') }} {{ $event->title }}
                                    </a>
                                @empty
                                @endforelse
                            </div>
                        </div>
                    @endfor

                    <!-- Días restantes (29, 1 de marzo) -->
                    @for ($day = 29; $day <= 29; $day++)
                        <div class="bg-[hsl(var(--secondary))] rounded-lg min-h-32 opacity-30"></div>
                    @endfor
                </div>
            </div>
        </div>

        <!-- VISTA DE LISTA -->
        <div id="listView" class="view-content hidden">
            @if($allEvents->count() > 0)
                <div class="space-y-4">
                    @foreach($eventsByDate as $date => $events)
                        <div class="border-l-4 border-[hsl(var(--primary))] pl-4 py-2">
                            <h4 class="font-semibold text-[hsl(var(--foreground))] mb-2">
                                {{ \Carbon\Carbon::parse($date)->locale('es')->format('l, d \\d\\e F') }}
                            </h4>
                            <div class="space-y-2">
                                @foreach($events as $event)
                                    <div class="flex items-start gap-3 p-3 bg-[hsl(var(--secondary))] rounded-lg hover:bg-[hsl(var(--border))] transition-colors">
                                        <div class="flex-1">
                                            <p class="font-medium text-[hsl(var(--foreground))]">{{ $event->title }}</p>
                                            <div class="flex gap-2 mt-1 text-xs text-[hsl(var(--muted-foreground))]">
                                                <span>🕐 {{ $event->start_time->format('H:i') }}</span>
                                                @if($event->location)
                                                    <span>📍 {{ $event->location }}</span>
                                                @endif
                                                @if($event->client_name)
                                                    <span>👤 {{ $event->client_name }}</span>
                                                @endif
                                            </div>
                                            @if($event->description)
                                                <p class="text-xs text-[hsl(var(--muted-foreground))] mt-1">{{ $event->description }}</p>
                                            @endif
                                        </div>
                                        <div class="flex gap-2">
                                            <a href="{{ route('admin.events.edit', $event->id) }}" class="text-[hsl(var(--primary))] hover:underline text-xs">
                                                Editar
                                            </a>
                                            <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('¿Eliminar este evento?')" class="text-red-500 hover:underline text-xs">
                                                    Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="w-16 h-16 mx-auto text-[hsl(var(--muted-foreground))] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <p class="text-[hsl(var(--muted-foreground))] mb-4">No hay eventos programados</p>
                    <a href="{{ route('admin.events.create') }}" class="px-4 py-2 bg-[hsl(var(--primary))] hover:opacity-90 text-[#0a0f14] rounded-lg font-medium transition-opacity inline-block">
                        Crear tu primer evento
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
function toggleView(view) {
    // Ocultar todas las vistas
    document.querySelectorAll('.view-content').forEach(el => el.classList.add('hidden'));
    
    // Mostrar vista seleccionada
    document.getElementById(view + 'View').classList.remove('hidden');
    
    // Actualizar botones
    document.querySelectorAll('.view-toggle').forEach(btn => {
        btn.classList.remove('bg-[hsl(var(--primary))]', 'text-[#0a0f14]', 'font-medium');
        btn.classList.add('text-[hsl(var(--muted-foreground))]');
    });
    
    if (view === 'grid') {
        document.getElementById('gridBtn').classList.add('bg-[hsl(var(--primary))]', 'text-[#0a0f14]', 'font-medium');
        document.getElementById('gridBtn').classList.remove('text-[hsl(var(--muted-foreground))]');
    } else {
        document.getElementById('listBtn').classList.add('bg-[hsl(var(--primary))]', 'text-[#0a0f14]', 'font-medium');
        document.getElementById('listBtn').classList.remove('text-[hsl(var(--muted-foreground))]');
    }
}
</script>
@endsection
