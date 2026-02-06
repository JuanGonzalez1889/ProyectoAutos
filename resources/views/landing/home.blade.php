@extends('layouts.landing')

@section('seo')
    <x-seo 
        title="AutoWeb Pro - Tu concesionaria online en minutos"
        description="Plataforma SaaS todo-en-uno para agencias de autos. Gestiona inventario, leads, sitio web personalizado y más. Prueba gratis 14 días."
        keywords="agencia de autos, gestión de inventario, CRM automotriz, sitio web para concesionaria, leads de vehículos"
        :image="asset('images/og-home.jpg')"
    />
@endsection

@section('content')
<!-- Navbar -->
<x-navbar />

<!-- Hero Section -->
<section class="relative min-h-screen flex items-center justify-center px-4 pt-20">
    <div class="max-w-7xl mx-auto w-full">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <!-- Left Column - Content -->
            <div class="text-center lg:text-left">
                <!-- Badge -->
                <div class="inline-flex items-center gap-2 px-4 py-2 glass rounded-full mb-6">
                    <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></span>
                    <span class="text-sm text-gray-300">Nueva versión 2.0 disponible</span>
                </div>
                
                <!-- Title -->
                <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold mb-6 leading-tight">
                    Tu concesionaria <span class="gradient-text">online</span> en minutos
                </h1>
                
                <!-- Subtitle -->
                <p class="text-lg md:text-xl text-gray-400 mb-8 leading-relaxed">
                    La plataforma todo-en-uno para gestionar tu inventario, conectar con clientes y vender más autos sin complicaciones técnicas ni código.
                </p>
                
                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                    <a href="{{ route('register') }}" class="px-8 py-4 btn-gradient rounded-lg font-semibold text-white hover:opacity-90 inline-flex items-center justify-center gap-2">
                        Comenzar prueba gratis
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </a>
                    <a href="#demo" class="px-8 py-4 glass rounded-lg font-semibold text-white hover-glow inline-flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Ver Demo
                    </a>
                </div>
            </div>
            
            <!-- Right Column - Mockup -->
            <div class="relative">
                <!-- Glow Effect -->
                <div class="absolute inset-0 bg-blue-500/20 blur-3xl rounded-full"></div>
                
                <!-- Dashboard Mockup -->
                <div class="relative glass rounded-2xl p-6 shadow-2xl">
                    <!-- Browser Chrome -->
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-3 h-3 rounded-full bg-red-500"></div>
                        <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                        <div class="w-3 h-3 rounded-full bg-green-500"></div>
                        <div class="flex-1 ml-4">
                            <div class="h-6 bg-white/5 rounded flex items-center px-3">
                                <svg class="w-3 h-3 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                <span class="text-xs text-gray-500">app.autowebpro.com/dashboard</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Sidebar -->
                    <div class="flex gap-4">
                        <div class="w-16 space-y-2">
                            <div class="w-12 h-12 bg-blue-500/20 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <div class="w-12 h-10 bg-white/5 rounded-lg"></div>
                            <div class="w-12 h-10 bg-white/5 rounded-lg"></div>
                            <div class="w-12 h-10 bg-white/5 rounded-lg"></div>
                            <div class="w-12 h-10 bg-white/5 rounded-lg"></div>
                        </div>
                        
                        <!-- Main Content -->
                        <div class="flex-1 space-y-4">
                            <!-- Header -->
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="h-6 w-32 bg-white/10 rounded mb-2"></div>
                                    <div class="h-4 w-48 bg-white/5 rounded"></div>
                                </div>
                                <div class="h-10 w-32 bg-blue-500/20 rounded-lg"></div>
                            </div>
                            
                            <!-- Stats Cards -->
                            <div class="grid grid-cols-3 gap-3">
                                <div class="bg-green-500/10 border border-green-500/20 rounded-lg p-3">
                                    <div class="h-3 w-16 bg-green-500/30 rounded mb-2"></div>
                                    <div class="h-6 w-12 bg-white/20 rounded"></div>
                                </div>
                                <div class="bg-purple-500/10 border border-purple-500/20 rounded-lg p-3">
                                    <div class="h-3 w-16 bg-purple-500/30 rounded mb-2"></div>
                                    <div class="h-6 w-12 bg-white/20 rounded"></div>
                                </div>
                                <div class="bg-yellow-500/10 border border-yellow-500/20 rounded-lg p-3">
                                    <div class="h-3 w-16 bg-yellow-500/30 rounded mb-2"></div>
                                    <div class="h-6 w-12 bg-white/20 rounded"></div>
                                </div>
                            </div>
                            
                            <!-- Table -->
                            <div class="bg-white/5 rounded-lg p-4">
                                <div class="h-4 w-32 bg-white/10 rounded mb-3"></div>
                                <div class="space-y-2">
                                    <div class="flex gap-3">
                                        <div class="w-12 h-12 bg-white/10 rounded"></div>
                                        <div class="flex-1 space-y-2">
                                            <div class="h-3 bg-white/10 rounded"></div>
                                            <div class="h-3 w-3/4 bg-white/5 rounded"></div>
                                        </div>
                                        <div class="h-6 w-16 bg-green-500/20 rounded"></div>
                                    </div>
                                    <div class="flex gap-3">
                                        <div class="w-12 h-12 bg-white/10 rounded"></div>
                                        <div class="flex-1 space-y-2">
                                            <div class="h-3 bg-white/10 rounded"></div>
                                            <div class="h-3 w-3/4 bg-white/5 rounded"></div>
                                        </div>
                                        <div class="h-6 w-16 bg-yellow-500/20 rounded"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Scroll Indicator (Hero) -->
<div class="bg-[#020617] px-6">
    <div class="max-w-7xl mx-auto flex flex-col items-center gap-3 py-8">
        <span class="text-xs uppercase tracking-[0.3em] text-slate-500">Scroll</span>
        <div class="relative w-8 h-14 rounded-full border border-slate-700/80 flex items-start justify-center">
            <div class="w-1.5 h-3 bg-blue-500 rounded-full mt-2 animate-bounce"></div>
        </div>
    </div>
</div>


<!-- How It Works Section -->
<section class="bg-[#020617] py-24 px-6 md:px-12 text-white">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-16">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-500/10 border border-blue-500/20 text-xs font-semibold uppercase tracking-wider text-blue-400 mb-4">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
                Proceso Optimizado
            </div>
            <h2 class="text-4xl md:text-5xl font-bold mb-4">
                Crea tu concesionaria
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-indigo-500">digital en minutos.</span>
            </h2>
            <p class="text-slate-400 max-w-3xl mx-auto text-lg">
                Desde el registro hasta la publicación, simplificamos cada paso con nuestra tecnología automatizada. Diseño premium y gestión de stock integrada en una plataforma unificada.
            </p>
        </div>

        <!-- Two Column Layout -->
        <div class="grid md:grid-cols-2 gap-16 items-start">
            <!-- Left: Steps -->
            <div class="space-y-8">
                <!-- Step 1 -->
                <div class="relative pl-10">
                    <!-- Timeline Line -->
                    <div class="absolute left-3 top-8 bottom-0 w-0.5 bg-gradient-to-b from-blue-500 to-transparent"></div>
                    
                    <!-- Number Circle -->
                    <div class="absolute left-0 top-0 w-6 h-6 rounded-full bg-blue-500 flex items-center justify-center shadow-[0_0_20px_rgba(59,130,246,0.6)]">
                        <span class="text-xs font-bold text-white">1</span>
                    </div>
                    
                    <div class="inline-block px-3 py-1 bg-blue-500/10 border border-blue-500/30 rounded-md text-xs font-bold text-blue-400 mb-2">
                        01 / REGISTRO
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Registro</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">
                        Creá tu cuenta en segundos con email y contraseña. Sin tarjetas de crédito, comenzás gratis.
                    </p>
                </div>

                <!-- Step 2 -->
                <div class="relative pl-10">
                    <!-- Timeline Line -->
                    <div class="absolute left-3 top-8 bottom-0 w-0.5 bg-gradient-to-b from-blue-500 to-transparent"></div>
                    
                    <!-- Number Circle -->
                    <div class="absolute left-0 top-0 w-6 h-6 rounded-full bg-blue-500 flex items-center justify-center shadow-[0_0_20px_rgba(59,130,246,0.6)]">
                        <span class="text-xs font-bold text-white">2</span>
                    </div>
                    
                    <div class="inline-block px-3 py-1 bg-blue-500/10 border border-blue-500/30 rounded-md text-xs font-bold text-blue-400 mb-2">
                        02 / DISEÑO
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Selección de Plantilla</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">
                        Elegí entre diseños profesionales optimizados para concesionarias. Todos responsive y rápidos.
                    </p>
                </div>

                <!-- Step 3 -->
                <div class="relative pl-10">
                    <!-- Timeline Line -->
                    <div class="absolute left-3 top-8 bottom-0 w-0.5 bg-gradient-to-b from-blue-500 to-transparent"></div>
                    
                    <!-- Number Circle -->
                    <div class="absolute left-0 top-0 w-6 h-6 rounded-full bg-blue-500 flex items-center justify-center shadow-[0_0_20px_rgba(59,130,246,0.6)]">
                        <span class="text-xs font-bold text-white">3</span>
                    </div>
                    
                    <div class="inline-block px-3 py-1 bg-blue-500/10 border border-blue-500/30 rounded-md text-xs font-bold text-blue-400 mb-2">
                        03 / DATOS
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Datos e Imágenes</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">
                        Completá el nombre de tu agencia, logo, colores y subí las fotos de tus vehículos. Todo drag & drop.
                    </p>
                </div>

                <!-- Step 4 -->
                <div class="relative pl-10">
                    <!-- Timeline Line -->
                    <div class="absolute left-3 top-8 bottom-0 w-0.5 bg-gradient-to-b from-blue-500 to-transparent"></div>
                    
                    <!-- Number Circle -->
                    <div class="absolute left-0 top-0 w-6 h-6 rounded-full bg-blue-500 flex items-center justify-center shadow-[0_0_20px_rgba(59,130,246,0.6)]">
                        <span class="text-xs font-bold text-white">4</span>
                    </div>
                    
                    <div class="inline-block px-3 py-1 bg-blue-500/10 border border-blue-500/30 rounded-md text-xs font-bold text-blue-400 mb-2">
                        04 / DOMINIO
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Selección de Dominio</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">
                        Elegí tu dominio personalizado (ej: tuagencia.com) o usá un subdominio gratis mientras decidís.
                    </p>
                </div>

                <!-- Step 5 -->
                <div class="relative pl-10">
                    <!-- Timeline Line -->
                    <div class="absolute left-3 top-8 bottom-0 w-0.5 bg-gradient-to-b from-blue-500 to-transparent"></div>
                    
                    <!-- Number Circle -->
                    <div class="absolute left-0 top-0 w-6 h-6 rounded-full bg-blue-500 flex items-center justify-center shadow-[0_0_20px_rgba(59,130,246,0.6)]">
                        <span class="text-xs font-bold text-white">5</span>
                    </div>
                    
                    <div class="inline-block px-3 py-1 bg-blue-500/10 border border-blue-500/30 rounded-md text-xs font-bold text-blue-400 mb-2">
                        05 / LANZAMIENTO
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Web Activa</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">
                        ¡Listo! Tu sitio está publicado y visible para el mundo. Optimizado para SEO y rendimiento.
                    </p>
                </div>

                <!-- Step 6 -->
                <div class="relative pl-10">
                    <!-- Number Circle -->
                    <div class="absolute left-0 top-0 w-6 h-6 rounded-full bg-blue-500 flex items-center justify-center shadow-[0_0_20px_rgba(59,130,246,0.6)]">
                        <span class="text-xs font-bold text-white">6</span>
                    </div>
                    
                    <div class="inline-block px-3 py-1 bg-blue-500/10 border border-blue-500/30 rounded-md text-xs font-bold text-blue-400 mb-2">
                        06 / GESTIÓN
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Panel de Administración</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">
                        Gestioná todo desde un dashboard intuitivo: stock, leads, estadísticas y configuración en un solo lugar.
                    </p>
                </div>
            </div>

            <!-- Right: Sticky Mockup -->
            <div class="relative">
                <div class="sticky top-24">
                    <!-- Glow Effect -->
                    <div class="absolute -inset-4 bg-blue-600/10 blur-3xl rounded-3xl"></div>
                    
                    <!-- Mockup Container -->
                    <div class="relative bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden shadow-2xl">
                        <!-- Browser Chrome -->
                        <div class="bg-slate-950 border-b border-slate-800 px-4 py-3 flex items-center gap-2">
                            <div class="flex gap-2">
                                <div class="w-3 h-3 rounded-full bg-red-500/80"></div>
                                <div class="w-3 h-3 rounded-full bg-yellow-500/80"></div>
                                <div class="w-3 h-3 rounded-full bg-green-500/80"></div>
                            </div>
                            <div class="flex-1 ml-4">
                                <div class="bg-slate-900/80 rounded-md px-3 py-1.5 flex items-center gap-2 max-w-md">
                                    <svg class="w-3 h-3 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                    <span class="text-xs text-slate-500">tuagencia.autowebpro.com</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded bg-slate-800 flex items-center justify-center">
                                    <div class="w-1 h-1 bg-green-500 rounded-full animate-pulse"></div>
                                </div>
                                <span class="text-xs text-green-400 font-medium">ONLINE</span>
                            </div>
                        </div>
                        
                        <!-- Mockup Content -->
                        <div class="bg-gradient-to-br from-slate-900 via-slate-900 to-slate-950 p-12 aspect-video flex items-center justify-center">
                            <div class="text-center">
                                <!-- Success Icon -->
                                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-green-500/20 border-2 border-green-500/50 mb-6 shadow-[0_0_30px_rgba(34,197,94,0.3)]">
                                    <svg class="w-10 h-10 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                
                                <!-- Text -->
                                <h3 class="text-2xl font-bold text-white mb-2">¡Sitio Publicado!</h3>
                                <p class="text-blue-400 text-sm font-mono mb-1">https://tuagencia.com</p>
                                <div class="inline-flex items-center gap-2 text-xs text-slate-400">
                                    <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                                    <span>System Operational</span>
                                </div>
                                
                                <!-- Stats -->
                                <div class="mt-8 grid grid-cols-2 gap-4 max-w-xs mx-auto">
                                    <div class="bg-slate-950/50 border border-slate-800 rounded-lg p-3">
                                        <div class="text-2xl font-bold text-blue-400">02:45</div>
                                        <div class="text-xs text-slate-500">Setup Time</div>
                                    </div>
                                    <div class="bg-slate-950/50 border border-slate-800 rounded-lg p-3">
                                        <div class="text-2xl font-bold text-green-400">100%</div>
                                        <div class="text-xs text-slate-500">Uptime</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA Bottom -->
        <div class="text-center mt-16">
            <p class="text-slate-400 mb-6">
                Desde el registro hasta la publicación: <span class="text-white font-semibold">menos de 15 minutos</span>
            </p>
            <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-blue-600 hover:bg-blue-700 rounded-lg font-semibold text-white shadow-[0_0_25px_rgba(37,99,235,0.4)] hover:shadow-[0_0_35px_rgba(37,99,235,0.6)] transition-all">
                Comenzar Ahora
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                </svg>
            </a>
        </div>


    <div class="absolute inset-0">
        <!-- Gradient Orbs -->
        <div class="absolute top-1/2 left-1/4 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 right-1/4 translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-purple-500/10 rounded-full blur-3xl"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 relative mt-16">
        <!-- Decorative Grid -->
        <div class="flex items-center justify-center gap-4">
            <!-- Left Line -->
            <div class="flex-1 h-px bg-gradient-to-r from-transparent via-blue-500/20 to-blue-500/50"></div>
            
            <!-- Center Icon Group -->
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500/20 to-purple-500/20 backdrop-blur-xl border border-white/10 flex items-center justify-center rotate-45">
                    <div class="w-6 h-6 bg-blue-500/40 rounded-sm -rotate-45"></div>
                </div>
                
                <div class="w-3 h-3 rounded-full bg-blue-500 shadow-lg shadow-blue-500/50 animate-pulse"></div>
                
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-purple-500/20 to-blue-500/20 backdrop-blur-xl border border-white/10 flex items-center justify-center -rotate-12">
                    <div class="w-6 h-6 bg-purple-500/40 rounded-sm rotate-12"></div>
                </div>
            </div>
            
            <!-- Right Line -->
            <div class="flex-1 h-px bg-gradient-to-l from-transparent via-blue-500/20 to-blue-500/50"></div>
        </div>
    </div>
</section>


<!-- Servicios Section -->
<section id="servicios" class="bg-[#020617] py-24">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-24">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Potencia cada aspecto de tu negocio</h2>
            <p class="text-lg text-slate-400 max-w-3xl mx-auto">
                Herramientas diseñadas específicamente para la industria automotriz moderna.
            </p>
        </div>
        <!-- Scroll Indicator -->
        <div class="flex flex-col items-center gap-3 pb-8">
            <span class="text-xs uppercase tracking-[0.3em] text-slate-500">Scroll</span>
            <div class="relative w-8 h-14 rounded-full border border-slate-700/80 flex items-start justify-center">
                <div class="w-1.5 h-3 bg-blue-500 rounded-full mt-2 animate-bounce"></div>
            </div>
        </div>
    </div>

    <!-- Servicio 1: Sitio Web Personalizado -->
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center gap-16 px-6 py-12 rounded-3xl border border-slate-800/40 bg-gradient-to-br from-slate-900/20 to-transparent backdrop-blur-sm transition-all duration-500 hover:border-blue-500/30 hover:bg-gradient-to-br hover:from-blue-900/10 hover:to-transparent hover:shadow-[0_0_40px_rgba(59,130,246,0.1)]">
        <div class="w-full md:w-1/2">
            <div class="inline-flex items-center gap-2 text-blue-400 text-xs uppercase tracking-widest mb-3">
                <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                Sitio Web
            </div>
            <h3 class="text-3xl font-bold text-white mb-4">Sitio Web Personalizado</h3>
            <p class="text-slate-400 text-lg leading-relaxed mb-6">
                Una concesionaria online profesional lista en minutos. Diseño moderno, responsive y optimizado para convertir visitantes en clientes. Totalmente personalizable sin necesidad de código.
            </p>
            <ul class="space-y-3 mb-6">
                <li class="flex items-start gap-3 text-slate-300">
                    <svg class="w-5 h-5 text-blue-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Diseños modernos y completamente responsivos.
                </li>
                <li class="flex items-start gap-3 text-slate-300">
                    <svg class="w-5 h-5 text-blue-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Galería de imágenes con lightbox y optimización automática.
                </li>
                <li class="flex items-start gap-3 text-slate-300">
                    <svg class="w-5 h-5 text-blue-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Integración con redes sociales y formularios de contacto.
                </li>
            </ul>
            <a href="#" class="text-blue-400 font-semibold hover:text-blue-300 transition-colors">Ver ejemplos →</a>
        </div>
        <div class="w-full md:w-1/2">
            <div class="bg-slate-900/80 border border-slate-800 rounded-2xl shadow-2xl shadow-blue-500/5 overflow-hidden">
                <div class="flex items-center gap-2 px-4 py-3 border-b border-slate-800">
                    <div class="w-3 h-3 rounded-full bg-red-500"></div>
                    <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                    <div class="w-3 h-3 rounded-full bg-green-500"></div>
                    <div class="ml-4 h-4 w-40 bg-slate-800 rounded"></div>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="h-4 w-32 bg-slate-700 rounded"></div>
                        <div class="h-7 w-20 bg-blue-500/30 rounded-md"></div>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="h-24 bg-slate-800/50 rounded-lg"></div>
                        <div class="h-24 bg-slate-800/50 rounded-lg"></div>
                        <div class="h-24 bg-slate-800/50 rounded-lg"></div>
                        <div class="h-24 bg-slate-800/50 rounded-lg"></div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="h-8 w-20 bg-slate-800/60 rounded-full"></div>
                        <div class="h-8 w-24 bg-slate-800/60 rounded-full"></div>
                        <div class="h-8 w-16 bg-slate-800/60 rounded-full"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Divisor -->
    <div class="max-w-7xl mx-auto px-6 py-8">
        <div class="flex items-center gap-4">
            <div class="flex-1 h-px bg-gradient-to-r from-transparent via-blue-500/30 to-transparent"></div>
            <div class="w-2 h-2 rounded-full bg-blue-500/50"></div>
            <div class="flex-1 h-px bg-gradient-to-r from-transparent via-blue-500/30 to-transparent"></div>
        </div>
    </div>

    <!-- Servicio 2: Panel de Administración -->
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row-reverse items-center gap-16 px-6 py-12 rounded-3xl border border-slate-800/40 bg-gradient-to-br from-slate-900/20 to-transparent backdrop-blur-sm transition-all duration-500 hover:border-blue-500/30 hover:bg-gradient-to-br hover:from-blue-900/10 hover:to-transparent hover:shadow-[0_0_40px_rgba(59,130,246,0.1)]">
        <div class="w-full md:w-1/2">
            <div class="inline-flex items-center gap-2 text-blue-400 text-xs uppercase tracking-widest mb-3">
                <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                Panel Admin
            </div>
            <h3 class="text-3xl font-bold text-white mb-4">Panel de Administración y Gestión de Usuarios</h3>
            <p class="text-slate-400 text-lg leading-relaxed mb-6">
                Controla todo desde un solo lugar. Panel intuitivo con permisos personalizables para cada vendedor, gerente o administrador. Auditoría completa de actividades.
            </p>
            <ul class="space-y-3 mb-6">
                <li class="flex items-start gap-3 text-slate-300">
                    <svg class="w-5 h-5 text-blue-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Roles y permisos granulares por usuario.
                </li>
                <li class="flex items-start gap-3 text-slate-300">
                    <svg class="w-5 h-5 text-blue-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Historial de cambios y auditoría de seguridad.
                </li>
                <li class="flex items-start gap-3 text-slate-300">
                    <svg class="w-5 h-5 text-blue-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Autenticación de dos factores (2FA) integrada.
                </li>
            </ul>
            <a href="#" class="text-blue-400 font-semibold hover:text-blue-300 transition-colors">Explorar panel →</a>
        </div>
        <div class="w-full md:w-1/2">
            <div class="bg-slate-900/80 border border-slate-800 rounded-2xl shadow-2xl shadow-blue-500/5 overflow-hidden">
                <div class="flex items-center justify-between px-4 py-3 border-b border-slate-800">
                    <div class="text-sm font-semibold text-white">Gestión de Usuarios</div>
                    <div class="text-[10px] text-slate-400">2026-02-02 21:57:56</div>
                </div>
                <div class="p-6 space-y-4">
                    <!-- Header con Title y Button -->
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <div class="text-lg font-bold text-white">Lista de Usuarios</div>
                            <div class="text-xs text-slate-400">Administra usuarios, roles y permisos del sistema</div>
                        </div>
                        <div class="h-9 px-3 rounded-lg bg-emerald-500/20 text-emerald-300 text-xs font-semibold border border-emerald-500/30 flex items-center">+ Crear Usuario</div>
                    </div>
                    
                    <!-- Stats Cards -->
                    <div class="grid grid-cols-4 gap-3 mb-4">
                        <div class="bg-blue-500/10 border border-blue-500/20 rounded-lg p-3">
                            <div class="text-[10px] text-slate-400 mb-1">Total Usuarios</div>
                            <div class="text-2xl font-bold text-blue-400">2</div>
                        </div>
                        <div class="bg-emerald-500/10 border border-emerald-500/20 rounded-lg p-3">
                            <div class="text-[10px] text-slate-400 mb-1">Activos</div>
                            <div class="text-2xl font-bold text-emerald-400">2</div>
                        </div>
                        <div class="bg-purple-500/10 border border-purple-500/20 rounded-lg p-3">
                            <div class="text-[10px] text-slate-400 mb-1">Administradores</div>
                            <div class="text-2xl font-bold text-purple-400">0</div>
                        </div>
                        <div class="bg-amber-500/10 border border-amber-500/20 rounded-lg p-3">
                            <div class="text-[10px] text-slate-400 mb-1">Agencieros</div>
                            <div class="text-2xl font-bold text-amber-400">1</div>
                        </div>
                    </div>
                    
                    <!-- Search and Filter -->
                    <div class="flex items-center gap-3 mb-4">
                        <div class="flex-1 flex items-center gap-2 bg-slate-800/50 border border-slate-700/50 rounded-lg px-3 py-2">
                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <span class="text-xs text-slate-500">Buscar por nombre, email o rol...</span>
                        </div>
                        <div class="h-9 px-3 rounded-lg border border-slate-700 flex items-center gap-2 text-xs text-slate-300">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                            </svg>
                            Filtros
                        </div>
                    </div>
                    
                    <!-- Table Header -->
                    <div class="grid grid-cols-6 gap-4 text-[10px] uppercase tracking-wider text-slate-500 font-semibold mb-3">
                        <div>Usuario</div>
                        <div>Email</div>
                        <div>Rol</div>
                        <div>Agencia</div>
                        <div>Estado</div>
                        <div>Registro</div>
                    </div>
                    
                    <!-- Table Rows -->
                    <div class="space-y-2">
                        <!-- Row 1 -->
                        <div class="grid grid-cols-6 gap-4 items-center bg-slate-800/30 rounded-lg px-4 py-2 text-sm">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-white text-xs font-bold">J</div>
                                <span class="text-white font-semibold">Juancito vendedor</span>
                            </div>
                            <div class="text-slate-400 text-xs">piru1889+1@gmail.com</div>
                            <div class="text-amber-400 text-[10px] font-semibold">COLABORADOR</div>
                            <div class="text-blue-400 text-xs">Agencia de Mauro</div>
                            <div class="text-emerald-400 text-[10px] font-semibold">Activo</div>
                            <div class="text-slate-400 text-xs">06/01/2026</div>
                        </div>
                        
                        <!-- Row 2 -->
                        <div class="grid grid-cols-6 gap-4 items-center bg-slate-800/30 rounded-lg px-4 py-2 text-sm">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-white text-xs font-bold">M</div>
                                <span class="text-white font-semibold">Mauro</span>
                            </div>
                            <div class="text-slate-400 text-xs">mauro@bief.com.ar</div>
                            <div class="text-emerald-400 text-[10px] font-semibold">AGENCIEROS</div>
                            <div class="text-blue-400 text-xs">Agencia de Mauro</div>
                            <div class="text-emerald-400 text-[10px] font-semibold">Activo</div>
                            <div class="text-slate-400 text-xs">06/01/2026</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Divisor -->
    <div class="max-w-7xl mx-auto px-6 py-8">
        <div class="flex items-center gap-4">
            <div class="flex-1 h-px bg-gradient-to-r from-transparent via-blue-500/30 to-transparent"></div>
            <div class="w-2 h-2 rounded-full bg-blue-500/50"></div>
            <div class="flex-1 h-px bg-gradient-to-r from-transparent via-blue-500/30 to-transparent"></div>
        </div>
    </div>

    <!-- Servicio 3: Control de Stock -->
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center gap-16 px-6 py-12 rounded-3xl border border-slate-800/40 bg-gradient-to-br from-slate-900/20 to-transparent backdrop-blur-sm transition-all duration-500 hover:border-blue-500/30 hover:bg-gradient-to-br hover:from-blue-900/10 hover:to-transparent hover:shadow-[0_0_40px_rgba(59,130,246,0.1)]">
        <div class="w-full md:w-1/2">
            <div class="inline-flex items-center gap-2 text-blue-400 text-xs uppercase tracking-widest mb-3">
                <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                Stock
            </div>
            <h3 class="text-3xl font-bold text-white mb-4">Control de Stock de Vehículos</h3>
            <p class="text-slate-400 text-lg leading-relaxed mb-6">
                Gestiona tu inventario completo con actualizaciones en tiempo real. Registra vehículos, detalles técnicos, galerías fotográficas y sincroniza automáticamente con todas tus plataformas.
            </p>
            <ul class="space-y-3 mb-6">
                <li class="flex items-start gap-3 text-slate-300">
                    <svg class="w-5 h-5 text-blue-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Registro completo: datos técnicos, historial, accesorios.
                </li>
                <li class="flex items-start gap-3 text-slate-300">
                    <svg class="w-5 h-5 text-blue-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Estados dinámicos: activo, reservado, vendido, bajo revisión.
                </li>
                <li class="flex items-start gap-3 text-slate-300">
                    <svg class="w-5 h-5 text-blue-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Búsqueda y filtrado avanzado por marca, modelo, rango de precio.
                </li>
            </ul>
            <a href="#" class="text-blue-400 font-semibold hover:text-blue-300 transition-colors">Más sobre stock →</a>
        </div>
        <div class="w-full md:w-1/2">
            <div class="bg-slate-900/80 border border-slate-800 rounded-2xl shadow-2xl shadow-blue-500/5 overflow-hidden">
                <div class="flex items-center gap-2 px-4 py-3 border-b border-slate-800">
                    <div class="w-3 h-3 rounded-full bg-red-500"></div>
                    <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                    <div class="w-3 h-3 rounded-full bg-green-500"></div>
                    <div class="ml-4 h-4 w-40 bg-slate-800 rounded"></div>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="h-4 w-32 bg-slate-800 rounded"></div>
                        <div class="h-7 w-20 bg-blue-500/30 rounded-md"></div>
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between bg-slate-800/50 rounded-lg px-4 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-slate-700/60"></div>
                                <div class="space-y-1">
                                    <div class="text-sm text-white">Toyota Corolla 2021</div>
                                    <div class="text-xs text-slate-400">$18,900 · 45.000 km</div>
                                </div>
                            </div>
                            <span class="text-[10px] px-2 py-1 rounded-full bg-blue-500/20 text-blue-300 border border-blue-500/30">Activo</span>
                        </div>
                        <div class="flex items-center justify-between bg-slate-800/50 rounded-lg px-4 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-slate-700/60"></div>
                                <div class="space-y-1">
                                    <div class="text-sm text-white">Ford Focus 2019</div>
                                    <div class="text-xs text-slate-400">$14,500 · 62.000 km</div>
                                </div>
                            </div>
                            <span class="text-[10px] px-2 py-1 rounded-full bg-amber-500/20 text-amber-300 border border-amber-500/30">Reservado</span>
                        </div>
                        <div class="flex items-center justify-between bg-slate-800/50 rounded-lg px-4 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-slate-700/60"></div>
                                <div class="space-y-1">
                                    <div class="text-sm text-white">VW Amarok 2020</div>
                                    <div class="text-xs text-slate-400">$27,800 · 38.000 km</div>
                                </div>
                            </div>
                            <span class="text-[10px] px-2 py-1 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">Vendido</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Divisor -->
    <div class="max-w-7xl mx-auto px-6 py-8">
        <div class="flex items-center gap-4">
            <div class="flex-1 h-px bg-gradient-to-r from-transparent via-blue-500/30 to-transparent"></div>
            <div class="w-2 h-2 rounded-full bg-blue-500/50"></div>
            <div class="flex-1 h-px bg-gradient-to-r from-transparent via-blue-500/30 to-transparent"></div>
        </div>
    </div>

    <!-- Servicio 4: Hosting y Dominio -->
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row-reverse items-center gap-16 px-6 py-12 rounded-3xl border border-slate-800/40 bg-gradient-to-br from-slate-900/20 to-transparent backdrop-blur-sm transition-all duration-500 hover:border-blue-500/30 hover:bg-gradient-to-br hover:from-blue-900/10 hover:to-transparent hover:shadow-[0_0_40px_rgba(59,130,246,0.1)]">
        <div class="w-full md:w-1/2">
            <div class="inline-flex items-center gap-2 text-blue-400 text-xs uppercase tracking-widest mb-3">
                <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                Hosting
            </div>
            <h3 class="text-3xl font-bold text-white mb-4">Hosting y Dominio</h3>
            <p class="text-slate-400 text-lg leading-relaxed mb-6">
                Hosting de clase mundial incluido en tu plan. Tu sitio se carga en milisegundos con CDN global, certificados SSL automáticos y máxima seguridad. Dominio personalizado configurado en minutos.
            </p>
            <ul class="space-y-3 mb-6">
                <li class="flex items-start gap-3 text-slate-300">
                    <svg class="w-5 h-5 text-blue-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Infraestructura en la nube con 99.9% de uptime garantizado.
                </li>
                <li class="flex items-start gap-3 text-slate-300">
                    <svg class="w-5 h-5 text-blue-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    SSL automático y backups diarios incluidos.
                </li>
                <li class="flex items-start gap-3 text-slate-300">
                    <svg class="w-5 h-5 text-blue-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Soporte técnico 24/7 en español incluido.
                </li>
            </ul>
            <a href="#" class="text-blue-400 font-semibold hover:text-blue-300 transition-colors">Conocé la infraestructura →</a>
        </div>
        <div class="w-full md:w-1/2">
            <div class="bg-slate-900/80 border border-slate-800 rounded-2xl shadow-2xl shadow-blue-500/5 overflow-hidden">
                <div class="flex items-center gap-2 px-4 py-3 border-b border-slate-800">
                    <div class="w-3 h-3 rounded-full bg-red-500"></div>
                    <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                    <div class="w-3 h-3 rounded-full bg-green-500"></div>
                    <div class="ml-4 h-4 w-40 bg-slate-800 rounded"></div>
                </div>
                <div class="p-6">
                    <div class="bg-slate-900/60 border border-slate-800/80 rounded-xl p-6">
                        <div class="relative mx-auto w-28 h-28">
                            <div class="absolute inset-0 rounded-full border-2 border-blue-500/30"></div>
                            <div class="absolute inset-2 rounded-full border-2 border-blue-500/60"></div>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="text-center">
                                    <div class="text-3xl font-bold text-white">100</div>
                                    <div class="text-[10px] uppercase tracking-widest text-blue-400">Performance</div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 grid grid-cols-3 gap-4 text-center">
                            <div>
                                <div class="text-[10px] text-slate-500">LCP</div>
                                <div class="text-xs font-semibold text-emerald-400">0.8s</div>
                            </div>
                            <div>
                                <div class="text-[10px] text-slate-500">FID</div>
                                <div class="text-xs font-semibold text-emerald-400">12ms</div>
                            </div>
                            <div>
                                <div class="text-[10px] text-slate-500">CLS</div>
                                <div class="text-xs font-semibold text-emerald-400">0</div>
                            </div>
                        </div>
                        <div class="mt-5 flex items-center gap-2 text-[10px] text-slate-400">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            Server Status: Operational
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Divisor -->
    <div class="max-w-7xl mx-auto px-6 py-8">
        <div class="flex items-center gap-4">
            <div class="flex-1 h-px bg-gradient-to-r from-transparent via-blue-500/30 to-transparent"></div>
            <div class="w-2 h-2 rounded-full bg-blue-500/50"></div>
            <div class="flex-1 h-px bg-gradient-to-r from-transparent via-blue-500/30 to-transparent"></div>
        </div>
    </div>

    <!-- Servicio 5: Analítica y Reportes -->
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center gap-16 px-6 py-12 rounded-3xl border border-slate-800/40 bg-gradient-to-br from-slate-900/20 to-transparent backdrop-blur-sm transition-all duration-500 hover:border-blue-500/30 hover:bg-gradient-to-br hover:from-blue-900/10 hover:to-transparent hover:shadow-[0_0_40px_rgba(59,130,246,0.1)]">
        <div class="w-full md:w-1/2">
            <div class="inline-flex items-center gap-2 text-blue-400 text-xs uppercase tracking-widest mb-3">
                <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                Analítica
            </div>
            <h3 class="text-3xl font-bold text-white mb-4">Analítica y Reportes Avanzados</h3>
            <p class="text-slate-400 text-lg leading-relaxed mb-6">
                Datos en tiempo real para tomar decisiones más inteligentes. Dashboards intuitivos con métricas de tráfico, conversiones, leads y ventas. Exporta reportes personalizados en PDF.
            </p>
            <ul class="space-y-3 mb-6">
                <li class="flex items-start gap-3 text-slate-300">
                    <svg class="w-5 h-5 text-blue-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Gráficos interactivos de visitantes, leads y ventas.
                </li>
                <li class="flex items-start gap-3 text-slate-300">
                    <svg class="w-5 h-5 text-blue-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Seguimiento de fuentes de tráfico y campañas.
                </li>
                <li class="flex items-start gap-3 text-slate-300">
                    <svg class="w-5 h-5 text-blue-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Reportes personalizados con métricas clave del negocio.
                </li>
            </ul>
            <a href="#" class="text-blue-400 font-semibold hover:text-blue-300 transition-colors">Explorar reportes →</a>
        </div>
        <div class="w-full md:w-1/2">
            <div class="bg-slate-900/80 border border-slate-800 rounded-2xl shadow-2xl shadow-blue-500/5 overflow-hidden">
                <div class="flex items-center justify-between px-4 py-3 border-b border-slate-800">
                    <div class="text-sm font-semibold text-white">Ventas Mensuales</div>
                    <div class="flex items-center gap-2">
                        <span class="text-[10px] text-slate-400 bg-slate-800/80 px-2 py-1 rounded">30 Días</span>
                        <span class="text-[10px] text-white bg-blue-500/80 px-2 py-1 rounded">Año Actual</span>
                    </div>
                </div>
                <div class="p-6">
                    <div class="relative h-40">
                        <div class="absolute inset-0 flex items-end gap-3">
                            <div class="w-10 bg-slate-800/60 rounded-t h-20"></div>
                            <div class="w-10 bg-slate-800/60 rounded-t h-28"></div>
                            <div class="w-10 bg-slate-800/60 rounded-t h-18"></div>
                            <div class="w-10 bg-blue-500 rounded-t h-32 shadow-[0_0_20px_rgba(59,130,246,0.4)]"></div>
                            <div class="w-10 bg-slate-800/60 rounded-t h-24"></div>
                            <div class="w-10 bg-slate-800/60 rounded-t h-36"></div>
                            <div class="w-10 bg-slate-800/60 rounded-t h-26"></div>
                        </div>
                        <div class="absolute left-1/2 -translate-x-1/2 -top-2 bg-white text-slate-900 text-xs font-semibold px-2 py-1 rounded shadow">75</div>
                    </div>
                    <div class="mt-6 h-px bg-slate-800"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll Indicator -->
    <div class="max-w-7xl mx-auto px-6 py-10">
        <div class="flex items-center justify-center gap-4">
            <div class="h-px w-16 bg-gradient-to-r from-transparent via-blue-500/40 to-transparent"></div>
            <div class="w-3 h-3 rounded-full bg-blue-500/60 animate-pulse"></div>
            <div class="h-px w-16 bg-gradient-to-r from-transparent via-blue-500/40 to-transparent"></div>
        </div>
        <div class="flex justify-center mt-3">
            <svg class="w-5 h-5 text-blue-400 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </div>
    </div>
</section>

<!-- Stock Control Section -->
<section class="py-24 px-4 bg-gradient-to-b from-blue-500/5 to-transparent">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Control total de tu stock</h2>
            <p class="text-lg text-gray-400 max-w-2xl mx-auto">
                Una interfaz intuitiva diseñada para que pases menos tiempo gestionando y más tiempo vendiendo.
            </p>
        </div>
        
        <!-- Stock Dashboard Mockup -->
        <div class="relative glass rounded-2xl p-8 max-w-4xl mx-auto">
            <!-- Browser Chrome -->
            <div class="flex items-center gap-2 mb-6">
                <div class="w-3 h-3 rounded-full bg-red-500"></div>
                <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                <div class="w-3 h-3 rounded-full bg-green-500"></div>
                <div class="flex-1 ml-4">
                    <div class="h-7 bg-white/5 rounded flex items-center px-3">
                        <svg class="w-3 h-3 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        <span class="text-xs text-gray-500">app.autowebpro.com/dashboard</span>
                    </div>
                </div>
            </div>
            
            <!-- Dashboard Content -->
            <div class="flex gap-6">
                <!-- Sidebar -->
                <div class="w-20 space-y-3">
                    <div class="w-16 h-14 bg-blue-500/20 rounded-lg flex items-center justify-center">
                        <svg class="w-7 h-7 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <div class="w-16 h-12 bg-white/5 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                    </div>
                    <div class="w-16 h-12 bg-white/5 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div class="w-16 h-12 bg-white/5 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                </div>
                
                <!-- Main Content -->
                <div class="flex-1 space-y-4">
                    <!-- Header -->
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-xl font-bold text-white mb-1">Resumen General</h3>
                            <p class="text-sm text-gray-400">Bienvenido de nuevo, Administrador</p>
                        </div>
                        <button class="px-4 py-2 bg-blue-500 hover:bg-blue-600 rounded-lg text-sm font-semibold text-white flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Nuevo Vehículo
                        </button>
                    </div>
                    
                    <!-- Stats Cards -->
                    <div class="grid grid-cols-3 gap-4">
                        <div class="bg-green-500/10 border border-green-500/20 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <div class="w-8 h-8 bg-green-500/20 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <span class="text-xs px-2 py-0.5 bg-green-500/20 text-green-400 rounded">+22%</span>
                            </div>
                            <p class="text-xs text-gray-400 mb-1">Vehículos Activos</p>
                            <p class="text-2xl font-bold text-white">124</p>
                        </div>
                        
                        <div class="bg-purple-500/10 border border-purple-500/20 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <div class="w-8 h-8 bg-purple-500/20 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </div>
                                <span class="text-xs px-2 py-0.5 bg-purple-500/20 text-purple-400 rounded">+5% hoy</span>
                            </div>
                            <p class="text-xs text-gray-400 mb-1">Visitas Mes</p>
                            <p class="text-2xl font-bold text-white">8,432</p>
                        </div>
                        
                        <div class="bg-yellow-500/10 border border-yellow-500/20 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <div class="w-8 h-8 bg-yellow-500/20 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                                <span class="text-xs px-2 py-0.5 bg-yellow-500/20 text-yellow-400 rounded">Requiere Atención</span>
                            </div>
                            <p class="text-xs text-gray-400 mb-1">Leads Pendientes</p>
                            <p class="text-2xl font-bold text-white">18</p>
                        </div>
                    </div>
                    
                    <!-- Vehicle List -->
                    <div class="bg-white/5 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-sm font-semibold text-white">Últimos Ingresos</h4>
                            <a href="#" class="text-xs text-blue-500 hover:text-blue-400">Ver todo</a>
                        </div>
                        
                        <div class="space-y-3">
                            <!-- Vehicle Item 1 -->
                            <div class="flex items-center gap-3 p-3 bg-white/5 rounded-lg hover:bg-white/10 transition-all">
                                <div class="w-16 h-12 bg-gradient-to-br from-gray-700 to-gray-800 rounded-lg flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-white">2023 Toyota Corolla</p>
                                    <p class="text-xs text-gray-400">SDN • 2,430 km</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-bold text-white">$24,600</p>
                                    <span class="text-xs px-2 py-0.5 bg-green-500/20 text-green-400 rounded">Destacado</span>
                                </div>
                            </div>
                            
                            <!-- Vehicle Item 2 -->
                            <div class="flex items-center gap-3 p-3 bg-white/5 rounded-lg hover:bg-white/10 transition-all">
                                <div class="w-16 h-12 bg-gradient-to-br from-red-900 to-red-800 rounded-lg flex items-center justify-center">
                                    <svg class="w-8 h-8 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-white">2022 Ford Mustang</p>
                                    <p class="text-xs text-gray-400">CPE • 2,820 km</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-bold text-white">$42,000</p>
                                    <span class="text-xs px-2 py-0.5 bg-yellow-500/20 text-yellow-400 rounded">Rotativo</span>
                                </div>
                            </div>
                            
                            <!-- Vehicle Item 3 -->
                            <div class="flex items-center gap-3 p-3 bg-white/5 rounded-lg hover:bg-white/10 transition-all">
                                <div class="w-16 h-12 bg-gradient-to-br from-blue-900 to-blue-800 rounded-lg flex items-center justify-center">
                                    <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-white">2024 BMW X5</p>
                                    <p class="text-xs text-gray-400">SUV • 1,005 km</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-bold text-white">$24,500</p>
                                    <span class="text-xs px-2 py-0.5 bg-green-500/20 text-green-400 rounded flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                                        </svg>
                                        Venta Confirmada
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="py-24 px-4">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-4">
                Hablemos de tu próximo proyecto.
            </h2>
            <p class="text-lg text-gray-400 max-w-3xl mx-auto">
                Contanos tu idea o desafío y te ayudamos a transformarlo en una solución tecnológica real para tu agencia.
            </p>
        </div>

        <!-- Contact Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Left Column - Contact Info -->
            <div class="bg-slate-900/50 backdrop-blur-xl border border-white/10 rounded-2xl p-8">
                <h3 class="text-2xl font-bold text-white mb-8">Información de contacto</h3>
                
                <div class="space-y-6">
                    <!-- Email -->
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-blue-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-semibold mb-1">Email</p>
                            <a href="mailto:hola@autowebpro.com" class="text-lg text-white hover:text-blue-400 transition-colors">hola@autowebpro.com</a>
                        </div>
                    </div>

                    <!-- WhatsApp -->
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-blue-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-semibold mb-1">WhatsApp</p>
                            <a href="#" class="text-lg text-white hover:text-blue-400 transition-colors font-semibold">Consultar directo</a>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-8 border-t border-white/10">
                    <p class="text-gray-400">Te respondemos a la brevedad para arrancar a trabajar juntos.</p>
                </div>
            </div>

            <!-- Right Column - Contact Form -->
            <div class="bg-slate-900/50 backdrop-blur-xl border border-white/10 rounded-2xl p-8">
                <form action="#" method="POST" class="space-y-6">
                    @csrf
                    
                    <!-- Name and Email Row -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <input 
                                type="text" 
                                name="name" 
                                placeholder="Nombre completo" 
                                class="w-full px-4 py-3 bg-slate-800/50 border border-slate-700/50 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all"
                                required
                            >
                        </div>
                        <div>
                            <input 
                                type="email" 
                                name="email" 
                                placeholder="Email corporativo" 
                                class="w-full px-4 py-3 bg-slate-800/50 border border-slate-700/50 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all"
                                required
                            >
                        </div>
                    </div>

                    <!-- Message -->
                    <div>
                        <textarea 
                            name="message" 
                            rows="6" 
                            placeholder="Contanos sobre tu proyecto" 
                            class="w-full px-4 py-3 bg-slate-800/50 border border-slate-700/50 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all resize-none"
                            required
                        ></textarea>
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit" 
                        class="w-full px-8 py-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-all flex items-center justify-center gap-2"
                    >
                        Enviar mensaje
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<x-footer />
@endsection
