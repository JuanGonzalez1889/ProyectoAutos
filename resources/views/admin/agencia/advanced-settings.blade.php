@extends('layouts.admin')

@section('title', 'Configuración Avanzada de Agencia')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[hsl(var(--background))] to-[hsl(var(--secondary))]">
    <div class="max-w-6xl mx-auto px-4 py-12">
        <!-- Header -->
        <div class="mb-12">
            <h1 class="text-4xl font-bold text-[hsl(var(--foreground))] mb-2">Configuración Avanzada</h1>
            <p class="text-[hsl(var(--muted-foreground))]">Gestiona los detalles operacionales y contables de tu agencia</p>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-900/50 rounded-lg p-4 mb-6">
                <h3 class="text-red-800 dark:text-red-400 font-semibold mb-2">Errores:</h3>
                <ul class="text-red-700 dark:text-red-400 text-sm space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Success Message -->
        @if (session('success'))
            <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-900/50 rounded-lg p-4 mb-6">
                <p class="text-green-800 dark:text-green-400">✓ {{ session('success') }}</p>
            </div>
        @endif

        <form action="{{ route('admin.agencia.advanced-settings.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PATCH')

            <!-- 1. Horarios de Atención -->
            <div class="bg-[hsl(var(--card))] border border-[hsl(var(--border))] rounded-lg p-6">
                <h2 class="text-2xl font-bold text-[hsl(var(--foreground))] mb-4 flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Horarios de Atención
                </h2>

                <div class="grid md:grid-cols-2 gap-6">
                    @php
                        $days = ['lunes' => 'Lunes', 'martes' => 'Martes', 'miercoles' => 'Miércoles', 'jueves' => 'Jueves', 'viernes' => 'Viernes', 'sabado' => 'Sábado', 'domingo' => 'Domingo'];
                        $businessHours = $tenant->business_hours ?? [];
                    @endphp

                    @foreach ($days as $dayKey => $dayName)
                        <div>
                            <label class="block text-sm font-medium text-[hsl(var(--foreground))] mb-2">{{ $dayName }}</label>
                            <div class="flex gap-2 items-center">
                                <input type="time" 
                                    name="business_hours[{{ $dayKey }}][open]" 
                                    value="{{ $businessHours[$dayKey]['open'] ?? '09:00' }}"
                                    class="flex-1 px-3 py-2 bg-[hsl(var(--secondary))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))]"
                                    placeholder="Apertura">
                                <span class="text-[hsl(var(--muted-foreground))]">—</span>
                                <input type="time" 
                                    name="business_hours[{{ $dayKey }}][close]" 
                                    value="{{ $businessHours[$dayKey]['close'] ?? '18:00' }}"
                                    class="flex-1 px-3 py-2 bg-[hsl(var(--secondary))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))]"
                                    placeholder="Cierre">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" 
                                        name="business_hours[{{ $dayKey }}][closed]"
                                        {{ ($businessHours[$dayKey]['closed'] ?? false) ? 'checked' : '' }}
                                        class="rounded">
                                    <span class="text-sm text-[hsl(var(--muted-foreground))]">Cerrado</span>
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- 2. Redes Sociales -->
            <div class="bg-[hsl(var(--card))] border border-[hsl(var(--border))] rounded-lg p-6">
                <h2 class="text-2xl font-bold text-[hsl(var(--foreground))] mb-4 flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.658 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                    </svg>
                    Redes Sociales
                </h2>

                @php
                    $socialMedia = $tenant->social_media ?? [];
                    $networks = ['facebook' => 'Facebook', 'instagram' => 'Instagram', 'linkedin' => 'LinkedIn', 'twitter' => 'Twitter', 'whatsapp' => 'WhatsApp'];
                @endphp

                <div class="grid md:grid-cols-2 gap-4">
                    @foreach ($networks as $networkKey => $networkName)
                        <div>
                            <label class="block text-sm font-medium text-[hsl(var(--foreground))] mb-2">{{ $networkName }}</label>
                            <input type="url" 
                                name="social_media[{{ $networkKey }}]" 
                                value="{{ $socialMedia[$networkKey] ?? '' }}"
                                placeholder="https://{{ strtolower($networkName) }}.com/..."
                                class="w-full px-3 py-2 bg-[hsl(var(--secondary))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))] focus:outline-none focus:border-[hsl(var(--primary))]">
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- 3. Métodos de Pago & Contacto -->
            <div class="bg-[hsl(var(--card))] border border-[hsl(var(--border))] rounded-lg p-6">
                <h2 class="text-2xl font-bold text-[hsl(var(--foreground))] mb-4 flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h10m4 0a1 1 0 11-2 0 1 1 0 012 0z"/>
                    </svg>
                    Métodos de Pago
                </h2>

                @php
                    $paymentMethods = $tenant->payment_methods ?? [];
                    $methods = ['credit_card' => 'Tarjeta de Crédito', 'debit_card' => 'Tarjeta de Débito', 'bank_transfer' => 'Transferencia Bancaria', 'cash' => 'Efectivo', 'checks' => 'Cheques'];
                @endphp

                <div class="space-y-3">
                    @foreach ($methods as $methodKey => $methodName)
                        <label class="flex items-center gap-3 p-3 border border-[hsl(var(--border))] rounded-lg cursor-pointer hover:bg-[hsl(var(--secondary))] transition">
                            <input type="checkbox" 
                                name="payment_methods[{{ $methodKey }}]"
                                value="1"
                                {{ ($paymentMethods[$methodKey] ?? false) ? 'checked' : '' }}
                                class="w-4 h-4 rounded text-[hsl(var(--primary))]">
                            <span class="text-[hsl(var(--foreground))]">{{ $methodName }}</span>
                        </label>
                    @endforeach
                </div>

                <!-- Contacto -->
                <div class="mt-6 pt-6 border-t border-[hsl(var(--border))]">
                    <h3 class="text-lg font-semibold text-[hsl(var(--foreground))] mb-4">Información de Contacto</h3>
                    
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-[hsl(var(--foreground))] mb-2">Teléfono</label>
                            <input type="tel" 
                                name="phone" 
                                value="{{ $tenant->phone ?? '' }}"
                                class="w-full px-3 py-2 bg-[hsl(var(--secondary))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))]">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-[hsl(var(--foreground))] mb-2">WhatsApp</label>
                            <input type="tel" 
                                name="whatsapp" 
                                value="{{ $tenant->whatsapp ?? '' }}"
                                placeholder="+1234567890"
                                class="w-full px-3 py-2 bg-[hsl(var(--secondary))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))]">
                        </div>
                    </div>
                </div>
            </div>

            <!-- 4. Comisiones -->
            <div class="bg-[hsl(var(--card))] border border-[hsl(var(--border))] rounded-lg p-6">
                <h2 class="text-2xl font-bold text-[hsl(var(--foreground))] mb-4 flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Comisiones
                </h2>

                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-[hsl(var(--foreground))] mb-2">Porcentaje de Comisión (%)</label>
                        <input type="number" 
                            name="commission_percentage" 
                            value="{{ $tenant->commission_percentage ?? 0 }}"
                            min="0" 
                            max="100" 
                            step="0.01"
                            class="w-full px-3 py-2 bg-[hsl(var(--secondary))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-[hsl(var(--foreground))] mb-2">Moneda</label>
                        <select name="commission_currency" class="w-full px-3 py-2 bg-[hsl(var(--secondary))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))]">
                            <option value="USD" {{ $tenant->commission_currency === 'USD' ? 'selected' : '' }}>USD</option>
                            <option value="ARS" {{ $tenant->commission_currency === 'ARS' ? 'selected' : '' }}>ARS</option>
                            <option value="MXN" {{ $tenant->commission_currency === 'MXN' ? 'selected' : '' }}>MXN</option>
                            <option value="COP" {{ $tenant->commission_currency === 'COP' ? 'selected' : '' }}>COP</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- 5. Datos Contables -->
            <div class="bg-[hsl(var(--card))] border border-[hsl(var(--border))] rounded-lg p-6">
                <h2 class="text-2xl font-bold text-[hsl(var(--foreground))] mb-4 flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Datos Contables
                </h2>

                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-[hsl(var(--foreground))] mb-2">Tipo de Negocio</label>
                        <select name="business_type" class="w-full px-3 py-2 bg-[hsl(var(--secondary))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))]">
                            <option value="">Selecciona...</option>
                            <option value="sole_proprietor" {{ $tenant->business_type === 'sole_proprietor' ? 'selected' : '' }}>Persona Física</option>
                            <option value="llc" {{ $tenant->business_type === 'llc' ? 'selected' : '' }}>Sociedad de Responsabilidad Limitada</option>
                            <option value="corporation" {{ $tenant->business_type === 'corporation' ? 'selected' : '' }}>Sociedad Anónima</option>
                            <option value="partnership" {{ $tenant->business_type === 'partnership' ? 'selected' : '' }}>Asociación</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-[hsl(var(--foreground))] mb-2">RUT / CUIT / NIF</label>
                        <input type="text" 
                            name="tax_id" 
                            value="{{ $tenant->tax_id ?? '' }}"
                            placeholder="Número de identificación fiscal"
                            class="w-full px-3 py-2 bg-[hsl(var(--secondary))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-[hsl(var(--foreground))] mb-2">Número de Registro Comercial</label>
                        <input type="text" 
                            name="business_registration" 
                            value="{{ $tenant->business_registration ?? '' }}"
                            class="w-full px-3 py-2 bg-[hsl(var(--secondary))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-[hsl(var(--foreground))] mb-2">Dirección de Facturación</label>
                        <input type="text" 
                            name="billing_address" 
                            value="{{ $tenant->billing_address ?? '' }}"
                            class="w-full px-3 py-2 bg-[hsl(var(--secondary))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))]">
                    </div>
                </div>

                <div class="mt-4">
                    <label class="block text-sm font-medium text-[hsl(var(--foreground))] mb-2">Notas de Facturación</label>
                    <textarea name="billing_notes" 
                        rows="3"
                        class="w-full px-3 py-2 bg-[hsl(var(--secondary))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))]"
                        placeholder="Información adicional para facturas..."></textarea>
                </div>
            </div>

            <!-- 6. Banca -->
            <div class="bg-[hsl(var(--card))] border border-[hsl(var(--border))] rounded-lg p-6">
                <h2 class="text-2xl font-bold text-[hsl(var(--foreground))] mb-4 flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9"/>
                    </svg>
                    Información Bancaria
                </h2>

                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-[hsl(var(--foreground))] mb-2">Banco</label>
                        <input type="text" 
                            name="bank_name" 
                            value="{{ $tenant->bank_name ?? '' }}"
                            class="w-full px-3 py-2 bg-[hsl(var(--secondary))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-[hsl(var(--foreground))] mb-2">Titular de Cuenta</label>
                        <input type="text" 
                            name="bank_account_holder" 
                            value="{{ $tenant->bank_account_holder ?? '' }}"
                            class="w-full px-3 py-2 bg-[hsl(var(--secondary))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-[hsl(var(--foreground))] mb-2">Número de Cuenta</label>
                        <input type="text" 
                            name="bank_account" 
                            value="{{ $tenant->bank_account ?? '' }}"
                            class="w-full px-3 py-2 bg-[hsl(var(--secondary))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-[hsl(var(--foreground))] mb-2">Código de Enrutamiento</label>
                        <input type="text" 
                            name="bank_routing_number" 
                            value="{{ $tenant->bank_routing_number ?? '' }}"
                            class="w-full px-3 py-2 bg-[hsl(var(--secondary))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))]">
                    </div>
                </div>
            </div>

            <!-- 7. Preferencias Operacionales -->
            <div class="bg-[hsl(var(--card))] border border-[hsl(var(--border))] rounded-lg p-6">
                <h2 class="text-2xl font-bold text-[hsl(var(--foreground))] mb-4 flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    </svg>
                    Preferencias Operacionales
                </h2>

                <div class="space-y-4">
                    <label class="flex items-center gap-3 p-3 border border-[hsl(var(--border))] rounded-lg cursor-pointer hover:bg-[hsl(var(--secondary))] transition">
                        <input type="checkbox" 
                            name="auto_approve_leads"
                            value="1"
                            {{ $tenant->auto_approve_leads ? 'checked' : '' }}
                            class="w-4 h-4 rounded text-[hsl(var(--primary))]">
                        <div>
                            <span class="text-[hsl(var(--foreground))] font-medium">Aprobar Leads Automáticamente</span>
                            <p class="text-xs text-[hsl(var(--muted-foreground))]">Los nuevos leads se aprobarán sin revisión manual</p>
                        </div>
                    </label>

                    <div>
                        <label class="block text-sm font-medium text-[hsl(var(--foreground))] mb-2">Tiempo de Respuesta Esperado (horas)</label>
                        <input type="number" 
                            name="response_time_hours" 
                            value="{{ $tenant->response_time_hours ?? 24 }}"
                            min="1" 
                            max="168"
                            class="w-full px-3 py-2 bg-[hsl(var(--secondary))] border border-[hsl(var(--border))] rounded-lg text-[hsl(var(--foreground))]">
                        <p class="text-xs text-[hsl(var(--muted-foreground))] mt-1">Define cuántas horas tiene para responder a los clientes</p>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex gap-4">
                <button type="submit" class="px-8 py-3 bg-[hsl(var(--primary))] hover:opacity-90 text-white rounded-lg font-semibold transition">
                    Guardar Cambios
                </button>
                <a href="{{ route('admin.dashboard') }}" class="px-8 py-3 bg-[hsl(var(--secondary))] hover:opacity-90 text-[hsl(var(--foreground))] rounded-lg font-semibold transition border border-[hsl(var(--border))]">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
