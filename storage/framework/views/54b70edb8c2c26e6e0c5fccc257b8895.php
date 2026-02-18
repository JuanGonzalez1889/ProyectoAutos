<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e($tenant->name ?? 'Agencia de Autos'); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <?php
        $font = $settings->font_family ?? '';
        $googleFonts = [
            'Roboto, sans-serif' => 'Roboto',
            'Open Sans, sans-serif' => 'Open+Sans',
            'Montserrat, sans-serif' => 'Montserrat',
            'Lato, sans-serif' => 'Lato',
            'Poppins, sans-serif' => 'Poppins',
            'Inter, sans-serif' => 'Inter',
            'Nunito, sans-serif' => 'Nunito',
            'Oswald, sans-serif' => 'Oswald',
            'Raleway, sans-serif' => 'Raleway',
            'Merriweather, serif' => 'Merriweather',
            'Playfair Display, serif' => 'Playfair+Display',
            'Muli, sans-serif' => 'Muli',
            'Quicksand, sans-serif' => 'Quicksand',
            'Source Sans Pro, sans-serif' => 'Source+Sans+Pro',
            'Work Sans, sans-serif' => 'Work+Sans',
            'PT Sans, sans-serif' => 'PT+Sans',
            'Ubuntu, sans-serif' => 'Ubuntu',
            'Fira Sans, sans-serif' => 'Fira+Sans',
        ];
        $fontUrl = isset($googleFonts[$font]) ? 'https://fonts.googleapis.com/css?family=' . $googleFonts[$font] . ':400,700&display=swap' : null;
    ?>
    <?php if($fontUrl): ?>
        <link href="<?php echo e($fontUrl); ?>" rel="stylesheet">
    <?php endif; ?>
    <style>
        :root {
            --primary-color: <?php echo e($settings && $settings->primary_color ? $settings->primary_color : '#00d084'); ?>;
            --secondary-color: <?php echo e($settings && $settings->secondary_color ? $settings->secondary_color : '#0a0f14'); ?>;
            --tertiary-color: <?php echo e($settings && $settings->tertiary_color ? $settings->tertiary_color : '#ffaa00'); ?>;
        }
        body { font-family: <?php echo e($settings->font_family ?? 'inherit'); ?>; }
        .edit-btn {
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            background: #2563eb !important;
            color: #fff !important;
            border-radius: 4px;
            font-size: 18px !important;
            padding: 4px 8px !important;
            margin-left: 6px;
            cursor: pointer;
            z-index: 9999 !important;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
            border: none;
        }
        .edit-btn i {
            color: #fff !important;
            font-size: 18px !important;
        }
    </style>
</head>
<body style="background-color: var(--secondary-color);" class="text-white">
    <?php ($template = 'minimalista'); ?>
    <!-- Navbar Minimalista -->
    <nav class="bg-gray-800 border-b border-gray-700 sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="editable-section inline-block relative">
                    <?php if($settings && $settings->logo_url): ?>
                        <img src="<?php echo e($settings->logo_url); ?>" alt="<?php echo e($tenant->name); ?>" class="h-8 object-contain">
                    <?php else: ?>
                        <div class="h-8 w-8 rounded flex items-center justify-center bg-gray-700">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </div>
                    <?php endif; ?>
                    <div class="edit-btn" onclick="editImage('logo_url')">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="18" height="18"><path d="M17.414 2.586a2 2 0 0 0-2.828 0l-9.192 9.192a2 2 0 0 0-.516.878l-1.414 4.243a1 1 0 0 0 1.272 1.272l4.243-1.414a2 2 0 0 0 .878-.516l9.192-9.192a2 2 0 0 0 0-2.828l-2.121-2.121zm-2.828 2.828l2.121 2.121-9.192 9.192-2.121-2.121 9.192-9.192z"/></svg>
                    </div>
                </div>
                <div class="editable-section inline-block relative ml-2">
                    <span class="font-semibold" style="color: <?php echo e($settings->navbar_agency_name_color ?? '#fff'); ?>"><?php echo e($settings->navbar_agency_name); ?></span>
                    <div class="edit-btn" onclick="editText('navbar_agency_name', 'Editar Nombre de Agencia')">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="18" height="18"><path d="M17.414 2.586a2 2 0 0 0-2.828 0l-9.192 9.192a2 2 0 0 0-.516.878l-1.414 4.243a1 1 0 0 0 1.272 1.272l4.243-1.414a2 2 0 0 0 .878-.516l9.192-9.192a2 2 0 0 0 0-2.828l-2.121-2.121zm-2.828 2.828l2.121 2.121-9.192 9.192-2.121-2.121 9.192-9.192z"/></svg>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-6">
                <div class="hidden md:flex gap-6">
                    <a href="#inicio" class="text-sm" style="color: <?php echo e($settings->navbar_links_color ?? 'var(--navbar-text-color, #fff)'); ?>">Inicio</a>
                    <a href="<?php echo e(route('public.vehiculos')); ?>" class="text-sm" style="color: <?php echo e($settings->navbar_links_color ?? 'var(--navbar-text-color, #fff)'); ?>">Vehículos</a>
                    <a href="#nosotros" class="text-sm" style="color: <?php echo e($settings->navbar_links_color ?? 'var(--navbar-text-color, #fff)'); ?>">Nosotros</a>
                    <a href="#contacto" class="text-sm" style="color: <?php echo e($settings->navbar_links_color ?? 'var(--navbar-text-color, #fff)'); ?>">Contacto</a>
                </div>
                <?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="text-sm font-medium text-white py-2 px-4 rounded" style="background-color: var(--primary-color);">
                        Admin
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Inicio -->
    <div id="inicio"></div>

    <?php echo $__env->yieldContent('content'); ?>

    <!-- Hero Simple -->
    <div class="max-w-6xl mx-auto px-6 py-0 border-b border-gray-700">
        <div class="flex flex-col md:flex-row items-stretch h-[350px] md:h-[400px] lg:h-[480px] mb-8">
            <!-- Lado izquierdo: texto editable -->
            <div class="flex-1 flex flex-col justify-center items-start p-8 bg-transparent relative z-10">
                <?php if(isset($editMode) && $editMode): ?>
                    <div class="editable-section inline-block relative mb-4">
                        <h1 class="text-5xl font-bold" style="color: <?php echo e($settings->hero_title_color ?? '#fff'); ?>"><?php echo e($settings->hero_title); ?></h1>
                        <div class="edit-btn" onclick="editText('hero_title', 'Editar Título del Hero')">
                            <i class="fa fa-pencil"></i>
                        </div>
                    </div>
                <?php else: ?>
                    <h1 class="text-5xl font-bold mb-4 auto-contrast-title"><?php echo e($settings->hero_title); ?></h1>
                <?php endif; ?>
                <div class="editable-section relative w-full">
                    <p class="text-xl max-w-2xl whitespace-pre-line" style="color: <?php echo e($settings->home_description_color ?? '#fff'); ?>">
                        <?php echo e($settings->home_description ?? 'Descubre nuestros vehículos'); ?>

                    </p>
                    <?php if(isset($editMode) && $editMode): ?>
                        <button onclick="editText('home_description','Texto de Inicio')" class="edit-btn absolute top-2 right-2 bg-blue-600 text-white text-xs px-2 py-1 rounded shadow">Editar</button>
                    <?php endif; ?>
                </div>
            </div>
            <!-- Lado derecho: imagen cuadrada -->
            <div class="flex-1 flex items-center justify-center relative overflow-hidden">
                <?php if(isset($editMode) && $editMode): ?>
                    <div class="editable-section w-full h-full relative flex items-center justify-center">
                        <?php if($settings && $settings->banner_url): ?>
                            <img src="<?php echo e($settings->banner_url); ?>" alt="Banner" class="object-cover w-full h-full max-h-[400px] max-w-[400px] rounded shadow-lg border-0">
                        <?php else: ?>
                            <div class="w-full h-full flex items-center justify-center bg-gray-700">
                                <svg class="w-16 h-16 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                        <?php endif; ?>
                        <div class="edit-btn absolute top-4 right-4 z-20" onclick="editImage('banner_url')">
                            <i class="fa fa-pencil"></i>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="relative w-full h-full flex items-center justify-center">
                        <?php if($settings && $settings->banner_url): ?>
                            <img src="<?php echo e($settings->banner_url); ?>" alt="Banner" class="object-cover w-full h-full max-h-[400px] max-w-[400px] rounded shadow-lg border-0">
                        <?php else: ?>
                            <div class="w-full h-full flex items-center justify-center bg-gray-700">
                                <svg class="w-16 h-16 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
    </div>

    <!-- Vehículos Lista Vertical -->
    <?php if($settings->show_vehicles && $vehicles->count() > 0): ?>
        <div class="max-w-6xl mx-auto px-6 py-12 border-b border-gray-700">
            <h2 class="text-3xl font-bold mb-8 auto-contrast-title">Vehículos Disponibles</h2>
            <div class="space-y-3">
                <?php $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-gray-800 p-4 rounded-lg border border-gray-700 hover:border-gray-600 hover:shadow-lg hover:-translate-y-1 transition transform" style="border-color: rgba(255,255,255,0.1);">
                        <div class="flex gap-4">
                            <div class="w-32 h-32 bg-gray-700 rounded flex-shrink-0">
                                <img src="<?php echo e($vehicle->main_image); ?>" alt="<?php echo e($vehicle->title); ?>" class="w-full h-full object-cover rounded">
                            </div>
                            <div class="flex-1">
                                <h3 class="text-xl font-bold mb-1"><?php echo e($vehicle->title); ?></h3>
                                <p class="text-gray-400 text-sm mb-2"><?php echo e($vehicle->brand); ?> <?php echo e($vehicle->model); ?> - <?php echo e($vehicle->year); ?></p>
                                <div class="flex gap-4 mb-3 text-sm">
                                    <div><span class="text-gray-400">Km:</span> <span class="font-semibold text-white"><?php echo e(number_format($vehicle->kilometers)); ?></span></div>
                                    <div><span class="text-gray-400">Precio:</span> <span class="font-semibold text-lg" style="color: var(--primary-color);">$<?php echo e(number_format($vehicle->price)); ?></span></div>
                                </div>
                                <p class="text-gray-300 text-sm mb-3 line-clamp-2"><?php echo e(Str::limit($vehicle->description, 150)); ?></p>
                                <a href="<?php echo e(route('public.vehiculos.show', $vehicle->id)); ?>" class="px-4 py-2 rounded text-white text-sm font-medium transition hover:opacity-90" style="background: linear-gradient(135deg, var(--primary-color), var(--tertiary-color));">Ver más</a>
                                <button onclick="openForm('<?php echo e($vehicle->id); ?>', '<?php echo e($vehicle->title); ?>')" class="ml-2 px-4 py-2 rounded text-white text-sm font-medium transition hover:opacity-90 bg-blue-700">Consultar</button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Nosotros Section -->
    <div id="nosotros" class="max-w-6xl mx-auto px-6 py-12 border-b border-gray-700">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-3xl font-bold auto-contrast-title">Sobre Nosotros</h2>
                <script>
                // Contraste automático para títulos principales y de sección
                function getContrastYIQ(hexcolor) {
                    hexcolor = hexcolor.replace('#', '');
                    if(hexcolor.length === 3) hexcolor = hexcolor.split('').map(x=>x+x).join('');
                    var r = parseInt(hexcolor.substr(0,2),16);
                    var g = parseInt(hexcolor.substr(2,2),16);
                    var b = parseInt(hexcolor.substr(4,2),16);
                    var yiq = ((r*299)+(g*587)+(b*114))/1000;
                    return (yiq >= 180) ? '#222' : '#fff';
                }
                function applyTitleContrast() {
                    let bg = getComputedStyle(document.body).backgroundColor;
                    let hex = window.getComputedStyle(document.body).getPropertyValue('--secondary-color') || '#fff';
                    if(hex.startsWith('#')) {
                        // ok
                    } else if(bg) {
                        // fallback: rgb to hex
                        let rgb = bg.match(/\d+/g);
                        if(rgb) hex = '#' + rgb.map(x=>(+x).toString(16).padStart(2,'0')).join('');
                    }
                    document.querySelectorAll('.auto-contrast-title').forEach(el=>{
                        el.style.color = getContrastYIQ(hex.trim());
                    });
                }
                document.addEventListener('DOMContentLoaded', applyTitleContrast);
                window.addEventListener('settings:updated', applyTitleContrast);
                </script>
            <?php if(isset($editMode) && $editMode): ?>
                <button onclick="editText('nosotros_description','Texto de Nosotros')" class="bg-blue-600 text-white text-xs px-3 py-1 rounded">Editar texto</button>
            <?php endif; ?>
        </div>
        <div class="grid md:grid-cols-2 gap-8 items-start">
            <div class="space-y-4">
                <p class="text-lg leading-relaxed whitespace-pre-line" style="color: <?php echo e($settings->nosotros_description_color ?? '#222'); ?>"><?php echo e($settings->nosotros_description ?? 'Cuéntale a tus usuarios sobre tu agencia, experiencia y servicios.'); ?></p>
                <div class="grid grid-cols-3 gap-4 mt-6 pt-6 border-t border-gray-700">
                    <div class="text-center">
                        <div class="text-3xl font-bold" style="color: var(--primary-color);"><?php echo e($settings->stat1 ?? '150+'); ?></div>
                        <p class="text-gray-400 text-sm"><?php echo e($settings->stat1_label ?? 'Autos Vendidos'); ?></p>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold" style="color: var(--primary-color);"><?php echo e($settings->stat2 ?? '98%'); ?></div>
                        <p class="text-gray-400 text-sm"><?php echo e($settings->stat2_label ?? 'Clientes Satisfechos'); ?></p>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold" style="color: var(--primary-color);"><?php echo e($settings->stat3 ?? '24h'); ?></div>
                        <p class="text-gray-400 text-sm"><?php echo e($settings->stat3_label ?? 'Atención al Cliente'); ?></p>
                    </div>
                </div>
                <?php if(isset($editMode) && $editMode): ?>
                    <button onclick="editStats()" class="mt-2 bg-blue-600 text-white text-xs px-3 py-1 rounded">Editar estadísticas</button>
                <?php endif; ?>
            </div>
            <div class="relative rounded overflow-hidden border border-gray-700">
                <img src="<?php echo e($settings->nosotros_url ?? 'https://images.unsplash.com/photo-1487730116645-74489c95b41b?w=900&h=600&fit=crop'); ?>" alt="Nosotros" class="w-full h-full object-cover">
                <?php if(isset($editMode) && $editMode): ?>
                    <button onclick="editImage('nosotros_url')" class="absolute top-2 right-2 bg-blue-600 text-white text-xs px-3 py-1 rounded shadow">Cambiar imagen</button>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Contacto Simple -->
    <?php if($settings->show_contact_form): ?>
        <div id="contacto" class="bg-gray-800 py-16 px-6 border-t border-gray-700">
            <div class="max-w-6xl mx-auto">
                <h2 class="text-3xl font-bold mb-12">Contacto</h2>
                
                <div class="grid md:grid-cols-2 gap-12">
                    <div>
                        <div class="relative">
                            <p class="text-gray-300 mb-6"><?php echo e($settings->contact_message); ?></p>
                        </div>
                        <div class="flex gap-2 mb-4">
                            <?php if(isset($editMode) && $editMode): ?>
                                <button onclick="editContact()" class="bg-blue-600 text-white text-xs px-3 py-1 rounded">Editar contacto</button>
                            <?php endif; ?>
                        </div>
                        <div class="space-y-2">
                            <div>
                                <span class="font-bold text-white">Teléfono:</span> <span class="text-gray-300"><?php echo e($settings->phone); ?></span>
                            </div>
                            <div>
                                <span class="font-bold text-white">Email:</span> <span class="text-gray-300"><?php echo e($settings->email); ?></span>
                            </div>
                            <div>
                                <span class="font-bold text-white">WhatsApp:</span> <span class="text-gray-300"><?php echo e($settings->whatsapp); ?></span>
                            </div>
                        </div>
                    </div>

                    <form action="<?php echo e(\App\Helpers\RouteHelper::publicContactRoute()); ?>" method="POST" class="space-y-4">
                        <?php echo csrf_field(); ?>
                        <input type="text" name="name" placeholder="Nombre" required class="w-full px-4 py-2 border border-gray-600 rounded bg-gray-700 text-white placeholder-gray-400">
                        <input type="email" name="email" placeholder="Email" required class="w-full px-4 py-2 border border-gray-600 rounded bg-gray-700 text-white placeholder-gray-400">
                        <input type="tel" name="phone" placeholder="Teléfono" required class="w-full px-4 py-2 border border-gray-600 rounded bg-gray-700 text-white placeholder-gray-400">
                        <textarea name="message" placeholder="Mensaje" rows="4" required class="w-full px-4 py-2 border border-gray-600 rounded bg-gray-700 text-white placeholder-gray-400"></textarea>
                        <input type="hidden" name="vehicle_id" id="vehicle_id">
                        <button type="submit" class="w-full py-2 rounded text-white font-medium transition hover:opacity-90" style="background: linear-gradient(135deg, var(--primary-color), var(--tertiary-color));">
                            Enviar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Footer -->
    <footer class="bg-gray-900 py-8 text-center text-gray-400 text-sm border-t border-gray-700">
        © <?php echo e(date('Y')); ?> <?php echo e($tenant->name); ?>

    </footer>

    <script>
        function openForm(vehicleId, title) {
            document.getElementById('vehicle_id').value = vehicleId;
            document.querySelector('textarea[name="message"]').value = `Consulta: ${title}`;
            document.querySelector('form').scrollIntoView({ behavior: 'smooth' });
        }
    </script>
    <?php if(isset($editMode) && $editMode): ?>
        <?php echo $__env->make('public.templates.partials.editor-scripts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?>
</body>
</html>
<?php /**PATH C:\Proyectos\ProyectoAutos\resources\views/public/templates/minimalista.blade.php ENDPATH**/ ?>