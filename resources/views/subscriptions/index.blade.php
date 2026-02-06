@extends('layouts.admin')

@section('title', 'Planes y Suscripción')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[hsl(var(--background))] to-[hsl(var(--secondary))]">
    <div class="max-w-7xl mx-auto px-4 py-12">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-[hsl(var(--foreground))] mb-3">Planes y Suscripción</h1>
            <p class="text-[hsl(var(--muted-foreground))] text-lg">Elige el plan perfecto para tu agencia</p>
        </div>

        <!-- Current Plan Info -->
        @php
            $currentPlan = auth()->user()->tenant->getPlanInfo();
        @endphp
        <div class="bg-[hsl(var(--card))] border border-[hsl(var(--border))] rounded-lg p-6 mb-12 shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-[hsl(var(--foreground))]">Plan Actual</h3>
                    <p class="text-2xl font-bold text-[hsl(var(--primary))] mt-2">{{ $currentPlan['name'] }}</p>
                    @if($currentPlan['is_trial'])
                        <p class="text-sm text-yellow-500 mt-2">
                            📅 Prueba Gratuita: <strong>{{ $currentPlan['days_remaining'] }} días restantes</strong>
                        </p>
                    @endif
                </div>
                <div class="text-right">
                    @if($currentPlan['plan'] === 'free')
                        <a href="#plans" class="px-6 py-2 bg-[hsl(var(--primary))] hover:opacity-90 text-white rounded-lg font-semibold">
                            Actualizar Plan
                        </a>
                    @else
                        <a href="{{ route('subscriptions.billing') }}" class="px-6 py-2 bg-[hsl(var(--secondary))] hover:opacity-90 text-[hsl(var(--foreground))] rounded-lg font-semibold">
                            Gestionar Suscripción
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Plans Comparison -->
        <div id="plans" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            <!-- Free Plan -->
            <div class="bg-[hsl(var(--card))] border-2 border-[hsl(var(--border))] rounded-lg p-6 relative">
                <div class="mb-6">
                    <h3 class="text-xl font-bold text-[hsl(var(--foreground))] mb-2">Plan Gratuito</h3>
                    <p class="text-3xl font-bold text-[hsl(var(--primary))] mb-1">$0</p>
                    <p class="text-sm text-[hsl(var(--muted-foreground))]">30 días de prueba</p>
                </div>

                <ul class="space-y-3 mb-6">
                    <li class="flex items-center gap-2 text-[hsl(var(--foreground))]">
                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Hasta 5 vehículos
                    </li>
                    <li class="flex items-center gap-2 text-[hsl(var(--foreground))]">
                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        1 usuario
                    </li>
                    <li class="flex items-center gap-2 text-[hsl(var(--foreground))]">
                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        1 GB de almacenamiento
                    </li>
                    <li class="flex items-center gap-2 text-[hsl(var(--muted-foreground))]">
                        <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                        <span class="line-through">Landing personalizada</span>
                    </li>
                </ul>

                @if($currentPlan['plan'] === 'free')
                    <button disabled class="w-full py-2 bg-gray-400 text-white rounded-lg font-semibold cursor-not-allowed">
                        Plan Actual
                    </button>
                @else
                    <button disabled class="w-full py-2 bg-gray-400 text-white rounded-lg font-semibold cursor-not-allowed">
                        Tu plan actual es superior
                    </button>
                @endif
            </div>

            <!-- Starter Plan -->
            <div class="bg-[hsl(var(--card))] border-2 border-[hsl(var(--primary))] rounded-lg p-6 relative shadow-lg">
                <div class="absolute top-0 right-0 bg-[hsl(var(--primary))] text-white px-3 py-1 rounded-bl-lg text-xs font-semibold">
                    RECOMENDADO
                </div>
                <div class="mb-6">
                    <h3 class="text-xl font-bold text-[hsl(var(--foreground))] mb-2">Plan Iniciador</h3>
                    <p class="text-3xl font-bold text-[hsl(var(--primary))] mb-1">$29.99</p>
                    <p class="text-sm text-[hsl(var(--muted-foreground))]">por mes, facturación anual</p>
                </div>

                <ul class="space-y-3 mb-6">
                    <li class="flex items-center gap-2 text-[hsl(var(--foreground))]">
                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Hasta 50 vehículos
                    </li>
                    <li class="flex items-center gap-2 text-[hsl(var(--foreground))]">
                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Hasta 3 usuarios
                    </li>
                    <li class="flex items-center gap-2 text-[hsl(var(--foreground))]">
                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        10 GB de almacenamiento
                    </li>
                    <li class="flex items-center gap-2 text-[hsl(var(--foreground))]">
                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Landing personalizada
                    </li>
                </ul>

                <form action="{{ route('subscriptions.checkout') }}" method="POST">
                    @csrf
                    <input type="hidden" name="plan" value="starter">
                    <button type="submit" class="w-full py-2 bg-[hsl(var(--primary))] hover:opacity-90 text-white rounded-lg font-semibold transition">
                        Iniciar ahora
                    </button>
                </form>
            </div>

            <!-- Professional Plan -->
            <div class="bg-[hsl(var(--card))] border-2 border-[hsl(var(--border))] rounded-lg p-6">
                <div class="mb-6">
                    <h3 class="text-xl font-bold text-[hsl(var(--foreground))] mb-2">Plan Profesional</h3>
                    <p class="text-3xl font-bold text-[hsl(var(--primary))] mb-1">$79.99</p>
                    <p class="text-sm text-[hsl(var(--muted-foreground))]">por mes, facturación anual</p>
                </div>

                <ul class="space-y-3 mb-6">
                    <li class="flex items-center gap-2 text-[hsl(var(--foreground))]">
                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Hasta 500 vehículos
                    </li>
                    <li class="flex items-center gap-2 text-[hsl(var(--foreground))]">
                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Hasta 10 usuarios
                    </li>
                    <li class="flex items-center gap-2 text-[hsl(var(--foreground))]">
                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        100 GB de almacenamiento
                    </li>
                    <li class="flex items-center gap-2 text-[hsl(var(--foreground))]">
                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Dominio personalizado
                    </li>
                </ul>

                <form action="{{ route('subscriptions.checkout') }}" method="POST">
                    @csrf
                    <input type="hidden" name="plan" value="professional">
                    <button type="submit" class="w-full py-2 bg-[hsl(var(--secondary))] hover:opacity-90 text-[hsl(var(--foreground))] rounded-lg font-semibold transition border border-[hsl(var(--border))]">
                        Actualizar a Profesional
                    </button>
                </form>
            </div>

            <!-- Enterprise Plan -->
            <div class="bg-[hsl(var(--card))] border-2 border-[hsl(var(--border))] rounded-lg p-6">
                <div class="mb-6">
                    <h3 class="text-xl font-bold text-[hsl(var(--foreground))] mb-2">Plan Empresarial</h3>
                    <p class="text-3xl font-bold text-[hsl(var(--primary))] mb-1">$249.99</p>
                    <p class="text-sm text-[hsl(var(--muted-foreground))]">por mes, facturación anual</p>
                </div>

                <ul class="space-y-3 mb-6">
                    <li class="flex items-center gap-2 text-[hsl(var(--foreground))]">
                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Vehículos ilimitados
                    </li>
                    <li class="flex items-center gap-2 text-[hsl(var(--foreground))]">
                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Usuarios ilimitados
                    </li>
                    <li class="flex items-center gap-2 text-[hsl(var(--foreground))]">
                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Almacenamiento ilimitado
                    </li>
                    <li class="flex items-center gap-2 text-[hsl(var(--foreground))]">
                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Soporte 24/7 + API
                    </li>
                </ul>

                <button onclick="alert('Contacta a ventas@proyectoautos.com para plan empresarial')" class="w-full py-2 bg-[hsl(var(--secondary))] hover:opacity-90 text-[hsl(var(--foreground))] rounded-lg font-semibold transition border border-[hsl(var(--border))]">
                    Contactar Ventas
                </button>
            </div>
        </div>

        <!-- FAQ -->
        <div class="bg-[hsl(var(--card))] border border-[hsl(var(--border))] rounded-lg p-8">
            <h3 class="text-2xl font-bold text-[hsl(var(--foreground))] mb-6">Preguntas Frecuentes</h3>
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <h4 class="font-semibold text-[hsl(var(--foreground))] mb-2">¿Puedo cambiar de plan en cualquier momento?</h4>
                    <p class="text-[hsl(var(--muted-foreground))] text-sm">Sí, puedes cambiar de plan en cualquier momento. Los cambios se reflejarán en tu próxima facturación.</p>
                </div>
                <div>
                    <h4 class="font-semibold text-[hsl(var(--foreground))] mb-2">¿Hay período de prueba?</h4>
                    <p class="text-[hsl(var(--muted-foreground))] text-sm">Sí, 30 días gratuitos para explorar todas las funcionalidades del plan profesional.</p>
                </div>
                <div>
                    <h4 class="font-semibold text-[hsl(var(--foreground))] mb-2">¿Qué métodos de pago aceptan?</h4>
                    <p class="text-[hsl(var(--muted-foreground))] text-sm">Aceptamos Stripe (Visa, Mastercard, Amex) y MercadoPago (tarjetas y transferencias).</p>
                </div>
                <div>
                    <h4 class="font-semibold text-[hsl(var(--foreground))] mb-2">¿Hay contrato a largo plazo?</h4>
                    <p class="text-[hsl(var(--muted-foreground))] text-sm">No, puedes cancelar tu suscripción en cualquier momento sin penalidades.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
