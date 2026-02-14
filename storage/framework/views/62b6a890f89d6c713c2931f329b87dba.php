<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'ctaLabel' => 'Registrarse',
    'ctaLink' => null,
    'ctaClass' => 'btn-gradient text-white hover:opacity-90',
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'ctaLabel' => 'Registrarse',
    'ctaLink' => null,
    'ctaClass' => 'btn-gradient text-white hover:opacity-90',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    $ctaLink = $ctaLink ?? route('register');
?>

<nav class="fixed top-0 left-0 right-0 z-50 glass">
        <!-- Hamburguesa -->
        <button id="menuBtn" class="md:hidden flex items-center justify-center w-10 h-10 rounded bg-slate-900 hover:bg-slate-800 transition absolute right-4 top-4 z-50" style="
    margin-top: -0.2rem;
">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
        <!-- Panel lateral -->
        <div id="mobileMenu" class="fixed inset-0 z-50 bg-slate-950 flex flex-col items-center justify-center gap-6 text-white text-lg transition-transform transform translate-x-full md:hidden" style="background: #0a0f14; height: 55vh;">
            <button id="closeMenu" class="absolute top-6 right-6 text-white text-2xl z-60" style="background: none; border: none;">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <div class="flex flex-col items-center gap-4 mt-12">
                <a href="<?php echo e(route('landing.home')); ?>" class="hover:text-blue-400 transition text-xl font-semibold">Inicio</a>
                <a href="<?php echo e(route('landing.home')); ?>#servicios" class="hover:text-blue-400 transition text-xl font-semibold">Servicios</a>
                <a href="<?php echo e(route('landing.nosotros')); ?>" class="hover:text-blue-400 transition text-xl font-semibold">Nosotros</a>
                <a href="<?php echo e(route('landing.precios')); ?>" class="hover:text-blue-400 transition text-xl font-semibold">Precios</a>
                <a href="<?php echo e(route('landing.proximamente')); ?>" class="hover:text-purple-400 transition text-xl font-semibold">Próximamente</a>
                <a href="<?php echo e(route('login')); ?>" class="hover:text-blue-400 transition text-xl font-semibold">Iniciar Sesión</a>
                <a href="<?php echo e($ctaLink); ?>" class="btn-gradient px-6 py-3 rounded-lg font-semibold text-white mt-6 text-xl"><?php echo e($ctaLabel); ?></a>
            </div>
        </div>
    <script>
        window.addEventListener('DOMContentLoaded', function () {
            var menuBtn = document.getElementById('menuBtn');
            var mobileMenu = document.getElementById('mobileMenu');
            var closeMenu = document.getElementById('closeMenu');
            if (menuBtn && mobileMenu) {
                menuBtn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    mobileMenu.classList.remove('translate-x-full');
                });
            }
            if (closeMenu && mobileMenu) {
                closeMenu.addEventListener('click', function (e) {
                    e.stopPropagation();
                    mobileMenu.classList.add('translate-x-full');
                });
            }
            mobileMenu && mobileMenu.addEventListener('click', function(e) {
                if (e.target === mobileMenu) {
                    mobileMenu.classList.add('translate-x-full');
                }
            });
            // Cerrar menú al hacer click en cualquier link
            var links = mobileMenu ? mobileMenu.querySelectorAll('a') : [];
            links.forEach(function(link) {
                link.addEventListener('click', function() {
                    mobileMenu.classList.add('translate-x-full');
                });
            });
        });
    </script>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <div class="flex items-center gap-2">
                <img src="/storage/logo5.png" alt="AutoWeb Pro Logo" class="w-32 h-auto max-w-xs md:w-40 md:h-auto object-contain bg-transparent rounded-lg border-none logo-zoom" style="min-width:80px;" />
                <style>
                .logo-zoom {
                    transition: transform 0.3s cubic-bezier(.4,2,.6,1);
                }
                .logo-zoom:hover {
                    transform: scale(1.12);
                }
                </style>
            </div>

            <!-- Navigation Links -->
            <div class="hidden md:flex items-center gap-8">
                <a href="<?php echo e(route('landing.home')); ?>" data-nav="inicio"
                    class="text-sm relative text-gray-300 hover:text-white font-medium">
                    Inicio
                    <span
                        class="inicio-underline <?php echo e(request()->routeIs('landing.home') ? '' : 'hidden'); ?> absolute -bottom-2 left-0 h-0.5 w-full bg-blue-500 rounded-full"></span>
                </a>
                <a href="<?php echo e(route('landing.home')); ?>#servicios" data-nav="servicios"
                    class="text-sm relative text-gray-300 hover:text-white font-medium">
                    Servicios
                    <span
                        class="servicios-underline hidden absolute -bottom-2 left-0 h-0.5 w-full bg-blue-500 rounded-full"></span>
                </a>
                <a href="<?php echo e(route('landing.nosotros')); ?>" data-nav="nosotros"
                    class="text-sm relative <?php echo e(request()->routeIs('landing.nosotros') ? 'text-white font-semibold' : 'text-gray-300 hover:text-white font-medium'); ?>">
                    Nosotros
                    <?php if(request()->routeIs('landing.nosotros')): ?>
                        <span class="absolute -bottom-2 left-0 h-0.5 w-full bg-blue-500 rounded-full"></span>
                    <?php endif; ?>
                </a>

                <a href="<?php echo e(route('landing.precios')); ?>" data-nav="precios"
                    class="text-sm relative <?php echo e(request()->routeIs('landing.precios') ? 'text-white font-semibold' : 'text-gray-300 hover:text-white font-medium'); ?>">
                    Precios
                    <?php if(request()->routeIs('landing.precios')): ?>
                        <span class="absolute -bottom-2 left-0 h-0.5 w-full bg-blue-500 rounded-full"></span>
                    <?php endif; ?>
                </a>
                <a href="<?php echo e(route('landing.proximamente')); ?>" data-nav="proximamente"
                    class="text-sm font-bold animate-pulse relative <?php echo e(request()->routeIs('landing.proximamente') ? 'text-purple-300' : 'text-purple-400'); ?>">
                    Próximamente
                    <span
                        class="absolute -bottom-2 left-0 h-0.5 w-full <?php echo e(request()->routeIs('landing.proximamente') ? 'bg-purple-300/80' : 'bg-purple-400/80'); ?> rounded-full"></span>
                </a>
            </div>

            <!-- CTA Buttons -->
            <div class="hidden md:flex items-center gap-3">
                <a href="<?php echo e(route('login')); ?>" class="text-sm font-medium text-gray-300 hover:text-white">Iniciar Sesión</a>
                <a href="<?php echo e($ctaLink); ?>" class="px-5 py-2 rounded-lg text-sm font-semibold <?php echo e($ctaClass); ?>">
                    <?php echo e($ctaLabel); ?>

                </a>
            </div>
        </div>
    </div>
</nav>
<?php /**PATH C:\Proyectos\ProyectoAutos\resources\views/components/navbar.blade.php ENDPATH**/ ?>