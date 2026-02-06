@extends('layouts.admin')

@section('title', 'Analytics')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-white">Analytics</h1>
            <p class="text-[hsl(var(--muted-foreground))] mt-1">Estadísticas y métricas de rendimiento</p>
        </div>
        <div class="text-sm text-[hsl(var(--muted-foreground))]">
            Último mes: {{ now()->format('F Y') }}
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Total Leads This Month -->
        <div class="card p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-500/20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <span class="text-xs font-medium px-2 py-1 rounded {{ $leadsTrend >= 0 ? 'bg-green-500/20 text-green-500' : 'bg-red-500/20 text-red-500' }}">
                    {{ $leadsTrend >= 0 ? '+' : '' }}{{ $leadsTrend }}%
                </span>
            </div>
            <h3 class="text-2xl font-bold text-white">{{ $totalLeadsThisMonth }}</h3>
            <p class="text-sm text-[hsl(var(--muted-foreground))]">Leads este mes</p>
        </div>

        <!-- Conversion Rate -->
        <div class="card p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-500/20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-white">{{ $conversionRate }}%</h3>
            <p class="text-sm text-[hsl(var(--muted-foreground))]">Tasa de conversión</p>
        </div>

        <!-- Most Viewed Vehicles -->
        <div class="card p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-purple-500/20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2" />
                        <circle cx="7" cy="17" r="2" />
                        <circle cx="17" cy="17" r="2" />
                    </svg>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-white">{{ $mostViewedVehicles->count() }}</h3>
            <p class="text-sm text-[hsl(var(--muted-foreground))]">Vehículos publicados</p>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Leads Chart -->
        <div class="card p-6">
            <h3 class="text-lg font-semibold text-white mb-4">Leads por Día (Este Mes)</h3>
            <canvas id="leadsChart" width="400" height="200"></canvas>
        </div>

        <!-- Traffic Sources Chart -->
        <div class="card p-6">
            <h3 class="text-lg font-semibold text-white mb-4">Fuentes de Tráfico</h3>
            <canvas id="trafficChart" width="400" height="200"></canvas>
        </div>
    </div>

    <!-- Most Viewed Vehicles Table -->
    <div class="card">
        <div class="p-6 border-b border-[hsl(var(--border))]">
            <h3 class="text-lg font-semibold text-white">Vehículos Más Recientes</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-[hsl(var(--muted))]">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[hsl(var(--muted-foreground))] uppercase tracking-wider">Vehículo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[hsl(var(--muted-foreground))] uppercase tracking-wider">Precio</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[hsl(var(--muted-foreground))] uppercase tracking-wider">Fecha Publicación</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[hsl(var(--border))]">
                    @forelse($mostViewedVehicles as $vehicle)
                        <tr class="hover:bg-[hsl(var(--muted))] transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if($vehicle->images && count($vehicle->images) > 0)
                                        <img src="{{ $vehicle->images[0] }}" alt="{{ $vehicle->brand }} {{ $vehicle->model }}" class="w-12 h-12 rounded object-cover mr-3">
                                    @else
                                        <div class="w-12 h-12 rounded bg-[hsl(var(--muted))] mr-3 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-[hsl(var(--muted-foreground))]" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2" />
                                                <circle cx="7" cy="17" r="2" />
                                                <circle cx="17" cy="17" r="2" />
                                            </svg>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="text-sm font-medium text-white">{{ $vehicle->brand }} {{ $vehicle->model }}</div>
                                        <div class="text-xs text-[hsl(var(--muted-foreground))]">{{ $vehicle->year }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-white font-semibold">$ {{ number_format($vehicle->price, 0, ',', '.') }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-[hsl(var(--muted-foreground))]">{{ $vehicle->created_at->diffForHumans() }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-[hsl(var(--muted-foreground))]">
                                No hay vehículos publicados aún
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    // Leads Chart
    const leadsCtx = document.getElementById('leadsChart').getContext('2d');
    const leadsData = @json($leadsThisMonth);
    
    new Chart(leadsCtx, {
        type: 'line',
        data: {
            labels: leadsData.map(item => new Date(item.date).toLocaleDateString('es-ES', { day: 'numeric', month: 'short' })),
            datasets: [{
                label: 'Leads',
                data: leadsData.map(item => item.count),
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: 'rgba(255, 255, 255, 0.7)'
                    },
                    grid: {
                        color: 'rgba(255, 255, 255, 0.1)'
                    }
                },
                x: {
                    ticks: {
                        color: 'rgba(255, 255, 255, 0.7)'
                    },
                    grid: {
                        color: 'rgba(255, 255, 255, 0.1)'
                    }
                }
            }
        }
    });

    // Traffic Sources Chart
    const trafficCtx = document.getElementById('trafficChart').getContext('2d');
    const trafficData = @json($trafficSources);
    
    new Chart(trafficCtx, {
        type: 'doughnut',
        data: {
            labels: trafficData.map(item => item.source),
            datasets: [{
                data: trafficData.map(item => item.count),
                backgroundColor: [
                    'rgba(59, 130, 246, 0.8)',
                    'rgba(16, 185, 129, 0.8)',
                    'rgba(245, 158, 11, 0.8)',
                    'rgba(239, 68, 68, 0.8)'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: 'rgba(255, 255, 255, 0.7)',
                        padding: 15
                    }
                }
            }
        }
    });
</script>
@endsection
