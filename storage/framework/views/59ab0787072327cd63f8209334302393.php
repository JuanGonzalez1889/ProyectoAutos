

<?php $__env->startSection('seo'); ?>
    <?php if (isset($component)) { $__componentOriginala2d9072d59b69a761b60324b3706ddf1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala2d9072d59b69a761b60324b3706ddf1 = $attributes; } ?>
<?php $component = App\View\Components\Seo::resolve(['title' => 'AutoWeb Pro - Tu concesionaria online en minutos','description' => 'Plataforma SaaS todo-en-uno para agencias de autos. Gestiona inventario, leads, sitio web personalizado y más.','keywords' => 'agencia de autos, gestión de inventario, CRM automotriz, sitio web para concesionaria, leads de vehículos','image' => asset('images/og-home.jpg')] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('seo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Seo::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala2d9072d59b69a761b60324b3706ddf1)): ?>
<?php $attributes = $__attributesOriginala2d9072d59b69a761b60324b3706ddf1; ?>
<?php unset($__attributesOriginala2d9072d59b69a761b60324b3706ddf1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala2d9072d59b69a761b60324b3706ddf1)): ?>
<?php $component = $__componentOriginala2d9072d59b69a761b60324b3706ddf1; ?>
<?php unset($__componentOriginala2d9072d59b69a761b60324b3706ddf1); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<!-- Navbar -->
<?php if (isset($component)) { $__componentOriginala591787d01fe92c5706972626cdf7231 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala591787d01fe92c5706972626cdf7231 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.navbar','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('navbar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala591787d01fe92c5706972626cdf7231)): ?>
<?php $attributes = $__attributesOriginala591787d01fe92c5706972626cdf7231; ?>
<?php unset($__attributesOriginala591787d01fe92c5706972626cdf7231); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala591787d01fe92c5706972626cdf7231)): ?>
<?php $component = $__componentOriginala591787d01fe92c5706972626cdf7231; ?>
<?php unset($__componentOriginala591787d01fe92c5706972626cdf7231); ?>
<?php endif; ?>
<nav class="w-full px-6 py-4 flex items-center justify-between bg-slate-950 shadow-md md:px-12">
   
    <!-- Hamburguesa -->
    <button id="menuBtn" class="md:hidden flex items-center justify-center w-10 h-10 rounded bg-slate-900 hover:bg-slate-800 transition">
        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>
    <!-- Panel lateral -->
    <div id="mobileMenu" class="fixed inset-0 z-50 bg-slate-950 bg-opacity-95 flex flex-col items-center justify-center gap-8 text-white text-lg transition-transform transform translate-x-full md:hidden">
        <button id="closeMenu" class="absolute top-6 right-6">
            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <a href="#servicios" class="hover:text-blue-400 transition">Servicios</a>
        <a href="#demo" class="hover:text-blue-400 transition">Demo</a>
        <a href="#contacto" class="hover:text-blue-400 transition">Contacto</a>
        <a href="<?php echo e(route('register')); ?>" class="btn-gradient px-6 py-2 rounded-lg font-semibold text-white">Comenzar</a>
    </div>
</nav>
<script>
    // Garantiza que el script se ejecute después de que el DOM esté listo
    window.addEventListener('DOMContentLoaded', function () {
        var menuBtn = document.getElementById('menuBtn');
        var mobileMenu = document.getElementById('mobileMenu');
        var closeMenu = document.getElementById('closeMenu');
        if (menuBtn && mobileMenu) {
            menuBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                mobileMenu.classList.remove('translate-x-full');
            });
        }
        if (closeMenu && mobileMenu) {
            closeMenu.addEventListener('click', function (e) {
                e.stopPropagation();
                mobileMenu.classList.add('translate-x-full');
            });
        }
        // Opcional: cerrar menú al hacer click fuera
        mobileMenu && mobileMenu.addEventListener('click', function(e) {
            if (e.target === mobileMenu) {
                mobileMenu.classList.add('translate-x-full');
            }
        });
    });
</script>

<!-- Hero Section -->
<section class="relative min-h-screen flex flex-col md:flex-row items-center justify-center w-full px-4 md:px-[10rem] md:overflow-x-hidden">
    <div class="w-full flex flex-col md:flex-row gap-12 items-center justify-center mx-auto">
            <!-- Left Column - Content -->
            <div class="text-center md:text-left w-full md:w-1/2 flex flex-col justify-center px-0 md:px-0">
                <!-- Badge -->
                <div class="inline-flex items-center gap-2 px-4 py-2 glass rounded-full mb-6">
                    <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></span>
                    <span class="text-sm text-gray-300">Nueva versión 2.0 disponible</span>
                </div>
                <!-- Title -->
                <h1 class="text-4xl md:text-6xl font-bold mb-6 leading-tight">
                    Tu concesionaria <span class="gradient-text">online</span> en minutos
                </h1>
                <!-- Subtitle -->
                <p class="text-base md:text-xl text-gray-400 mb-8 leading-relaxed">
                    La plataforma todo-en-uno para gestionar tu inventario, conectar con clientes y vender más autos sin complicaciones técnicas ni código.
                </p>
                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                    <a href="<?php echo e(route('register')); ?>" class="px-8 py-4 btn-gradient rounded-lg font-semibold text-white hover:opacity-90 inline-flex items-center justify-center gap-2">
                        Comenzar hoy
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </a>
                    
                </div>
            </div>
            <!-- Right Column - Publicación Exitosa Animada -->
            <div class="relative w-full md:w-1/2 flex justify-center items-center px-0 md:px-0">
                <!-- Glow Effect -->
                <div class="absolute inset-0 bg-blue-500/20 blur-3xl rounded-full"></div>
                <!-- Dashboard Mockup -->
                <div class="relative glass rounded-2xl p-6 shadow-2xl w-full h-auto mx-auto">
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
<div class="bg-[#020617] w-full px-4 md:px-6 overflow-x-hidden">
    <div class="max-w-7xl mx-auto flex flex-col items-center gap-3 py-8">
        <span class="text-xs uppercase tracking-[0.3em] text-slate-500">Scroll</span>
        <div class="relative w-8 h-14 rounded-full border border-slate-700/80 flex items-start justify-center">
            <div class="w-1.5 h-3 bg-blue-500 rounded-full mt-2 animate-bounce"></div>
        </div>
    </div>
</div>


<!-- How It Works Section -->
<section class="bg-[#020617] py-24 w-full px-4 md:px-12 text-white overflow-x-hidden">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-16 w-full">
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
        <div class="grid md:grid-cols-2 gap-16 items-start w-full">
            <!-- Left: Steps -->
            <div class="space-y-8 w-full">
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
            <div class="relative w-full">
                <div class="sticky top-24 w-full">
                    <?php if (isset($component)) { $__componentOriginalf6348b400ad6ffdcb4c3ae4058502eec = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf6348b400ad6ffdcb4c3ae4058502eec = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.publicacion-exitosa','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('publicacion-exitosa'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf6348b400ad6ffdcb4c3ae4058502eec)): ?>
<?php $attributes = $__attributesOriginalf6348b400ad6ffdcb4c3ae4058502eec; ?>
<?php unset($__attributesOriginalf6348b400ad6ffdcb4c3ae4058502eec); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf6348b400ad6ffdcb4c3ae4058502eec)): ?>
<?php $component = $__componentOriginalf6348b400ad6ffdcb4c3ae4058502eec; ?>
<?php unset($__componentOriginalf6348b400ad6ffdcb4c3ae4058502eec); ?>
<?php endif; ?>
                </div>
            </div>
        </div>

        <!-- CTA Bottom -->
        <div class="text-center mt-16">
            <p class="text-slate-400 mb-6">
                Desde el registro hasta la publicación: <span class="text-white font-semibold">menos de 15 minutos</span>
            </p>
            <a href="<?php echo e(route('register')); ?>" class="inline-flex items-center gap-2 px-8 py-4 bg-blue-600 hover:bg-blue-700 rounded-lg font-semibold text-white shadow-[0_0_25px_rgba(37,99,235,0.4)] hover:shadow-[0_0_35px_rgba(37,99,235,0.6)] transition-all">
                Comenzar Ahora
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                </svg>
            </a>
        </div>


    <div class="absolute inset-0 pointer-events-none">
        <!-- Gradient Orbs -->
        <div class="absolute top-1/2 left-1/4 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 right-1/4 translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-purple-500/10 rounded-full blur-3xl hidden md:block"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 relative mt-16 w-full">
        <!-- Decorative Grid -->
        <div class="flex items-center justify-center gap-4 w-full">
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
<section id="servicios" class="bg-[#020617] py-24 w-full overflow-x-hidden">
    <div class="max-w-7xl mx-auto px-4 md:px-6">
        <div class="text-center mb-24">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Conocé nuestros servicios</h2>
            <p class="text-lg text-slate-400 max-w-3xl mx-auto">
                Potencia cada aspecto de tu negocio con herramientas diseñadas específicamente para la industria automotriz moderna.
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
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center gap-16 px-4 md:px-6 py-12 rounded-3xl border border-slate-800/40 bg-gradient-to-br from-slate-900/20 to-transparent backdrop-blur-sm transition-all duration-500 hover:border-blue-500/30 hover:bg-gradient-to-br hover:from-blue-900/10 hover:to-transparent hover:shadow-[0_0_40px_rgba(59,130,246,0.1)] w-full">
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
            <a href="login" class="text-blue-400 font-semibold hover:text-blue-300 transition-colors">Ver ejemplos →</a>
        </div>
        <div class="w-full md:w-1/2">
            <div class="bg-slate-900/80 border border-slate-800 rounded-2xl shadow-2xl shadow-blue-500/5 overflow-hidden flex items-center justify-center">
                <img src="/storage/web.jpeg" alt="Sitio Web Personalizado" class="w-full h-auto object-cover rounded-2xl" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Divisor -->
    <div class="max-w-7xl mx-auto px-4 md:px-6 py-8 w-full">
        <div class="flex items-center gap-4">
            <div class="flex-1 h-px bg-gradient-to-r from-transparent via-blue-500/30 to-transparent"></div>
            <div class="w-2 h-2 rounded-full bg-blue-500/50"></div>
            <div class="flex-1 h-px bg-gradient-to-r from-transparent via-blue-500/30 to-transparent"></div>
        </div>
    </div>

    <!-- Servicio 2: Panel de Administración -->
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row-reverse items-center gap-16 px-4 md:px-6 py-12 rounded-3xl border border-slate-800/40 bg-gradient-to-br from-slate-900/20 to-transparent backdrop-blur-sm transition-all duration-500 hover:border-blue-500/30 hover:bg-gradient-to-br hover:from-blue-900/10 hover:to-transparent hover:shadow-[0_0_40px_rgba(59,130,246,0.1)] w-full">
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
            <a href="login" class="text-blue-400 font-semibold hover:text-blue-300 transition-colors">Explorar panel →</a>
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
                                <span class="text-white font-semibold">Juan</span>
                            </div>
                            <div class="text-slate-400 text-xs">piru1889@...</div>
                            <div class="text-amber-400 text-[10px] font-semibold">COLABORADOR</div>
                            <div class="text-blue-400 text-xs">Agencia de Mauro</div>
                            <div class="text-emerald-400 text-[10px] font-semibold">Activo</div>
                            <div class="text-slate-400 text-xs">06/01/2026</div>
                        </div>
                        
                        <!-- Row 2 -->
                        <div class="grid grid-cols-6 gap-4 items-center bg-slate-800/30 rounded-lg px-4 py-2 text-sm">
                            <div class="flex items-center gap-2">
                                <span class="text-white font-semibold">Mauro</span>
                            </div>
                            <div class="text-slate-400 text-xs">mauro@...</div>
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
    <div class="max-w-7xl mx-auto px-4 md:px-6 py-8 w-full">
        <div class="flex items-center gap-4">
            <div class="flex-1 h-px bg-gradient-to-r from-transparent via-blue-500/30 to-transparent"></div>
            <div class="w-2 h-2 rounded-full bg-blue-500/50"></div>
            <div class="flex-1 h-px bg-gradient-to-r from-transparent via-blue-500/30 to-transparent"></div>
        </div>
    </div>

    <!-- Servicio 3: Control de Stock -->
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center gap-16 px-4 md:px-6 py-12 rounded-3xl border border-slate-800/40 bg-gradient-to-br from-slate-900/20 to-transparent backdrop-blur-sm transition-all duration-500 hover:border-blue-500/30 hover:bg-gradient-to-br hover:from-blue-900/10 hover:to-transparent hover:shadow-[0_0_40px_rgba(59,130,246,0.1)] w-full">
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
            <a href="login" class="text-blue-400 font-semibold hover:text-blue-300 transition-colors">Más sobre stock →</a>
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
                        <div class="h-7 w-20 bg-blue-500/30 rounded-md" style="text-align: center">Publicar</div>
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
    <div class="max-w-7xl mx-auto px-4 md:px-6 py-8 w-full">
        <div class="flex items-center gap-4">
            <div class="flex-1 h-px bg-gradient-to-r from-transparent via-blue-500/30 to-transparent"></div>
            <div class="w-2 h-2 rounded-full bg-blue-500/50"></div>
            <div class="flex-1 h-px bg-gradient-to-r from-transparent via-blue-500/30 to-transparent"></div>
        </div>
    </div>

    <!-- Servicio 4: Hosting y Dominio -->
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row-reverse items-center gap-16 px-4 md:px-6 py-12 rounded-3xl border border-slate-800/40 bg-gradient-to-br from-slate-900/20 to-transparent backdrop-blur-sm transition-all duration-500 hover:border-blue-500/30 hover:bg-gradient-to-br hover:from-blue-900/10 hover:to-transparent hover:shadow-[0_0_40px_rgba(59,130,246,0.1)] w-full">
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
                    Configuración en minutos, sin complicaciones técnicas.
                </li>
            </ul>
            <a href="login" class="text-blue-400 font-semibold hover:text-blue-300 transition-colors">Conocé la infraestructura →</a>
        </div>
        <div class="w-full md:w-1/2">
                        <div class="bg-slate-900/80 border border-slate-800 rounded-2xl shadow-2xl shadow-blue-500/5 overflow-hidden flex flex-col items-center justify-center py-8">
                            <div class="relative w-56 h-56 mx-auto flex items-center justify-center">
                                <!-- SVG con dos anillos animados -->
                                <svg class="absolute inset-0 w-full h-full" viewBox="0 0 220 220" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <defs>
                                        <linearGradient id="blueRing" x1="0" y1="0" x2="220" y2="220" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#3b82f6"/>
                                            <stop offset="1" stop-color="#06b6d4"/>
                                        </linearGradient>
                                        <linearGradient id="greenRing" x1="220" y1="0" x2="0" y2="220" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#22d3ee"/>
                                            <stop offset="1" stop-color="#22c55e"/>
                                        </linearGradient>
                                    </defs>
                                    <g>
                                        <circle cx="110" cy="110" r="100" stroke="url(#blueRing)" stroke-width="8" fill="none" stroke-linecap="round" stroke-dasharray="440 220" class="animate-spin-slow-reverse"/>
                                        <circle cx="110" cy="110" r="90" stroke="url(#greenRing)" stroke-width="6" fill="none" stroke-linecap="round" stroke-dasharray="320 180" class="animate-spin-slow"/>
                                    </g>
                                </svg>
                                <!-- Contenido central -->
                                <div class="absolute inset-0 flex flex-col items-center justify-center">
                                    <div class="text-6xl font-extrabold text-white">100</div>
                                    <div class="text-base uppercase tracking-widest text-blue-400 font-semibold mt-1">Performance</div>
                                </div>
                            </div>
                            <div class="mt-8 grid grid-cols-3 gap-4 text-center w-full max-w-xs mx-auto">
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
                            <div class="mt-6 flex items-center gap-2 text-[10px] text-slate-400 justify-center">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                Server Status: Operational
                            </div>
                        </div>
                        <style>
                            @keyframes spin-slow {
                                0% { transform: rotate(0deg); }
                                100% { transform: rotate(360deg); }
                            }
                            @keyframes spin-slow-reverse {
                                0% { transform: rotate(0deg); }
                                100% { transform: rotate(-360deg); }
                            }
                            .animate-spin-slow {
                                animation: spin-slow 6s linear infinite;
                                transform-origin: 50% 50%;
                            }
                            .animate-spin-slow-reverse {
                                animation: spin-slow-reverse 8s linear infinite;
                                transform-origin: 50% 50%;
                            }
                        </style>
        </div>
    </div>

    <!-- Divisor -->
    <div class="max-w-7xl mx-auto px-4 md:px-6 py-8 w-full">
        <div class="flex items-center gap-4">
            <div class="flex-1 h-px bg-gradient-to-r from-transparent via-blue-500/30 to-transparent"></div>
            <div class="w-2 h-2 rounded-full bg-blue-500/50"></div>
            <div class="flex-1 h-px bg-gradient-to-r from-transparent via-blue-500/30 to-transparent"></div>
        </div>
    </div>

    <!-- Servicio 5: Analítica y Reportes -->
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center gap-16 px-4 md:px-6 py-12 rounded-3xl border border-slate-800/40 bg-gradient-to-br from-slate-900/20 to-transparent backdrop-blur-sm transition-all duration-500 hover:border-blue-500/30 hover:bg-gradient-to-br hover:from-blue-900/10 hover:to-transparent hover:shadow-[0_0_40px_rgba(59,130,246,0.1)] w-full">
        <div class="w-full md:w-1/2">
            <div class="inline-flex items-center gap-2 text-blue-400 text-xs uppercase tracking-widest mb-3">
                <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                Analítica
            </div>
            <h3 class="text-3xl font-bold text-white mb-4">Analítica y Reportes Avanzados</h3>
            <p class="text-slate-400 text-lg leading-relaxed mb-6">
                Datos en tiempo real para tomar decisiones más inteligentes. Dashboards intuitivos con métricas de ventas, ingresos, y leads.  
            </p>
            <ul class="space-y-3 mb-6">
                <li class="flex items-start gap-3 text-slate-300">
                    <svg class="w-5 h-5 text-blue-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Gráficos interactivos leads y ventas.
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
            <a href="login" class="text-blue-400 font-semibold hover:text-blue-300 transition-colors">Explorar reportes →</a>
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
                <div class="p-6" style="min-height:260px;display:flex;align-items:center;justify-content:center;">
                    <div style="width:100%;max-width:520px;min-width:320px;min-height:220px;position:relative;border:2px dashed #3b82f6; border-radius:12px; background:rgba(30,41,59,0.7);padding:12px;">
                        <canvas id="ventasChart" width="480" height="180" style="display:block;width:100%;max-width:480px;"></canvas>
                    </div>
                    <div class="mt-6 h-px bg-slate-800"></div>
                    <script src="/js/chart.min.js"></script>
                    <script>
                    let ventasChartInstance = null;
                    function renderVentasChart() {
                        var canvas = document.getElementById('ventasChart');
                        if (!canvas) { return; }
                        var ctx = canvas.getContext('2d');
                        if (ventasChartInstance) {
                            ventasChartInstance.destroy();
                        }
                        ventasChartInstance = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul'],
                                datasets: [{
                                    label: 'Ventas',
                                    data: [12, 19, 17, 22, 15, 25, 20],
                                    backgroundColor: [
                                        'rgba(59,130,246,0.9)',
                                        'rgba(59,130,246,0.7)',
                                        'rgba(59,130,246,0.7)',
                                        'rgba(59,130,246,1)',
                                        'rgba(59,130,246,0.7)',
                                        'rgba(59,130,246,0.7)',
                                        'rgba(59,130,246,0.7)'
                                    ],
                                    borderRadius: 8,
                                    borderSkipped: false,
                                    hoverBackgroundColor: 'rgba(59,130,246,1)',
                                    barPercentage: 0.7,
                                    categoryPercentage: 0.6,
                                }]
                            },
                            options: {
                                responsive: false,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: { display: false },
                                    tooltip: {
                                        backgroundColor: '#1e293b',
                                        titleColor: '#fff',
                                        bodyColor: '#60a5fa',
                                        borderColor: '#3b82f6',
                                        borderWidth: 1,
                                        padding: 12,
                                        callbacks: {
                                            label: function(context) {
                                                return ' Ventas: ' + context.parsed.y;
                                            }
                                        }
                                    },
                                },
                                scales: {
                                    x: {
                                        grid: { display: false },
                                        ticks: { color: '#cbd5e1', font: { weight: 'bold' } }
                                    },
                                    y: {
                                        grid: { color: 'rgba(59,130,246,0.08)' },
                                        ticks: { color: '#64748b', stepSize: 5 }
                                    }
                                }
                            }
                        });
                    }
                    // Intersection Observer para reiniciar el gráfico al entrar al viewport
                    document.addEventListener('DOMContentLoaded', function() {
                        var chartSection = document.getElementById('ventasChart');
                        if (!chartSection) return;
                        let firstLoad = true;
                        let observer = new window.IntersectionObserver((entries) => {
                            entries.forEach(entry => {
                                if (entry.isIntersecting) {
                                    // Solo animar si no está visible
                                    renderVentasChart();
                                } else {
                                    // Opcional: destruir el gráfico al salir
                                    // if (ventasChartInstance) ventasChartInstance.destroy();
                                }
                            });
                        }, { threshold: 0.5 });
                        observer.observe(chartSection);
                    });
                    </script>
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll Indicator -->
    <div class="max-w-7xl mx-auto px-4 md:px-6 py-10 w-full">
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


<!-- Otros servicios que ofrecemos -->
<section class="bg-[#020617] py-24 w-full overflow-x-hidden">
    <div class="max-w-7xl mx-auto px-4 md:px-6">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Otros servicios que ofrecemos</h2>
            <p class="text-lg text-slate-400 max-w-3xl mx-auto">Además de nuestra plataforma SaaS, brindamos soluciones de marketing digital para potenciar tu concesionaria.</p>
        </div>
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center gap-16 px-4 md:px-6 py-12 rounded-3xl border border-blue-500/20 bg-gradient-to-br from-blue-900/20 to-transparent backdrop-blur-sm shadow-[0_0_40px_rgba(59,130,246,0.08)] w-full">
            <div class="w-full md:w-1/2">
                <div class="inline-flex items-center gap-2 text-blue-400 text-xs uppercase tracking-widest mb-3">
                    <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                    Marketing Digital
                </div>
                <h3 class="text-3xl font-bold text-white mb-4">Impulsá tu concesionaria en redes</h3>
                <p class="text-slate-400 text-lg leading-relaxed mb-6">
                    Servicios profesionales para potenciar tu presencia digital y atraer más clientes.
                </p>
                <ul class="space-y-4 text-base text-blue-100 mb-8">
                    <li class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Community manager y gestión de redes sociales.
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Fotografía profesional y edición de contenido.
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Métricas, reportes y análisis de campañas.
                    </li>
                </ul>
                <a href="https://wa.me/5493413365206" target="_blank" rel="noopener" class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-all">
                    Consultanos
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>
            </div>
            <div class="w-full md:w-1/2 flex items-center justify-center">
                <svg width="320" height="220" viewBox="0 0 320 220" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="10" y="10" width="300" height="200" rx="32" fill="url(#bgGradientMarketing)" stroke="#1e293b" stroke-width="2"/>
                    <ellipse cx="160" cy="80" rx="48" ry="32" fill="#1e293b" fill-opacity="0.7"/>
                    <circle cx="160" cy="80" r="24" fill="#2563eb" fill-opacity="0.8"/>
                    <circle cx="160" cy="80" r="12" fill="#60a5fa" fill-opacity="0.8"/>
                    <rect x="80" y="140" width="48" height="24" rx="10" fill="#2563eb" fill-opacity="0.7"/>
                    <rect x="192" y="140" width="48" height="24" rx="10" fill="#2563eb" fill-opacity="0.7"/>
                    <circle cx="104" cy="152" r="6" fill="#60a5fa"/>
                    <circle cx="216" cy="152" r="6" fill="#60a5fa"/>
                    <text x="160" y="200" text-anchor="middle" font-size="18" fill="#60a5fa" font-family="sans-serif">Marketing Digital</text>
                    <defs>
                        <linearGradient id="bgGradientMarketing" x1="10" y1="10" x2="310" y2="210" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#0f172a"/>
                            <stop offset="1" stop-color="#1e293b"/>
                        </linearGradient>
                    </defs>
                </svg>
            </div>
        </div>
    </div>
</section>

<!-- Stock Control Section -->


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
                            <a href="https://wa.me/5493413365206" class="text-lg text-white hover:text-blue-400 transition-colors font-semibold">Consultar directo</a>
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
                    <?php echo csrf_field(); ?>
                    
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
<?php if (isset($component)) { $__componentOriginal8a8716efb3c62a45938aca52e78e0322 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8a8716efb3c62a45938aca52e78e0322 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.footer','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('footer'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8a8716efb3c62a45938aca52e78e0322)): ?>
<?php $attributes = $__attributesOriginal8a8716efb3c62a45938aca52e78e0322; ?>
<?php unset($__attributesOriginal8a8716efb3c62a45938aca52e78e0322); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8a8716efb3c62a45938aca52e78e0322)): ?>
<?php $component = $__componentOriginal8a8716efb3c62a45938aca52e78e0322; ?>
<?php unset($__componentOriginal8a8716efb3c62a45938aca52e78e0322); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.landing', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Juan Gonzalez\Desktop\JuanMauro\ProyectoAutos\resources\views/landing/home.blade.php ENDPATH**/ ?>