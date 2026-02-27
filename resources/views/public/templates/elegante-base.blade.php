@php
    // Template base para la página de vehículos individuales - Elegante
@endphp
<!DOCTYPE html>
<html lang="es" style="font-size: 140%;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/storage/icono.png">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $tenant->name ?? 'Agencia de Autos' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @php
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
    @endphp
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=Cormorant+Garamond:wght@300;400;600&display=swap" rel="stylesheet">
    @if($fontUrl)
        <link href="{{ $fontUrl }}" rel="stylesheet">
    @endif
    <style>
        :root {
            --primary-color: {{ $settings && $settings->primary_color ? $settings->primary_color : '#c9a96e' }};
            --secondary-color: {{ $settings && $settings->secondary_color ? $settings->secondary_color : '#0a0a0a' }};
            --tertiary-color: {{ $settings && $settings->tertiary_color ? $settings->tertiary_color : '#d4af37' }};
        }
        body { font-family: {{ $settings->font_family ?? "'Cormorant Garamond', serif" }}; }
        .font-display { font-family: 'Playfair Display', serif; }
        .font-body { font-family: 'Cormorant Garamond', serif; }
    </style>
</head>
<body style="background-color: var(--secondary-color);" class="text-white">
    @php($template = 'elegante')

    <!-- Navbar Elegante -->
    <nav class="sticky top-0 z-50" style="background: rgba(10,10,10,0.92); backdrop-filter: blur(20px); border-bottom: 1px solid rgba(201,169,110,0.15);">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5 flex items-center justify-between">
            <div class="flex items-center gap-4">
                @if($settings && $settings->logo_url)
                    <img src="{{ $settings->logo_url }}" alt="{{ $tenant->name }}" class="h-10 object-contain">
                @else
                    <div class="h-10 w-10 rounded-sm border border-[var(--primary-color)]" style="background: linear-gradient(135deg, var(--primary-color), var(--tertiary-color));"></div>
                @endif
                    <div class="editable-section inline-block relative">
                        @if($settings && $settings->logo_url)
                            <img src="{{ $settings->logo_url }}" alt="{{ $tenant->name }}" class="h-10 object-contain">
                        @else
                            <div class="h-10 w-10 flex items-center justify-center" style="border: 1px solid var(--primary-color);">
                                <span class="font-display text-xl" style="color: var(--primary-color);">{{ substr($tenant->name, 0, 1) }}</span>
                            </div>
                        @endif
                            <div class="edit-btn" onclick="editImage('logo_url')"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="18" height="18" fill="currentColor" style="vertical-align:middle"><path d="M12.146 2.146a1 1 0 0 1 1.414 0l.294.294a1 1 0 0 1 0 1.414l-8.5 8.5a1 1 0 0 1-.293.207l-2.5 1.25a.5.5 0 0 1-.66-.66l1.25-2.5a1 1 0 0 1 .207-.293l8.5-8.5zm1.414-1.414a2 2 0 0 0-2.828 0l-8.5 8.5a2 2 0 0 0-.414.586l-1.25 2.5A1.5 1.5 0 0 0 2.5 14.5l2.5-1.25a2 2 0 0 0 .586-.414l8.5-8.5a2 2 0 0 0 0-2.828l-.294-.294z"/></svg></div>
                    </div>
                    <div class="editable-section inline-block relative ml-2">
                        <span class="font-display text-lg font-bold" style="color: var(--primary-color);">{{ $tenant->name }}</span>
                            <button type="button" class="edit-btn" style="position:static; display:flex; margin-left:4px; background:var(--primary-color); color:#fff; width:24px; height:24px; border-radius:50%; align-items:center; justify-content:center; cursor:pointer; z-index:50; border:none; font-size:10px;" onclick="editText('agency_name','Editar Nombre')"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="18" height="18" fill="currentColor" style="vertical-align:middle"><path d="M12.146 2.146a1 1 0 0 1 1.414 0l.294.294a1 1 0 0 1 0 1.414l-8.5 8.5a1 1 0 0 1-.293.207l-2.5 1.25a.5.5 0 0 1-.66-.66l1.25-2.5a1 1 0 0 1 .207-.293l8.5-8.5zm1.414-1.414a2 2 0 0 0-2.828 0l-8.5 8.5a2 2 0 0 0-.414.586l-1.25 2.5A1.5 1.5 0 0 0 2.5 14.5l2.5-1.25a2 2 0 0 0 .586-.414l8.5-8.5a2 2 0 0 0 0-2.828l-.294-.294z"/></svg></button>
                    </div>
            </div>
            <div class="flex items-center gap-8">
                <!-- Menú Desktop -->
                <div class="hidden md:flex gap-8">
                    <a href="#inicio" class="text-sm tracking-widest uppercase font-light transition hover:opacity-70" style="color: {{ $settings->navbar_links_color ?? 'rgba(255,255,255,0.7)' }}">Inicio</a>
                    <a href="{{ route('public.vehiculos') }}" class="text-sm tracking-widest uppercase font-light transition hover:opacity-70" style="color: {{ $settings->navbar_links_color ?? 'rgba(255,255,255,0.7)' }}">Colección</a>
                    <a href="#nosotros" class="text-sm tracking-widest uppercase font-light transition hover:opacity-70" style="color: {{ $settings->navbar_links_color ?? 'rgba(255,255,255,0.7)' }}">Nosotros</a>
                    <a href="#contacto" class="text-sm tracking-widest uppercase font-light transition hover:opacity-70" style="color: {{ $settings->navbar_links_color ?? 'rgba(255,255,255,0.7)' }}">Contacto</a>
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
            <a href="#inicio" class="navbar-link-auto" style="color: {{ $settings->navbar_links_color ?? 'rgba(255,255,255,0.7)' }}">Inicio</a>
            <a href="{{ route('public.vehiculos') }}" class="navbar-link-auto" style="color: {{ $settings->navbar_links_color ?? 'rgba(255,255,255,0.7)' }}">Colección</a>
            <a href="#nosotros" class="navbar-link-auto" style="color: {{ $settings->navbar_links_color ?? 'rgba(255,255,255,0.7)' }}">Nosotros</a>
            <a href="#contacto" class="navbar-link-auto" style="color: {{ $settings->navbar_links_color ?? 'rgba(255,255,255,0.7)' }}">Contacto</a>
        </div>
        </div>
    </nav>

    @yield('content')

    <!-- Footer -->
    <footer class="py-10 text-center text-gray-500 text-sm border-t" style="background: rgba(0,0,0,0.6); border-color: rgba(201,169,110,0.15);">
        © {{ date('Y') }} {{ $tenant->name }}
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
    @if(isset($editMode) && $editMode)
        @include('public.templates.partials.editor-scripts')
    @endif
</body>
</html>
