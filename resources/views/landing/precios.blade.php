@extends('layouts.landing')

@section('title', 'Precios - AutoWeb Pro')

@section('content')
<!-- Navbar -->
<x-navbar />

<!-- Pricing Hero -->
<section class="pt-32 pb-16 px-4">
    <div class="max-w-7xl mx-auto text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
            Planes diseñados para tu concesionaria
        </h1>
        <p class="text-lg text-gray-400 mb-8 max-w-2xl mx-auto">
            Elige el plan perfecto para potenciar tus ventas y gestionar tu inventario sin complicaciones.
        </p>
        
        <!-- Toggle Monthly/Annual -->
        <div class="inline-flex items-center gap-3 bg-white/5 rounded-lg p-1">
            <button class="px-6 py-2 rounded-lg bg-white/10 font-semibold text-white transition-all">
                Mensual
            </button>
            <button class="px-6 py-2 rounded-lg font-semibold text-gray-400 hover:text-white transition-all">
                Anual <span class="text-xs ml-1 px-2 py-0.5 bg-blue-500/20 text-blue-400 rounded">-20%</span>
            </button>
        </div>
    </div>
</section>

<!-- Pricing Cards -->
<section class="pb-24 px-4">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
            <!-- Plan Básico -->
            <x-pricing-card 
                plan="Básico"
                price="49"
                period="mes"
                cta="Empezar ahora"
                ctaLink="{{ route('register') }}"
                :features="[
                    '10 autos máximo',
                    'Sitio web básico',
                    'Soporte por email',
                    'Sin integración CRM'
                ]"
            />
            
            <!-- Plan Profesional (Popular) -->
            <x-pricing-card 
                plan="Profesional"
                price="99"
                period="mes"
                cta="Empezar ahora"
                ctaLink="{{ route('register') }}"
                :popular="true"
                :features="[
                    'Autos ilimitados',
                    'Integración CRM completa',
                    'Herramientas SEO avanzadas',
                    'Soporte prioritario 24/7',
                    'Certificado SSL incluido'
                ]"
            />
            
            <!-- Plan Premium -->
            <x-pricing-card 
                plan="Premium"
                price="199"
                period="mes"
                cta="Contactar Ventas"
                ctaLink="#"
                :features="[
                    'Acceso completo a API',
                    'Gerente de cuenta dedicado',
                    'Soporte multi-ubicación',
                    'Analítica avanzada',
                    'Todo de Profesional'
                ]"
            />
        </div>
    </div>
</section>

<!-- Newsletter Section -->
<section class="py-16 px-4">
    <div class="max-w-4xl mx-auto">
        <div class="glass rounded-2xl p-12">
            <div class="text-center mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-white mb-3">
                    Suscríbete a nuestro boletín
                </h2>
                <p class="text-gray-400">
                    Recibe las últimas noticias del mercado automotriz, consejos de ventas y actualizaciones de la plataforma.
                </p>
            </div>
            
            <form class="flex flex-col sm:flex-row gap-3 max-w-md mx-auto">
                <input 
                    type="email" 
                    placeholder="tucorreo@empresa.com" 
                    class="flex-1 px-4 py-3 bg-white/5 border border-white/10 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 transition-all"
                    required
                >
                <button type="submit" class="px-6 py-3 btn-gradient rounded-lg font-semibold text-white hover:opacity-90 transition-all">
                    Suscribirse
                </button>
            </form>
            <p class="text-xs text-gray-500 text-center mt-4">
                No enviamos spam. Date de baja cuando quieras.
            </p>
        </div>
    </div>
</section>

<!-- Footer -->
<x-footer />
@endsection
