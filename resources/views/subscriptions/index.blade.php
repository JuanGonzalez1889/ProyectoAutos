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
            $subscription = null;
            $currentPlanName = 'SIN PLAN CONTRATADO';
            $currentPlan = ['plan' => ''];
            $allSubscriptions = collect();
            $allInvoices = collect();
            if(in_array(auth()->user()->email, ['superadmin@autos.com', 'admin@autowebpro.com.ar'])) {
                // Superadmin: ver todas las suscripciones y facturas
                $allSubscriptions = App\Models\Subscription::with('tenant')->orderByDesc('created_at')->get();
                $allInvoices = App\Models\Invoice::with(['tenant', 'subscription'])->orderByDesc('created_at')->get();
            } else {
                // Usar suscripción activa (tenant_id correcto)
                $subs = App\Models\Subscription::where('tenant_id', auth()->user()->tenant_id)
                    ->where('status', 'active')
                    ->orderByDesc('created_at')
                    ->first();
                if($subs) {
                    $planes = App\Models\Plan::all();
                    $plan = $planes->first(function($p) use ($subs) {
                        return $p->slug === $subs->plan || $p->id == $subs->plan || $p->nombre === $subs->plan;
                    });
                    $currentPlanName = $plan ? $plan->nombre : $subs->plan;
                    $currentPlan = ['plan' => $plan ? $plan->slug : $subs->plan];
                }
            }
        @endphp
        @if(in_array(auth()->user()->email, ['superadmin@autos.com', 'admin@autowebpro.com.ar']))
        <div class="mb-12">
            <h2 class="text-2xl font-bold mb-4">Todas las Suscripciones</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white text-gray-900 rounded shadow text-xs">
                    <thead>
                        <tr>
                            <th class="px-2 py-1">ID</th>
                            <th class="px-2 py-1">Tenant</th>
                            <th class="px-2 py-1">Plan</th>
                            <th class="px-2 py-1">Estado</th>
                            <th class="px-2 py-1">Renovación activada</th>
                            <th class="px-2 py-1">Inicio</th>
                            <th class="px-2 py-1">Fin</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($allSubscriptions as $sub)
                        @php
                            $hasPreapprovalId = !empty($sub->mercadopago_id) && !is_numeric((string) $sub->mercadopago_id);
                            $autoRenewEnabled = $sub->payment_method === 'mercadopago'
                                && $hasPreapprovalId
                                && $sub->status === 'active'
                                && (string) $sub->mercadopago_status === 'authorized';
                        @endphp
                        <tr>
                            <td class="border px-2 py-1">{{ $sub->id }}</td>
                            <td class="border px-2 py-1">{{ $sub->tenant->name ?? '-' }}</td>
                            <td class="border px-2 py-1">{{ $sub->plan }}</td>
                            <td class="border px-2 py-1">{{ $sub->status }}</td>
                            <td class="border px-2 py-1 font-semibold {{ $autoRenewEnabled ? 'text-emerald-600' : 'text-red-600' }}">
                                {{ $autoRenewEnabled ? 'SI' : 'NO' }}
                            </td>
                            <td class="border px-2 py-1">{{ $sub->current_period_start ? $sub->current_period_start->format('Y-m-d') : '-' }}</td>
                            <td class="border px-2 py-1">{{ $sub->current_period_end ? $sub->current_period_end->format('Y-m-d') : '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mb-12">
            <h2 class="text-2xl font-bold mb-4">Todas las Facturas</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white text-gray-900 rounded shadow text-xs">
                    <thead>
                        <tr>
                            <th class="px-2 py-1">ID</th>
                            <th class="px-2 py-1">Tenant</th>
                            <th class="px-2 py-1">Suscripción</th>
                            <th class="px-2 py-1">Total</th>
                            <th class="px-2 py-1">Estado</th>
                            <th class="px-2 py-1">Pagada</th>
                            <th class="px-2 py-1">Vencimiento</th>
                            <th class="px-2 py-1">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($allInvoices as $inv)
                        <tr>
                            <td class="border px-2 py-1">{{ $inv->id }}</td>
                            <td class="border px-2 py-1">{{ $inv->tenant->name ?? '-' }}</td>
                            <td class="border px-2 py-1">{{ $inv->subscription_id }}</td>
                            <td class="border px-2 py-1">${{ number_format($inv->total, 2) }}</td>
                            <td class="border px-2 py-1">{{ $inv->status }}</td>
                            <td class="border px-2 py-1">{{ $inv->paid_at ? $inv->paid_at->format('Y-m-d') : '-' }}</td>
                            <td class="border px-2 py-1">{{ $inv->due_date ? $inv->due_date->format('Y-m-d') : '-' }}</td>
                            <td class="border px-2 py-1 text-center">
                                <a href="{{ route('invoices.download', $inv->id) }}" class="text-xs text-blue-600 hover:underline" target="_blank">PDF</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
        {{-- Mostrar bloque de Plan Actual con botón Gestionar Suscripción --}}
        @if(!in_array(auth()->user()->email, ['superadmin@autos.com', 'admin@autowebpro.com.ar']))
            <div class="mb-10">
                <div class="flex flex-col md:flex-row items-center justify-between bg-[#181f2a] border border-[#2c374a] rounded-xl px-8 py-6 mb-6">
                    <div>
                        <div class="text-lg text-white font-semibold mb-1">Plan Actual</div>
                        <div class="text-3xl font-extrabold text-[#3fffc2]">{{ $currentPlanName }}</div>
                    </div>
                    <a href="{{ route('subscriptions.billing') }}" class="mt-4 md:mt-0 px-8 py-3 bg-[#3fffc2] hover:bg-[#2be6a7] text-[#23272f] font-semibold rounded-lg text-lg transition">Gestionar Suscripción</a>
                </div>
            </div>
        @endif
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
                    @if(($currentPlan['plan'] ?? null) === 'basico')
                        <button disabled class="w-full py-2 bg-gray-400 text-white rounded-lg font-semibold cursor-not-allowed">
                            PLAN ACTUAL
                        </button>
                    @else
                        <form action="{{ route('subscriptions.checkout') }}" method="POST">
                            @csrf
                            <input type="hidden" name="plan" value="basico">
                            <button type="submit" class="w-full py-2 bg-[#009ee3] hover:opacity-90 text-white rounded-lg font-semibold transition border-2 border-[#009ee3] shadow-lg">
                                Pagar con Mercado Pago
                            </button>
                        </form>
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
                    @if(($currentPlan['plan'] ?? null) === 'profesional')
                        <button disabled class="w-full py-2 bg-gray-400 text-white rounded-lg font-semibold cursor-not-allowed">
                            PLAN ACTUAL
                        </button>
                    @else
                        <form action="{{ route('subscriptions.checkout') }}" method="POST">
                            @csrf
                            <input type="hidden" name="plan" value="profesional">
                            <button type="submit" class="w-full py-2 bg-[#009ee3] hover:opacity-90 text-white rounded-lg font-semibold transition border-2 border-[#009ee3] shadow-lg">
                                Pagar con Mercado Pago
                            </button>
                        </form>
                    @endif
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
                    @if(($currentPlan['plan'] ?? null) === 'premium')
                        <button disabled class="w-full py-2 bg-gray-400 text-white rounded-lg font-semibold cursor-not-allowed">
                            PLAN ACTUAL
                        </button>
                    @else
                        <form action="{{ route('subscriptions.checkout') }}" method="POST">
                            @csrf
                            <input type="hidden" name="plan" value="premium">
                            <button type="submit" class="w-full py-2 bg-[#009ee3] hover:opacity-90 text-white rounded-lg font-semibold transition border-2 border-[#009ee3] shadow-lg">
                                Pagar con Mercado Pago
                            </button>
                        </form>
                    @endif
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
                    @if(($currentPlan['plan'] ?? null) === 'premium_plus')
                        <button disabled class="w-full py-2 bg-gray-400 text-white rounded-lg font-semibold cursor-not-allowed">
                            PLAN ACTUAL
                        </button>
                    @else
                        <form action="{{ route('subscriptions.checkout') }}" method="POST">
                            @csrf
                            <input type="hidden" name="plan" value="premium_plus">
                            <button type="submit" class="w-full py-2 bg-[#009ee3] hover:opacity-90 text-white rounded-lg font-semibold transition border-2 border-[#009ee3] shadow-lg">
                                Pagar con Mercado Pago
                            </button>
                        </form>
                    @endif
                </div>
            </div>

                     
        </div>

        <!-- Plan Test $100 -->
        <div class="flex justify-center mb-12">
            <form action="{{ route('subscriptions.checkout') }}" method="POST" class="inline-block">
                @csrf
                <input type="hidden" name="plan" value="test100">
                <button type="submit" class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg font-bold text-lg shadow">
                    Plan de $100 (prueba MercadoPago)
                </button>
            </form>
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
