<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/storage/icono.png">
    <title><?php echo e($tenant->name ?? 'Agencia de Autos'); ?> - Vehículos en Venta</title>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
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

        /* Estilo Glassmorphism */
        .glass { 
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.15);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.25);
        }
        .btn-gradient {
            background: linear-gradient(135deg, var(--primary-color), var(--tertiary-color));
            color: #fff;
        }

        <?php if(isset($editMode) && $editMode): ?>
        .editable-section { position: relative; outline: 2px dashed rgba(59,130,246,0.4); outline-offset: 4px; }
        .editable-section:hover .edit-btn,
        .editable-section .edit-btn:hover,
        .editable-section .edit-btn:focus {
            display: flex !important;
        }
        .edit-btn { display: inline-flex !important; align-items: center; justify-content: center; background: #3b82f6 !important; color: #fff !important; border-radius: 50%; font-size: 18px !important; padding: 4px !important; margin-left: 6px; cursor: pointer; z-index: 9999 !important; box-shadow: 0 2px 8px rgba(0,0,0,0.15); border: none; position: absolute; top: 8px; right: 8px; }
        <?php endif; ?>
    </style>
</head>
<body style="background: radial-gradient(circle at 20% 50%, rgba(0, 208, 132, 0.08), transparent 50%), radial-gradient(circle at 80% 80%, rgba(255, 170, 0, 0.06), transparent 50%), var(--secondary-color);" class="text-white">
    <!-- Navbar -->
    <nav class="sticky top-0 z-50" style="background: rgba(255,255,255,0.06); backdrop-filter: blur(12px); border-bottom: 1px solid rgba(255,255,255,0.15);">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <?php if(isset($editMode) && $editMode): ?>
                    <div class="editable-section inline-block relative">
                        <?php if($settings && $settings->logo_url): ?>
                            <img src="<?php echo e($settings->logo_url); ?>" alt="<?php echo e($tenant->name); ?>" class="h-10 object-contain">
                        <?php else: ?>
                            <div class="h-10 w-10 rounded-lg" style="background-color: var(--primary-color);"></div>
                        <?php endif; ?>
                        <div class="edit-btn" onclick="editImage('logo_url')"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="18" height="18" fill="currentColor" style="vertical-align:middle"><path d="M12.146 2.146a1 1 0 0 1 1.414 0l.294.294a1 1 0 0 1 0 1.414l-8.5 8.5a1 1 0 0 1-.293.207l-2.5 1.25a.5.5 0 0 1-.66-.66l1.25-2.5a1 1 0 0 1 .207-.293l8.5-8.5zm1.414-1.414a2 2 0 0 0-2.828 0l-8.5 8.5a2 2 0 0 0-.414.586l-1.25 2.5A1.5 1.5 0 0 0 2.5 14.5l2.5-1.25a2 2 0 0 0 .586-.414l8.5-8.5a2 2 0 0 0 0-2.828l-.294-.294z"/></svg></div>
                    </div>
                    <?php
                        $showAgencyName = isset($tenant->name) && trim($tenant->name) !== '';
                    ?>
                    <div class="editable-section inline-block relative ml-2 align-middle" style="min-width: 120px; min-height: 40px; display: flex; align-items: center; gap: 8px;">
                        <?php if($showAgencyName): ?>
                            <span class="text-xl font-bold" style="color: <?php echo e($settings->agency_name_color ?? '#fff'); ?>; min-width: 80px; display: inline-block;"><?php echo e($tenant->name); ?></span>
                        <?php endif; ?>
                        <button type="button" class="edit-btn" style="position:static; display:flex; margin-left:4px; background:#3b82f6; color:#fff; width:32px; height:32px; border-radius:50%; align-items:center; justify-content:center; cursor:pointer; box-shadow:0 2px 8px rgba(0,0,0,0.3); z-index:50; border:none;" onclick="editText('agency_name','Editar Nombre de Agencia')"><i class="fa fa-pencil"></i></button>
                    </div>
                <?php else: ?>
                    <?php if($settings && $settings->logo_url): ?>
                        <img src="<?php echo e($settings->logo_url); ?>" alt="<?php echo e($tenant->name); ?>" class="h-10 object-contain">
                    <?php else: ?>
                        <div class="h-10 w-10 rounded-lg" style="background-color: var(--primary-color);"></div>
                    <?php endif; ?>
                    <span class="text-xl font-bold text-white align-middle"><?php echo e($tenant->name); ?></span>
                <?php endif; ?>
            </div>
            <div class="flex items-center gap-8">
                <div class="hidden md:flex gap-8">
                    <a href="#inicio" class="font-medium" style="color: <?php echo e($settings->navbar_links_color ?? 'var(--navbar-text-color, #fff)'); ?>">Inicio</a>
                    <a href="<?php echo e(route('public.vehiculos')); ?>" class="font-medium" style="color: <?php echo e($settings->navbar_links_color ?? 'var(--navbar-text-color, #fff)'); ?>">Vehículos</a>
                    <a href="#nosotros" class="font-medium" style="color: <?php echo e($settings->navbar_links_color ?? 'var(--navbar-text-color, #fff)'); ?>">Nosotros</a>
                    <a href="#contacto" class="font-medium" style="color: <?php echo e($settings->navbar_links_color ?? 'var(--navbar-text-color, #fff)'); ?>">Contacto</a>
                </div>
                <?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="px-4 py-2 rounded-lg font-medium text-white transition hover:opacity-80" style="background-color: var(--primary-color);">
                        Panel Admin
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Inicio -->
    <div id="inicio"></div>

    <!-- Hero Section -->
    <div class="relative min-h-[600px] flex items-center justify-center overflow-hidden">
        <?php if(isset($editMode) && $editMode): ?>
            <div class="absolute inset-0">
                <?php if($settings && $settings->banner_url): ?>
                    <img src="<?php echo e($settings->banner_url); ?>" alt="Banner" class="absolute inset-0 w-full h-full object-cover">
                <?php endif; ?>
                <div class="editable-section" style="position:absolute; top:16px; right:16px; z-index:51; width:40px; height:40px; display:flex; align-items:center; justify-content:center;">
                    <button type="button" class="edit-btn" style="position:static; display:flex; background:#3b82f6; color:#fff; width:40px; height:40px; border-radius:50%; align-items:center; justify-content:center; cursor:pointer; box-shadow:0 2px 8px rgba(0,0,0,0.3); z-index:51; border:none;" onclick="editImage('banner_url')"><i class="fa fa-pencil"></i></button>
                </div>
            </div>
        <?php else: ?>
            <?php if($settings && $settings->banner_url): ?>
                <img src="<?php echo e($settings->banner_url); ?>" alt="Banner" class="absolute inset-0 w-full h-full object-cover">
            <?php endif; ?>
        <?php endif; ?>
        <div class="absolute inset-0" style="background: radial-gradient(ellipse at top, rgba(255,255,255,0.08), transparent), linear-gradient(135deg, rgba(0,0,0,0.4), rgba(0,0,0,0.2))"></div>
        <div class="relative text-center text-white px-4">
            <div class="glass inline-block px-10 py-8 rounded-3xl">
                <?php if(isset($editMode) && $editMode): ?>
                    <div class="editable-section inline-block max-w-2xl mx-auto mb-6">
                        <p class="text-xl md:text-2xl font-extralight tracking-wide opacity-90" style="color: <?php echo e($settings->home_description_color ?? '#fff'); ?>"><?php echo e($settings->home_description ?? 'Descubre nuestro catálogo premium de vehículos'); ?></p>
                        <div class="edit-btn" onclick="editText('home_description','Editar Descripción Principal')"><i class="fa fa-pencil"></i></div>
                    </div>
                <?php else: ?>
                    <p class="text-xl md:text-2xl max-w-2xl mx-auto font-extralight tracking-wide opacity-90 mb-6" style="color: <?php echo e($settings->home_description_color ?? '#fff'); ?>"><?php echo e($settings->home_description ?? 'Descubre nuestro catálogo premium de vehículos'); ?></p>
                <?php endif; ?>
                <div class="w-full flex justify-center mt-6">
                  <a href="<?php echo e(route('public.vehiculos')); ?>" class="inline-block px-10 py-4 rounded-xl font-medium transition hover:opacity-90 hover:scale-105 transform btn-gradient shadow-lg">
                      Ver Catálogo ↓
                  </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Vehículos Section -->
    <?php if($settings->show_vehicles && $vehicles->count() > 0): ?>
        <div id="vehiculos" class="py-20 px-4">
            <div class="max-w-7xl mx-auto">
                <div class="mb-16 text-center">
                    <h3 class="text-5xl font-light tracking-tight mb-4 auto-contrast-title" style="letter-spacing: -0.02em;">Nuestro Catálogo</h3>
                    <p class="text-gray-300 text-lg"><?php echo e($vehicles->count()); ?> vehículos disponibles</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <?php $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="group rounded-2xl overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 glass">
                            <div class="relative h-40 bg-gray-700 overflow-hidden">
                                <img src="<?php echo e($vehicle->main_image); ?>" alt="<?php echo e($vehicle->title); ?>" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                <div class="absolute top-2 left-2">
                                    <span class="px-2 py-1 rounded text-xs font-bold" style="background-color: var(--primary-color); color: var(--secondary-color);">
                                        <?php echo e($vehicle->year); ?>

                                    </span>
                                </div>
                                <div class="absolute top-2 right-2">
                                    <span class="px-2 py-1 rounded text-xs font-bold text-white" style="background-color: var(--primary-color);">
                                        $<?php echo e(number_format($vehicle->price)); ?>

                                    </span>
                                </div>
                            </div>

                            <div class="p-4">
                                <h4 class="text-lg font-bold mb-2 line-clamp-1"><?php echo e($vehicle->title); ?></h4>
                                
                                <div class="text-xs text-gray-300 mb-3">
                                    <p><?php echo e($vehicle->brand); ?> <?php echo e($vehicle->model); ?></p>
                                </div>

                                <p class="text-gray-400 text-xs mb-3 line-clamp-2"><?php echo e(Str::limit($vehicle->description, 60)); ?></p>

                                <button type="button" 
                                    onclick="openContactForm('<?php echo e($vehicle->id); ?>', '<?php echo e($vehicle->title); ?>')"
                                    class="w-full py-2 rounded text-xs font-bold text-white transition hover:shadow-lg" 
                                    style="background: linear-gradient(135deg, var(--primary-color), var(--tertiary-color));">
                                    Consultar
                                </button>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Nosotros Section -->
    <div id="nosotros" class="py-20 px-4" style="background: linear-gradient(135deg, rgba(255,255,255,0.05), rgba(0,0,0,0.05));">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div class="glass p-8 rounded-3xl">
                    <h3 class="text-5xl font-light tracking-tight mb-6 auto-contrast-title" style="letter-spacing: -0.02em;">Sobre Nosotros</h3>
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
                        <div class="editable-section">
                            <p class="text-lg mb-8 leading-loose whitespace-pre-line font-light" style="color: <?php echo e($settings->nosotros_description_color ?? '#222'); ?>"><?php echo e($settings->nosotros_description ?? 'Somos una agencia de autos con más de 15 años de experiencia en el mercado automotriz.\n\nNuestro equipo de profesionales está comprometido en brindarte la mejor atención y asesoramiento.'); ?></p>
                            <div class="edit-btn" onclick="editText('nosotros_description','Editar Sección Nosotros')"><i class="fa fa-pencil"></i></div>
                        </div>
                        <div class="editable-section flex gap-6 mt-4">
                            <div class="text-center">
                                <div class="text-4xl font-bold" style="color: var(--primary-color);"><?php echo e($settings->stat1 ?? '150+'); ?></div>
                                <p class="text-gray-300"><?php echo e($settings->stat1_label ?? 'Autos Vendidos'); ?></p>
                            </div>
                            <div class="text-center">
                                <div class="text-4xl font-bold" style="color: var(--primary-color);"><?php echo e($settings->stat2 ?? '98%'); ?></div>
                                <p class="text-gray-300"><?php echo e($settings->stat2_label ?? 'Clientes Satisfechos'); ?></p>
                            </div>
                            <div class="text-center">
                                <div class="text-4xl font-bold" style="color: var(--primary-color);"><?php echo e($settings->stat3 ?? '24h'); ?></div>
                                <p class="text-gray-300"><?php echo e($settings->stat3_label ?? 'Atención al Cliente'); ?></p>
                            </div>
                            <div class="edit-btn self-center" onclick="editStats()"><i class="fa fa-pencil"></i></div>
                        </div>
                    <?php else: ?>
                        <p class="text-lg mb-8 leading-loose whitespace-pre-line font-light" style="color: <?php echo e($settings->nosotros_description_color ?? '#222'); ?>"><?php echo e($settings->nosotros_description ?? 'Somos una agencia de autos con más de 15 años de experiencia en el mercado automotriz.\n\nNuestro equipo de profesionales está comprometido en brindarte la mejor atención y asesoramiento.'); ?></p>
                        <div class="flex gap-6 mt-4">
                            <div class="text-center">
                                <div class="text-4xl font-bold" style="color: var(--primary-color);"><?php echo e($settings->stat1 ?? '150+'); ?></div>
                                <p class="text-gray-300"><?php echo e($settings->stat1_label ?? 'Autos Vendidos'); ?></p>
                            </div>
                            <div class="text-center">
                                <div class="text-4xl font-bold" style="color: var(--primary-color);"><?php echo e($settings->stat2 ?? '98%'); ?></div>
                                <p class="text-gray-300"><?php echo e($settings->stat2_label ?? 'Clientes Satisfechos'); ?></p>
                            </div>
                            <div class="text-center">
                                <div class="text-4xl font-bold" style="color: var(--primary-color);"><?php echo e($settings->stat3 ?? '24h'); ?></div>
                                <p class="text-gray-300"><?php echo e($settings->stat3_label ?? 'Atención al Cliente'); ?></p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="h-96 rounded-3xl overflow-hidden shadow-2xl glass <?php if(isset($editMode) && $editMode): ?> editable-section <?php endif; ?>">
                    <img src="<?php echo e($settings->nosotros_url ?? 'https://images.unsplash.com/photo-1487730116645-74489c95b41b?w=600&h=500&fit=crop'); ?>" alt="Nosotros" class="w-full h-full object-cover">
                    <?php if(isset($editMode) && $editMode): ?>
                        <div class="edit-btn" onclick="editImage('nosotros_url')"><i class="fa fa-pencil"></i></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Contacto Section -->
    <?php if($settings->show_contact_form): ?>
        <div id="contacto" class="py-20 px-4" style="background-color: rgba(0,0,0,0.2);">
            <div class="max-w-7xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    <div class="glass p-8 rounded-3xl">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-5xl font-light tracking-tight text-white" style="letter-spacing: -0.02em;">Contacta con Nosotros</h3>
                            <?php if(isset($editMode) && $editMode): ?>
                                <button onclick="editContact()" class="ml-4 bg-blue-600 text-white text-xs px-3 py-1 rounded shadow">Editar contacto</button>
                            <?php endif; ?>
                        </div>
                        <p class="text-gray-300 mb-8 text-lg"><?php echo e($settings->contact_message ?? 'Estamos disponibles para responder todas tus preguntas.'); ?></p>

                        <div class="space-y-6">
                            <?php if($settings->phone): ?>
                                <div class="flex items-start gap-4">
                                    <span class="text-3xl">📞</span>
                                    <div>
                                        <p class="font-bold text-white text-lg">Teléfono</p>
                                        <a href="tel:<?php echo e($settings->phone); ?>" class="text-gray-300 hover:text-white transition"><?php echo e($settings->phone); ?></a>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if($settings->email): ?>
                                <div class="flex items-start gap-4">
                                    <span class="text-3xl">✉️</span>
                                    <div>
                                        <p class="font-bold text-white text-lg">Email</p>
                                        <a href="mailto:<?php echo e($settings->email); ?>" class="text-gray-300 hover:text-white transition"><?php echo e($settings->email); ?></a>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if($settings->whatsapp): ?>
                                <div class="flex items-start gap-4">
                                    <span class="text-3xl">💬</span>
                                    <div>
                                        <p class="font-bold text-white text-lg">WhatsApp</p>
                                        <a href="https://wa.me/<?php echo e(preg_replace('/[^0-9]/', '', $settings->whatsapp)); ?>" target="_blank" class="text-gray-300 hover:text-white transition"><?php echo e($settings->whatsapp); ?></a>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mt-10 flex gap-4">
                            <?php if($settings->facebook_url): ?>
                                <a href="<?php echo e($settings->facebook_url); ?>" target="_blank" class="text-3xl hover:scale-125 transition">📘</a>
                            <?php endif; ?>
                            <?php if($settings->instagram_url): ?>
                                <a href="<?php echo e($settings->instagram_url); ?>" target="_blank" class="text-3xl hover:scale-125 transition">📷</a>
                            <?php endif; ?>
                            <?php if($settings->linkedin_url): ?>
                                <a href="<?php echo e($settings->linkedin_url); ?>" target="_blank" class="text-3xl hover:scale-125 transition">💼</a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <form action="<?php echo e(\App\Helpers\RouteHelper::publicContactRoute()); ?>" method="POST" class="space-y-5 glass p-8 rounded-3xl">
                        <?php echo csrf_field(); ?>
                        <input type="text" name="name" placeholder="Tu Nombre" required class="w-full px-5 py-3 rounded-lg bg-gray-700 text-white placeholder-gray-400 focus:outline-none focus:ring-2" style="--tw-ring-color: var(--primary-color);">
                        <input type="email" name="email" placeholder="Tu Email" required class="w-full px-5 py-3 rounded-lg bg-gray-700 text-white placeholder-gray-400 focus:outline-none focus:ring-2" style="--tw-ring-color: var(--primary-color);">
                        <input type="tel" name="phone" placeholder="Tu Teléfono" required class="w-full px-5 py-3 rounded-lg bg-gray-700 text-white placeholder-gray-400 focus:outline-none focus:ring-2" style="--tw-ring-color: var(--primary-color);">
                        <textarea name="message" placeholder="Tu Mensaje" rows="4" required class="w-full px-5 py-3 rounded-lg bg-gray-700 text-white placeholder-gray-400 focus:outline-none focus:ring-2" style="--tw-ring-color: var(--primary-color);"></textarea>
                        <input type="hidden" name="vehicle_id" id="vehicle_id">
                        <button type="submit" class="w-full py-3 rounded-lg font-bold text-white transition hover:shadow-2xl" style="background: linear-gradient(135deg, var(--primary-color), var(--tertiary-color));">
                            Enviar Mensaje
                        </button>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Footer -->
    <footer class="py-8 px-4" style="background-color: rgba(0,0,0,0.5); border-top: 1px solid rgba(255,255,255,0.1);">
        <div class="max-w-7xl mx-auto text-center">
            <p class="text-gray-400">© <?php echo e(date('Y')); ?> <?php echo e($tenant->name); ?>. Todos los derechos reservados.</p>
        </div>
    </footer>

    <?php if(isset($editMode) && $editMode): ?>
    <?php echo $__env->make('public.templates.partials.editor-scripts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?>

    <script>
        function openContactForm(vehicleId, vehicleTitle) {
            document.getElementById('vehicle_id').value = vehicleId;
            document.querySelector('textarea[name="message"]').value = `Consulta por: ${vehicleTitle}`;
            document.getElementById('contacto').scrollIntoView({ behavior: 'smooth' });
            document.querySelector('input[name="name"]').focus();
        }
    </script>
</body>
<?php if(isset($editMode) && $editMode): ?>
    <?php echo $__env->make('public.templates.partials.editor-scripts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>
</html>
<?php /**PATH C:\Proyectos\ProyectoAutos\resources\views/public/templates/moderno.blade.php ENDPATH**/ ?>