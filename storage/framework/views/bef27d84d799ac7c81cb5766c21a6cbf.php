

<?php $__env->startSection('title', 'Nosotros - AutoWeb Pro'); ?>

<?php $__env->startSection('content'); ?>
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

<!-- Sobre Nosotros Section -->
<section id="nosotros" class="py-24 px-4">
    <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
       
        <!-- Texto -->
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/5 border border-white/10 text-xs font-semibold uppercase tracking-wider text-blue-400 mb-4">
                <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
                Sobre Nosotros
            </div>
            <h2 class="text-3xl md:text-5xl font-bold text-white mb-6">
                Potenciando la próxima generación de
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-indigo-500">concesionarias</span>.
            </h2>
            <div class="space-y-6 text-base md:text-lg text-slate-400 leading-relaxed">
                <p>
                    En AutoWeb Pro, entendemos que la industria automotriz está evolucionando más rápido que nunca. Nuestra misión es cerrar la brecha entre la venta tradicional de vehículos y la demanda moderna de experiencias digitales fluidas.
                </p>
                <p>
                    Desarrollamos tecnología SaaS de vanguardia que permite a los concesionarios optimizar inventarios, automatizar el seguimiento de clientes potenciales y cerrar ventas desde cualquier lugar del mundo. No somos solo software; somos el motor de tu transformación digital
                </p>
            </div>
            
        </div>

        <!-- Visual -->
         <!-- Imagen ilustrativa -->
        <div class="hidden lg:block">
            <img src="/storage/nosotros.png" alt="Sobre Nosotros AutoWeb Pro" class="rounded-2xl shadow-2xl w-full h-auto object-cover" />
        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contacto Premium Section -->
<section id="contacto" class="py-24 px-4">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-5xl font-bold text-white">¿Necesitas una web diferente?</h2>
            <p class="text-slate-400 max-w-2xl mx-auto mt-3">
                Contanos tu idea o desafío y te ayudamos a transformarlo en una solución tecnológica real para tu negocio en tiempo récord.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Info -->
            <div class="lg:col-span-4 bg-slate-900/30 border border-slate-800 rounded-2xl p-8">
                <h3 class="text-xl font-bold text-white mb-8">Información de contacto</h3>
                <div class="space-y-6">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl bg-blue-500/10 border border-blue-500/20 flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8m-18 8h18a2 2 0 002-2V6a2 2 0 00-2-2H3a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Email</p>
                            <a href="mailto:hola@autowebpro.com" class="text-slate-200 hover:text-blue-400 transition-colors font-medium">hola@autowebpro.com</a>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl bg-blue-500/10 border border-blue-500/20 flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h2.28a2 2 0 011.94 1.52l.57 2.28a2 2 0 01-.45 1.9l-1.07 1.07a16 16 0 006.59 6.59l1.07-1.07a2 2 0 011.9-.45l2.28.57A2 2 0 0121 18.72V21a2 2 0 01-2 2h-1C9.16 23 1 14.84 1 4V3a2 2 0 012-2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">WhatsApp</p>
                            <a href="https://wa.me/5493413365206" class="text-slate-200 hover:text-blue-400 hover:drop-shadow-[0_0_12px_rgba(59,130,246,0.6)] transition-colors font-medium">Consultar directo</a>
                        </div>
                    </div>
                </div>
                <div class="mt-8 pt-6 border-t border-slate-800">
                    <p class="text-sm text-slate-400 leading-relaxed">Te respondemos a la brevedad para arrancar a trabajar juntos.</p>
                </div>
            </div>

            <!-- Formulario -->
            <div class="lg:col-span-8 bg-slate-900/30 border border-slate-800 rounded-2xl p-8">
                <form action="#" method="POST" class="space-y-6">
                    <?php echo csrf_field(); ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <input type="text" name="nombre" placeholder="Nombre completo" class="w-full bg-slate-950/80 border border-slate-800 rounded-lg px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all">
                        <input type="email" name="email" placeholder="Email corporativo" class="w-full bg-slate-950/80 border border-slate-800 rounded-lg px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all">
                    </div>
                    <textarea name="mensaje" rows="4" placeholder="Contanos sobre tu proyecto" class="w-full bg-slate-950/80 border border-slate-800 rounded-lg px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all resize-none"></textarea>
                    <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold py-4 rounded-lg hover:shadow-[0_0_25px_rgba(37,99,235,0.4)] transition-all">
                        Enviar mensaje
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

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

<?php echo $__env->make('layouts.landing', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Juan Gonzalez\Desktop\JuanMauro\ProyectoAutos\resources\views/landing/nosotros.blade.php ENDPATH**/ ?>