@extends('layouts.admin')

@section('title', 'Facturación')
@section('page-title', 'Facturación y Suscripción')

@section('content')
<div class="space-y-6">
    <!-- Subscription Info Card -->
    @if($subscription && $subscription->isActive())
    <div class="card">
        <div class="p-6">
            <div class="flex items-start justify-between mb-6">
                <div>
                    <h3 class="text-xl font-bold text-white mb-2">Suscripción Actual</h3>
                    <p class="text-sm text-[hsl(var(--muted-foreground))]">Información de tu plan activo</p>
                </div>
                <span class="px-3 py-1 bg-emerald-500/20 text-emerald-400 text-sm font-semibold rounded-full">Activo</span>
            </div>

            <div class="grid md:grid-cols-4 gap-6">
                <div>
                    <p class="text-xs text-[hsl(var(--muted-foreground))] mb-1">Plan</p>
                    <p class="text-lg font-bold text-white">{{ ucfirst($subscription->plan) }}</p>
                </div>
                <div>
                    <p class="text-xs text-[hsl(var(--muted-foreground))] mb-1">Monto</p>
                    <p class="text-lg font-bold text-white">
                        @if($subscription->currency === 'USD')
                            ${{ number_format($subscription->amount, 2) }}
                        @else
                            ${{ number_format($subscription->amount, 0) }} ARS
                        @endif
                        <span class="text-sm font-normal text-[hsl(var(--muted-foreground))]">/mes</span>
                    </p>
                </div>
                <div>
                    <p class="text-xs text-[hsl(var(--muted-foreground))] mb-1">Método de Pago</p>
                    <p class="text-lg font-bold text-white">
                        @if($subscription->payment_method === 'stripe')
                            <span class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M13.976 9.15c-2.172-.806-3.356-1.426-3.356-2.409 0-.831.683-1.305 1.901-1.305 2.227 0 4.515.858 6.09 1.631l.89-5.494C18.252.975 15.697 0 12.165 0 9.667 0 7.589.654 6.104 1.872 4.56 3.147 3.757 4.992 3.757 7.218c0 4.039 2.467 5.76 6.476 7.219 2.585.92 3.445 1.574 3.445 2.583 0 .98-.84 1.545-2.354 1.545-1.875 0-4.965-.921-6.99-2.109l-.9 5.555C5.175 22.99 8.385 24 11.714 24c2.641 0 4.843-.624 6.328-1.813 1.664-1.305 2.525-3.236 2.525-5.732 0-4.128-2.524-5.851-6.594-7.305h.003z"/>
                                </svg>
                                Stripe
                            </span>
                        @else
                            <span class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M21.457 0H2.543C1.14 0 0 1.14 0 2.543v18.914C0 22.86 1.14 24 2.543 24h18.914c1.403 0 2.543-1.14 2.543-2.543V2.543C24 1.14 22.86 0 21.457 0z"/>
                                </svg>
                                MercadoPago
                            </span>
                        @endif
                    </p>
                </div>
                <div>
                    <p class="text-xs text-[hsl(var(--muted-foreground))] mb-1">Próxima Renovación</p>
                    <p class="text-lg font-bold text-white">{{ $subscription->current_period_end->format('d/m/Y') }}</p>
                    <p class="text-xs text-[hsl(var(--muted-foreground))]">
                        ({{ $subscription->current_period_end->diffForHumans() }})
                    </p>
                </div>
            </div>

            <div class="mt-6 pt-6 border-t border-[hsl(var(--border))] flex gap-3">
                <a href="{{ route('subscriptions.index') }}" 
                   class="h-10 px-5 bg-[hsl(var(--primary))] hover:opacity-90 text-[#0a0f14] rounded-lg text-sm font-medium transition-opacity flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                    </svg>
                    Cambiar Plan
                </a>
                
                <form action="{{ route('subscriptions.destroy') }}" method="POST" 
                      onsubmit="return confirm('¿Estás seguro de que deseas cancelar tu suscripción? Perderás acceso al finalizar el período actual.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="h-10 px-5 bg-red-500/10 hover:bg-red-500/20 border border-red-500/30 text-red-400 rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Cancelar Suscripción
                    </button>
                </form>
            </div>
        </div>
    </div>
    @elseif($tenant && $tenant->isOnTrial())
    <div class="card">
        <div class="p-6">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-full bg-blue-500/20 flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-xl font-bold text-white mb-2">Período de Prueba Activo</h3>
                    <p class="text-sm text-[hsl(var(--muted-foreground))] mb-4">
                        Te quedan <strong class="text-blue-400">{{ $tenant->trialDaysRemaining() }} días</strong> de prueba gratuita.
                        Finaliza el {{ $tenant->trial_ends_at->format('d/m/Y') }}.
                    </p>
                    <a href="{{ route('subscriptions.index') }}" 
                       class="inline-flex items-center gap-2 h-10 px-5 bg-[hsl(var(--primary))] hover:opacity-90 text-[#0a0f14] rounded-lg text-sm font-medium transition-opacity">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Suscribirte Ahora
                    </a>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="card">
        <div class="p-6">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-full bg-red-500/20 flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-xl font-bold text-white mb-2">Sin Suscripción Activa</h3>
                    <p class="text-sm text-[hsl(var(--muted-foreground))] mb-4">
                        No tienes una suscripción activa en este momento. Suscríbete para continuar usando todas las funcionalidades.
                    </p>
                    <a href="{{ route('subscriptions.index') }}" 
                       class="inline-flex items-center gap-2 h-10 px-5 bg-[hsl(var(--primary))] hover:opacity-90 text-[#0a0f14] rounded-lg text-sm font-medium transition-opacity">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Ver Planes
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Invoices Table -->
    <div class="card">
        <div class="p-6">
            <h3 class="text-xl font-bold text-white mb-6">Historial de Facturas</h3>

            @if($invoices && $invoices->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-[hsl(var(--border))]">
                            <th class="text-left text-xs font-semibold text-[hsl(var(--muted-foreground))] uppercase tracking-wider pb-3">Número</th>
                            <th class="text-left text-xs font-semibold text-[hsl(var(--muted-foreground))] uppercase tracking-wider pb-3">Fecha</th>
                            <th class="text-left text-xs font-semibold text-[hsl(var(--muted-foreground))] uppercase tracking-wider pb-3">Monto</th>
                            <th class="text-left text-xs font-semibold text-[hsl(var(--muted-foreground))] uppercase tracking-wider pb-3">Método</th>
                            <th class="text-left text-xs font-semibold text-[hsl(var(--muted-foreground))] uppercase tracking-wider pb-3">Estado</th>
                            <th class="text-right text-xs font-semibold text-[hsl(var(--muted-foreground))] uppercase tracking-wider pb-3">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[hsl(var(--border))]">
                        @foreach($invoices as $invoice)
                        <tr class="hover:bg-[hsl(var(--muted))] transition-colors">
                            <td class="py-4">
                                <span class="text-sm font-mono text-white">{{ $invoice->invoice_number }}</span>
                            </td>
                            <td class="py-4">
                                <span class="text-sm text-[hsl(var(--muted-foreground))]">{{ $invoice->created_at->format('d/m/Y') }}</span>
                            </td>
                            <td class="py-4">
                                <span class="text-sm font-semibold text-white">
                                    @if($invoice->currency === 'USD')
                                        ${{ number_format($invoice->total, 2) }} USD
                                    @else
                                        ${{ number_format($invoice->total, 0) }} ARS
                                    @endif
                                </span>
                            </td>
                            <td class="py-4">
                                @if($invoice->payment_method === 'stripe')
                                    <span class="text-xs px-2 py-1 bg-purple-500/20 text-purple-400 rounded-full">Stripe</span>
                                @elseif($invoice->payment_method === 'mercadopago')
                                    <span class="text-xs px-2 py-1 bg-blue-500/20 text-blue-400 rounded-full">MercadoPago</span>
                                @else
                                    <span class="text-xs px-2 py-1 bg-gray-500/20 text-gray-400 rounded-full">{{ ucfirst($invoice->payment_method) }}</span>
                                @endif
                            </td>
                            <td class="py-4">
                                @if($invoice->status === 'paid')
                                    <span class="text-xs px-2 py-1 bg-emerald-500/20 text-emerald-400 rounded-full">Pagada</span>
                                @elseif($invoice->status === 'pending')
                                    <span class="text-xs px-2 py-1 bg-amber-500/20 text-amber-400 rounded-full">Pendiente</span>
                                @elseif($invoice->status === 'failed')
                                    <span class="text-xs px-2 py-1 bg-red-500/20 text-red-400 rounded-full">Fallida</span>
                                @else
                                    <span class="text-xs px-2 py-1 bg-gray-500/20 text-gray-400 rounded-full">{{ ucfirst($invoice->status) }}</span>
                                @endif
                            </td>
                            <td class="py-4 text-right">
                                <button class="text-sm text-blue-400 hover:text-blue-300">
                                    <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Descargar PDF
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($invoices->hasPages())
            <div class="mt-6">
                {{ $invoices->links() }}
            </div>
            @endif
            @else
            <div class="text-center py-12">
                <svg class="w-16 h-16 mx-auto text-[hsl(var(--muted-foreground))] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <p class="text-[hsl(var(--muted-foreground))]">No tienes facturas todavía</p>
                <p class="text-sm text-[hsl(var(--muted-foreground))] mt-1">Tus facturas aparecerán aquí cuando realices pagos</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
