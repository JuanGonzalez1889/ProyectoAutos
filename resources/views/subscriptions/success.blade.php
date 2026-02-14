@extends('layouts.public')

@section('title', 'Pago Exitoso')
@section('page-title', 'Pago Exitoso')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="card text-center">
        <div class="p-12">
            <!-- Success Icon -->
            <div class="mb-6 flex justify-center">
                <div class="w-20 h-20 bg-emerald-500/20 rounded-full flex items-center justify-center">
                    <svg class="w-10 h-10 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>

            <h1 class="text-3xl font-bold text-white mb-4">¡Pago Procesado Exitosamente!</h1>
            
            <p class="text-[hsl(var(--muted-foreground))] mb-8">
                Tu suscripción ha sido activada correctamente. Ya puedes disfrutar de todas las funcionalidades de tu plan.
            </p>

            <div class="bg-blue-500/10 border border-blue-500/20 rounded-lg p-4 mb-8 text-left">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-blue-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-blue-400 mb-1">Próximos pasos</p>
                        <ul class="text-sm text-[hsl(var(--muted-foreground))] space-y-1">
                            <li>✓ Tu suscripción está activa ahora</li>
                            <li>✓ Recibirás un email de confirmación en breve</li>
                            <li>✓ La factura está disponible en tu panel de facturación</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="flex gap-4 justify-center">
                <a href="{{ route('admin.dashboard') }}" 
                   class="h-10 px-6 bg-[hsl(var(--primary))] hover:opacity-90 text-[#0a0f14] rounded-lg text-sm font-medium transition-opacity flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Ir al Dashboard
                </a>
                
                <a href="{{ route('subscriptions.billing') }}" 
                   class="h-10 px-6 bg-[hsl(var(--secondary))] hover:bg-[hsl(var(--muted))] rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Ver Facturación
                </a>
            </div>
        </div>
    </div>

    <!-- Additional Info -->
    <div class="mt-6 card">
        <div class="p-6">
            <h3 class="text-lg font-semibold text-white mb-4">¿Necesitas ayuda?</h3>
            <p class="text-sm text-[hsl(var(--muted-foreground))] mb-4">
                Si tienes alguna pregunta sobre tu suscripción o necesitas asistencia, no dudes en contactarnos.
            </p>
            <a href="mailto:soporte@autowebpro.com" class="text-sm text-blue-400 hover:text-blue-300">
                soporte@autowebpro.com →
            </a>
        </div>
    </div>
</div>
@endsection
