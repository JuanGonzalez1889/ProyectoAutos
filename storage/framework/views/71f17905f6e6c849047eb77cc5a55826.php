

<?php $__env->startSection('title', 'Próximamente - AutoWeb Pro'); ?>

<?php $__env->startSection('content'); ?>
<?php if (isset($component)) { $__componentOriginala591787d01fe92c5706972626cdf7231 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala591787d01fe92c5706972626cdf7231 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.navbar','data' => ['ctaLabel' => 'Notificarme','ctaLink' => '#notificarme','ctaClass' => 'bg-white/10 hover:bg-white/20 border border-white/10 text-white']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('navbar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['cta-label' => 'Notificarme','cta-link' => '#notificarme','cta-class' => 'bg-white/10 hover:bg-white/20 border border-white/10 text-white']); ?>
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

<section class="pt-32 pb-16 px-4">
    <div class="max-w-6xl mx-auto text-center">
        <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/5 border border-white/10 rounded-full mb-6">
            <span class="w-2 h-2 bg-purple-400 rounded-full animate-pulse"></span>
            <span class="text-xs text-purple-200 tracking-widest">EN DESARROLLO ACTIVO</span>
        </div>

        <h1 class="text-4xl md:text-6xl font-bold text-white mb-4">
            El futuro de la venta automotriz
            <span class="block text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-blue-500">
                está muy cerca.
            </span>
        </h1>
        <p class="text-base md:text-lg text-gray-400 max-w-2xl mx-auto">
            Estamos construyendo herramientas avanzadas para potenciar tu concesionaria. Experimenta el siguiente nivel de gestión con funciones diseñadas para maximizar tu alcance.
        </p>
    </div>
</section>

<section class="pb-20 px-4">
    <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Multipublicador Card (Constelación) -->
        <div class="lg:col-span-2 relative bg-slate-900/40 backdrop-blur-2xl border border-slate-800 rounded-3xl p-12 overflow-hidden group hover:filter-none transition-all duration-300 filter blur-[1px] hover:blur-[0px]">
            <!-- Resplandor azul de fondo -->
            <div class="absolute inset-0 bg-blue-600/10 blur-[100px] rounded-full"></div>
            
            <!-- SVG Connector Lines -->
            <svg class="absolute inset-0 w-full h-full" style="pointer-events: none;">
                <!-- Línea a Mercado Libre (top-left) -->
                <line x1="50%" y1="50%" x2="25%" y2="20%" stroke="#3b82f6" stroke-width="2" stroke-dasharray="5,5" opacity="0.3" class="transition-opacity duration-300 group-hover:opacity-50"/>
                <!-- Línea a Marketplace (bottom-left) -->
                <line x1="50%" y1="50%" x2="20%" y2="75%" stroke="#3b82f6" stroke-width="2" stroke-dasharray="5,5" opacity="0.3" class="transition-opacity duration-300 group-hover:opacity-50"/>
                <!-- Línea a RosarioGarage (bottom-right) -->
                <line x1="50%" y1="50%" x2="80%" y2="75%" stroke="#3b82f6" stroke-width="2" stroke-dasharray="5,5" opacity="0.3" class="transition-opacity duration-300 group-hover:opacity-50"/>
                <!-- Línea a Instagram (top-right) -->
                <line x1="50%" y1="50%" x2="75%" y2="20%" stroke="#3b82f6" stroke-width="2" stroke-dasharray="5,5" opacity="0.3" class="transition-opacity duration-300 group-hover:opacity-50"/>
            </svg>

            <div class="relative h-96 flex flex-col items-center justify-center">
                <!-- Etiqueta Próximamente -->
                <div class="absolute top-0 flex justify-center w-full mb-8">
                    <span class="bg-blue-500/20 text-blue-400 border border-blue-500/30 rounded-full px-4 py-1 text-xs uppercase font-bold tracking-widest">Próximamente</span>
                </div>

                <!-- Núcleo Central (AutoWeb Pro) -->
                <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 z-20">
                    <div class="w-24 h-24 bg-blue-600 rounded-full flex items-center justify-center shadow-[0_0_40px_rgba(37,99,235,0.6)] border-2 border-blue-500/50 relative">
                        <!-- Check Icon -->
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                </div>

                <!-- Satélites - Top Left (Mercado Libre) -->
                <div class="absolute top-8 left-8 group-hover:animate-bounce" style="animation-delay: 0s;">
                    <div class="w-20 h-20 bg-slate-950 border border-slate-800 rounded-full flex items-center justify-center hover:border-blue-500/50 transition-all">
                        <img src="/storage/ml.png" alt="Mercado Libre" class="w-10 h-10 object-contain" />
                    </div>
                    <p class="text-xs text-gray-400 text-center mt-2">Mercado Libre</p>
                </div>

                <!-- Satélites - Bottom Left (Marketplace) -->
                <div class="absolute bottom-8 left-8 group-hover:animate-bounce" style="animation-delay: 0.2s;">
                    <div class="w-20 h-20 bg-slate-950 border border-slate-800 rounded-full flex items-center justify-center hover:border-blue-500/50 transition-all">
                        <svg viewBox="0 0 100 100" class="w-10 h-10">
                            <circle cx="50" cy="50" r="48" fill="#1e293b" stroke="#3b82f6" stroke-width="2"/>
                            <path d="M30 40h40l5 15H25l5-15zM25 55h50v20H25V55z" fill="#0866FF"/>
                            <rect x="42" y="60" width="16" height="15" fill="#1e293b"/>
                        </svg>
                    </div>
                    <p class="text-xs text-gray-400 text-center mt-2">Marketplace</p>
                </div>

                <!-- Satélites - Bottom Right (RosarioGarage) -->
                <div class="absolute bottom-8 right-8 group-hover:animate-bounce" style="animation-delay: 0.4s;">
                    <div class="w-20 h-20 bg-slate-950 border border-slate-800 rounded-full flex items-center justify-center hover:border-blue-500/50 transition-all">
                        <svg viewBox="0 0 100 100" class="w-10 h-10">
                            <circle cx="50" cy="50" r="48" fill="#1e293b" stroke="#3b82f6" stroke-width="2"/>
                            <path d="M50 25c-11 0-20 9-20 20 0 15 20 30 20 30s20-15 20-30c0-11-9-20-20-20z" fill="#EF4444"/>
                            <text x="50" y="52" text-anchor="middle" fill="white" font-family="Arial" font-weight="bold" font-size="20">R</text>
                        </svg>
                    </div>
                    <p class="text-xs text-gray-400 text-center mt-2">RosarioGarage</p>
                </div>

                <!-- Satélites - Top Right (Instagram) -->
                <div class="absolute top-8 right-8 group-hover:animate-bounce" style="animation-delay: 0.6s;">
                    <div class="w-20 h-20 bg-slate-950 border border-slate-800 rounded-full flex items-center justify-center hover:border-blue-500/50 transition-all">
                        <svg viewBox="0 0 100 100" class="w-10 h-10">
                            <circle cx="50" cy="50" r="48" fill="#1e293b" stroke="#3b82f6" stroke-width="2"/>
                            <rect x="30" y="30" width="40" height="40" rx="10" stroke="url(#insta-grad)" stroke-width="4" fill="none"/>
                            <circle cx="50" cy="50" r="10" stroke="url(#insta-grad)" stroke-width="4" fill="none"/>
                            <circle cx="62" cy="38" r="3" fill="url(#insta-grad)"/>
                            <defs>
                                <linearGradient id="insta-grad" x1="0%" y1="100%" x2="100%" y2="0%">
                                    <stop offset="0%" style="stop-color:#f09433"/>
                                    <stop offset="25%" style="stop-color:#e6683c"/>
                                    <stop offset="50%" style="stop-color:#dc2743"/>
                                    <stop offset="75%" style="stop-color:#cc2366"/>
                                    <stop offset="100%" style="stop-color:#bc1888"/>
                                </linearGradient>
                            </defs>
                        </svg>
                    </div>
                    <p class="text-xs text-gray-400 text-center mt-2">Instagram</p>
                </div>
            </div>

            <!-- Texto y descripción (debajo) -->
            <div class="relative text-center mt-8">
                <h3 class="text-2xl md:text-3xl font-bold text-white mb-2">Sincronización Total</h3>
                <p class="text-slate-400 text-sm md:text-base">Publica en todos los portales con un solo click</p>
            </div>
        </div>

        <div class="flex flex-col gap-6">
            <!-- Vendedor IA -->
            <div class="rounded-2xl border border-white/10 bg-slate-900/40 backdrop-blur-md p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-lg bg-purple-500/20 flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c1.657 0 3-1.343 3-3S13.657 2 12 2 9 3.343 9 5s1.343 3 3 3zm0 2c-2.761 0-5 2.239-5 5v5h10v-5c0-2.761-2.239-5-5-5z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-white">Vendedor IA</h3>
                </div>
                <p class="text-sm text-gray-400 mb-4">Un asistente virtual que atiende consultas 24/7, califica leads y agenda visitas automáticamente.</p>
                <div class="bg-white/5 rounded-lg p-3 text-xs text-gray-300">
                    <p class="mb-2">👤 Hola, ¿el Corolla sigue disponible?</p>
                    <p>🤖 ¡Sí! Tiene 12,000 km. ¿Te gustaría verlo mañana?</p>
                </div>
            </div>

            <!-- Smart Pricing -->
            <div class="rounded-2xl border border-white/10 bg-slate-900/40 backdrop-blur-md p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-lg bg-blue-500/20 flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3h2v18h-2V3zm-4 8h2v10H7V11zm8 4h2v6h-2v-6z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-white">Smart Pricing</h3>
                </div>
                <p class="text-sm text-gray-400 mb-4">Algoritmos que analizan el mercado en tiempo real para sugerir el precio óptimo de venta.</p>
                <div class="grid grid-cols-5 gap-2 items-end h-20">
                    <div class="bg-blue-500/40 h-6 rounded"></div>
                    <div class="bg-blue-500/40 h-10 rounded"></div>
                    <div class="bg-blue-500/40 h-4 rounded"></div>
                    <div class="bg-blue-500/40 h-14 rounded"></div>
                    <div class="bg-blue-500/40 h-8 rounded"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="notificarme" class="pb-20 px-4">
    <div class="max-w-3xl mx-auto text-center">
        <h2 class="text-2xl md:text-3xl font-bold text-white mb-4">¿Quieres acceso anticipado?</h2>
        <p class="text-gray-400 mb-6">Sé el primero en probar el Multipublicador cuando lancemos la beta cerrada.</p>
        <form action="<?php echo e(route('landing.newsletter')); ?>" method="POST" class="flex flex-col sm:flex-row gap-3 justify-center">
            <?php echo csrf_field(); ?>
            <input type="email" name="email" placeholder="Tu correo electrónico" class="w-full sm:w-96 px-4 py-3 bg-white/5 border border-white/10 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-purple-400 transition-all" required>
            <button type="submit" class="px-6 py-3 bg-purple-500 hover:bg-purple-600 rounded-lg font-semibold text-white transition-all">Unirme a la lista</button>
        </form>
        <p class="text-xs text-gray-500 mt-3">No enviamos spam. Solo notificaciones importantes de lanzamiento.</p>
    </div>
</section>

<footer class="border-t border-white/10 py-6 px-4">
    <div class="max-w-6xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4">
        <p class="text-xs text-gray-500">© 2026 AutoWeb Pro. Todos los derechos reservados.</p>
        <div class="flex items-center gap-6 text-xs text-gray-400">
            <a href="#" class="hover:text-white">Privacidad</a>
            <a href="#" class="hover:text-white">Términos</a>
            <a href="#" class="hover:text-white">Contacto</a>
        </div>
    </div>
</footer>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.landing', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Juan Gonzalez\Desktop\JuanMauro\ProyectoAutos\resources\views/landing/proximamente.blade.php ENDPATH**/ ?>