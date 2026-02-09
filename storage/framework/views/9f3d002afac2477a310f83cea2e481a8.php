

<?php $__env->startSection('title', 'Precios - AutoWeb Pro'); ?>

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
                
            </div>
        </div>
    </section>

    <!-- Pricing Cards -->
    <section class="pb-24 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 max-w-6xl mx-auto">
                <!-- Plan Básico -->
                <?php if (isset($component)) { $__componentOriginalfa5dda94d5e1211c6ad7dcc9e6648aaa = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfa5dda94d5e1211c6ad7dcc9e6648aaa = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.pricing-card','data' => ['plan' => 'Básico','price' => '50.000','period' => 'mes','cta' => 'Empezar ahora','ctaLink' => ''.e(route('register')).'','features' => [
                        'Sitio web básico',
                        '15 autos publicados máximo',
                        'Soporte por whatsapp',
                        'Certificado SSL incluido',
                        '1 consulta mensual de Marketing',
                    ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('pricing-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['plan' => 'Básico','price' => '50.000','period' => 'mes','cta' => 'Empezar ahora','ctaLink' => ''.e(route('register')).'','features' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                        'Sitio web básico',
                        '15 autos publicados máximo',
                        'Soporte por whatsapp',
                        'Certificado SSL incluido',
                        '1 consulta mensual de Marketing',
                    ])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfa5dda94d5e1211c6ad7dcc9e6648aaa)): ?>
<?php $attributes = $__attributesOriginalfa5dda94d5e1211c6ad7dcc9e6648aaa; ?>
<?php unset($__attributesOriginalfa5dda94d5e1211c6ad7dcc9e6648aaa); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfa5dda94d5e1211c6ad7dcc9e6648aaa)): ?>
<?php $component = $__componentOriginalfa5dda94d5e1211c6ad7dcc9e6648aaa; ?>
<?php unset($__componentOriginalfa5dda94d5e1211c6ad7dcc9e6648aaa); ?>
<?php endif; ?>

                <!-- Plan Profesional (Popular) -->
                <?php if (isset($component)) { $__componentOriginalfa5dda94d5e1211c6ad7dcc9e6648aaa = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfa5dda94d5e1211c6ad7dcc9e6648aaa = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.pricing-card','data' => ['plan' => 'Profesional','price' => '150.000','period' => 'mes','cta' => 'Empezar ahora','ctaLink' => ''.e(route('register')).'','popular' => true,'features' => [
                        'Sitio web básico',
                        '30 autos publicados máximo',
                        'Integración CRM básica',
                        'Herramientas SEO avanzadas',
                        'Soporte básico',
                        'Certificado SSL incluido',
                        '2 consultas mensuales de Marketing',
                    ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('pricing-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['plan' => 'Profesional','price' => '150.000','period' => 'mes','cta' => 'Empezar ahora','ctaLink' => ''.e(route('register')).'','popular' => true,'features' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                        'Sitio web básico',
                        '30 autos publicados máximo',
                        'Integración CRM básica',
                        'Herramientas SEO avanzadas',
                        'Soporte básico',
                        'Certificado SSL incluido',
                        '2 consultas mensuales de Marketing',
                    ])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfa5dda94d5e1211c6ad7dcc9e6648aaa)): ?>
<?php $attributes = $__attributesOriginalfa5dda94d5e1211c6ad7dcc9e6648aaa; ?>
<?php unset($__attributesOriginalfa5dda94d5e1211c6ad7dcc9e6648aaa); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfa5dda94d5e1211c6ad7dcc9e6648aaa)): ?>
<?php $component = $__componentOriginalfa5dda94d5e1211c6ad7dcc9e6648aaa; ?>
<?php unset($__componentOriginalfa5dda94d5e1211c6ad7dcc9e6648aaa); ?>
<?php endif; ?>

                <!-- Plan Premium -->
                <?php if (isset($component)) { $__componentOriginalfa5dda94d5e1211c6ad7dcc9e6648aaa = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfa5dda94d5e1211c6ad7dcc9e6648aaa = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.pricing-card','data' => ['plan' => 'Premium','price' => '300.000','period' => 'mes','cta' => 'Empezar ahora','ctaLink' => ''.e(route('register')).'','features' => [
                        'Sitio web básico o personalizado',
                        'Publicaciones ilimitadas',
                        'Soporte Prioritario 24/7',
                        'CRM para gestionar clientes',
                        'Analítica avanzada',
                        'Certificado SSL incluido',
                        'Gestión de Marketing completa incluida',
                    ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('pricing-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['plan' => 'Premium','price' => '300.000','period' => 'mes','cta' => 'Empezar ahora','ctaLink' => ''.e(route('register')).'','features' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                        'Sitio web básico o personalizado',
                        'Publicaciones ilimitadas',
                        'Soporte Prioritario 24/7',
                        'CRM para gestionar clientes',
                        'Analítica avanzada',
                        'Certificado SSL incluido',
                        'Gestión de Marketing completa incluida',
                    ])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfa5dda94d5e1211c6ad7dcc9e6648aaa)): ?>
<?php $attributes = $__attributesOriginalfa5dda94d5e1211c6ad7dcc9e6648aaa; ?>
<?php unset($__attributesOriginalfa5dda94d5e1211c6ad7dcc9e6648aaa); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfa5dda94d5e1211c6ad7dcc9e6648aaa)): ?>
<?php $component = $__componentOriginalfa5dda94d5e1211c6ad7dcc9e6648aaa; ?>
<?php unset($__componentOriginalfa5dda94d5e1211c6ad7dcc9e6648aaa); ?>
<?php endif; ?>

                    <!-- Plan Premium + -->
                <?php if (isset($component)) { $__componentOriginalfa5dda94d5e1211c6ad7dcc9e6648aaa = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfa5dda94d5e1211c6ad7dcc9e6648aaa = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.pricing-card','data' => ['plan' => 'Premium +','price' => '500.000','period' => 'mes','cta' => 'Empezar ahora','ctaLink' => ''.e(route('register')).'','features' => [
                        'Sitio web básico o personalizado',
                        'Publicaciones ilimitadas',
                        'Soporte Prioritario 24/7',
                        'CRM para gestionar clientes',
                        'Analítica avanzada',
                        'Certificado SSL incluido',
                        'Gestión de Marketing completa incluida',
                        'Manejo de Redes Sociales completa incluida',
                        'Incluye fotos profesionales de tus autos',
                    ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('pricing-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['plan' => 'Premium +','price' => '500.000','period' => 'mes','cta' => 'Empezar ahora','ctaLink' => ''.e(route('register')).'','features' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                        'Sitio web básico o personalizado',
                        'Publicaciones ilimitadas',
                        'Soporte Prioritario 24/7',
                        'CRM para gestionar clientes',
                        'Analítica avanzada',
                        'Certificado SSL incluido',
                        'Gestión de Marketing completa incluida',
                        'Manejo de Redes Sociales completa incluida',
                        'Incluye fotos profesionales de tus autos',
                    ])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfa5dda94d5e1211c6ad7dcc9e6648aaa)): ?>
<?php $attributes = $__attributesOriginalfa5dda94d5e1211c6ad7dcc9e6648aaa; ?>
<?php unset($__attributesOriginalfa5dda94d5e1211c6ad7dcc9e6648aaa); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfa5dda94d5e1211c6ad7dcc9e6648aaa)): ?>
<?php $component = $__componentOriginalfa5dda94d5e1211c6ad7dcc9e6648aaa; ?>
<?php unset($__componentOriginalfa5dda94d5e1211c6ad7dcc9e6648aaa); ?>
<?php endif; ?>
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
                        Recibe las últimas noticias del mercado automotriz, consejos de ventas y actualizaciones de la
                        plataforma.
                    </p>
                </div>

                <form class="flex flex-col sm:flex-row gap-3 max-w-md mx-auto">
                    <input type="email" placeholder="tucorreo@empresa.com"
                        class="flex-1 px-4 py-3 bg-white/5 border border-white/10 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 transition-all"
                        required>
                    <button type="submit"
                        class="px-6 py-3 btn-gradient rounded-lg font-semibold text-white hover:opacity-90 transition-all">
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

<?php echo $__env->make('layouts.landing', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Juan Gonzalez\Desktop\JuanMauro\ProyectoAutos\resources\views/landing/precios.blade.php ENDPATH**/ ?>