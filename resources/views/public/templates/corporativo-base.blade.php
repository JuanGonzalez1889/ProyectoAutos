@php
    // Template base para la página de vehículos individuales - Corporativo
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
        $fontUrl = isset($googleFonts[$font]) ? 'https://fonts.googleapis.com/css?family=' . $googleFonts[$font] . ':400,500,600,700&display=swap' : null;
    @endphp
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @if($fontUrl)
        <link href="{{ $fontUrl }}" rel="stylesheet">
    @endif
    <style>
        :root {
            --primary-color: {{ $settings && $settings->primary_color ? $settings->primary_color : '#1e3a5f' }};
            --secondary-color: {{ $settings && $settings->secondary_color ? $settings->secondary_color : '#f8fafc' }};
            --tertiary-color: {{ $settings && $settings->tertiary_color ? $settings->tertiary_color : '#2563eb' }};
        }
        body { font-family: {{ $settings->font_family ?? "'Inter', sans-serif" }}; }
    </style>
</head>
<body style="background-color: var(--secondary-color);" class="text-gray-800">
    @php($template = 'corporativo')

    <!-- Top Bar -->
    <div style="background: var(--primary-color);" class="text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2 flex items-center justify-between text-xs">
            <div class="flex items-center gap-6">
                @if($settings->phone)
                    <span class="flex items-center gap-1">📞 {{ $settings->phone }}</span>
                @endif
                @if($settings->email)
                    <span class="flex items-center gap-1 hidden md:flex">✉️ {{ $settings->email }}</span>
                @endif
            </div>
        </div>
    </div>

    <!-- Navbar Corporativo -->
    <nav class="sticky top-0 z-50 bg-white shadow-sm border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                @if($settings && $settings->logo_url)
                    <img src="{{ $settings->logo_url }}" alt="{{ $tenant->name }}" class="h-10 object-contain">
                @else
                    <div class="h-10 w-10 rounded-lg flex items-center justify-center text-white font-bold text-lg" style="background: var(--primary-color);">{{ substr($tenant->name, 0, 1) }}</div>
                @endif
                <span class="text-xl font-bold" style="color: var(--primary-color);">{{ $tenant->name }}</span>
            </div>
            <div class="flex items-center gap-8">
                <div class="hidden md:flex gap-6">
                    <a href="#inicio" class="text-sm font-medium text-gray-600 hover:text-gray-900 transition" style="color: {{ $settings->navbar_links_color ?? '#4b5563' }}">Inicio</a>
                    <a href="{{ route('public.vehiculos') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 transition" style="color: {{ $settings->navbar_links_color ?? '#4b5563' }}">Vehículos</a>
                    <a href="#nosotros" class="text-sm font-medium text-gray-600 hover:text-gray-900 transition" style="color: {{ $settings->navbar_links_color ?? '#4b5563' }}">Empresa</a>
                    <a href="#contacto" class="text-sm font-medium text-gray-600 hover:text-gray-900 transition" style="color: {{ $settings->navbar_links_color ?? '#4b5563' }}">Contacto</a>
                </div>
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="px-5 py-2.5 rounded-lg text-sm font-medium text-white transition" style="background: var(--primary-color);">
                        Panel Admin
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    @yield('content')

    <!-- Footer -->
    <footer class="bg-gray-900 py-8 text-center text-gray-500 text-sm border-t border-gray-800">
        © {{ date('Y') }} {{ $tenant->name }}
    </footer>
    @if(isset($editMode) && $editMode)
        @include('public.templates.partials.editor-scripts')
    @endif
</body>
</html>
