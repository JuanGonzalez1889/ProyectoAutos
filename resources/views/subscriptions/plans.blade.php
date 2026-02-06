@extends('layouts.admin')

@section('title', 'Planes de Suscripción')
@section('page-title', 'Planes de Suscripción')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <!-- Header -->
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-white mb-4">Elige el plan perfecto para tu agencia</h1>
        <p class="text-[hsl(var(--muted-foreground))] text-lg">Comienza con 30 días de prueba gratuita. Sin tarjeta de crédito requerida.</p>
    </div>

    @if($tenant && $tenant->isOnTrial())
    <div class="bg-blue-500/10 border border-blue-500/20 rounded-lg p-4 mb-6">
        <div class="flex items-start gap-3">
            <svg class="w-5 h-5 text-blue-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <p class="text-sm font-semibold text-blue-400">Período de Prueba Activo</p>
                <p class="text-sm text-[hsl(var(--muted-foreground))] mt-1">
                    Te quedan <strong class="text-blue-400">{{ $tenant->trialDaysRemaining() }} días</strong> de prueba gratuita. 
                    Elige un plan ahora para continuar sin interrupciones.
                </p>
            </div>
        </div>
    </div>
    @endif

    @if($currentSubscription && $currentSubscription->isActive())
    <div class="bg-emerald-500/10 border border-emerald-500/20 rounded-lg p-4 mb-6">
        <div class="flex items-start gap-3">
            <svg class="w-5 h-5 text-emerald-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div class="flex-1">
                <p class="text-sm font-semibold text-emerald-400">Suscripción Activa</p>
                <p class="text-sm text-[hsl(var(--muted-foreground))] mt-1">
                    Plan actual: <strong class="text-emerald-400">{{ ucfirst($currentSubscription->plan) }}</strong> 
                    • Próxima renovación: {{ $currentSubscription->current_period_end->format('d/m/Y') }}
                </p>
            </div>
            <a href="{{ route('subscriptions.billing') }}" class="text-sm text-blue-400 hover:text-blue-300">
                Ver facturación →
            </a>
        </div>
    </div>
    @endif

    <!-- Pricing Cards -->
    <div class="grid md:grid-cols-3 gap-6 mb-12">
        <!-- Plan Básico -->
        <div class="card group hover:border-blue-500/50 transition-all duration-300">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-white">Básico</h3>
                    @if($currentSubscription && $currentSubscription->plan === 'basic')
                        <span class="text-xs px-2 py-1 bg-blue-500/20 text-blue-400 rounded-full">Plan actual</span>
                    @endif
                </div>
                
                <div class="mb-6">
                    <div class="flex items-baseline gap-1">
                        <span class="text-4xl font-bold text-[hsl(var(--primary))]">$29</span>
                        <span class="text-[hsl(var(--muted-foreground))]">/mes</span>
                    </div>
                    <p class="text-xs text-[hsl(var(--muted-foreground))] mt-1">ARS $29,000/mes</p>
                </div>

                <ul class="space-y-3 mb-6">
                    <li class="flex items-start gap-2 text-sm">
                        <svg class="w-5 h-5 text-emerald-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-[hsl(var(--muted-foreground))]"><strong class="text-white">10 vehículos</strong> en catálogo</span>
                    </li>
                    <li class="flex items-start gap-2 text-sm">
                        <svg class="w-5 h-5 text-emerald-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-[hsl(var(--muted-foreground))]">1 plantilla básica</span>
                    </li>
                    <li class="flex items-start gap-2 text-sm">
                        <svg class="w-5 h-5 text-emerald-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-[hsl(var(--muted-foreground))]">Soporte por email</span>
                    </li>
                    <li class="flex items-start gap-2 text-sm">
                        <svg class="w-5 h-5 text-emerald-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-[hsl(var(--muted-foreground))]">Gestión de leads</span>
                    </li>
                </ul>

                <form action="{{ route('subscriptions.checkout') }}" method="POST" class="space-y-3">
                    @csrf
                    <input type="hidden" name="plan" value="basic">
                    
                    <button type="submit" name="payment_method" value="stripe" 
                            class="w-full h-10 px-4 bg-[hsl(var(--primary))] hover:opacity-90 text-[#0a0f14] rounded-lg text-sm font-medium transition-opacity flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M13.976 9.15c-2.172-.806-3.356-1.426-3.356-2.409 0-.831.683-1.305 1.901-1.305 2.227 0 4.515.858 6.09 1.631l.89-5.494C18.252.975 15.697 0 12.165 0 9.667 0 7.589.654 6.104 1.872 4.56 3.147 3.757 4.992 3.757 7.218c0 4.039 2.467 5.76 6.476 7.219 2.585.92 3.445 1.574 3.445 2.583 0 .98-.84 1.545-2.354 1.545-1.875 0-4.965-.921-6.99-2.109l-.9 5.555C5.175 22.99 8.385 24 11.714 24c2.641 0 4.843-.624 6.328-1.813 1.664-1.305 2.525-3.236 2.525-5.732 0-4.128-2.524-5.851-6.594-7.305h.003z"/>
                        </svg>
                        Pagar con Stripe
                    </button>
                    
                    <button type="submit" name="payment_method" value="mercadopago"
                            class="w-full h-10 px-4 bg-blue-500 hover:bg-blue-600 text-white rounded-lg text-sm font-medium transition-colors flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M21.457 0H2.543C1.14 0 0 1.14 0 2.543v18.914C0 22.86 1.14 24 2.543 24h18.914c1.403 0 2.543-1.14 2.543-2.543V2.543C24 1.14 22.86 0 21.457 0z"/>
                        </svg>
                        Pagar con MercadoPago
                    </button>
                </form>
            </div>
        </div>

        <!-- Plan Premium (Destacado) -->
        <div class="card group hover:border-blue-500/50 transition-all duration-300 relative border-blue-500/30 shadow-lg shadow-blue-500/10">
            <div class="absolute -top-3 left-1/2 -translate-x-1/2">
                <span class="bg-gradient-to-r from-blue-500 to-blue-600 text-white text-xs font-bold px-4 py-1 rounded-full">
                    ⭐ Más Popular
                </span>
            </div>
            
            <div class="p-6 pt-8">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-white">Premium</h3>
                    @if($currentSubscription && $currentSubscription->plan === 'premium')
                        <span class="text-xs px-2 py-1 bg-blue-500/20 text-blue-400 rounded-full">Plan actual</span>
                    @endif
                </div>
                
                <div class="mb-6">
                    <div class="flex items-baseline gap-1">
                        <span class="text-4xl font-bold text-[hsl(var(--primary))]">$79</span>
                        <span class="text-[hsl(var(--muted-foreground))]">/mes</span>
                    </div>
                    <p class="text-xs text-[hsl(var(--muted-foreground))] mt-1">ARS $79,000/mes</p>
                </div>

                <ul class="space-y-3 mb-6">
                    <li class="flex items-start gap-2 text-sm">
                        <svg class="w-5 h-5 text-emerald-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-[hsl(var(--muted-foreground))]"><strong class="text-white">50 vehículos</strong> en catálogo</span>
                    </li>
                    <li class="flex items-start gap-2 text-sm">
                        <svg class="w-5 h-5 text-emerald-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-[hsl(var(--muted-foreground))]"><strong class="text-white">4 plantillas</strong> premium</span>
                    </li>
                    <li class="flex items-start gap-2 text-sm">
                        <svg class="w-5 h-5 text-emerald-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-[hsl(var(--muted-foreground))]">Soporte prioritario</span>
                    </li>
                    <li class="flex items-start gap-2 text-sm">
                        <svg class="w-5 h-5 text-emerald-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-[hsl(var(--muted-foreground))]">Analytics avanzado</span>
                    </li>
                    <li class="flex items-start gap-2 text-sm">
                        <svg class="w-5 h-5 text-emerald-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-[hsl(var(--muted-foreground))]">SEO optimizado</span>
                    </li>
                </ul>

                <form action="{{ route('subscriptions.checkout') }}" method="POST" class="space-y-3">
                    @csrf
                    <input type="hidden" name="plan" value="premium">
                    
                    <button type="submit" name="payment_method" value="stripe"
                            class="w-full h-10 px-4 bg-[hsl(var(--primary))] hover:opacity-90 text-[#0a0f14] rounded-lg text-sm font-medium transition-opacity flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M13.976 9.15c-2.172-.806-3.356-1.426-3.356-2.409 0-.831.683-1.305 1.901-1.305 2.227 0 4.515.858 6.09 1.631l.89-5.494C18.252.975 15.697 0 12.165 0 9.667 0 7.589.654 6.104 1.872 4.56 3.147 3.757 4.992 3.757 7.218c0 4.039 2.467 5.76 6.476 7.219 2.585.92 3.445 1.574 3.445 2.583 0 .98-.84 1.545-2.354 1.545-1.875 0-4.965-.921-6.99-2.109l-.9 5.555C5.175 22.99 8.385 24 11.714 24c2.641 0 4.843-.624 6.328-1.813 1.664-1.305 2.525-3.236 2.525-5.732 0-4.128-2.524-5.851-6.594-7.305h.003z"/>
                        </svg>
                        Pagar con Stripe
                    </button>
                    
                    <button type="submit" name="payment_method" value="mercadopago"
                            class="w-full h-10 px-4 bg-blue-500 hover:bg-blue-600 text-white rounded-lg text-sm font-medium transition-colors flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M21.457 0H2.543C1.14 0 0 1.14 0 2.543v18.914C0 22.86 1.14 24 2.543 24h18.914c1.403 0 2.543-1.14 2.543-2.543V2.543C24 1.14 22.86 0 21.457 0z"/>
                        </svg>
                        Pagar con MercadoPago
                    </button>
                </form>
            </div>
        </div>

        <!-- Plan Enterprise -->
        <div class="card group hover:border-blue-500/50 transition-all duration-300">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-white">Enterprise</h3>
                    @if($currentSubscription && $currentSubscription->plan === 'enterprise')
                        <span class="text-xs px-2 py-1 bg-blue-500/20 text-blue-400 rounded-full">Plan actual</span>
                    @endif
                </div>
                
                <div class="mb-6">
                    <div class="flex items-baseline gap-1">
                        <span class="text-4xl font-bold text-[hsl(var(--primary))]">$199</span>
                        <span class="text-[hsl(var(--muted-foreground))]">/mes</span>
                    </div>
                    <p class="text-xs text-[hsl(var(--muted-foreground))] mt-1">ARS $199,000/mes</p>
                </div>

                <ul class="space-y-3 mb-6">
                    <li class="flex items-start gap-2 text-sm">
                        <svg class="w-5 h-5 text-emerald-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-[hsl(var(--muted-foreground))]"><strong class="text-white">Vehículos ilimitados</strong></span>
                    </li>
                    <li class="flex items-start gap-2 text-sm">
                        <svg class="w-5 h-5 text-emerald-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-[hsl(var(--muted-foreground))]">Plantillas <strong class="text-white">personalizadas</strong></span>
                    </li>
                    <li class="flex items-start gap-2 text-sm">
                        <svg class="w-5 h-5 text-emerald-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-[hsl(var(--muted-foreground))]">Soporte <strong class="text-white">24/7</strong></span>
                    </li>
                    <li class="flex items-start gap-2 text-sm">
                        <svg class="w-5 h-5 text-emerald-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-[hsl(var(--muted-foreground))]">Acceso a <strong class="text-white">API REST</strong></span>
                    </li>
                    <li class="flex items-start gap-2 text-sm">
                        <svg class="w-5 h-5 text-emerald-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-[hsl(var(--muted-foreground))]">Multipublicador</span>
                    </li>
                </ul>

                <form action="{{ route('subscriptions.checkout') }}" method="POST" class="space-y-3">
                    @csrf
                    <input type="hidden" name="plan" value="enterprise">
                    
                    <button type="submit" name="payment_method" value="stripe"
                            class="w-full h-10 px-4 bg-[hsl(var(--primary))] hover:opacity-90 text-[#0a0f14] rounded-lg text-sm font-medium transition-opacity flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M13.976 9.15c-2.172-.806-3.356-1.426-3.356-2.409 0-.831.683-1.305 1.901-1.305 2.227 0 4.515.858 6.09 1.631l.89-5.494C18.252.975 15.697 0 12.165 0 9.667 0 7.589.654 6.104 1.872 4.56 3.147 3.757 4.992 3.757 7.218c0 4.039 2.467 5.76 6.476 7.219 2.585.92 3.445 1.574 3.445 2.583 0 .98-.84 1.545-2.354 1.545-1.875 0-4.965-.921-6.99-2.109l-.9 5.555C5.175 22.99 8.385 24 11.714 24c2.641 0 4.843-.624 6.328-1.813 1.664-1.305 2.525-3.236 2.525-5.732 0-4.128-2.524-5.851-6.594-7.305h.003z"/>
                        </svg>
                        Pagar con Stripe
                    </button>
                    
                    <button type="submit" name="payment_method" value="mercadopago"
                            class="w-full h-10 px-4 bg-blue-500 hover:bg-blue-600 text-white rounded-lg text-sm font-medium transition-colors flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M21.457 0H2.543C1.14 0 0 1.14 0 2.543v18.914C0 22.86 1.14 24 2.543 24h18.914c1.403 0 2.543-1.14 2.543-2.543V2.543C24 1.14 22.86 0 21.457 0z"/>
                        </svg>
                        Pagar con MercadoPago
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="card max-w-3xl mx-auto">
        <div class="p-6">
            <h3 class="text-xl font-bold text-white mb-6">Preguntas Frecuentes</h3>
            
            <div class="space-y-4">
                <details class="group">
                    <summary class="flex items-center justify-between cursor-pointer text-[hsl(var(--foreground))] font-medium">
                        ¿Puedo cambiar de plan en cualquier momento?
                        <svg class="w-5 h-5 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </summary>
                    <p class="mt-2 text-sm text-[hsl(var(--muted-foreground))]">
                        Sí, puedes actualizar o cambiar tu plan en cualquier momento. Los cambios se aplican inmediatamente y se ajustará el prorrateo del pago.
                    </p>
                </details>

                <details class="group">
                    <summary class="flex items-center justify-between cursor-pointer text-[hsl(var(--foreground))] font-medium">
                        ¿Qué métodos de pago aceptan?
                        <svg class="w-5 h-5 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </summary>
                    <p class="mt-2 text-sm text-[hsl(var(--muted-foreground))]">
                        Aceptamos tarjetas de crédito/débito a través de Stripe (internacional) y MercadoPago (Argentina, Brasil, México, etc.).
                    </p>
                </details>

                <details class="group">
                    <summary class="flex items-center justify-between cursor-pointer text-[hsl(var(--foreground))] font-medium">
                        ¿Puedo cancelar mi suscripción?
                        <svg class="w-5 h-5 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </summary>
                    <p class="mt-2 text-sm text-[hsl(var(--muted-foreground))]">
                        Por supuesto. Puedes cancelar tu suscripción en cualquier momento desde tu panel de facturación. No hay penalizaciones.
                    </p>
                </details>

                <details class="group">
                    <summary class="flex items-center justify-between cursor-pointer text-[hsl(var(--foreground))] font-medium">
                        ¿Ofrecen descuentos por pago anual?
                        <svg class="w-5 h-5 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </summary>
                    <p class="mt-2 text-sm text-[hsl(var(--muted-foreground))]">
                        Actualmente solo ofrecemos planes mensuales. Los planes anuales con descuento estarán disponibles próximamente.
                    </p>
                </details>
            </div>
        </div>
    </div>
</div>
@endsection
