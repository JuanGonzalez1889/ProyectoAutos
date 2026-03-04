<?php
    // Template base para la página de vehículos individuales - Elegante
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="<?php echo e(isset($settings) && $settings->logo_url ? $settings->logo_url : '/storage/icono.png'); ?>">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e($tenant->name ?? 'Agencia de Autos'); ?></title>
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
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=Cormorant+Garamond:wght@300;400;600&display=swap" rel="stylesheet">
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
    </style>
</head>
<body style="background-color: var(--secondary-color);" class="text-white">
    <?php ($template = 'elegante'); ?>

    <!-- Navbar Elegante -->
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
                    <a href="/" class="text-xs tracking-[0.25em] uppercase font-light transition hover:opacity-60" style="color: <?php echo e($settings->navbar_links_color ?? 'rgba(255,255,255,0.5)'); ?>">Inicio</a>
                    <a href="<?php echo e(route('public.vehiculos')); ?>" class="text-xs tracking-[0.25em] uppercase font-light transition hover:opacity-60" style="color: <?php echo e($settings->navbar_links_color ?? 'rgba(255,255,255,0.5)'); ?>">Colección</a>
                    <a href="/#nosotros" class="text-xs tracking-[0.25em] uppercase font-light transition hover:opacity-60" style="color: <?php echo e($settings->navbar_links_color ?? 'rgba(255,255,255,0.5)'); ?>">Nosotros</a>
                    <a href="/#contacto" class="text-xs tracking-[0.25em] uppercase font-light transition hover:opacity-60" style="color: <?php echo e($settings->navbar_links_color ?? 'rgba(255,255,255,0.5)'); ?>">Contacto</a>
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
            <a href="/" class="navbar-link-auto" style="color: <?php echo e($settings->navbar_links_color ?? 'rgba(255,255,255,0.7)'); ?>">Inicio</a>
            <a href="<?php echo e(route('public.vehiculos')); ?>" class="navbar-link-auto" style="color: <?php echo e($settings->navbar_links_color ?? 'rgba(255,255,255,0.7)'); ?>">Colección</a>
            <a href="/#nosotros" class="navbar-link-auto" style="color: <?php echo e($settings->navbar_links_color ?? 'rgba(255,255,255,0.7)'); ?>">Nosotros</a>
            <a href="/#contacto" class="navbar-link-auto" style="color: <?php echo e($settings->navbar_links_color ?? 'rgba(255,255,255,0.7)'); ?>">Contacto</a>
        </div>
        </div>
    </nav>

    <?php echo $__env->yieldContent('content'); ?>

    <!-- Footer -->
    <footer class="py-10 text-center text-gray-500 text-sm border-t" style="background: rgba(0,0,0,0.6); border-color: rgba(201,169,110,0.15);">
        © <?php echo e(date('Y')); ?> <?php echo e($tenant->name); ?>

    </footer>
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
    </script>
    <?php if(isset($editMode) && $editMode): ?>
        <?php echo $__env->make('public.templates.partials.editor-scripts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?>
</body>
</html>
<?php /**PATH C:\Proyectos\ProyectoAutos\resources\views\public\templates\elegante-base.blade.php ENDPATH**/ ?>