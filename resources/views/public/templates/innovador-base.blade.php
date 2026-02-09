@php
    // Base layout for innovador template — vehicle detail pages
@endphp
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $tenant->name ?? 'Agencia de Autos' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @php
        $font = $settings->font_family ?? 'Inter, sans-serif';
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
        $fontUrl = isset($googleFonts[$font]) ? 'https://fonts.googleapis.com/css?family=' . $googleFonts[$font] . ':300,400,500,600,700,800&display=swap' : null;
    @endphp
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @if($fontUrl)
        <link href="{{ $fontUrl }}" rel="stylesheet">
    @endif
    <style>
        :root {
            --primary-color: {{ $settings && $settings->primary_color ? $settings->primary_color : '#2563eb' }};
            --secondary-color: {{ $settings && $settings->secondary_color ? $settings->secondary_color : '#fafbff' }};
            --tertiary-color: {{ $settings && $settings->tertiary_color ? $settings->tertiary_color : '#e0e7ff' }};
        }
        body { font-family: {{ $settings->font_family ?? "'Inter', sans-serif" }}; }
    </style>
</head>
<body style="background-color: var(--secondary-color);" class="text-gray-800 antialiased">
    @php($template = 'innovador')

    <!-- Navbar -->
    <nav class="sticky top-0 z-50 bg-white/90 backdrop-blur-xl border-b border-gray-100/50">
        <div class="max-w-7xl mx-auto px-6 py-3.5 flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                @if($settings && $settings->logo_url)
                    <img src="{{ $settings->logo_url }}" alt="{{ $tenant->name }}" class="h-9 object-contain">
                @else
                    <div class="h-9 w-9 rounded-xl flex items-center justify-center" style="background: var(--primary-color);">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                @endif
                <span class="text-lg font-bold text-gray-900">{{ $tenant->name }}</span>
            </div>
            <div class="flex items-center gap-8">
                <div class="hidden md:flex gap-7">
                    <a href="#inicio" class="text-sm font-medium text-gray-500 hover:text-gray-900 transition" style="color: {{ $settings->navbar_links_color ?? '#6b7280' }}">Inventario</a>
                    <a href="{{ route('public.vehiculos') }}" class="text-sm font-medium text-gray-500 hover:text-gray-900 transition" style="color: {{ $settings->navbar_links_color ?? '#6b7280' }}">Vehículos</a>
                    <a href="#nosotros" class="text-sm font-medium text-gray-500 hover:text-gray-900 transition" style="color: {{ $settings->navbar_links_color ?? '#6b7280' }}">Nosotros</a>
                    <a href="#contacto" class="text-sm font-medium text-gray-500 hover:text-gray-900 transition" style="color: {{ $settings->navbar_links_color ?? '#6b7280' }}">Contacto</a>
                </div>
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="px-5 py-2 text-sm font-semibold text-white rounded-xl transition hover:opacity-90" style="background: var(--primary-color);">
                        Panel Admin
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    @yield('content')

    <!-- Footer -->
    <footer class="py-8 text-center text-xs text-gray-400 bg-gray-900" style="border-top: 1px solid rgba(255,255,255,0.06);">
        © {{ date('Y') }} {{ $tenant->name }}. Todos los derechos reservados.
    </footer>
    @if(isset($editMode) && $editMode)
        @include('public.templates.partials.editor-scripts')
    @endif
</body>
</html>
