<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['plan', 'price', 'period', 'features', 'popular' => false, 'cta', 'ctaLink']));

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

foreach (array_filter((['plan', 'price', 'period', 'features', 'popular' => false, 'cta', 'ctaLink']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<div class="relative <?php echo e($popular ? 'border-2 border-blue-500' : 'glass'); ?> rounded-xl p-8 hover-glow flex flex-col min-h-[440px]">
    <?php if($popular): ?>
        <div class="absolute -top-4 left-1/2 -translate-x-1/2" style="width: 59%">
            <span class="px-4 py-1 bg-blue-500 text-white text-xs font-bold rounded-full uppercase">El más elegido</span>
        </div>
    <?php endif; ?>
    
    <h3 class="text-lg font-semibold text-white mb-2"><?php echo e($plan); ?></h3>
    <div class="mb-6">
        <span class="text-4xl font-bold text-white">$<?php echo e($price); ?></span>
        <span class="text-gray-400 text-sm">/<?php echo e($period); ?></span>
    </div>
    
    <ul class="space-y-3 mb-8 flex-1">
        <?php $__currentLoopData = $features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li class="flex items-start gap-2">
            <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span class="text-sm text-gray-300"><?php echo e($feature); ?></span>
        </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
    
    <a href="<?php echo e($ctaLink); ?>" class="block w-full py-3 mt-auto <?php echo e($popular ? 'btn-gradient' : 'bg-white/5 hover:bg-white/10'); ?> rounded-lg text-center font-semibold text-white transition-all">
        <?php echo e($cta); ?>

    </a>
</div>
<?php /**PATH C:\Users\Juan Gonzalez\Desktop\JuanMauro\ProyectoAutos\resources\views/components/pricing-card.blade.php ENDPATH**/ ?>