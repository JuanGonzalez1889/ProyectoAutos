
<?php $__env->startSection('content'); ?>
<div class="max-w-[1280px] mx-auto px-6 py-16">
    <div class="mb-10">
        <p class="text-sm uppercase tracking-[0.2em] mb-1" style="color: var(--text-muted-on-secondary);">Inventario</p>
        <h1 class="text-4xl font-semibold" style="color: var(--text-on-secondary);">Vehículos Disponibles</h1>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        <?php $__empty_1 = true; $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <article class="rounded-2xl overflow-hidden transition hover:-translate-y-1 hover:shadow-xl" style="border: 1px solid var(--border-on-secondary); background: var(--secondary-color);">
                <a href="<?php echo e(route('public.vehiculos.show', $vehicle->id)); ?>">
                    <img src="<?php echo e($vehicle->main_image); ?>" alt="<?php echo e($vehicle->title); ?>" class="w-full h-56 object-cover">
                </a>
                <div class="p-5">
                    <h2 class="text-xl font-semibold mb-1 line-clamp-1" style="color: var(--text-on-secondary);"><?php echo e($vehicle->title); ?></h2>
                    <p class="text-sm mb-3" style="color: var(--text-muted-on-secondary);"><?php echo e($vehicle->brand); ?> <?php echo e($vehicle->model); ?> · <?php echo e($vehicle->year); ?></p>
                    <p class="text-sm mb-4 line-clamp-2" style="color: var(--text-muted-on-secondary);"><?php echo e(Str::limit($vehicle->description, 100)); ?></p>
                    <div class="flex items-center justify-between gap-3">
                        <span class="font-bold text-lg" style="color: var(--text-on-secondary);">$<?php echo e(number_format($vehicle->price)); ?></span>
                        <a href="<?php echo e(route('public.vehiculos.show', $vehicle->id)); ?>" class="px-5 py-2 rounded-full text-sm font-medium transition hover:opacity-85" style="background: var(--primary-color); color: var(--text-on-primary);">Ver más</a>
                    </div>
                </div>
            </article>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-span-full text-center py-16" style="color: var(--text-muted-on-secondary);">
                <p class="text-lg">Aún no hay vehículos publicados.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('public.templates.autono-base', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Proyectos\ProyectoAutos\resources\views\public\vehiculos\index-autono.blade.php ENDPATH**/ ?>