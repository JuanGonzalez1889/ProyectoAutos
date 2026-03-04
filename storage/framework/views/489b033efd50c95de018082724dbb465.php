
<?php $__env->startSection('content'); ?>
<div class="max-w-[1280px] mx-auto px-6 py-16">
    <a href="<?php echo e(route('public.vehiculos')); ?>" class="inline-flex items-center gap-2 text-sm mb-8 transition hover:opacity-70" style="color: var(--primary-color);">
        ← Volver a vehículos
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
        
        <div>
            <img id="main-vehicle-image" src="<?php echo e($vehicle->main_image); ?>" alt="<?php echo e($vehicle->title); ?>" class="w-full h-[400px] object-cover rounded-2xl mb-4">
            <?php if($vehicle->images && count($vehicle->images) > 1): ?>
                <div class="grid grid-cols-4 gap-2">
                    <?php $__currentLoopData = $vehicle->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <img src="<?php echo e($img); ?>" alt="<?php echo e($vehicle->title); ?>" class="w-full h-20 object-cover rounded-lg cursor-pointer hover:opacity-80 transition" onclick="document.getElementById('main-vehicle-image').src = this.src">
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
        </div>

        
        <div>
            <h1 class="text-3xl font-bold mb-2" style="color: var(--text-on-secondary);"><?php echo e($vehicle->title); ?></h1>
            <p class="text-lg mb-4" style="color: var(--text-muted-on-secondary);"><?php echo e($vehicle->brand); ?> <?php echo e($vehicle->model); ?> · <?php echo e($vehicle->year); ?></p>
            <p class="text-3xl font-bold mb-6" style="color: var(--primary-color);">$<?php echo e(number_format($vehicle->price)); ?></p>

            <div class="grid grid-cols-2 gap-4 mb-6 p-5 rounded-xl" style="background: var(--tertiary-color);">
                <div>
                    <p class="text-xs uppercase tracking-wider mb-1" style="color: var(--text-muted-on-tertiary);">Kilómetros</p>
                    <p class="font-semibold" style="color: var(--text-on-tertiary);"><?php echo e(number_format($vehicle->kilometers)); ?> km</p>
                </div>
                <div>
                    <p class="text-xs uppercase tracking-wider mb-1" style="color: var(--text-muted-on-tertiary);">Color</p>
                    <p class="font-semibold" style="color: var(--text-on-tertiary);"><?php echo e($vehicle->color ?? '-'); ?></p>
                </div>
                <div>
                    <p class="text-xs uppercase tracking-wider mb-1" style="color: var(--text-muted-on-tertiary);">Combustible</p>
                    <p class="font-semibold" style="color: var(--text-on-tertiary);"><?php echo e($vehicle->fuel_type ?? '-'); ?></p>
                </div>
                <div>
                    <p class="text-xs uppercase tracking-wider mb-1" style="color: var(--text-muted-on-tertiary);">Transmisión</p>
                    <p class="font-semibold" style="color: var(--text-on-tertiary);"><?php echo e($vehicle->transmission ?? '-'); ?></p>
                </div>
            </div>

            <?php if($vehicle->description): ?>
                <div class="mb-6">
                    <h3 class="text-sm uppercase tracking-wider mb-2" style="color: var(--text-muted-on-secondary);">Descripción</h3>
                    <p class="leading-relaxed" style="color: var(--text-on-secondary); overflow-wrap: break-word; word-break: break-word;"><?php echo e($vehicle->description); ?></p>
                </div>
            <?php endif; ?>

            
            <div class="p-6 rounded-xl" style="border: 1px solid var(--border-on-secondary);">
                <h3 class="text-lg font-semibold mb-4" style="color: var(--text-on-secondary);">Consultar por este vehículo</h3>
                <form action="/contacto" method="POST" class="space-y-3">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="vehicle_id" value="<?php echo e($vehicle->id); ?>">
                    <input type="text" name="name" placeholder="Tu nombre" required class="w-full px-4 py-3 rounded-xl focus:outline-none" style="border: 1px solid var(--border-on-secondary); background: var(--secondary-color); color: var(--text-on-secondary);">
                    <input type="email" name="email" placeholder="Tu email" required class="w-full px-4 py-3 rounded-xl focus:outline-none" style="border: 1px solid var(--border-on-secondary); background: var(--secondary-color); color: var(--text-on-secondary);">
                    <input type="tel" name="phone" placeholder="Tu teléfono" required class="w-full px-4 py-3 rounded-xl focus:outline-none" style="border: 1px solid var(--border-on-secondary); background: var(--secondary-color); color: var(--text-on-secondary);">
                    <textarea name="message" rows="3" placeholder="Tu mensaje" required class="w-full px-4 py-3 rounded-xl focus:outline-none" style="border: 1px solid var(--border-on-secondary); background: var(--secondary-color); color: var(--text-on-secondary);">Consulta por: <?php echo e($vehicle->title); ?></textarea>
                    <button type="submit" class="w-full py-3 rounded-xl font-semibold transition hover:opacity-90" style="background: var(--primary-color); color: var(--text-on-primary);">Enviar consulta</button>
                </form>

                <?php if($vehicle->whatsapp ?? $settings->whatsapp ?? false): ?>
                    <a href="https://wa.me/<?php echo e(preg_replace('/[^0-9]/', '', $vehicle->whatsapp ?? $settings->whatsapp ?? '')); ?>?text=Hola! Estoy interesado en el <?php echo e($vehicle->title); ?>" target="_blank" class="mt-3 w-full py-3 rounded-xl font-semibold text-center block transition hover:opacity-90" style="background: #25d366; color: #fff;">
                        Consultar por WhatsApp
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('public.templates.autono-base', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Proyectos\ProyectoAutos\resources\views\public\vehiculos\show-autono.blade.php ENDPATH**/ ?>