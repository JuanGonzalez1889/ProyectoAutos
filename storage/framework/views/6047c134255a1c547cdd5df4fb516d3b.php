
<?php $__env->startSection('content'); ?>
<style>
    .vehiculo-card-auto {
        color: var(--auto-text-color, #222);
        overflow-wrap: break-word;
        word-break: break-word;
    }
    .vehiculo-card-bg {
        background: var(--secondary-color);
        border-color: var(--primary-color);
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
<div class="max-w-7xl mx-auto px-4 py-12" style="font-family: <?php echo e($settings->font_family ?? 'inherit'); ?>;">
    <h1 class="text-4xl font-extrabold mb-10 text-center" style="color: var(--primary-color)">Vehículos Disponibles</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="rounded-xl shadow-lg overflow-hidden border flex flex-col vehiculo-card-bg">
                <div class="relative">
                    <img src="<?php echo e($vehicle->main_image); ?>" alt="<?php echo e($vehicle->title); ?>" class="w-full h-56 object-cover">
                    <span class="absolute top-2 left-2 text-white text-xs px-3 py-1 rounded" style="background: var(--primary-color);"><?php echo e($vehicle->year); ?></span>
                    <span class="absolute top-2 right-2 text-white text-xs px-3 py-1 rounded" style="background: var(--primary-color);">$<?php echo e(number_format($vehicle->price)); ?></span>
                </div>
                <div class="p-6 flex-1 flex flex-col">
                    <h2 class="text-2xl font-bold mb-1 vehiculo-card-auto"><?php echo e($vehicle->title); ?></h2>
                    <p class="mb-2 vehiculo-card-auto"><?php echo e($vehicle->brand); ?> <?php echo e($vehicle->model); ?></p>
                    <p class="text-sm mb-4 flex-1 vehiculo-card-auto"><?php echo e(Str::limit($vehicle->description, 80)); ?></p>
                    <a href="<?php echo e(route('public.vehiculos.show', $vehicle->id)); ?>" class="mt-auto inline-block px-4 py-2 rounded font-semibold text-center transition" style="background: var(--primary-color); color: var(--secondary-color);">Ver más</a>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('public.templates.clasico-base', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Proyectos\ProyectoAutos\resources\views\public\vehiculos\index-clasico.blade.php ENDPATH**/ ?>