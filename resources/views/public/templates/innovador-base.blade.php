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
            <div class="flex items-center gap-2.5">
                <div class="editable-section inline-block relative">
                    @if($settings && $settings->logo_url)
                        <img src="{{ $settings->logo_url }}" alt="{{ $tenant->name }}" class="h-9 object-contain">
                    @else
                        <div class="h-9 w-9 rounded-xl flex items-center justify-center" style="background: var(--primary-color);">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </div>
                    @endif
                    <div class="edit-btn" onclick="editImage('logo_url')"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="18" height="18" fill="currentColor" style="vertical-align:middle"><path d="M12.146 2.146a1 1 0 0 1 1.414 0l.294.294a1 1 0 0 1 0 1.414l-8.5 8.5a1 1 0 0 1-.293.207l-2.5 1.25a.5.5 0 0 1-.66-.66l1.25-2.5a1 1 0 0 1 .207-.293l8.5-8.5zm1.414-1.414a2 2 0 0 0-2.828 0l-8.5 8.5a2 2 0 0 0-.414.586l-1.25 2.5A1.5 1.5 0 0 0 2.5 14.5l2.5-1.25a2 2 0 0 0 .586-.414l8.5-8.5a2 2 0 0 0 0-2.828l-.294-.294z"/></svg></div>
                </div>
            </div>
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
