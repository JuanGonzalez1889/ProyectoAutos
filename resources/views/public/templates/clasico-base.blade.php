@php
    // Copia de la estructura general de clasico, pero sin hero, nosotros, etc.
@endphp
<!DOCTYPE html>
<html lang="es" style="font-size: 140%;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        .edit-btn {
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            background: var(--primary-color) !important;
            color: #fff !important;
            border-radius: 50%;
            font-size: 18px !important;
            padding: 4px !important;
            margin-left: 6px;
            cursor: pointer;
            z-index: 9999 !important;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
            border: none;
        }
    </style>
</head>
<body style="background-color: var(--secondary-color);" class="text-white">
    @php($template = 'clasico')

    <!-- Header Clásico (idéntico a la home) -->
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
    <header style="background-color: var(--secondary-color);" class="sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-4">
                            <div class="editable-section inline-block relative">
                                @if($settings && $settings->logo_url)
                                    <img src="{{ $settings->logo_url }}" alt="{{ $tenant->name }}" class="h-10 object-contain">
                                @endif
                                <div class="edit-btn" onclick="editImage('logo_url')">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="18" height="18" fill="currentColor" style="vertical-align:middle"><path d="M12.146 2.146a1 1 0 0 1 1.414 0l.294.294a1 1 0 0 1 0 1.414l-8.5 8.5a1 1 0 0 1-.293.207l-2.5 1.25a.5.5 0 0 1-.66-.66l1.25-2.5a1 1 0 0 1 .207-.293l8.5-8.5zm1.414-1.414a2 2 0 0 0-2.828 0l-8.5 8.5a2 2 0 0 0-.414.586l-1.25 2.5A1.5 1.5 0 0 0 2.5 14.5l2.5-1.25a2 2 0 0 0 .586-.414l8.5-8.5a2 2 0 0 0 0-2.828l-.294-.294z"/></svg>
                                </div>
                            </div>
                            <h1 class="text-2xl font-bold navbar-auto">{{ $tenant->name }}</h1>
                            <div class="editable-section inline-block relative ml-2">
                                <span class="font-semibold" style="color: {{ $settings->navbar_agency_name_color ?? '#fff' }}">{{ $settings->navbar_agency_name }}</span>
                                <div class="edit-btn" onclick="editText('navbar_agency_name', 'Editar Nombre de Agencia (Navbar)')">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="18" height="18" fill="currentColor" style="vertical-align:middle"><path d="M12.146 2.146a1 1 0 0 1 1.414 0l.294.294a1 1 0 0 1 0 1.414l-8.5 8.5a1 1 0 0 1-.293.207l-2.5 1.25a.5.5 0 0 1-.66-.66l1.25-2.5a1 1 0 0 1 .207-.293l8.5-8.5zm1.414-1.414a2 2 0 0 0-2.828 0l-8.5 8.5a2 2 0 0 0-.414.586l-1.25 2.5A1.5 1.5 0 0 0 2.5 14.5l2.5-1.25a2 2 0 0 0 .586-.414l8.5-8.5a2 2 0 0 0 0-2.828l-.294-.294z"/></svg>
                                </div>
                            </div>
                </div>
                <div class="flex items-center gap-6">
                    <div class="hidden md:flex gap-6">
                        <a href="#inicio" class="navbar-link-auto transition font-medium" style="color: {{ $settings->navbar_links_color ?? 'var(--navbar-text-color, #fff)' }}">Inicio</a>
                        <a href="{{ route('public.vehiculos') }}" class="navbar-link-auto transition font-medium" style="color: {{ $settings->navbar_links_color ?? 'var(--navbar-text-color, #fff)' }}">Vehículos</a>
                        <a href="#nosotros" class="navbar-link-auto transition font-medium" style="color: {{ $settings->navbar_links_color ?? 'var(--navbar-text-color, #fff)' }}">Nosotros</a>
                        <a href="#contacto" class="navbar-link-auto transition font-medium" style="color: {{ $settings->navbar_links_color ?? 'var(--navbar-text-color, #fff)' }}">Contacto</a>
                    </div>
                    <a href="{{ route('login') }}" class="border-2 border-white px-6 py-2 rounded hover:bg-white hover:text-gray-900 transition">
                        Ingresar
                    </a>
                </div>
            </div>
        </div>
    </header>

    @yield('content')

    <!-- Footer -->
    <footer class="bg-gray-900 py-8 text-center text-gray-400 text-sm border-t border-gray-800">
        © {{ date('Y') }} {{ $tenant->name }}
    </footer>
    @if(isset($editMode) && $editMode)
        @include('public.templates.partials.editor-scripts')
    @endif
</body>
</html>
