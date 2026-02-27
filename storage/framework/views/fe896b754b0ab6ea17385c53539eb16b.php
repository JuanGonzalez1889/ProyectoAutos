<?php
    // Copia de la estructura general de moderno, pero sin hero, nosotros, etc.
?>
<!DOCTYPE html>
<html lang="es" style="font-size: 140%;">
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
    </style>
</head>
<body style="background-color: var(--secondary-color);" class="text-white">
    <?php ($template = 'moderno'); ?>

    <!-- Navbar Moderno con menú hamburguesa -->
    <style>
        .navbar-auto {
            color: var(--navbar-text-color, #fff);
        }
        .navbar-link-auto {
            color: var(--navbar-text-color, #fff);
        }
        .navbar-link-auto:hover {
            opacity: 0.8;
        }
        .hamburger {
            display: block;
            width: 32px;
            height: 32px;
            cursor: pointer;
        }
        .hamburger span {
            display: block;
            height: 4px;
            margin: 6px 0;
            background: var(--navbar-text-color, #fff);
            border-radius: 2px;
            transition: 0.3s;
        }
        .mobile-menu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            background: rgba(30,41,59,0.98);
            z-index: 100;
        }
        .mobile-menu.open {
            display: block;
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
            root.style.setProperty('--navbar-text-color', getContrastYIQ(bg));
        })();
        function toggleMenu() {
            var menu = document.getElementById('mobile-menu');
            menu.classList.toggle('open');
        }
        document.addEventListener('click', function(e) {
            var menu = document.getElementById('mobile-menu');
            var hamburger = document.getElementById('hamburger-btn');
            if (!menu || !hamburger) return;
            if (!menu.contains(e.target) && !hamburger.contains(e.target)) {
                menu.classList.remove('open');
            }
        });
    </script>
    <nav class="sticky top-0 z-50" style="background: rgba(255,255,255,0.06); backdrop-filter: blur(12px); border-bottom: 1px solid rgba(255,255,255,0.15);">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between relative">
            <div class="flex items-center gap-3">
                <?php if($settings && $settings->logo_url): ?>
                    <img src="<?php echo e($settings->logo_url); ?>" alt="<?php echo e($tenant->name); ?>" class="h-10 object-contain">
                <?php else: ?>
                    <div class="h-10 w-10 rounded-lg" style="background-color: var(--primary-color);"></div>
                <?php endif; ?>
                <span class="text-xl font-bold navbar-auto align-middle"><?php echo e($tenant->name); ?></span>
            </div>
            <!-- Botón hamburguesa solo en mobile -->
            <div class="md:hidden ml-4">
                <div id="hamburger-btn" class="hamburger" onclick="toggleMenu()">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
            <!-- Menú normal en desktop -->
            <div class="hidden md:flex items-center gap-8">
                <a href="#inicio" class="navbar-link-auto hover:opacity-80 transition font-medium" style="color: <?php echo e($settings->navbar_links_color ?? 'var(--navbar-text-color, #fff)'); ?>">Inicio</a>
                <a href="<?php echo e(route('public.vehiculos')); ?>" class="navbar-link-auto hover:opacity-80 transition font-medium" style="color: <?php echo e($settings->navbar_links_color ?? 'var(--navbar-text-color, #fff)'); ?>">Vehículos</a>
                <a href="#nosotros" class="navbar-link-auto hover:opacity-80 transition font-medium" style="color: <?php echo e($settings->navbar_links_color ?? 'var(--navbar-text-color, #fff)'); ?>">Nosotros</a>
                <a href="#contacto" class="navbar-link-auto hover:opacity-80 transition font-medium" style="color: <?php echo e($settings->navbar_links_color ?? 'var(--navbar-text-color, #fff)'); ?>">Contacto</a>
            </div>
            <!-- Menú hamburguesa en mobile -->
            <div id="mobile-menu" class="mobile-menu md:hidden">
                <div class="flex flex-col gap-4 p-4">
                    <a href="#inicio" class="navbar-link-auto hover:opacity-80 transition font-medium" style="color: <?php echo e($settings->navbar_links_color ?? 'var(--navbar-text-color, #fff)'); ?>">Inicio</a>
                    <a href="<?php echo e(route('public.vehiculos')); ?>" class="navbar-link-auto hover:opacity-80 transition font-medium" style="color: <?php echo e($settings->navbar_links_color ?? 'var(--navbar-text-color, #fff)'); ?>">Vehículos</a>
                    <a href="#nosotros" class="navbar-link-auto hover:opacity-80 transition font-medium" style="color: <?php echo e($settings->navbar_links_color ?? 'var(--navbar-text-color, #fff)'); ?>">Nosotros</a>
                    <a href="#contacto" class="navbar-link-auto hover:opacity-80 transition font-medium" style="color: <?php echo e($settings->navbar_links_color ?? 'var(--navbar-text-color, #fff)'); ?>">Contacto</a>
                </div>
            </div>
        </div>
    </nav>

    <?php echo $__env->yieldContent('content'); ?>

    <!-- Footer -->
    <footer class="bg-gray-900 py-8 text-center text-gray-400 text-sm border-t border-gray-800">
        © <?php echo e(date('Y')); ?> <?php echo e($tenant->name); ?>

    </footer>
    <?php if(isset($editMode) && $editMode): ?>
        <?php echo $__env->make('public.templates.partials.editor-scripts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?>
</body>
</html>
<?php /**PATH C:\Proyectos\ProyectoAutos\resources\views/public/templates/moderno-base.blade.php ENDPATH**/ ?>