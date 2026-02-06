<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'ctaLabel' => 'Prueba gratis',
    'ctaLink' => null,
    'ctaClass' => 'btn-gradient text-white hover:opacity-90',
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'ctaLabel' => 'Prueba gratis',
    'ctaLink' => null,
    'ctaClass' => 'btn-gradient text-white hover:opacity-90',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    $ctaLink = $ctaLink ?? route('register');
?>

<nav class="fixed top-0 left-0 right-0 z-50 glass">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <span class="text-lg font-bold text-white">AutoWeb Pro</span>
            </div>
            
            <!-- Navigation Links -->
            <div class="hidden md:flex items-center gap-8">
                <a href="<?php echo e(route('landing.home')); ?>" data-nav="inicio" class="text-sm relative text-gray-300 hover:text-white font-medium">
                    Inicio
                    <span class="inicio-underline <?php echo e(request()->routeIs('landing.home') ? '' : 'hidden'); ?> absolute -bottom-2 left-0 h-0.5 w-full bg-blue-500 rounded-full"></span>
                </a>
                <a href="<?php echo e(route('landing.home')); ?>#servicios" data-nav="servicios" class="text-sm relative text-gray-300 hover:text-white font-medium">
                    Servicios
                    <span class="servicios-underline hidden absolute -bottom-2 left-0 h-0.5 w-full bg-blue-500 rounded-full"></span>
                </a>
                <a href="<?php echo e(route('landing.nosotros')); ?>" data-nav="nosotros" class="text-sm relative <?php echo e(request()->routeIs('landing.nosotros') ? 'text-white font-semibold' : 'text-gray-300 hover:text-white font-medium'); ?>">
                    Nosotros
                    <?php if(request()->routeIs('landing.nosotros')): ?>
                    <span class="absolute -bottom-2 left-0 h-0.5 w-full bg-blue-500 rounded-full"></span>
                    <?php endif; ?>
                </a>
                <a href="<?php echo e(route('landing.proximamente')); ?>" data-nav="proximamente" class="text-sm font-bold animate-pulse relative <?php echo e(request()->routeIs('landing.proximamente') ? 'text-purple-300' : 'text-purple-400'); ?>">
                    Próximamente
                    <span class="absolute -bottom-2 left-0 h-0.5 w-full <?php echo e(request()->routeIs('landing.proximamente') ? 'bg-purple-300/80' : 'bg-purple-400/80'); ?> rounded-full"></span>
                </a>
                <a href="<?php echo e(route('landing.precios')); ?>" data-nav="precios" class="text-sm relative <?php echo e(request()->routeIs('landing.precios') ? 'text-white font-semibold' : 'text-gray-300 hover:text-white font-medium'); ?>">
                    Precios
                    <?php if(request()->routeIs('landing.precios')): ?>
                    <span class="absolute -bottom-2 left-0 h-0.5 w-full bg-blue-500 rounded-full"></span>
                    <?php endif; ?>
                </a>
            </div>
            
            <!-- CTA Buttons -->
            <div class="flex items-center gap-3">
                <a href="<?php echo e(route('login')); ?>" class="text-sm font-medium text-gray-300 hover:text-white">Login</a>
                <a href="<?php echo e($ctaLink); ?>" class="px-5 py-2 rounded-lg text-sm font-semibold <?php echo e($ctaClass); ?>">
                    <?php echo e($ctaLabel); ?>

                </a>
            </div>
        </div>
    </div>
</nav>
<?php /**PATH C:\Users\Juan Gonzalez\Desktop\JuanMauro\ProyectoAutos\resources\views/components/navbar.blade.php ENDPATH**/ ?>