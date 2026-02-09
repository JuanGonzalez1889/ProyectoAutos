@php
    // Template base para la página de vehículos individuales - Elegante
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
                <span class="font-display text-xl font-bold tracking-wider uppercase" style="color: var(--primary-color);">{{ $tenant->name }}</span>
            </div>
            <div class="flex items-center gap-8">
                <div class="hidden md:flex gap-8">
                    <a href="#inicio" class="text-sm tracking-widest uppercase font-light transition hover:opacity-70" style="color: {{ $settings->navbar_links_color ?? 'rgba(255,255,255,0.7)' }}">Inicio</a>
                    <a href="{{ route('public.vehiculos') }}" class="text-sm tracking-widest uppercase font-light transition hover:opacity-70" style="color: {{ $settings->navbar_links_color ?? 'rgba(255,255,255,0.7)' }}">Colección</a>
                    <a href="#nosotros" class="text-sm tracking-widest uppercase font-light transition hover:opacity-70" style="color: {{ $settings->navbar_links_color ?? 'rgba(255,255,255,0.7)' }}">Nosotros</a>
                    <a href="#contacto" class="text-sm tracking-widest uppercase font-light transition hover:opacity-70" style="color: {{ $settings->navbar_links_color ?? 'rgba(255,255,255,0.7)' }}">Contacto</a>
                </div>
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="px-5 py-2 text-sm tracking-widest uppercase font-medium transition border" style="color: var(--primary-color); border-color: var(--primary-color);">
                        Panel
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    @yield('content')

    <!-- Footer -->
    <footer class="py-10 text-center text-gray-500 text-sm border-t" style="background: rgba(0,0,0,0.6); border-color: rgba(201,169,110,0.15);">
        © {{ date('Y') }} {{ $tenant->name }}
    </footer>
    @if(isset($editMode) && $editMode)
        @include('public.templates.partials.editor-scripts')
    @endif
</body>
</html>
