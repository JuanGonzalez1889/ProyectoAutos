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
            <div class="bg-[hsl(var(--card))] border-2 border-[hsl(var(--border))] rounded-lg p-6 relative flex flex-col h-full">
                <div class="mb-6">
                    <h3 class="text-xl font-bold text-[hsl(var(--foreground))] mb-2">Plan Básico</h3>
                    <p class="text-3xl font-bold text-[hsl(var(--primary))] mb-1">$50.000</p>
                    <p class="text-sm text-[hsl(var(--muted-foreground))]">Por mes</p>
                </div>

                <ul class="space-y-3 mb-6">
                    <li class="flex items-center gap-2 text-[hsl(var(--foreground))]">
                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Sitio web básico
                    </li>
                    <li class="flex items-center gap-2 text-[hsl(var(--foreground))]">
                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        15 autos publicados máximo
                    </li>
                    <li class="flex items-center gap-2 text-[hsl(var(--foreground))]">
                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Soporte por whatsapp
                    </li>
                    <li class="flex items-center gap-2 text-[hsl(var(--foreground))]">
                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Certificado SSL incluido
                    </li>
                    <li class="flex items-center gap-2 text-[hsl(var(--foreground))]">
                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        1 consulta mensual de Marketing
                    </li>
                    
                </ul>

                <div class="mt-auto">
                    @if($currentPlan['plan'] === 'basico')
                        <button disabled class="w-full py-2 bg-gray-400 text-white rounded-lg font-semibold cursor-not-allowed">
                            Plan Actual
                        </button>
                    @else
                        <button disabled class="w-full py-2 bg-gray-400 text-white rounded-lg font-semibold cursor-not-allowed">
                            Tu plan actual es superior
                        </button>
                    @endif
                </div>
            </div>

            <!-- Profesional Plan -->
            <div class="bg-[hsl(var(--card))] border-2 border-[hsl(var(--primary))] rounded-lg p-6 relative shadow-lg flex flex-col h-full">
                <div class="absolute top-0 right-0 bg-[hsl(var(--primary))] text-white px-3 py-1 rounded-bl-lg text-xs font-semibold">
                    RECOMENDADO
                </div>
                <div class="mb-6">
                    <h3 class="text-xl font-bold text-[hsl(var(--foreground))] mb-2">Plan Profesional</h3>
                    <p class="text-3xl font-bold text-[hsl(var(--primary))] mb-1">$150.000</p>
                    <p class="text-sm text-[hsl(var(--muted-foreground))]">Por mes</p>
                </div>

                <ul class="space-y-3 mb-6">
                    <li class="flex items-center gap-2 text-[hsl(var(--foreground))]">
                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Sitio web básico
                    </li>
                    <li class="flex items-center gap-2 text-[hsl(var(--foreground))]">
                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        30 autos publicados máximo
                    </li>
                    <li class="flex items-center gap-2 text-[hsl(var(--foreground))]">
                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Integración CRM básica
                    </li>
                    <li class="flex items-center gap-2 text-[hsl(var(--foreground))]">
                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Herramientas SEO avanzadas
                    </li>
                    <li class="flex items-center gap-2 text-[hsl(var(--foreground))]">
                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Soporte básico por whatsapp
                    </li>
                    <li class="flex items-center gap-2 text-[hsl(var(--foreground))]">
                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                       Certificado SSL incluido
                    </li>
                    <li class="flex items-center gap-2 text-[hsl(var(--foreground))]">
                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                       2 consultas mensuales de Marketing
                    </li>
                </ul>

                <div class="mt-auto">
                    <form action="{{ route('subscriptions.checkout') }}" method="POST">
                        @csrf
                        <input type="hidden" name="plan" value="profesional">
                        <button type="submit" class="w-full py-2 bg-[#009ee3] hover:opacity-90 text-white rounded-lg font-semibold transition border-2 border-[#009ee3] shadow-lg">
                            Pagar con Mercado Pago
                        </button>
                    </form>
                </div>
            </div>

            <!-- Premium Plan -->
            <div class="bg-[hsl(var(--card))] border-2 border-[hsl(var(--border))] rounded-lg p-6 flex flex-col h-full">
                <div class="mb-6">
                    <h3 class="text-xl font-bold text-[hsl(var(--foreground))] mb-2">Plan Premium</h3>
                    <p class="text-3xl font-bold text-[hsl(var(--primary))] mb-1">$300.000</p>
                    <p class="text-sm text-[hsl(var(--muted-foreground))]">Por mes</p>
                </div>

                <ul class="space-y-3 mb-6">
                    <li class="flex items-center gap-2 text-[hsl(var(--foreground))]">
                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                       Sitio web básico o personalizado
                    </li>
                    <li class="flex items-center gap-2 text-[hsl(var(--foreground))]">
                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Publicación ilimitada de autos
                    </li>
                    <li class="flex items-center gap-2 text-[hsl(var(--foreground))]">
                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                       Soporte 24/7 por whatsapp
                    </li>
                    <li class="flex items-center gap-2 text-[hsl(var(--foreground))]">
                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        CRM para gestionar clientes
                    </li>
                    <li class="flex items-center gap-2 text-[hsl(var(--foreground))]">
                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Analítica avanzada para optimizar tu negocio
                    </li>
                    <li class="flex items-center gap-2 text-[hsl(var(--foreground))]">
                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Certificado SSL incluido
                    </li>
                    <li class="flex items-center gap-2 text-[hsl(var(--foreground))]">
                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Gestión de marketing completa incluido
                    </li>
                </ul>

                <div class="mt-auto">
                    <form action="{{ route('subscriptions.checkout') }}" method="POST">
                        @csrf
                        <input type="hidden" name="plan" value="premium">
                        <button type="submit" class="w-full py-2 bg-[#009ee3] hover:opacity-90 text-white rounded-lg font-semibold transition border-2 border-[#009ee3] shadow-lg">
                            Pagar con Mercado Pago
                        </button>
                    </form>
                </div>
            </div>


            <!-- Premium + Plan -->
            <div class="bg-[hsl(var(--card))] border-2 border-[hsl(var(--border))] rounded-lg p-6 flex flex-col h-full">
                <div class="mb-6">
                    <h3 class="text-xl font-bold text-[hsl(var(--foreground))] mb-2">Plan Premium +</h3>
                    <p class="text-3xl font-bold text-[hsl(var(--primary))] mb-1">$500.000</p>
                    <p class="text-sm text-[hsl(var(--muted-foreground))]">Por mes</p>
                </div>

                <ul class="space-y-3 mb-6">
                    <li class="flex items-center gap-2 text-[hsl(var(--foreground))]">
                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                       Sitio web básico o personalizado
                    </li>
                    <li class="flex items-center gap-2 text-[hsl(var(--foreground))]">
                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Publicación ilimitada de autos
                    </li>
                    <li class="flex items-center gap-2 text-[hsl(var(--foreground))]">
                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                       Soporte 24/7 por whatsapp
                    </li>
                    <li class="flex items-center gap-2 text-[hsl(var(--foreground))]">
                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        CRM para gestionar clientes
                    </li>
                    <li class="flex items-center gap-2 text-[hsl(var(--foreground))]">
                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Analítica avanzada para optimizar tu negocio
                    </li>
                    <li class="flex items-center gap-2 text-[hsl(var(--foreground))]">
                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Certificado SSL incluido
                    </li>
                    <li class="flex items-center gap-2 text-[hsl(var(--foreground))]">
                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Gestión de marketing completa incluido
                    </li>
                    <li class="flex items-center gap-2 text-[hsl(var(--foreground))]">
                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Manejo de Redes Sociales completa incluido
                    </li>
                </ul>

                <div class="mt-auto">
                    <form action="{{ route('subscriptions.checkout') }}" method="POST">
                        @csrf
                        <input type="hidden" name="plan" value="premium_plus">
                        <button type="submit" class="w-full py-2 bg-[#009ee3] hover:opacity-90 text-white rounded-lg font-semibold transition border-2 border-[#009ee3] shadow-lg">
                            Pagar con Mercado Pago
                        </button>
                    </form>
                </div>
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
                    <p class="text-[hsl(var(--muted-foreground))] text-sm">No tenemos períodos de prueba.</p>
                </div>
                <div>
                    <h4 class="font-semibold text-[hsl(var(--foreground))] mb-2">¿Qué métodos de pago aceptan?</h4>
                    <p class="text-[hsl(var(--muted-foreground))] text-sm">Realizamos los cobros a través de MercadoPago (tarjetas, transferencias, débito, efectivo).</p>
                </div>
                <div>
                    <h4 class="font-semibold text-[hsl(var(--foreground))] mb-2">¿Hay contrato a largo plazo?</h4>
                    <p class="text-[hsl(var(--muted-foreground))] text-sm">Sí, debes cumplir un mínimo de 1 año para poder cancelar, ya que es lo que dura el contrato del dominio.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
