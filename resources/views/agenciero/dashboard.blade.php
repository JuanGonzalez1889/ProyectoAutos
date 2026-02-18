@extends('layouts.admin')

@section('title', 'Dashboard - Agenciero')
@section('page-title', 'Resumen General')

@section('content')
<div class="space-y-6">
    @if(($onboarding['show'] ?? false))
    <style>
        .onboarding-backdrop {
            position: fixed;
            inset: 0;
            z-index: 50;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }
        .onboarding-modal {
            width: 100%;
            max-width: 42rem;
            background: hsl(var(--card));
            border: 1px solid hsl(var(--border));
            border-radius: 0.75rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            max-height: 90vh;
            overflow-y: auto;
            padding: 3rem 3.5rem;
        }
        .domain-check-loader {
            display: none;
            width: 16px;
            height: 16px;
            border: 2px solid rgba(16, 185, 129, 0.3);
            border-top-color: #10b981;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }
        .domain-check-loader.active {
            display: inline-block;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
    <div class="onboarding-backdrop">
        <div class="onboarding-modal">
            <!-- Header -->
            <div class="mb-8">
                <h2 class="text-3xl font-bold text-white">Completa tu agencia</h2>
                <p class="text-sm text-[hsl(var(--muted-foreground))] mt-2">
                    Solo una vez. Necesitamos estos datos para activar tu dominio.
                </p>
            </div>

            @if($errors->any())
                <div class="mb-6 p-4 rounded-lg bg-red-500/15 border border-red-500/40 text-red-200 text-sm space-y-2">
                    @foreach($errors->all() as $error)
                        <div>• {{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('admin.onboarding.complete') }}" class="space-y-6" id="onboarding-form">
                @csrf
                
                <!-- Nombre completo -->
                <div>
                    <label class="block text-sm font-semibold text-white mb-2">Nombre completo</label>
                    <input type="text" id="full-name-input" name="full_name" required
                           placeholder="Juan Pérez"
                           class="w-full h-12 px-4 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-sm text-white placeholder-[hsl(var(--muted-foreground))] focus:outline-none focus:border-[hsl(var(--primary))] focus:ring-1 focus:ring-[hsl(var(--primary))]">
                </div>

                <!-- Nombre de la agencia -->
                <div>
                    <label class="block text-sm font-semibold text-white mb-2">Nombre de la agencia</label>
                    <input type="text" id="agencia-name-input" name="agencia_name" required
                           placeholder="Mi Agencia"
                           class="w-full h-12 px-4 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-lg text-sm text-white placeholder-[hsl(var(--muted-foreground))] focus:outline-none focus:border-[hsl(var(--primary))] focus:ring-1 focus:ring-[hsl(var(--primary))]">
                </div>

                <!-- Dominio -->
                <div>
                    <label class="block text-sm font-semibold text-white mb-2">Dominio deseado</label>
                    <div class="flex gap-2">
                        <div class="flex-1 relative">
                            <input type="text" id="domain-input" name="domain" required
                                   placeholder="miagencia"
                                   class="w-full h-12 px-4 bg-[hsl(var(--background))] border border-[hsl(var(--border))] rounded-l-lg text-sm text-white placeholder-[hsl(var(--muted-foreground))] focus:outline-none focus:border-[hsl(var(--primary))] focus:ring-1 focus:ring-[hsl(var(--primary))]">
                            <div class="domain-check-loader" id="domain-loader" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%);"></div>
                        </div>
                        <span class="h-12 px-4 flex items-center bg-[hsl(var(--muted))] border border-[hsl(var(--border))] rounded-r-lg text-sm text-[hsl(var(--muted-foreground))] whitespace-nowrap font-medium">
                            {{ $onboarding['domain_suffix'] ?? '.autowebpro.com.ar' }}
                        </span>
                    </div>
                    <div id="domain-status" class="text-xs mt-2 flex items-center gap-2">
                        <span id="domain-status-text" class="text-[hsl(var(--muted-foreground))]">Escribe un dominio para verificar disponibilidad</span>
                    </div>
                    <p class="text-xs text-[hsl(var(--muted-foreground))] mt-2">Ej: si escribes "miagencia", tu URL será miagencia.autowebpro.com.ar</p>
                </div>

                <!-- Botón de guardar -->
                <button type="submit" id="submit-btn" class="w-full h-12 mt-8 bg-[hsl(var(--primary))] text-[#0a0f14] rounded-lg font-semibold hover:opacity-90 transition-opacity text-sm disabled:opacity-50 disabled:cursor-not-allowed">
                    Guardar y continuar
                </button>
            </form>

            <script>
                const domainInput = document.getElementById('domain-input');
                const domainLoader = document.getElementById('domain-loader');
                const domainStatus = document.getElementById('domain-status-text');
                const submitBtn = document.getElementById('submit-btn');
                let checkTimeout;

                domainInput.addEventListener('input', function() {
                    clearTimeout(checkTimeout);
                    const domain = this.value.trim().toLowerCase();

                    if (!domain) {
                        domainStatus.textContent = 'Escribe un dominio para verificar disponibilidad';
                        domainStatus.className = 'text-[hsl(var(--muted-foreground))]';
                        domainLoader.classList.remove('active');
                        submitBtn.disabled = false;
                        return;
                    }

                    // Validación local
                    if (!domain.match(/^[a-z0-9]([a-z0-9-]*[a-z0-9])?$/)) {
                        domainStatus.textContent = '❌ Formato inválido (solo letras, números y guiones)';
                        domainStatus.className = 'text-red-400';
                        domainLoader.classList.remove('active');
                        submitBtn.disabled = true;
                        return;
                    }

                    // Mostrar loader
                    domainLoader.classList.add('active');
                    domainStatus.textContent = 'Verificando disponibilidad...';
                    domainStatus.className = 'text-[hsl(var(--muted-foreground))]';

                    // Verificar disponibilidad
                    checkTimeout = setTimeout(() => {
                        fetch(`{{ route('admin.check-domain') }}?domain=${encodeURIComponent(domain)}`)
                            .then(res => res.json())
                            .then(data => {
                                domainLoader.classList.remove('active');
                                if (data.available) {
                                    domainStatus.innerHTML = '✅ <span>' + data.message + '</span>';
                                    domainStatus.className = 'text-green-400 flex items-center gap-1';
                                    submitBtn.disabled = false;
                                } else {
                                    domainStatus.innerHTML = '❌ <span>' + data.message + '</span>';
                                    domainStatus.className = 'text-red-400 flex items-center gap-1';
                                    submitBtn.disabled = true;
                                }
                            })
                            .catch(err => {
                                domainLoader.classList.remove('active');
                                domainStatus.textContent = 'Error verificando disponibilidad';
                                domainStatus.className = 'text-red-400';
                            });
                    }, 500);
                });

                // Trigger check on page load si hay valor
                if (domainInput.value) {
                    domainInput.dispatchEvent(new Event('input'));
                }

            </script>
        </div>
    </div>
    @endif
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
                <span class="text-[10px] px-1.5 py-0.5 bg-green-500/20 text-green-600 rounded">+0%</span>
            </div>
            <p class="text-xs text-[hsl(var(--muted-foreground))] mb-1">Ingresos Mensuales</p>
            <p class="text-2xl font-bold text-white">${{ number_format($stats['monthly_revenue'], 0) }}</p>
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
                <span class="text-[10px] px-1.5 py-0.5 bg-blue-500/20 text-blue-600 rounded">{{ $stats['units_sold'] > 0 ? '+' : '' }}0%</span>
            </div>
            <p class="text-xs text-[hsl(var(--muted-foreground))] mb-1">Unidades Vendidas</p>
            <p class="text-2xl font-bold text-white">{{ $stats['units_sold'] }}</p>
        </div>

        <!-- Inventario Activo -->
        <div class="p-5 bg-gradient-to-br from-orange-500/10 to-orange-600/10 border border-orange-500/20 rounded-lg">
            <div class="flex items-start justify-between mb-2">
                <div class="p-2 bg-orange-500/20 rounded-lg">
                    <svg class="h-4 w-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <span class="text-[10px] px-1.5 py-0.5 bg-orange-500/20 text-orange-600 rounded">{{ $stats['active_inventory'] > 0 ? '+' : '' }}0%</span>
            </div>
            <p class="text-xs text-[hsl(var(--muted-foreground))] mb-1">Inventario Activo</p>
            <p class="text-2xl font-bold text-white">{{ $stats['active_inventory'] }}/{{ $stats['total_vehicles'] }}</p>
        </div>

        <!-- Citas Pendientes -->
        <div class="p-5 bg-gradient-to-br from-purple-500/10 to-purple-600/10 border border-purple-500/20 rounded-lg">
            <div class="flex items-start justify-between mb-2">
                <div class="p-2 bg-purple-500/20 rounded-lg">
                    <svg class="h-4 w-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <span class="text-[10px] px-1.5 py-0.5 bg-purple-500/20 text-purple-600 rounded">{{ $stats['pending_events'] > 0 ? '+' : '' }}0%</span>
            </div>
            <p class="text-xs text-[hsl(var(--muted-foreground))] mb-1">Citas Pendientes</p>
            <p class="text-2xl font-bold text-white">{{ $stats['pending_events'] }}</p>
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
                    <p class="text-2xl font-bold text-[hsl(var(--primary))]">${{ number_format($stats['sales_performance'], 0) }}</p>
                    <span class="text-[10px] px-1.5 py-0.5 bg-[hsl(var(--primary))]/20 text-[hsl(var(--primary))] rounded mt-1 inline-block">+0%</span>
                </div>
            </div>

            <!-- Gráfico de Rendimiento de Ventas (últimos 6 meses) -->
            <div class="h-64 flex items-end justify-around gap-2">
                @php
                    // Generar datos reales de los últimos 6 meses
                    $months = [];
                    $monthLabels = [];
                    $monthValues = [];
                    
                    for ($i = 5; $i >= 0; $i--) {
                        $date = now()->subMonths($i);
                        $start = $date->startOfMonth();
                        $end = $date->endOfMonth();
                        
                        $monthLabels[] = strtoupper($date->locale('es')->format('M'));
                        
                        // Contar invoices de ese mes
                        $count = collect($stats['agencia']->invoices ?? [])->filter(function($inv) use ($start, $end) {
                            return $inv->created_at >= $start && $inv->created_at <= $end;
                        })->count();
                        
                        $monthValues[] = max($count, 1) * 15; // Altura mínima de 15%
                    }
                @endphp
                
                @forelse($monthValues as $value)
                    <div class="flex-1 bg-[hsl(var(--primary))]/50 rounded-t transition-all hover:bg-[hsl(var(--primary))]" 
                         style="height: {{ min($value, 90) }}%"
                         title="Mes: {{ $monthLabels[$loop->index] }}"></div>
                @empty
                    <div class="flex-1 bg-[hsl(var(--primary))]/20 rounded-t" style="height: 40%"></div>
                    <div class="flex-1 bg-[hsl(var(--primary))]/30 rounded-t" style="height: 55%"></div>
                    <div class="flex-1 bg-[hsl(var(--primary))]/40 rounded-t" style="height: 65%"></div>
                    <div class="flex-1 bg-[hsl(var(--primary))]/50 rounded-t" style="height: 50%"></div>
                    <div class="flex-1 bg-[hsl(var(--primary))]/60 rounded-t" style="height: 75%"></div>
                    <div class="flex-1 bg-[hsl(var(--primary))] rounded-t" style="height: 90%"></div>
                @endforelse
            </div>
            <div class="flex justify-around mt-4 text-xs text-[hsl(var(--muted-foreground))]">
                @forelse($monthLabels as $label)
                    <span>{{ $label }}</span>
                @empty
                    <span>MAY</span>
                    <span>JUN</span>
                    <span>JUL</span>
                    <span>AGO</span>
                    <span>SEP</span>
                    <span>OCT</span>
                @endforelse
            </div>
        </div>

        <!-- Columna derecha (1/3) -->
        <div class="space-y-6">
            <!-- Auto destacado (más visto) -->
            @if(count($stats['top_vehicles']) > 0)
                @php $vehicle = $stats['top_vehicles']->first(); @endphp
                <div class="card p-0 overflow-hidden relative">
                    <div class="relative h-40 bg-gradient-to-br from-gray-700 to-gray-900">
                        @if($vehicle->image_url)
                            <img src="{{ $vehicle->image_url }}" 
                                 alt="{{ $vehicle->marca }} {{ $vehicle->modelo }}" 
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gray-800">
                                <svg class="w-16 h-16 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2"></path>
                                </svg>
                            </div>
                        @endif
                        <div class="absolute top-3 right-3">
                            <span class="px-2 py-1 bg-[hsl(var(--primary))] text-[#0a0f14] text-[10px] font-medium rounded">MÁS VISTO</span>
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-white mb-1">{{ $vehicle->marca }} {{ $vehicle->modelo }} {{ $vehicle->anio }}</h3>
                        <p class="text-xs text-[hsl(var(--muted-foreground))] mb-2">Vistas: {{ $vehicle->views ?? 0 }}</p>
                        <div class="flex items-center justify-between">
                            <p class="text-lg font-bold text-[hsl(var(--primary))]">${{ number_format($vehicle->precio, 0) }}</p>
                            <a href="{{ route('admin.vehicles.show', $vehicle->id) }}" class="text-xs text-white hover:text-[hsl(var(--primary))] flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Ver Detalles
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <div class="card p-0 overflow-hidden relative">
                    <div class="relative h-40 bg-gradient-to-br from-gray-700 to-gray-900">
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-16 h-16 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2"></path>
                            </svg>
                        </div>
                        <div class="absolute top-3 right-3">
                            <span class="px-2 py-1 bg-[hsl(var(--primary))] text-[#0a0f14] text-[10px] font-medium rounded">SIN VEHÍCULOS</span>
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-white mb-1">Sin vehículos disponibles</h3>
                        <p class="text-xs text-[hsl(var(--muted-foreground))] mb-2">Agrega tus primeros vehículos</p>
                        <a href="{{ route('admin.vehicles.create') }}" class="text-xs text-[hsl(var(--primary))] hover:underline">
                            Crear Vehículo →
                        </a>
                    </div>
                </div>
            @endif

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
                    @forelse($stats['upcoming_events'] ?? [] as $event)
                        <div class="flex gap-3">
                            <div class="flex flex-col items-center">
                                <div class="w-8 h-8 rounded-lg bg-green-500/20 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                @if(!$loop->last)
                                    <div class="w-0.5 h-8 bg-[hsl(var(--border))] mt-1"></div>
                                @endif
                            </div>
                            <div class="flex-1 pb-3">
                                <p class="text-xs {{ $loop->first ? 'text-green-500' : 'text-blue-500' }} mb-0.5">
                                    {{ $event->start_time->format('h:i A') }}
                                </p>
                                <p class="text-sm font-medium text-white">{{ $event->titulo }}</p>
                                <p class="text-xs text-[hsl(var(--muted-foreground))]">{{ $event->descripcion ?? 'Sin descripción' }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-[hsl(var(--muted-foreground))] text-center py-4">
                            No hay eventos programados para hoy
                        </p>
                    @endforelse
                </div>

                <a href="{{ route('admin.events.create') }}" class="w-full mt-4 pt-3 border-t border-[hsl(var(--border))] text-xs text-[hsl(var(--primary))] hover:text-[hsl(var(--primary))]/80 flex items-center justify-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Agregar Cita
                </a>
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
