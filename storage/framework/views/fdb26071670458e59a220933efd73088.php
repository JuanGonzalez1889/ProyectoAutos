
<?php $__env->startSection('content'); ?>
<style>
    .vehiculo-card-auto {
        color: var(--auto-text-color, #222);
        overflow-wrap: break-word;
        word-break: break-word;
    }
</style>
<script>
    (function() {
        function getContrastYIQ(hexcolor){
            hexcolor = hexcolor.replace('#', '');
            if(hexcolor.length === 3) hexcolor = hexcolor.split('').map(x=>x+x).join('');
            var r = parseInt(hexcolor.substr(0,2),16);
            var g = parseInt(hexcolor.substr(2,2),16);
            var b = parseInt(hexcolor.substr(4,2),16);
            var yiq = ((r*299)+(g*587)+(b*114))/1000;
            return (yiq >= 180) ? '#222' : '#fff';
        }
        var root = document.documentElement;
        var bg = getComputedStyle(root).getPropertyValue('--secondary-color').trim();
        if(bg.startsWith('rgb')) {
            var rgb = bg.match(/\d+/g);
            var hex = '#' + rgb.map(x=>(+x).toString(16).padStart(2,'0')).join('');
            bg = hex;
        }
        root.style.setProperty('--auto-text-color', getContrastYIQ(bg));
    })();
</script>
<div class="max-w-4xl mx-auto px-4 py-12" style="font-family: <?php echo e($settings->font_family ?? 'inherit'); ?>;">
    <div class="flex flex-col md:flex-row gap-8">
        <div class="md:w-1/2">
            <img id="main-vehicle-image" src="<?php echo e($vehicle->main_image); ?>" alt="<?php echo e($vehicle->title); ?>" class="w-full h-80 object-cover rounded-2xl mb-4">
            <?php if($vehicle->images && count($vehicle->images) > 1): ?>
                <div class="grid grid-cols-4 gap-2">
                    <?php $__currentLoopData = $vehicle->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <img src="<?php echo e($img); ?>" alt="<?php echo e($vehicle->title); ?>" class="w-full h-20 object-cover rounded-lg cursor-pointer hover:opacity-80 transition" onclick="document.getElementById('main-vehicle-image').src = this.src">
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="md:w-1/2 flex flex-col">
            <h1 class="text-3xl font-extrabold mb-2 vehiculo-card-auto"><?php echo e($vehicle->title); ?></h1>
            <div class="flex gap-4 mb-2">
                <span class="text-white text-xs px-3 py-1 rounded" style="background: var(--primary-color);">Año: <?php echo e($vehicle->year); ?></span>
                <span class="text-white text-xs px-3 py-1 rounded" style="background: var(--primary-color);">Precio: $<?php echo e(number_format($vehicle->price)); ?></span>
            </div>
            <p class="mb-4 vehiculo-card-auto"><?php echo e($vehicle->brand); ?> <?php echo e($vehicle->model); ?></p>
            <p class="mb-6 vehiculo-card-auto"><?php echo e($vehicle->description); ?></p>
            <ul class="mb-6 text-sm vehiculo-card-auto">
                <li><strong>Kilómetros:</strong> <?php echo e(number_format($vehicle->kilometers)); ?></li>
                <li><strong>Color:</strong> <?php echo e($vehicle->color ?? '-'); ?></li>
                <li><strong>Combustible:</strong> <?php echo e($vehicle->fuel_type ?? '-'); ?></li>
                <li><strong>Transmisión:</strong> <?php echo e($vehicle->transmission ?? '-'); ?></li>
            </ul>
            <form action="/contacto" method="POST" class="mb-4">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="vehicle_id" value="<?php echo e($vehicle->id); ?>">
                <input type="text" name="name" placeholder="Tu Nombre" required class="w-full px-4 py-2 mb-2 rounded vehiculo-card-auto" style="background: var(--secondary-color);">
                <input type="email" name="email" placeholder="Tu Email" required class="w-full px-4 py-2 mb-2 rounded vehiculo-card-auto" style="background: var(--secondary-color);">
                <input type="tel" name="phone" placeholder="Tu Teléfono" required class="w-full px-4 py-2 mb-2 rounded vehiculo-card-auto" style="background: var(--secondary-color);">
                <textarea name="message" placeholder="Mensaje" rows="3" required class="w-full px-4 py-2 mb-2 rounded vehiculo-card-auto" style="background: var(--secondary-color);"></textarea>
                <button type="submit" class="w-full py-2 rounded font-semibold" style="background: var(--primary-color); color: var(--secondary-color);">Consultar</button>
            </form>
            <a href="https://wa.me/<?php echo e(preg_replace('/[^0-9]/', '', $vehicle->whatsapp ?? $settings->whatsapp ?? '')); ?>?text=Hola! Estoy interesado en el <?php echo e($vehicle->title); ?>" target="_blank" class="w-full py-2 rounded font-semibold text-center block" style="background: var(--tertiary-color); color: var(--primary-color);">Consultar por WhatsApp</a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('public.templates.moderno-base', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Proyectos\ProyectoAutos\resources\views\public\vehiculos\show-moderno.blade.php ENDPATH**/ ?>