@extends('layouts.admin')

@section('title', 'Vehículos')
@section('page-title', 'Gestión de Vehículos')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-xl font-semibold text-white mb-1">Inventario de Vehículos</h3>
            <p class="text-sm text-[hsl(var(--muted-foreground))]">Administra todos los vehículos disponibles</p>
        </div>
        
        <a href="{{ route('admin.vehicles.create') }}" 
           class="h-10 px-5 bg-[hsl(var(--primary))] hover:opacity-90 text-[#0a0f14] rounded-lg text-sm font-medium transition-opacity flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Agregar Vehículo
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="p-4 bg-gradient-to-br from-blue-500/10 to-blue-600/10 border border-blue-500/20 rounded-lg">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-blue-500/20 rounded-lg">
                    <svg class="h-5 w-5 text-blue-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2"></path>
                        <circle cx="7" cy="17" r="2"></circle>
                        <circle cx="17" cy="17" r="2"></circle>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-[hsl(var(--muted-foreground))]">Total</p>
                    <p class="text-2xl font-bold text-white">{{ $vehicles->total() }}</p>
                </div>
            </div>
        </div>

        <div class="p-4 bg-gradient-to-br from-green-500/10 to-green-600/10 border border-green-500/20 rounded-lg">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-green-500/20 rounded-lg">
                    <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-[hsl(var(--muted-foreground))]">Publicados</p>
                    <p class="text-2xl font-bold text-green-500">{{ $vehicles->where('status', 'published')->count() }}</p>
                </div>
            </div>
        </div>

        <div class="p-4 bg-gradient-to-br from-yellow-500/10 to-yellow-600/10 border border-yellow-500/20 rounded-lg">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-yellow-500/20 rounded-lg">
                    <svg class="h-5 w-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-[hsl(var(--muted-foreground))]">Borradores</p>
                    <p class="text-2xl font-bold text-yellow-500">{{ $vehicles->where('status', 'draft')->count() }}</p>
                </div>
            </div>
        </div>

        <div class="p-4 bg-gradient-to-br from-red-500/10 to-red-600/10 border border-red-500/20 rounded-lg">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-red-500/20 rounded-lg">
                    <svg class="h-5 w-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-[hsl(var(--muted-foreground))]">Vendidos</p>
                    <p class="text-2xl font-bold text-red-500">{{ $vehicles->where('status', 'sold')->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Grid de vehículos -->
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @forelse($vehicles as $vehicle)
        <div class="card p-0 overflow-hidden group max-w-xs">
            <!-- Imagen -->
            <div class="relative bg-gradient-to-br from-gray-700 to-gray-900 overflow-hidden" style="height: 140px;">
                <img src="{{ $vehicle->main_image }}" 
                     alt="{{ $vehicle->title }}" 
                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                
                <!-- Badges -->
                <div class="absolute top-3 left-3 flex gap-2">
                    @if($vehicle->status === 'published')
                        <span class="px-2 py-1 text-xs font-medium rounded bg-green-500 text-white">Publicado</span>
                    @elseif($vehicle->status === 'draft')
                        <span class="px-2 py-1 text-xs font-medium rounded bg-yellow-500 text-white">Borrador</span>
                    @else
                        <span class="px-2 py-1 text-xs font-medium rounded bg-red-500 text-white">Vendido</span>
                    @endif
                    
                    @if($vehicle->featured)
                        <span class="px-2 py-1 text-xs font-medium rounded bg-[hsl(var(--primary))] text-[#0a0f14]">⭐ Destacado</span>
                    @endif
                </div>

                <!-- Contador de imágenes -->
                @if($vehicle->images && count($vehicle->images) > 1)
                <div class="absolute bottom-3 right-3 px-2 py-1 text-xs font-medium rounded bg-black/60 text-white flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    {{ count($vehicle->images) }}
                </div>
                @endif
            </div>

            <!-- Contenido -->
            <div class="p-3">
                <h3 class="font-semibold text-sm text-white mb-0.5 truncate">{{ $vehicle->title }}</h3>
                <p class="text-[11px] text-[hsl(var(--muted-foreground))] mb-2">
                    {{ $vehicle->year }} • {{ number_format($vehicle->kilometers) }} km • {{ $vehicle->fuel_type }}
                </p>
                
                <div class="flex items-center justify-between mb-3">
                    <div>
                        @if($vehicle->price_original && $vehicle->price_original > $vehicle->price)
                            <p class="text-[10px] text-[hsl(var(--muted-foreground))] line-through">${{ number_format($vehicle->price_original) }}</p>
                        @endif
                        <p class="text-lg font-bold text-[hsl(var(--primary))]">${{ number_format($vehicle->price) }}</p>
                    </div>
                </div>

                <!-- Acciones -->
                <div class="flex gap-2 pt-2 border-t border-[hsl(var(--border))]">
                    <a href="{{ route('admin.vehicles.edit', $vehicle) }}" 
                       class="flex-1 h-8 px-2 bg-blue-500/20 hover:bg-blue-500/30 text-blue-500 rounded-md text-xs font-medium transition-colors flex items-center justify-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Editar
                    </a>
                    <form action="{{ route('admin.vehicles.destroy', $vehicle) }}" method="POST" class="flex-1"
                          onsubmit="return confirm('¿Estás seguro de eliminar este vehículo?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full h-8 px-2 bg-red-500/20 hover:bg-red-500/30 text-red-500 rounded-md text-xs font-medium transition-colors flex items-center justify-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Eliminar
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-16 text-center">
            <svg class="mx-auto h-16 w-16 text-[hsl(var(--muted-foreground))]/50 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
            </svg>
            <p class="text-[hsl(var(--muted-foreground))] mb-4">No hay vehículos registrados</p>
            <a href="{{ route('admin.vehicles.create') }}" 
               class="inline-flex items-center gap-2 px-4 py-2 bg-[hsl(var(--primary))] hover:opacity-90 text-[#0a0f14] rounded-lg text-sm font-medium transition-opacity">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Agregar primer vehículo
            </a>
        </div>
        @endforelse
    </div>

    <!-- Paginación -->
    @if($vehicles->hasPages())
    <div class="flex justify-center">
        {{ $vehicles->links() }}
    </div>
    @endif
</div>
@endsection
