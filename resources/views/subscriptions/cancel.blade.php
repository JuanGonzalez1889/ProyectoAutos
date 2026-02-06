@extends('layouts.admin')

@section('title', 'Pago Cancelado')
@section('page-title', 'Pago Cancelado')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="card text-center">
        <div class="p-12">
            <!-- Warning Icon -->
            <div class="mb-6 flex justify-center">
                <div class="w-20 h-20 bg-amber-500/20 rounded-full flex items-center justify-center">
                    <svg class="w-10 h-10 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
            </div>

            <h1 class="text-3xl font-bold text-white mb-4">Pago Cancelado</h1>
            
            <p class="text-[hsl(var(--muted-foreground))] mb-8">
                El proceso de pago ha sido cancelado. No se realizó ningún cargo a tu cuenta.
            </p>

            <div class="bg-amber-500/10 border border-amber-500/20 rounded-lg p-4 mb-8 text-left">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-amber-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-amber-400 mb-1">¿Qué pasó?</p>
                        <p class="text-sm text-[hsl(var(--muted-foreground))]">
                            Cancelaste el proceso de pago antes de completarlo. Esto puede ocurrir por:
                        </p>
                        <ul class="text-sm text-[hsl(var(--muted-foreground))] mt-2 space-y-1 ml-4">
                            <li>• Decidiste no continuar con la compra</li>
                            <li>• Cerraste la ventana de pago</li>
                            <li>• Ocurrió un error durante el proceso</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="flex gap-4 justify-center">
                <a href="{{ route('subscriptions.index') }}" 
                   class="h-10 px-6 bg-[hsl(var(--primary))] hover:opacity-90 text-[#0a0f14] rounded-lg text-sm font-medium transition-opacity flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Volver a Intentar
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

    <!-- Help Section -->
    <div class="mt-6 card">
        <div class="p-6">
            <h3 class="text-lg font-semibold text-white mb-4">¿Necesitas ayuda con el pago?</h3>
            <p class="text-sm text-[hsl(var(--muted-foreground))] mb-4">
                Si tuviste problemas durante el proceso de pago o tienes dudas, nuestro equipo está disponible para ayudarte.
            </p>
            <div class="flex gap-4">
                <a href="mailto:soporte@autowebpro.com" class="text-sm text-blue-400 hover:text-blue-300">
                    📧 soporte@autowebpro.com
                </a>
                <a href="https://wa.me/5491112345678" target="_blank" class="text-sm text-emerald-400 hover:text-emerald-300">
                    💬 WhatsApp Soporte
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
