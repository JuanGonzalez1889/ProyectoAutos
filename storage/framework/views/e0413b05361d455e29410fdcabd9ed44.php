<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['title', 'description', 'icon']));

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

foreach (array_filter((['title', 'description', 'icon']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<div class="glass hover-glow rounded-xl p-6">
    <div class="w-12 h-12 rounded-lg bg-blue-500/20 flex items-center justify-center mb-4">
        <?php echo e($icon); ?>

    </div>
    <h3 class="text-lg font-semibold text-white mb-2"><?php echo e($title); ?></h3>
    <p class="text-sm text-gray-400 leading-relaxed"><?php echo e($description); ?></p>
</div>
<?php /**PATH C:\Proyectos\ProyectoAutos\resources\views\components\feature-card.blade.php ENDPATH**/ ?>