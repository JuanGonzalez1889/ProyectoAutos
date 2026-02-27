@php
    // Copia de la estructura general de minimalista, pero sin hero, nosotros, etc.
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
    @endphp
    @if($fontUrl)
        <link href="{{ $fontUrl }}" rel="stylesheet">
    @endif
    <style>
        :root {
            --primary-color: {{ $settings && $settings->primary_color ? $settings->primary_color : '#00d084' }};
            --secondary-color: {{ $settings && $settings->secondary_color ? $settings->secondary_color : '#0a0f14' }};
            --tertiary-color: {{ $settings && $settings->tertiary_color ? $settings->tertiary_color : '#ffaa00' }};
        }
        body { font-family: {{ $settings->font_family ?? 'inherit' }}; }
    </style>
</head>
<body style="background-color: var(--secondary-color);" class="text-white">
    @php($template = 'minimalista')
    <!-- Navbar Minimalista -->
    <style>
        .navbar-auto { color: var(--navbar-text-color, #fff); }
        .navbar-link-auto { color: var(--navbar-text-color, #fff); }
        .navbar-link-auto:hover { opacity: 0.8; }
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
    </script>
    <nav class="bg-gray-800 border-b border-gray-700 sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-3">
                @if(isset($editMode) && $editMode)
                    <div class="editable-section inline-block relative">
                        @if($settings && $settings->logo_url)
                            <img src="{{ $settings->logo_url }}" alt="{{ $tenant->name }}" class="h-8 object-contain">
                        @endif
                        <div class="edit-btn" onclick="editImage('logo_url')">
                               <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="18" height="18" fill="currentColor" style="vertical-align:middle"><path d="M12.146 2.146a1 1 0 0 1 1.414 0l.294.294a1 1 0 0 1 0 1.414l-8.5 8.5a1 1 0 0 1-.293.207l-2.5 1.25a.5.5 0 0 1-.66-.66l1.25-2.5a1 1 0 0 1 .207-.293l8.5-8.5zm1.414-1.414a2 2 0 0 0-2.828 0l-8.5 8.5a2 2 0 0 0-.414.586l-1.25 2.5A1.5 1.5 0 0 0 2.5 14.5l2.5-1.25a2 2 0 0 0 .586-.414l8.5-8.5a2 2 0 0 0 0-2.828l-.294-.294z"/></svg>
                        </div>
                    </div>
                    <div class="editable-section inline-block relative ml-2">
                        <span class="font-semibold navbar-auto">{{ $settings->navbar_agency_name }}</span>
                        <div class="edit-btn" onclick="editText('navbar_agency_name', 'Editar Nombre de Agencia (Navbar)')">
                               <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="18" height="18" fill="currentColor" style="vertical-align:middle"><path d="M12.146 2.146a1 1 0 0 1 1.414 0l.294.294a1 1 0 0 1 0 1.414l-8.5 8.5a1 1 0 0 1-.293.207l-2.5 1.25a.5.5 0 0 1-.66-.66l1.25-2.5a1 1 0 0 1 .207-.293l8.5-8.5zm1.414-1.414a2 2 0 0 0-2.828 0l-8.5 8.5a2 2 0 0 0-.414.586l-1.25 2.5A1.5 1.5 0 0 0 2.5 14.5l2.5-1.25a2 2 0 0 0 .586-.414l8.5-8.5a2 2 0 0 0 0-2.828l-.294-.294z"/></svg>
                        </div>
                    </div>
                @else
                    @if($settings && $settings->logo_url)
                        <img src="{{ $settings->logo_url }}" alt="{{ $tenant->name }}" class="h-8 object-contain">
                    @endif
                    <span class="font-semibold" style="color: {{ $settings->navbar_agency_name_color ?? '#fff' }}">{{ $settings->navbar_agency_name }}</span>
                @endif
            </div>
            <div class="flex items-center gap-6">
                <!-- Menú Desktop -->
                <div class="hidden md:flex gap-6">
                    <a href="/" class="text-sm navbar-link-auto transition" style="color: {{ $settings->navbar_links_color ?? 'var(--navbar-text-color, #fff)' }}">Inicio</a>
                    <a href="{{ route('public.vehiculos') }}" class="text-sm navbar-link-auto transition" style="color: {{ $settings->navbar_links_color ?? 'var(--navbar-text-color, #fff)' }}">Vehículos</a>
                    <a href="#nosotros" class="text-sm navbar-link-auto transition" style="color: {{ $settings->navbar_links_color ?? 'var(--navbar-text-color, #fff)' }}">Nosotros</a>
                    <a href="#contacto" class="text-sm navbar-link-auto transition" style="color: {{ $settings->navbar_links_color ?? 'var(--navbar-text-color, #fff)' }}">Contacto</a>
                </div>
                <!-- Botón Hamburguesa Mobile -->
                <button id="menu-toggle" class="md:hidden flex flex-col justify-center items-center w-10 h-10 focus:outline-none" aria-label="Abrir menú">
                    <span class="block w-6 h-0.5 bg-white mb-1 transition-all"></span>
                    <span class="block w-6 h-0.5 bg-white mb-1 transition-all"></span>
                    <span class="block w-6 h-0.5 bg-white transition-all"></span>
                </button>
            </div>
        </div>
        <!-- Menú Mobile -->
        <div id="mobile-menu" class="md:hidden fixed inset-0 bg-gray-900 bg-opacity-95 z-50 flex flex-col items-center justify-center space-y-8 text-lg font-semibold transition-all duration-300 opacity-0 pointer-events-none">
            <button id="menu-close" class="absolute top-6 right-6 text-white text-3xl focus:outline-none" aria-label="Cerrar menú">&times;</button>
            <a href="/" class="navbar-link-auto" style="color: {{ $settings->navbar_links_color ?? 'var(--navbar-text-color, #fff)' }}">Inicio</a>
            <a href="{{ route('public.vehiculos') }}" class="navbar-link-auto" style="color: {{ $settings->navbar_links_color ?? 'var(--navbar-text-color, #fff)' }}">Vehículos</a>
            <a href="#nosotros" class="navbar-link-auto" style="color: {{ $settings->navbar_links_color ?? 'var(--navbar-text-color, #fff)' }}">Nosotros</a>
            <a href="#contacto" class="navbar-link-auto" style="color: {{ $settings->navbar_links_color ?? 'var(--navbar-text-color, #fff)' }}">Contacto</a>
        </div>
        </div>
    </nav>

    @yield('content')
    <!-- HERO editable -->
    <section class="max-w-7xl mx-auto px-4 py-12">
        <div class="rounded-3xl bg-gradient-to-b from-gray-700 to-gray-900 shadow-xl overflow-hidden relative flex flex-col justify-center items-center min-h-[320px]">
            @if(isset($editMode) && $editMode)
                <form action="{{ route('admin.template.hero.update', $tenant->id) }}" method="POST" enctype="multipart/form-data" class="absolute top-4 left-4 z-10">
                    @csrf
                    <input type="text" name="hero_title" value="{{ $settings->hero_title ?? 'Curando el futuro de la movilidad' }}" class="bg-gray-800 text-white rounded px-4 py-2 mb-2 w-96 font-bold text-2xl" placeholder="Título principal">
                    <input type="file" name="hero_image" accept="image/*" class="block mb-2">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Guardar</button>
                </form>
            @endif
            <div class="flex flex-col items-center justify-center h-full w-full">
                @if($settings && $settings->hero_image)
                    <img src="{{ $settings->hero_image }}" alt="Hero" class="mx-auto mb-6 rounded-xl object-cover h-48 w-full max-w-lg">
                @else
                    <div class="flex flex-col items-center justify-center h-48 w-full max-w-lg mb-6 rounded-xl bg-gradient-to-b from-gray-600 to-gray-800">
                        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="mx-auto text-gray-400"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                    </div>
                @endif
                <div class="px-6 py-4">
                    <h1 class="text-4xl font-extrabold mb-2 text-center" style="background: linear-gradient(90deg, var(--primary-color), #5a7cff); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">{{ $settings->hero_title ?? 'Curando el futuro de la movilidad' }}</h1>
                    <p class="text-lg text-gray-300 text-center">Explorá lo extraordinario</p>
                </div>
            </div>
        </div>
    </section

    <!-- Footer -->
    <footer class="bg-gray-900 py-8 text-center text-gray-400 text-sm border-t border-gray-700">
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
        function openForm(vehicleId, title) {
            document.getElementById('vehicle_id').value = vehicleId;
            document.querySelector('textarea[name="message"]').value = `Consulta: ${title}`;
            document.querySelector('form').scrollIntoView({ behavior: 'smooth' });
        }
    </script>
    @if(isset($editMode) && $editMode)
        @include('public.templates.partials.editor-scripts')
    @endif
</body>
</html>
