<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($tenant->name ?? 'Agencia de Autos'); ?> - Vehículos Premium</title>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <script src="https://cdn.tailwindcss.com"></script>
    <?php
        $font = $settings->font_family ?? 'Playfair Display, serif';
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
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400&family=Cormorant+Garamond:wght@300;400;500;600&display=swap" rel="stylesheet">
    <?php if($fontUrl): ?>
        <link href="<?php echo e($fontUrl); ?>" rel="stylesheet">
    <?php endif; ?>
    <style>
        :root {
            --primary-color: <?php echo e($settings && $settings->primary_color ? $settings->primary_color : '#c9a96e'); ?>;
            --secondary-color: <?php echo e($settings && $settings->secondary_color ? $settings->secondary_color : '#0a0a0a'); ?>;
            --tertiary-color: <?php echo e($settings && $settings->tertiary_color ? $settings->tertiary_color : '#d4af37'); ?>;
        }
        body { font-family: <?php echo e($settings->font_family ?? "'Cormorant Garamond', serif"); ?>; }
        .font-display { font-family: 'Playfair Display', serif; }
        .font-body { font-family: 'Cormorant Garamond', serif; }

        /* Ornamental divider */
        .ornament {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .ornament::before, .ornament::after {
            content: '';
            flex: 1;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--primary-color), transparent);
        }
        .ornament-icon {
            color: var(--primary-color);
            font-size: 14px;
            letter-spacing: 8px;
        }

        /* Vehicle horizontal showcase card */
        .vehicle-showcase {
            display: grid;
            grid-template-columns: 55% 45%;
            min-height: 320px;
            border: 1px solid rgba(201,169,110,0.12);
            transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .vehicle-showcase:hover {
            border-color: rgba(201,169,110,0.35);
            box-shadow: 0 30px 80px rgba(0,0,0,0.4);
        }
        @media (max-width: 768px) {
            .vehicle-showcase {
                grid-template-columns: 1fr;
            }
        }

        <?php if(isset($editMode) && $editMode): ?>
        .editable-section { position: relative; outline: 2px dashed rgba(201,169,110,0.4); outline-offset: 4px; }
        .editable-section:hover .edit-btn,
        .editable-section .edit-btn:hover,
        .editable-section .edit-btn:focus {
            display: flex !important;
        }
        .edit-btn { position: absolute; top: 8px; right: 8px; background: var(--primary-color); color: #0a0a0a; width: 32px; height: 32px; border-radius: 50%; display: none; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 2px 8px rgba(0,0,0,0.3); z-index: 50; transition: background 0.2s; }
        <?php endif; ?>
    </style>
</head>
<body style="background-color: var(--secondary-color);" class="text-white">

    <!-- Navbar: Logo + name CENTERED, links below — diseño de joyería/fashion -->
    <nav class="sticky top-0 z-50" style="background: rgba(10,10,10,0.95); backdrop-filter: blur(20px); border-bottom: 1px solid rgba(201,169,110,0.1);">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="flex flex-col items-center mb-2">
                <?php if(isset($editMode) && $editMode): ?>
                    <div class="editable-section inline-block relative mb-1">
                        <?php if($settings && $settings->logo_url): ?>
                            <img src="<?php echo e($settings->logo_url); ?>" alt="<?php echo e($tenant->name); ?>" class="h-12 object-contain">
                        <?php else: ?>
                            <div class="h-12 w-12 flex items-center justify-center" style="border: 1px solid var(--primary-color);">
                                <span class="font-display text-xl" style="color: var(--primary-color);"><?php echo e(substr($tenant->name, 0, 1)); ?></span>
                            </div>
                        <?php endif; ?>
                        <div class="edit-btn" onclick="editImage('logo_url')"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="14" height="14" fill="currentColor" style="vertical-align:middle"><path d="M12.146.854a.5.5 0 0 1 .708 0l2.292 2.292a.5.5 0 0 1 0 .708l-9.5 9.5a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l9.5-9.5z"/></svg></div>
                    </div>
                    <div class="editable-section inline-block relative" style="min-width: 120px; display: flex; align-items: center; gap: 8px;">
                        <span class="font-display text-lg tracking-[0.3em] uppercase" style="color: <?php echo e($settings->agency_name_color ?? 'var(--primary-color)'); ?>"><?php echo e($tenant->name); ?></span>
                        <button type="button" class="edit-btn" style="position:static; display:flex; margin-left:4px; background:var(--primary-color); color:#0a0a0a; width:28px; height:28px; border-radius:50%; align-items:center; justify-content:center; cursor:pointer; z-index:50; border:none;" onclick="editText('agency_name','Editar Nombre de Agencia')"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="14" height="14" fill="currentColor" style="vertical-align:middle"><path d="M12.146.854a.5.5 0 0 1 .708 0l2.292 2.292a.5.5 0 0 1 0 .708l-9.5 9.5a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l9.5-9.5z"/></svg></button>
                    </div>
                <?php else: ?>
                    <div class="inline-block relative mb-1">
                        <?php if($settings && $settings->logo_url): ?>
                            <img src="<?php echo e($settings->logo_url); ?>" alt="<?php echo e($tenant->name); ?>" class="h-12 object-contain">
                        <?php else: ?>
                            <div class="h-12 w-12 flex items-center justify-center" style="border: 1px solid var(--primary-color);">
                                <span class="font-display text-xl" style="color: var(--primary-color);"><?php echo e(substr($tenant->name, 0, 1)); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <span class="font-display text-lg tracking-[0.3em] uppercase" style="color: var(--primary-color);"><?php echo e($tenant->name); ?></span>
                <?php endif; ?>
            </div>
            <div class="flex items-center justify-center gap-10">
                <!-- Menú Desktop -->
                <div class="hidden md:flex items-center gap-10">
                    <a href="#inicio" class="text-xs tracking-[0.25em] uppercase font-light transition hover:opacity-60" style="color: <?php echo e($settings->navbar_links_color ?? 'rgba(255,255,255,0.5)'); ?>">Inicio</a>
                    <a href="<?php echo e(route('public.vehiculos')); ?>" class="text-xs tracking-[0.25em] uppercase font-light transition hover:opacity-60" style="color: <?php echo e($settings->navbar_links_color ?? 'rgba(255,255,255,0.5)'); ?>">Colección</a>
                    <a href="#nosotros" class="text-xs tracking-[0.25em] uppercase font-light transition hover:opacity-60" style="color: <?php echo e($settings->navbar_links_color ?? 'rgba(255,255,255,0.5)'); ?>">Nosotros</a>
                    <a href="#contacto" class="text-xs tracking-[0.25em] uppercase font-light transition hover:opacity-60" style="color: <?php echo e($settings->navbar_links_color ?? 'rgba(255,255,255,0.5)'); ?>">Contacto</a>
                </div>
                <!-- Botón Hamburguesa Mobile -->
                <button id="menu-toggle" class="md:hidden flex flex-col justify-center items-center w-10 h-10 focus:outline-none ml-2" aria-label="Abrir menú">
                    <span class="block w-6 h-0.5 bg-[var(--primary-color)] mb-1 transition-all"></span>
                    <span class="block w-6 h-0.5 bg-[var(--primary-color)] mb-1 transition-all"></span>
                    <span class="block w-6 h-0.5 bg-[var(--primary-color)] transition-all"></span>
                </button>
            </div>
        </div>
        <!-- Menú Mobile -->
        <div id="mobile-menu" class="md:hidden fixed inset-0 bg-black bg-opacity-95 z-50 flex flex-col items-center justify-center space-y-8 text-lg font-semibold transition-all duration-300 opacity-0 pointer-events-none">
            <button id="menu-close" class="absolute top-6 right-6 text-[var(--primary-color)] text-3xl focus:outline-none" aria-label="Cerrar menú">&times;</button>
            <a href="#inicio" class="navbar-link-auto" style="color: <?php echo e($settings->navbar_links_color ?? 'rgba(255,255,255,0.7)'); ?>">Inicio</a>
            <a href="<?php echo e(route('public.vehiculos')); ?>" class="navbar-link-auto" style="color: <?php echo e($settings->navbar_links_color ?? 'rgba(255,255,255,0.7)'); ?>">Colección</a>
            <a href="#nosotros" class="navbar-link-auto" style="color: <?php echo e($settings->navbar_links_color ?? 'rgba(255,255,255,0.7)'); ?>">Nosotros</a>
            <a href="#contacto" class="navbar-link-auto" style="color: <?php echo e($settings->navbar_links_color ?? 'rgba(255,255,255,0.7)'); ?>">Contacto</a>
        </div>
        </div>
    </nav>

    <div id="inicio"></div>

    <!-- HERO: Asymmetric split (60% imagen izquierda / 40% texto derecha) — ÚNICO -->
    <div class="grid grid-cols-1 md:grid-cols-5 min-h-[600px]">
        <div class="md:col-span-3 relative overflow-hidden">
            <?php if(isset($editMode) && $editMode): ?>
                <div class="absolute inset-0">
                    <?php if($settings && $settings->banner_url): ?>
                        <img src="<?php echo e($settings->banner_url); ?>" alt="Banner" class="w-full h-full object-cover">
                    <?php else: ?>
                        <div class="w-full h-full" style="background: linear-gradient(135deg, #1a1a1a, #0a0a0a);"></div>
                    <?php endif; ?>
                    <div class="editable-section" style="position:absolute; top:16px; right:16px; z-index:51; width:40px; height:40px; display:flex; align-items:center; justify-content:center;">
                        <button type="button" class="edit-btn" style="position:static; display:flex; background:var(--primary-color); color:#0a0a0a; width:40px; height:40px; border-radius:50%; align-items:center; justify-content:center; cursor:pointer; z-index:51; border:none;" onclick="editImage('banner_url')"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="14" height="14" fill="currentColor" style="vertical-align:middle"><path d="M12.146.854a.5.5 0 0 1 .708 0l2.292 2.292a.5.5 0 0 1 0 .708l-9.5 9.5a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l9.5-9.5z"/></svg></button>
                    </div>
                </div>
            <?php else: ?>
                <div class="absolute inset-0">
                    <?php if($settings && $settings->banner_url): ?>
                        <img src="<?php echo e($settings->banner_url); ?>" alt="Banner" class="w-full h-full object-cover">
                    <?php else: ?>
                        <div class="w-full h-full" style="background: linear-gradient(135deg, #1a1a1a, #0a0a0a);"></div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <div class="absolute inset-0" style="background: linear-gradient(to right, transparent 60%, var(--secondary-color) 100%);"></div>
        </div>
        <div class="md:col-span-2 flex flex-col justify-center px-10 py-16 relative">
            <div class="mb-6" style="width: 40px; height: 1px; background: var(--primary-color);"></div>
            <p class="text-xs tracking-[0.4em] uppercase mb-6 font-light" style="color: var(--primary-color);">Colección Exclusiva</p>
            <?php if(isset($editMode) && $editMode): ?>
                <div class="editable-section mb-8">
                    <p class="font-display text-2xl md:text-3xl font-light leading-relaxed italic" style="color: <?php echo e($settings->home_description_color ?? 'rgba(255,255,255,0.85)'); ?>"><?php echo e($settings->home_description ?? 'Donde la excelencia automotriz se encuentra con el servicio personalizado.'); ?></p>
                    <div class="edit-btn" onclick="editText('home_description','Editar Descripción Principal')"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="14" height="14" fill="currentColor" style="vertical-align:middle"><path d="M12.146.854a.5.5 0 0 1 .708 0l2.292 2.292a.5.5 0 0 1 0 .708l-9.5 9.5a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l9.5-9.5z"/></svg></div>
                </div>
            <?php else: ?>
                <p class="font-display text-2xl md:text-3xl font-light leading-relaxed italic mb-8" style="color: <?php echo e($settings->home_description_color ?? 'rgba(255,255,255,0.85)'); ?>"><?php echo e($settings->home_description ?? 'Donde la excelencia automotriz se encuentra con el servicio personalizado.'); ?></p>
            <?php endif; ?>
            <a href="<?php echo e(route('public.vehiculos')); ?>" class="inline-flex items-center gap-3 text-sm tracking-[0.2em] uppercase transition group" style="color: var(--primary-color);">
                <span>Explorar</span>
                <span class="inline-block w-8 h-px transition-all group-hover:w-14" style="background: var(--primary-color);"></span>
            </a>
        </div>
    </div>

    <!-- Ornamental divider -->
    <div class="max-w-xl mx-auto py-10 px-8">
        <div class="ornament"><span class="ornament-icon">✦ ✦ ✦</span></div>
    </div>

    <!-- VEHÍCULOS: Cards horizontales (imagen izq + info der) — 2 por fila, estilo magazine -->
    <?php if($settings->show_vehicles && $vehicles->count() > 0): ?>
        <div id="vehiculos" class="py-16 px-4">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-16">
                    <p class="text-xs tracking-[0.4em] uppercase mb-4 font-light" style="color: var(--primary-color);">Nuestra Selección</p>
                    <h3 class="font-display text-5xl font-bold" style="color: var(--primary-color);">Colección</h3>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <?php $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="vehicle-showcase rounded-sm overflow-hidden">
                            <a href="<?php echo e(route('public.vehiculos.show', $vehicle->id)); ?>" class="block relative overflow-hidden">
                                <img src="<?php echo e($vehicle->main_image); ?>" alt="<?php echo e($vehicle->title); ?>" class="w-full h-full object-cover hover:scale-105 transition duration-700">
                                <div class="absolute top-4 left-4">
                                    <span class="px-3 py-1 text-[10px] font-medium tracking-[0.2em] uppercase" style="background: var(--primary-color); color: #0a0a0a;"><?php echo e($vehicle->year); ?></span>
                                </div>
                            </a>
                            <div class="flex flex-col justify-between p-8" style="background: linear-gradient(180deg, rgba(15,15,15,0.98), rgba(10,10,10,0.99));">
                                <div>
                                    <p class="text-[10px] tracking-[0.3em] uppercase text-gray-500 mb-3"><?php echo e($vehicle->brand); ?></p>
                                    <h4 class="font-display text-xl font-bold text-white mb-2"><?php echo e($vehicle->title); ?></h4>
                                    <div class="w-8 h-px mb-4" style="background: var(--primary-color);"></div>
                                    <p class="font-body text-sm text-gray-400 leading-relaxed mb-6"><?php echo e(Str::limit($vehicle->description, 120)); ?></p>
                                </div>
                                <div>
                                    <div class="flex items-end justify-between mb-5">
                                        <div>
                                            <p class="text-[10px] tracking-[0.2em] uppercase text-gray-600">Precio</p>
                                            <span class="font-display text-2xl font-bold" style="color: var(--primary-color);">$<?php echo e(number_format($vehicle->price)); ?></span>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-[10px] tracking-[0.2em] uppercase text-gray-600">Kilometraje</p>
                                            <span class="text-sm text-gray-300"><?php echo e(number_format($vehicle->kilometers)); ?> km</span>
                                        </div>
                                    </div>
                                    <a href="https://wa.me/<?php echo e(preg_replace('/[^0-9]/', '', $settings->whatsapp ?? '')); ?>?text=Hola! Estoy interesado en el <?php echo e(urlencode($vehicle->title)); ?>" target="_blank"
                                        class="w-full py-3 text-[11px] tracking-[0.25em] uppercase font-medium border transition-all duration-300 hover:bg-[rgba(37,211,102,0.1)] text-center flex items-center justify-center gap-2"
                                        style="color: #25d366; border-color: rgba(37,211,102,0.3);">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                        Consultar por WhatsApp
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="max-w-xl mx-auto py-6 px-8">
        <div class="ornament"><span class="ornament-icon">✦</span></div>
    </div>

    <!-- NOSOTROS: Full-width background image con overlay lateral — estilo editorial -->
    <div id="nosotros" class="relative min-h-[500px]">
        <div class="absolute inset-0 <?php if(isset($editMode) && $editMode): ?> editable-section <?php endif; ?>">
            <img src="<?php echo e($settings->nosotros_url ?? 'https://images.unsplash.com/photo-1563720223185-11003d516935?w=1200&h=600&fit=crop'); ?>" alt="Nosotros" class="w-full h-full object-cover">
            <?php if(isset($editMode) && $editMode): ?>
                <div class="edit-btn" onclick="editImage('nosotros_url')"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="14" height="14" fill="currentColor" style="vertical-align:middle"><path d="M12.146.854a.5.5 0 0 1 .708 0l2.292 2.292a.5.5 0 0 1 0 .708l-9.5 9.5a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l9.5-9.5z"/></svg></div>
            <?php endif; ?>
        </div>
        <div class="absolute inset-0" style="background: linear-gradient(to right, rgba(10,10,10,0.92) 0%, rgba(10,10,10,0.7) 50%, rgba(10,10,10,0.4) 100%);"></div>
        <div class="relative max-w-7xl mx-auto px-8 py-20">
            <div class="max-w-xl">
                <p class="text-xs tracking-[0.4em] uppercase mb-4 font-light" style="color: var(--primary-color);">Nuestra Esencia</p>
                <h3 class="font-display text-4xl font-bold mb-2" style="color: var(--primary-color);">Sobre Nosotros</h3>
                <div class="w-12 h-px mb-8" style="background: var(--primary-color);"></div>
                <?php if(isset($editMode) && $editMode): ?>
                    <div class="editable-section mb-8">
                        <p class="font-body text-lg leading-loose text-gray-200 whitespace-pre-line" style="color: <?php echo e($settings->nosotros_description_color ?? '#e5e7eb'); ?>"><?php echo e($settings->nosotros_description ?? "Somos una agencia de autos premium con más de 15 años de experiencia.\n\nNos especializamos en vehículos de alta gama, ofreciendo un servicio personalizado y exclusivo."); ?></p>
                        <div class="edit-btn" onclick="editText('nosotros_description','Editar Sección Nosotros')"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="14" height="14" fill="currentColor" style="vertical-align:middle"><path d="M12.146.854a.5.5 0 0 1 .708 0l2.292 2.292a.5.5 0 0 1 0 .708l-9.5 9.5a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l9.5-9.5z"/></svg></div>
                    </div>
                <?php else: ?>
                    <p class="font-body text-lg leading-loose text-gray-200 whitespace-pre-line mb-8" style="color: <?php echo e($settings->nosotros_description_color ?? '#e5e7eb'); ?>"><?php echo e($settings->nosotros_description ?? "Somos una agencia de autos premium con más de 15 años de experiencia.\n\nNos especializamos en vehículos de alta gama, ofreciendo un servicio personalizado y exclusivo."); ?></p>
                <?php endif; ?>
                <?php if(isset($editMode) && $editMode): ?>
                    <div class="editable-section flex gap-12 mt-8 pt-8" style="border-top: 1px solid rgba(201,169,110,0.15);">
                        <div>
                            <div class="font-display text-3xl font-bold" style="color: var(--primary-color);"><?php echo e($settings->stat1 ?? '150+'); ?></div>
                            <p class="text-gray-500 text-[10px] tracking-[0.2em] uppercase mt-1"><?php echo e($settings->stat1_label ?? 'Autos Vendidos'); ?></p>
                        </div>
                        <div>
                            <div class="font-display text-3xl font-bold" style="color: var(--primary-color);"><?php echo e($settings->stat2 ?? '98%'); ?></div>
                            <p class="text-gray-500 text-[10px] tracking-[0.2em] uppercase mt-1"><?php echo e($settings->stat2_label ?? 'Satisfacción'); ?></p>
                        </div>
                        <div>
                            <div class="font-display text-3xl font-bold" style="color: var(--primary-color);"><?php echo e($settings->stat3 ?? '24h'); ?></div>
                            <p class="text-gray-500 text-[10px] tracking-[0.2em] uppercase mt-1"><?php echo e($settings->stat3_label ?? 'Atención'); ?></p>
                        </div>
                        <div class="edit-btn self-center" onclick="editStats()"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="14" height="14" fill="currentColor" style="vertical-align:middle"><path d="M12.146.854a.5.5 0 0 1 .708 0l2.292 2.292a.5.5 0 0 1 0 .708l-9.5 9.5a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l9.5-9.5z"/></svg></div>
                    </div>
                <?php else: ?>
                    <div class="flex gap-12 mt-8 pt-8" style="border-top: 1px solid rgba(201,169,110,0.15);">
                        <div>
                            <div class="font-display text-3xl font-bold" style="color: var(--primary-color);"><?php echo e($settings->stat1 ?? '150+'); ?></div>
                            <p class="text-gray-500 text-[10px] tracking-[0.2em] uppercase mt-1"><?php echo e($settings->stat1_label ?? 'Autos Vendidos'); ?></p>
                        </div>
                        <div>
                            <div class="font-display text-3xl font-bold" style="color: var(--primary-color);"><?php echo e($settings->stat2 ?? '98%'); ?></div>
                            <p class="text-gray-500 text-[10px] tracking-[0.2em] uppercase mt-1"><?php echo e($settings->stat2_label ?? 'Satisfacción'); ?></p>
                        </div>
                        <div>
                            <div class="font-display text-3xl font-bold" style="color: var(--primary-color);"><?php echo e($settings->stat3 ?? '24h'); ?></div>
                            <p class="text-gray-500 text-[10px] tracking-[0.2em] uppercase mt-1"><?php echo e($settings->stat3_label ?? 'Atención'); ?></p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- CONTACTO: Centrado, single column, inputs con border-bottom — estilo carta -->
    <?php if($settings->show_contact_form): ?>
        <div id="contacto" class="py-24 px-4">
            <div class="max-w-2xl mx-auto text-center">
                <p class="text-xs tracking-[0.4em] uppercase mb-4 font-light" style="color: var(--primary-color);">Comuníquese</p>
                <h3 class="font-display text-4xl font-bold mb-4" style="color: var(--primary-color);">Contacto</h3>
                <div class="ornament max-w-xs mx-auto mb-8"><span class="ornament-icon">✦</span></div>

                <div class="flex flex-wrap items-center justify-center gap-8 mb-10 text-sm">
                    <?php if(isset($editMode) && $editMode): ?>
                        <button onclick="editContact()" class="text-xs px-3 py-1 border transition" style="color: var(--primary-color); border-color: var(--primary-color);">Editar contacto</button>
                    <?php endif; ?>
                    <?php if($settings->phone): ?>
                        <a href="tel:<?php echo e($settings->phone); ?>" class="text-gray-400 hover:text-white transition font-body flex items-center gap-2"><span style="color: var(--primary-color);">📞</span> <?php echo e($settings->phone); ?></a>
                    <?php endif; ?>
                    <?php if($settings->email): ?>
                        <a href="mailto:<?php echo e($settings->email); ?>" class="text-gray-400 hover:text-white transition font-body flex items-center gap-2"><span style="color: var(--primary-color);">✉️</span> <?php echo e($settings->email); ?></a>
                    <?php endif; ?>
                    <?php if($settings->whatsapp): ?>
                        <a href="https://wa.me/<?php echo e(preg_replace('/[^0-9]/', '', $settings->whatsapp)); ?>" target="_blank" class="text-gray-400 hover:text-white transition font-body flex items-center gap-2"><span style="color: var(--primary-color);">💬</span> <?php echo e($settings->whatsapp); ?></a>
                    <?php endif; ?>
                </div>

                <p class="text-gray-400 font-body text-lg mb-10"><?php echo e($settings->contact_message ?? 'Un asesor exclusivo le atenderá personalmente.'); ?></p>

                <form action="<?php echo e(\App\Helpers\RouteHelper::publicContactRoute()); ?>" method="POST" class="space-y-4 text-left">
                    <?php echo csrf_field(); ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <input type="text" name="name" placeholder="Su Nombre" required class="w-full px-5 py-4 bg-transparent text-white placeholder-gray-600 border-b focus:outline-none transition font-body text-lg" style="border-color: rgba(201,169,110,0.2);" onfocus="this.style.borderColor='var(--primary-color)'" onblur="this.style.borderColor='rgba(201,169,110,0.2)'">
                        <input type="email" name="email" placeholder="Su Email" required class="w-full px-5 py-4 bg-transparent text-white placeholder-gray-600 border-b focus:outline-none transition font-body text-lg" style="border-color: rgba(201,169,110,0.2);" onfocus="this.style.borderColor='var(--primary-color)'" onblur="this.style.borderColor='rgba(201,169,110,0.2)'">
                    </div>
                    <input type="tel" name="phone" placeholder="Su Teléfono" required class="w-full px-5 py-4 bg-transparent text-white placeholder-gray-600 border-b focus:outline-none transition font-body text-lg" style="border-color: rgba(201,169,110,0.2);" onfocus="this.style.borderColor='var(--primary-color)'" onblur="this.style.borderColor='rgba(201,169,110,0.2)'">
                    <textarea name="message" placeholder="Su Mensaje" rows="3" required class="w-full px-5 py-4 bg-transparent text-white placeholder-gray-600 border-b focus:outline-none transition font-body text-lg resize-none" style="border-color: rgba(201,169,110,0.2);" onfocus="this.style.borderColor='var(--primary-color)'" onblur="this.style.borderColor='rgba(201,169,110,0.2)'"></textarea>
                    <input type="hidden" name="vehicle_id" id="vehicle_id">
                    <div class="text-center pt-6">
                        <button type="submit" class="px-16 py-4 text-[11px] tracking-[0.3em] uppercase font-medium border transition-all duration-300 hover:bg-[rgba(201,169,110,0.1)]" style="color: var(--primary-color); border-color: var(--primary-color);">Enviar Mensaje</button>
                    </div>
                </form>

                <div class="mt-12 flex justify-center gap-6">
                    <?php if($settings->facebook_url): ?><a href="<?php echo e($settings->facebook_url); ?>" target="_blank" class="text-gray-600 hover:text-white transition text-lg">📘</a><?php endif; ?>
                    <?php if($settings->instagram_url): ?><a href="<?php echo e($settings->instagram_url); ?>" target="_blank" class="text-gray-600 hover:text-white transition text-lg">📷</a><?php endif; ?>
                    <?php if($settings->linkedin_url): ?><a href="<?php echo e($settings->linkedin_url); ?>" target="_blank" class="text-gray-600 hover:text-white transition text-lg">💼</a><?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <footer class="py-8 px-4" style="border-top: 1px solid rgba(201,169,110,0.08);">
        <div class="max-w-7xl mx-auto text-center">
            <p class="text-gray-600 font-body text-xs tracking-[0.2em] uppercase">© <?php echo e(date('Y')); ?> <?php echo e($tenant->name); ?> — Todos los derechos reservados</p>
        </div>
    </footer>

    <?php if(isset($editMode) && $editMode): ?>
    <?php echo $__env->make('public.templates.partials.editor-scripts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?>

    <script>
        // Menú hamburguesa responsive
        document.addEventListener('DOMContentLoaded', function() {
            var menuToggle = document.getElementById('menu-toggle');
            var mobileMenu = document.getElementById('mobile-menu');
            var menuClose = document.getElementById('menu-close');
            function openMenu() {
                mobileMenu.classList.remove('opacity-0', 'pointer-events-none');
                mobileMenu.classList.add('opacity-100');
                document.body.style.overflow = 'hidden';
            }
            function closeMenu() {
                mobileMenu.classList.add('opacity-0', 'pointer-events-none');
                mobileMenu.classList.remove('opacity-100');
                document.body.style.overflow = '';
            }
            if(menuToggle && mobileMenu) {
                menuToggle.addEventListener('click', openMenu);
            }
            if(menuClose && mobileMenu) {
                menuClose.addEventListener('click', closeMenu);
            }
            // Cerrar menú al hacer click fuera
            mobileMenu && mobileMenu.addEventListener('click', function(e) {
                if(e.target === mobileMenu) closeMenu();
            });
            // Cerrar menú con ESC
            document.addEventListener('keydown', function(e) {
                if(e.key === 'Escape') closeMenu();
            });
        });
        function openContactForm(vehicleId, vehicleTitle) {
            document.getElementById('vehicle_id').value = vehicleId;
            document.querySelector('textarea[name="message"]').value = `Consulta por: ${vehicleTitle}`;
            document.getElementById('contacto').scrollIntoView({ behavior: 'smooth' });
            document.querySelector('input[name="name"]').focus();
        }
    </script>
</body>
</html>
<?php /**PATH C:\Proyectos\ProyectoAutos\resources\views\public\templates\elegante.blade.php ENDPATH**/ ?>