@extends('layouts.admin')

@section('title', 'Dashboard - Agenciero')
@section('page-title', 'Resumen General')

@section('content')
<div class="space-y-6">
    <!-- Header con fecha y búsqueda -->
    <div class="flex items-center justify-between">
        <div>
            <p class="text-xs text-[hsl(var(--muted-foreground))]">{{ now()->locale('es')->isoFormat('dddd, D [de] MMMM YYYY') }}</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-[hsl(var(--muted-foreground))]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <input type="text" placeholder="Buscar vehículo, cliente..." 
                       class="w-60 h-9 pl-10 pr-4 bg-[hsl(var(--card))] border border-[hsl(var(--border))] rounded-lg text-sm focus:outline-none focus:border-[hsl(var(--primary))]">
            </div>
            <button class="h-9 px-4 bg-[hsl(var(--primary))] hover:opacity-90 text-[#0a0f14] rounded-lg text-sm font-medium transition-opacity">
                + Nueva Venta
            </button>
        </div>
    </div>

    <!-- Cards de métricas -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <!-- Ingresos Mensuales -->
        <div class="p-5 bg-gradient-to-br from-green-500/10 to-green-600/10 border border-green-500/20 rounded-lg">
            <div class="flex items-start justify-between mb-2">
                <div class="p-2 bg-green-500/20 rounded-lg">
                    <svg class="h-4 w-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <span class="text-[10px] px-1.5 py-0.5 bg-green-500/20 text-green-600 rounded">+12%</span>
            </div>
            <p class="text-xs text-[hsl(var(--muted-foreground))] mb-1">Ingresos Mensuales</p>
            <p class="text-2xl font-bold text-white">$145,000</p>
        </div>

        <!-- Unidades Vendidas -->
        <div class="p-5 bg-gradient-to-br from-blue-500/10 to-blue-600/10 border border-blue-500/20 rounded-lg">
            <div class="flex items-start justify-between mb-2">
                <div class="p-2 bg-blue-500/20 rounded-lg">
                    <svg class="h-4 w-4 text-blue-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2"></path>
                        <circle cx="7" cy="17" r="2"></circle>
                        <circle cx="17" cy="17" r="2"></circle>
                    </svg>
                </div>
                <span class="text-[10px] px-1.5 py-0.5 bg-blue-500/20 text-blue-600 rounded">+3%</span>
            </div>
            <p class="text-xs text-[hsl(var(--muted-foreground))] mb-1">Unidades Vendidas</p>
            <p class="text-2xl font-bold text-white">{{ $stats['total_users'] }}</p>
        </div>

        <!-- Inventario Activo -->
        <div class="p-5 bg-gradient-to-br from-orange-500/10 to-orange-600/10 border border-orange-500/20 rounded-lg">
            <div class="flex items-start justify-between mb-2">
                <div class="p-2 bg-orange-500/20 rounded-lg">
                    <svg class="h-4 w-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <span class="text-[10px] px-1.5 py-0.5 bg-orange-500/20 text-orange-600 rounded">-2%</span>
            </div>
            <p class="text-xs text-[hsl(var(--muted-foreground))] mb-1">Inventario Activo</p>
            <p class="text-2xl font-bold text-white">42</p>
        </div>

        <!-- Citas Pendientes -->
        <div class="p-5 bg-gradient-to-br from-purple-500/10 to-purple-600/10 border border-purple-500/20 rounded-lg">
            <div class="flex items-start justify-between mb-2">
                <div class="p-2 bg-purple-500/20 rounded-lg">
                    <svg class="h-4 w-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <span class="text-[10px] px-1.5 py-0.5 bg-purple-500/20 text-purple-600 rounded">0%</span>
            </div>
            <p class="text-xs text-[hsl(var(--muted-foreground))] mb-1">Citas Pendientes</p>
            <p class="text-2xl font-bold text-white">8</p>
        </div>
    </div>

    <!-- Sección principal -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Rendimiento de Ventas (2/3) -->
        <div class="lg:col-span-2 card">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-base font-semibold mb-1">Rendimiento de Ventas</h2>
                    <p class="text-xs text-[hsl(var(--muted-foreground))]">Últimos 6 meses</p>
                </div>
                <div class="text-right">
                    <p class="text-2xl font-bold text-[hsl(var(--primary))]">$845k</p>
                    <span class="text-[10px] px-1.5 py-0.5 bg-[hsl(var(--primary))]/20 text-[hsl(var(--primary))] rounded mt-1 inline-block">+18%</span>
                </div>
            </div>

            <!-- Gráfico placeholder -->
            <div class="h-64 flex items-end justify-around gap-2">
                <div class="flex-1 bg-[hsl(var(--primary))]/20 rounded-t" style="height: 40%"></div>
                <div class="flex-1 bg-[hsl(var(--primary))]/30 rounded-t" style="height: 55%"></div>
                <div class="flex-1 bg-[hsl(var(--primary))]/40 rounded-t" style="height: 65%"></div>
                <div class="flex-1 bg-[hsl(var(--primary))]/50 rounded-t" style="height: 50%"></div>
                <div class="flex-1 bg-[hsl(var(--primary))]/60 rounded-t" style="height: 75%"></div>
                <div class="flex-1 bg-[hsl(var(--primary))] rounded-t" style="height: 90%"></div>
            </div>
            <div class="flex justify-around mt-4 text-xs text-[hsl(var(--muted-foreground))]">
                <span>MAY</span>
                <span>JUN</span>
                <span>JUL</span>
                <span>AGO</span>
                <span>SEP</span>
                <span>OCT</span>
            </div>
        </div>

        <!-- Columna derecha (1/3) -->
        <div class="space-y-6">
            <!-- Auto destacado -->
            <div class="card p-0 overflow-hidden relative">
                <div class="relative h-40 bg-gradient-to-br from-gray-700 to-gray-900">
                    <img src="https://images.unsplash.com/photo-1617654112368-307921291f42?w=400&h=300&fit=crop" 
                         alt="Auto destacado" 
                         class="w-full h-full object-cover">
                    <div class="absolute top-3 right-3">
                        <span class="px-2 py-1 bg-[hsl(var(--primary))] text-[#0a0f14] text-[10px] font-medium rounded">MÁS VISTO</span>
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-white mb-1">Model X SUV 2024</h3>
                    <p class="text-xs text-[hsl(var(--muted-foreground))] mb-2">Interés: +40% esta semana</p>
                    <div class="flex items-center justify-between">
                        <p class="text-lg font-bold text-[hsl(var(--primary))]">$89,900</p>
                        <button class="text-xs text-white hover:text-[hsl(var(--primary))] flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            Ver Detalles
                        </button>
                    </div>
                </div>
            </div>

            <!-- Agenda de Hoy -->
            <div class="card">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-semibold">Agenda de Hoy</h3>
                    <button class="text-xs text-[hsl(var(--muted-foreground))] hover:text-white">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                        </svg>
                    </button>
                </div>

                <div class="space-y-3">
                    <!-- Cita 1 -->
                    <div class="flex gap-3">
                        <div class="flex flex-col items-center">
                            <div class="w-8 h-8 rounded-lg bg-green-500/20 flex items-center justify-center">
                                <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2"></path>
                                    <circle cx="7" cy="17" r="2"></circle>
                                    <circle cx="17" cy="17" r="2"></circle>
                                </svg>
                            </div>
                            <div class="w-0.5 h-full bg-[hsl(var(--border))] mt-1"></div>
                        </div>
                        <div class="flex-1 pb-3">
                            <p class="text-xs text-green-500 mb-0.5">10:00 AM</p>
                            <p class="text-sm font-medium text-white">Prueba de Manejo</p>
                            <p class="text-xs text-[hsl(var(--muted-foreground))]">Cliente: Juan Pérez (RAV4 XS)</p>
                        </div>
                    </div>

                    <!-- Cita 2 -->
                    <div class="flex gap-3">
                        <div class="flex flex-col items-center">
                            <div class="w-8 h-8 rounded-lg bg-purple-500/20 flex items-center justify-center">
                                <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div class="w-0.5 h-full bg-[hsl(var(--border))] mt-1"></div>
                        </div>
                        <div class="flex-1 pb-3">
                            <p class="text-xs text-purple-500 mb-0.5">12:30 PM</p>
                            <p class="text-sm font-medium text-white">Firma de Contrato</p>
                            <p class="text-xs text-[hsl(var(--muted-foreground))]">Entrega: Toyota Corolla</p>
                        </div>
                    </div>

                    <!-- Cita 3 -->
                    <div class="flex gap-3">
                        <div class="flex flex-col items-center">
                            <div class="w-8 h-8 rounded-lg bg-orange-500/20 flex items-center justify-center">
                                <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <p class="text-xs text-orange-500 mb-0.5">03:00 PM</p>
                            <p class="text-sm font-medium text-white">Recepción de Servicio</p>
                            <p class="text-xs text-[hsl(var(--muted-foreground))]">Mantenimiento: Hilux #2</p>
                        </div>
                    </div>
                </div>

                <button class="w-full mt-4 pt-3 border-t border-[hsl(var(--border))] text-xs text-[hsl(var(--primary))] hover:text-[hsl(var(--primary))]/80 flex items-center justify-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Agregar Cita
                </button>
            </div>
        </div>
    </div>

    <!-- Información de Agencia -->
    <div class="card">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold">Mi Agencia</h3>
            <a href="{{ route('admin.agencia.show') }}" class="text-sm text-[hsl(var(--primary))] hover:underline">
                Editar Agencia
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
            <div>
                <p class="text-[hsl(var(--muted-foreground))] mb-1">Nombre</p>
                <p class="font-semibold text-white">{{ $stats['agencia']->nombre }}</p>
            </div>
            <div>
                <p class="text-[hsl(var(--muted-foreground))] mb-1">Ubicación</p>
                <p class="font-semibold text-white">{{ $stats['agencia']->ubicacion ?: 'No especificada' }}</p>
            </div>
            <div>
                <p class="text-[hsl(var(--muted-foreground))] mb-1">Teléfono</p>
                <p class="font-semibold text-white">{{ $stats['agencia']->telefono ?: 'No especificado' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
