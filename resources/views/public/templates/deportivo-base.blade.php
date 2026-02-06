@php
    // Copia de la estructura general de deportivo, pero sin hero, nosotros, etc.
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
    </style>
</head>
<body style="background-color: var(--secondary-color); zoom: 1.2;" class="text-white">
    @php($template = 'deportivo')

    <!-- Navbar Deportivo (idéntico a la home) -->
    <style>
        .navbar-auto { color: var(--navbar-text-color, #fff); }
        .navbar-link-auto { color: var(--navbar-text-color, #fff); font-weight: bold; }
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
    <nav class="sticky top-0 z-50 backdrop-blur-lg border-b" style="border-color: var(--primary-color); zoom: 1.2;">
        <div class="max-w-7xl mx-auto px-6 py-3 flex justify-between items-center">
            <div class="flex items-center gap-3">
                @if($settings && $settings->logo_url)
                    <img src="{{ $settings->logo_url }}" alt="{{ $tenant->name }}" class="h-10 object-contain">
                @else
                    <div class="w-10 h-10 rounded-full" style="background: linear-gradient(135deg, var(--primary-color), white);"></div>
                @endif
                <span class="font-black text-xl tracking-wider navbar-auto">{{ $tenant->name }}</span>
            </div>
            <div class="flex items-center gap-6">
                <div class="hidden md:flex gap-6">
                    <a href="#inicio" class="navbar-link-auto transition" style="color: {{ $settings->navbar_links_color ?? 'var(--navbar-text-color, #fff)' }}">INICIO</a>
                    <a href="{{ route('public.vehiculos') }}" class="navbar-link-auto transition" style="color: {{ $settings->navbar_links_color ?? 'var(--navbar-text-color, #fff)' }}">VEHÍCULOS</a>
                    <a href="#nosotros" class="navbar-link-auto transition" style="color: {{ $settings->navbar_links_color ?? 'var(--navbar-text-color, #fff)' }}">NOSOTROS</a>
                    <a href="#contacto" class="navbar-link-auto transition" style="color: {{ $settings->navbar_links_color ?? 'var(--navbar-text-color, #fff)' }}">CONTACTO</a>
                </div>
                <a href="{{ route('login') }}" class="px-6 py-2 rounded-full font-bold transition hover:scale-105" style="background-color: var(--primary-color); color: var(--secondary-color);">
                    ACCESO
                </a>
            </div>
        </div>
    </nav>

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
