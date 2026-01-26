<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e($tenant->name ?? 'Agencia de Autos'); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --primary-color: <?php echo e($settings && $settings->primary_color ? $settings->primary_color : '#00d084'); ?>;
            --secondary-color: <?php echo e($settings && $settings->secondary_color ? $settings->secondary_color : '#0a0f14'); ?>;
            --tertiary-color: <?php echo e($settings && $settings->tertiary_color ? $settings->tertiary_color : '#ffaa00'); ?>;
        }
    </style>
</head>
<body class="bg-white">
    <?php ($template = 'clasico'); ?>
    <!-- Header Clásico -->
    <header style="background-color: var(--secondary-color);" class="text-white sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <?php if(isset($editMode) && $editMode): ?>
                        <div class="editable-section inline-block relative">
                            <?php if($settings && $settings->logo_url): ?>
                                <img src="<?php echo e($settings->logo_url); ?>" alt="<?php echo e($tenant->name); ?>" class="h-10 object-contain">
                            <?php endif; ?>
                            <div class="edit-btn" onclick="editImage('logo_url')">
                                <i class="fa fa-pencil"></i>
                            </div>
                        </div>
                        <div class="editable-section inline-block relative ml-2">
                            <h1 class="text-2xl font-bold" style="color: <?php echo e($settings->agency_name_color ?? '#fff'); ?>"><?php echo e($tenant->name); ?></h1>
                            <div class="edit-btn" onclick="editText('agency_name', 'Editar Nombre de Agencia')">
                                <i class="fa fa-pencil"></i>
                            </div>
                        </div>
                    <?php else: ?>
                        <?php if($settings && $settings->logo_url): ?>
                            <img src="<?php echo e($settings->logo_url); ?>" alt="<?php echo e($tenant->name); ?>" class="h-10 object-contain">
                        <?php endif; ?>
                        <h1 class="text-2xl font-bold"><?php echo e($tenant->name); ?></h1>
                    <?php endif; ?>
                </div>
                <div class="flex items-center gap-6">
                    <div class="hidden md:flex gap-6">
                        <a href="#inicio" class="text-white hover:opacity-80 transition font-medium">Inicio</a>
                        <a href="#vehiculos" class="text-white hover:opacity-80 transition font-medium">Vehículos</a>
                        <a href="#nosotros" class="text-white hover:opacity-80 transition font-medium">Nosotros</a>
                        <a href="#contacto" class="text-white hover:opacity-80 transition font-medium">Contacto</a>
                    </div>
                    <a href="<?php echo e(route('login')); ?>" class="border-2 border-white px-6 py-2 rounded hover:bg-white hover:text-gray-900 transition">
                        Ingresar
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Banner Clásico -->
    <div class="relative w-full h-64 md:h-80 lg:h-96 flex items-center justify-center bg-gray-200 overflow-hidden">
        <?php if(isset($editMode) && $editMode): ?>
            <div class="editable-section w-full h-full relative">
                <?php if($settings && $settings->banner_url): ?>
                    <img src="<?php echo e($settings->banner_url); ?>" alt="Banner" class="absolute inset-0 w-full h-full object-cover opacity-80">
                <?php endif; ?>
                <div class="edit-btn absolute top-4 right-4 z-20" onclick="editImage('banner_url')">
                    <i class="fa fa-pencil"></i>
                </div>
            </div>
            <div class="editable-section absolute inset-0 flex flex-col items-center justify-center z-10">
                <h1 class="text-5xl md:text-6xl font-black text-white drop-shadow-lg text-center">
                    <span style="color: <?php echo e($settings->home_description_color ?? '#fff'); ?>">
                        <?php echo e($settings->home_description ?? 'Bienvenido a nuestra agencia'); ?>

                    </span>
                </h1>
                <div class="edit-btn" onclick="editText('home_description', 'Editar Texto del Banner')">
                    <i class="fa fa-pencil"></i>
                </div>
            </div>
        <?php else: ?>
            <?php if($settings && $settings->banner_url): ?>
                <img src="<?php echo e($settings->banner_url); ?>" alt="Banner" class="absolute inset-0 w-full h-full object-cover opacity-80">
            <?php endif; ?>
            <div class="absolute inset-0 flex flex-col items-center justify-center z-10">
                <h1 class="text-5xl md:text-6xl font-black text-white drop-shadow-lg text-center"><?php echo e($settings->home_description ?? 'Bienvenido a nuestra agencia'); ?></h1>
            </div>
        <?php endif; ?>
    </div>

    <!-- Inicio -->
    <div id="inicio" class="max-w-6xl mx-auto px-6 py-8">
        <?php if(isset($editMode) && $editMode): ?>
            <div class="editable-section relative">
                <p class="text-lg" style="color: <?php echo e($settings->home_description_color ?? '#fff'); ?>"><?php echo e($settings->home_description ?? 'Bienvenido a nuestra agencia'); ?></p>
                <div class="edit-btn" onclick="editText('home_description', 'Editar Descripción de Inicio')">
                    <i class="fa fa-pencil"></i>
                </div>
            </div>
        <?php else: ?>
            <p class="text-lg text-gray-200"><?php echo e($settings->home_description ?? 'Bienvenido a nuestra agencia'); ?></p>
        <?php endif; ?>
    </div>

    <!-- Sección de Vehículos -->
    <?php if($settings->show_vehicles && $vehicles->count() > 0): ?>
        <div id="vehiculos" class="max-w-6xl mx-auto px-6 py-16 border-b" style="border-color: rgba(255,255,255,0.1);">
            <h2 class="text-4xl font-bold mb-12 text-center" style="color: var(--primary-color);">Nuestros Vehículos</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">
                <?php $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="border-2 rounded-lg overflow-hidden hover:shadow-xl hover:-translate-y-2 transition transform" style="border-color: var(--primary-color);">
                        <img src="<?php echo e($vehicle->main_image); ?>" alt="<?php echo e($vehicle->title); ?>" class="w-full h-40 object-cover">
                        <div class="p-4">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="text-lg font-bold flex-1"><?php echo e($vehicle->title); ?></h3>
                                <span class="font-bold text-sm" style="color: var(--primary-color);">$<?php echo e(number_format($vehicle->price)); ?></span>
                            </div>
                            <p class="text-gray-400 text-xs mb-2"><?php echo e($vehicle->brand); ?> <?php echo e($vehicle->model); ?> · <?php echo e($vehicle->year); ?></p>
                            <p class="text-gray-300 text-xs mb-3 line-clamp-1"><?php echo e(Str::limit($vehicle->description, 60)); ?></p>

                            <button onclick="openForm('<?php echo e($vehicle->id); ?>', '<?php echo e($vehicle->title); ?>')" class="w-full py-2 text-white font-semibold rounded text-xs transition hover:opacity-90" style="background: linear-gradient(135deg, var(--primary-color), var(--tertiary-color));">
                                Ver Detalles
                            </button>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Nosotros Section -->
    <div class="max-w-6xl mx-auto px-6 py-16 border-b" style="border-color: rgba(255,255,255,0.1);">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-4xl font-bold" style="color: var(--primary-color);">Sobre Nosotros</h2>
            <?php if(isset($editMode) && $editMode): ?>
                <button onclick="editText('nosotros_description','Texto de Nosotros')" class="bg-blue-600 text-white text-xs px-3 py-1 rounded">Editar texto</button>
            <?php endif; ?>
        </div>
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <div>
                <?php if(isset($editMode) && $editMode): ?>
                    <div class="editable-section relative mb-4">
                        <p class="text-lg mb-8 leading-relaxed whitespace-pre-line" style="color: <?php echo e($settings->nosotros_description_color ?? '#222'); ?>">
                            <?php echo e($settings->nosotros_description ?? 'Cuéntale a tus usuarios sobre tu agencia, experiencia y servicios.'); ?>

                        </p>
                        <div class="edit-btn" onclick="editText('nosotros_description', 'Editar Sección Nosotros')">
                            <i class="fa fa-pencil"></i>
                        </div>
                    </div>
                    <div class="editable-section grid grid-cols-3 gap-4">
                        <div class="text-center p-4 rounded" style="background-color: rgba(59, 130, 246, 0.1); border: 1px solid rgb(59, 130, 246);">
                            <div class="text-3xl font-bold" style="color: var(--primary-color);"><?php echo e($settings->stat1 ?? '150+'); ?></div>
                            <p class="text-gray-600 text-sm"><?php echo e($settings->stat1_label ?? 'Autos Vendidos'); ?></p>
                        </div>
                        <div class="text-center p-4 rounded" style="background-color: rgba(59, 130, 246, 0.1); border: 1px solid rgb(59, 130, 246);">
                            <div class="text-3xl font-bold" style="color: var(--primary-color);"><?php echo e($settings->stat2 ?? '98%'); ?></div>
                            <p class="text-gray-600 text-sm"><?php echo e($settings->stat2_label ?? 'Clientes Satisfechos'); ?></p>
                        </div>
                        <div class="text-center p-4 rounded" style="background-color: rgba(59, 130, 246, 0.1); border: 1px solid rgb(59, 130, 246);">
                            <div class="text-3xl font-bold" style="color: var(--primary-color);"><?php echo e($settings->stat3 ?? '24h'); ?></div>
                            <p class="text-gray-600 text-sm"><?php echo e($settings->stat3_label ?? 'Atención al Cliente'); ?></p>
                        </div>
                        <div class="edit-btn col-span-3 flex justify-center" onclick="editStats()">
                            <i class="fa fa-pencil"></i>
                        </div>
                    </div>
                <?php else: ?>
                    <p class="text-gray-700 text-lg mb-8 leading-relaxed whitespace-pre-line">
                        <span style="color: <?php echo e($settings->nosotros_description_color ?? '#222'); ?>">
                            <?php echo e($settings->nosotros_description ?? 'Cuéntale a tus usuarios sobre tu agencia, experiencia y servicios.'); ?>

                        </span>
                    </p>
                    <div class="grid grid-cols-3 gap-4">
                        <div class="text-center p-4 rounded" style="background-color: rgba(59, 130, 246, 0.1); border: 1px solid rgb(59, 130, 246);">
                            <div class="text-3xl font-bold" style="color: var(--primary-color);"><?php echo e($settings->stat1 ?? '150+'); ?></div>
                            <p class="text-gray-600 text-sm"><?php echo e($settings->stat1_label ?? 'Autos Vendidos'); ?></p>
                        </div>
                        <div class="text-center p-4 rounded" style="background-color: rgba(59, 130, 246, 0.1); border: 1px solid rgb(59, 130, 246);">
                            <div class="text-3xl font-bold" style="color: var(--primary-color);"><?php echo e($settings->stat2 ?? '98%'); ?></div>
                            <p class="text-gray-600 text-sm"><?php echo e($settings->stat2_label ?? 'Clientes Satisfechos'); ?></p>
                        </div>
                        <div class="text-center p-4 rounded" style="background-color: rgba(59, 130, 246, 0.1); border: 1px solid rgb(59, 130, 246);">
                            <div class="text-3xl font-bold" style="color: var(--primary-color);"><?php echo e($settings->stat3 ?? '24h'); ?></div>
                            <p class="text-gray-600 text-sm"><?php echo e($settings->stat3_label ?? 'Atención al Cliente'); ?></p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <div class="relative rounded-lg overflow-hidden shadow-xl">
                <img src="<?php echo e($settings->nosotros_url ?? 'https://images.unsplash.com/photo-1487730116645-74489c95b41b?w=600&h=500&fit=crop'); ?>" alt="Nosotros" class="w-full h-full object-cover">
                <?php if(isset($editMode) && $editMode): ?>
                    <button onclick="editImage('nosotros_url')" class="absolute top-2 right-2 bg-blue-600 text-white text-xs px-3 py-1 rounded shadow">Cambiar imagen</button>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Sección de Contacto -->
    <?php if($settings->show_contact_form): ?>
        <div class="py-16 px-6" style="background: linear-gradient(135deg, rgba(<?php echo e($settings && $settings->primary_color ? $settings->primary_color : '#00d084'); ?>, 0.05), transparent);">
            <div class="max-w-6xl mx-auto" style="background-color: var(--secondary-color);" class="py-12 px-8 rounded">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-3xl font-bold text-white">Contáctenos</h2>
                    <?php if(isset($editMode) && $editMode): ?>
                        <button onclick="editContact()" class="bg-blue-600 text-white text-xs px-3 py-1 rounded">Editar contacto</button>
                    <?php endif; ?>
                </div>
                <div class="grid md:grid-cols-3 gap-8 mb-12">
                    <?php if($settings->phone): ?>
                        <div>
                            <h3 class="font-bold text-white mb-2">Teléfono</h3>
                            <a href="tel:<?php echo e($settings->phone); ?>" class="text-gray-300 hover:text-white transition"><?php echo e($settings->phone); ?></a>
                        </div>
                    <?php endif; ?>
                    <?php if($settings->email): ?>
                        <div>
                            <h3 class="font-bold text-white mb-2">Email</h3>
                            <a href="mailto:<?php echo e($settings->email); ?>" class="text-gray-300 hover:text-white transition"><?php echo e($settings->email); ?></a>
                        </div>
                    <?php endif; ?>
                    <?php if($settings->whatsapp): ?>
                        <div>
                            <h3 class="font-bold text-white mb-2">WhatsApp</h3>
                            <a href="https://wa.me/<?php echo e(preg_replace('/[^0-9]/', '', $settings->whatsapp)); ?>" target="_blank" class="text-gray-300 hover:text-white transition"><?php echo e($settings->whatsapp); ?></a>
                        </div>
                    <?php endif; ?>
                </div>
                <hr class="border-gray-700 mb-8">
                <form action="<?php echo e(route('public.contact')); ?>" method="POST" class="max-w-2xl">
                    <?php echo csrf_field(); ?>
                    <div class="grid md:grid-cols-2 gap-4 mb-4">
                        <input type="text" name="name" placeholder="Nombre Completo" required class="px-4 py-2 rounded bg-gray-700 text-white placeholder-gray-400 border border-gray-600">
                        <input type="email" name="email" placeholder="Correo Electrónico" required class="px-4 py-2 rounded bg-gray-700 text-white placeholder-gray-400 border border-gray-600">
                    </div>
                    <input type="tel" name="phone" placeholder="Teléfono" required class="w-full px-4 py-2 rounded bg-gray-700 text-white placeholder-gray-400 mb-4 border border-gray-600">
                    <textarea name="message" placeholder="Mensaje" rows="5" required class="w-full px-4 py-2 rounded bg-gray-700 text-white placeholder-gray-400 mb-4 border border-gray-600"></textarea>
                    <input type="hidden" name="vehicle_id" id="vehicle_id">
                    <button type="submit" class="px-8 py-3 rounded text-white font-bold transition hover:opacity-90" style="background: linear-gradient(135deg, var(--primary-color), var(--tertiary-color));">
                        Enviar Consulta
                    </button>
                </form>
            </div>
        </div>
    <?php endif; ?>

    <!-- Footer -->
    <footer style="background-color: var(--secondary-color);" class="text-white text-center py-8 border-t" style="border-color: rgba(255,255,255,0.1);">
        <p>© <?php echo e(date('Y')); ?> <?php echo e($tenant->name); ?> - TODOS LOS DERECHOS RESERVADOS</p>
    </footer>

    <script>
        function openForm(vehicleId, title) {
            document.getElementById('vehicle_id').value = vehicleId;
            document.querySelector('textarea[name="message"]').value = `Consulta sobre: ${title}\n`;
            document.querySelector('form').scrollIntoView({ behavior: 'smooth' });
            document.querySelector('input[name="name"]').focus();
        }
    </script>
    <?php if(isset($editMode) && $editMode): ?>
        <?php echo $__env->make('public.templates.partials.editor-scripts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?>
</body>
</html>
<?php /**PATH C:\Users\Juan Gonzalez\Desktop\JuanMauro\ProyectoAutos\resources\views/public/templates/clasico.blade.php ENDPATH**/ ?>