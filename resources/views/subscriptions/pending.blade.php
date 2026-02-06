@extends('layouts.admin')

@section('title', 'Pago Pendiente')
@section('page-title', 'Pago Pendiente')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="card text-center">
        <div class="p-12">
            <!-- Pending Icon -->
            <div class="mb-6 flex justify-center">
                <div class="w-20 h-20 bg-blue-500/20 rounded-full flex items-center justify-center">
                    <svg class="w-10 h-10 text-blue-400 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>

            <h1 class="text-3xl font-bold text-white mb-4">Pago en Proceso</h1>
            
            <p class="text-[hsl(var(--muted-foreground))] mb-8">
                Tu pago está siendo procesado. Te notificaremos cuando se complete la transacción.
            </p>

            <div class="bg-blue-500/10 border border-blue-500/20 rounded-lg p-4 mb-8 text-left">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-blue-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-blue-400 mb-2">Estado del Pago</p>
                        <p class="text-sm text-[hsl(var(--muted-foreground))] mb-3">
                            El pago con MercadoPago puede tardar unos minutos en procesarse, especialmente si elegiste opciones como:
                        </p>
                        <ul class="text-sm text-[hsl(var(--muted-foreground))] space-y-1 ml-4">
                            <li>• Pago en efectivo (Rapipago, PagoFácil)</li>
                            <li>• Transferencia bancaria</li>
                            <li>• Tarjetas con verificación adicional</li>
                        </ul>
                        <div class="mt-4 pt-4 border-t border-blue-500/20">
                            <p class="text-sm text-blue-400 font-semibold">¿Qué hacer ahora?</p>
                            <ul class="text-sm text-[hsl(var(--muted-foreground))] mt-2 space-y-1">
                                <li>✓ Recibirás un email cuando el pago se confirme</li>
                                <li>✓ Puedes revisar el estado en tu panel de facturación</li>
                                <li>✓ Si el pago no se confirma en 48hs, contacta a soporte</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex gap-4 justify-center">
                <a href="{{ route('subscriptions.billing') }}" 
                   class="h-10 px-6 bg-[hsl(var(--primary))] hover:opacity-90 text-[#0a0f14] rounded-lg text-sm font-medium transition-opacity flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Ver Estado de Facturación
                </a>
                
                <a href="{{ route('admin.dashboard') }}" 
                   class="h-10 px-6 bg-[hsl(var(--secondary))] hover:bg-[hsl(var(--muted))] rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Ir al Dashboard
                </a>
            </div>
        </div>
    </div>

    <!-- Timeline Info -->
    <div class="mt-6 card">
        <div class="p-6">
            <h3 class="text-lg font-semibold text-white mb-4">Tiempos de Procesamiento</h3>
            <div class="space-y-3">
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-full bg-emerald-500/20 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-white">Tarjetas de crédito/débito</p>
                        <p class="text-xs text-[hsl(var(--muted-foreground))]">Confirmación inmediata (1-5 minutos)</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-full bg-blue-500/20 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-white">Transferencia bancaria</p>
                        <p class="text-xs text-[hsl(var(--muted-foreground))]">1-3 días hábiles</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-full bg-amber-500/20 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-white">Efectivo (Rapipago/PagoFácil)</p>
                        <p class="text-xs text-[hsl(var(--muted-foreground))]">24-48 horas después del pago</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Help Section -->
    <div class="mt-6 card">
        <div class="p-6">
            <h3 class="text-lg font-semibold text-white mb-4">¿Tienes dudas?</h3>
            <p class="text-sm text-[hsl(var(--muted-foreground))] mb-4">
                Si tu pago no se confirma en el tiempo esperado, contacta a nuestro equipo de soporte.
            </p>
            <a href="mailto:soporte@autowebpro.com" class="text-sm text-blue-400 hover:text-blue-300">
                soporte@autowebpro.com →
            </a>
        </div>
    </div>
</div>
@endsection
