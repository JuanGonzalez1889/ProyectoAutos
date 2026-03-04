@php
    // Base layout for Autono template — used by vehiculos index & show views
@endphp
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $tenant->name ?? 'Agencia de Autos' }} - Vehículos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @php
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
        $fontUrl = isset($googleFonts[$font])
            ? 'https://fonts.googleapis.com/css?family=' . $googleFonts[$font] . ':400,700&display=swap'
            : null;
    @endphp
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @if($fontUrl)
        <link href="{{ $fontUrl }}" rel="stylesheet">
    @endif
    @php
        if (!function_exists('isDark_autono_base')) {
            function isDark_autono_base($hex) {
                $hex = ltrim($hex, '#');
                if (strlen($hex) === 3) $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
                $r = hexdec(substr($hex, 0, 2));
                $g = hexdec(substr($hex, 2, 2));
                $b = hexdec(substr($hex, 4, 2));
                return (0.299 * $r + 0.587 * $g + 0.114 * $b) < 150;
            }
        }
        $primaryColor = $settings && $settings->primary_color ? $settings->primary_color : '#00d084';
        $secondaryColor = $settings && $settings->secondary_color ? $settings->secondary_color : '#ffffff';
        $tertiaryColor = $settings && $settings->tertiary_color ? $settings->tertiary_color : '#f3f4f6';

        $textOnSecondary = isDark_autono_base($secondaryColor) ? '#ffffff' : '#111827';
        $textMutedOnSecondary = isDark_autono_base($secondaryColor) ? '#d1d5db' : '#6b7280';
        $textOnTertiary = isDark_autono_base($tertiaryColor) ? '#ffffff' : '#111827';
        $textMutedOnTertiary = isDark_autono_base($tertiaryColor) ? '#d1d5db' : '#6b7280';
        $textOnPrimary = isDark_autono_base($primaryColor) ? '#ffffff' : '#111827';
        $borderOnSecondary = isDark_autono_base($secondaryColor) ? 'rgba(255,255,255,0.15)' : '#e5e7eb';

        $brandName = strtoupper(trim((string) ($tenant->name ?? '')));
    @endphp
    <style>
        :root {
            --primary-color: {{ $primaryColor }};
            --secondary-color: {{ $secondaryColor }};
            --tertiary-color: {{ $tertiaryColor }};
            --text-on-secondary: {{ $textOnSecondary }};
            --text-muted-on-secondary: {{ $textMutedOnSecondary }};
            --text-on-tertiary: {{ $textOnTertiary }};
            --text-muted-on-tertiary: {{ $textMutedOnTertiary }};
            --text-on-primary: {{ $textOnPrimary }};
            --border-on-secondary: {{ $borderOnSecondary }};
        }

        body {
            font-family: {{ $settings->font_family ?? "'Inter', sans-serif" }};
            background: var(--secondary-color);
            color: var(--text-on-secondary);
        }

        .autono-nav-link {
            color: {{ $settings->navbar_links_color ?? $textOnSecondary }};
            font-weight: 500;
            transition: opacity .2s ease;
        }

        .autono-nav-link:hover {
            opacity: .7;
        }
    </style>
</head>
<body>
    <!-- Navbar Autono -->
    <header class="sticky top-0 z-50" style="background: var(--secondary-color); border-bottom: 1px solid var(--border-on-secondary);">
        <div class="max-w-[1600px] mx-auto px-7 md:px-14 py-8 flex items-center justify-between">
            <a href="/" class="flex items-center gap-3 no-underline">
                @if($settings && $settings->logo_url)
                    <img src="{{ $settings->logo_url }}" alt="{{ $tenant->name }}" style="height: 56px; max-height: 70px; max-width: 200px; width: auto; object-fit: contain;">
                @endif
                @if($brandName !== '')
                    <span class="text-3xl tracking-[0.35em] font-bold" style="color: {{ $settings->agency_name_color ?? $textOnSecondary }}">{{ $brandName }}</span>
                @endif
            </a>

            <nav class="hidden md:flex items-center gap-10 text-3xl">
                <a href="/" class="autono-nav-link">Inicio</a>
                <a href="{{ route('public.vehiculos') }}" class="autono-nav-link">Vehículos</a>
                <a href="/#nosotros" class="autono-nav-link">Nosotros</a>
                <a href="/#contacto" class="autono-nav-link">Contacto</a>
            </nav>

            <button id="menu-toggle" class="md:hidden flex flex-col justify-center items-center w-10 h-10" aria-label="Abrir menú">
                <span class="block w-6 h-0.5 mb-1" style="background: var(--text-on-secondary);"></span>
                <span class="block w-6 h-0.5 mb-1" style="background: var(--text-on-secondary);"></span>
                <span class="block w-6 h-0.5" style="background: var(--text-on-secondary);"></span>
            </button>
        </div>
    </header>

    <!-- Mobile menu -->
    <div id="mobile-menu" class="fixed inset-0 z-50 flex flex-col items-center justify-center space-y-8 text-2xl transition-all duration-300 opacity-0 pointer-events-none" style="background: var(--secondary-color);">
        <button id="menu-close" class="absolute top-6 right-6 text-3xl" style="color: var(--text-on-secondary);">&times;</button>
        <a href="/" class="autono-nav-link">Inicio</a>
        <a href="{{ route('public.vehiculos') }}" class="autono-nav-link">Vehículos</a>
        <a href="/#nosotros" class="autono-nav-link">Nosotros</a>
        <a href="/#contacto" class="autono-nav-link">Contacto</a>
    </div>

    @yield('content')

    <!-- Footer -->
    <footer class="py-8 text-center text-sm" style="color: var(--text-muted-on-secondary); border-top: 1px solid var(--border-on-secondary);">
        © {{ date('Y') }} {{ $tenant->name }}. Todos los derechos reservados.
    </footer>

    <script>
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
            if(menuToggle && mobileMenu) menuToggle.addEventListener('click', openMenu);
            if(menuClose && mobileMenu) menuClose.addEventListener('click', closeMenu);
            mobileMenu && mobileMenu.addEventListener('click', function(e) { if(e.target === mobileMenu) closeMenu(); });
            document.addEventListener('keydown', function(e) { if(e.key === 'Escape') closeMenu(); });
        });
    </script>
</body>
</html>
