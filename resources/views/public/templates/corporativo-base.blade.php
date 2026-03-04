@php
    // Template base para la página de vehículos individuales - Corporativo
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
            --tertiary-color: {{ $settings && $settings->tertiary_color ? $settings->tertiary_color : '#e2e8f0' }};
        }
        body { font-family: {{ $settings->font_family ?? "'Inter', sans-serif" }}; }
        .font-corp { font-family: 'Inter', sans-serif; }

        @if(isset($editMode) && $editMode)
        .editable-section { position: relative; outline: 2px dashed rgba(30,58,95,0.3); outline-offset: 4px; }
        .editable-section:hover .edit-btn,
        .editable-section .edit-btn:hover,
        .editable-section .edit-btn:focus {
            display: flex !important;
        }
        .edit-btn { position: absolute; top: 8px; right: 8px; background: var(--primary-color); color: #fff; width: 32px; height: 32px; border-radius: 50%; display: none; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 2px 8px rgba(0,0,0,0.2); z-index: 50; transition: background 0.2s; }
        @endif
    </style>
</head>
<body style="background-color: var(--secondary-color);" class="text-gray-800">
    @php($template = 'corporativo')

    <!-- TOP INFO BAR — solo corporativo tiene esto -->
    <div class="top-bar py-2 px-4 text-xs" style="background: var(--primary-color); color: rgba(255,255,255,0.85);">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-6">
                @if($settings->phone)
                    <a href="tel:{{ $settings->phone }}" class="flex items-center gap-1.5 hover:text-white transition" style="color: rgba(255,255,255,0.85);">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        {{ $settings->phone }}
                    </a>
                @endif
                @if($settings->email)
                    <a href="mailto:{{ $settings->email }}" class="flex items-center gap-1.5 hover:text-white transition" style="color: rgba(255,255,255,0.85);">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        {{ $settings->email }}
                    </a>
                @endif
            </div>
            <div class="flex items-center gap-4">
                @if($settings->instagram_url)<a href="{{ $settings->instagram_url }}" target="_blank" class="hover:text-white transition" style="color: rgba(255,255,255,0.85);">Instagram</a>@endif
                @if($settings->facebook_url)<a href="{{ $settings->facebook_url }}" target="_blank" class="hover:text-white transition" style="color: rgba(255,255,255,0.85);">Facebook</a>@endif
                @if($settings->linkedin_url)<a href="{{ $settings->linkedin_url }}" target="_blank" class="hover:text-white transition" style="color: rgba(255,255,255,0.85);">LinkedIn</a>@endif
            </div>
        </div>
    </div>

    <!-- NAVBAR: Logo izquierda + menú derecha — profesional, color secundario -->
    <nav class="sticky top-0 z-50" style="background: var(--secondary-color); box-shadow: 0 2px 8px rgba(0,0,0,0.04); border-bottom: 1px solid var(--tertiary-color);">
        <div class="max-w-7xl mx-auto px-6 py-3 flex items-center justify-between relative">
            <div class="flex items-center gap-3">
                @if(isset($editMode) && $editMode)
                    <div class="editable-section inline-block relative">
                        @if($settings && $settings->logo_url)
                            <img src="{{ $settings->logo_url }}" alt="{{ $tenant->name }}" class="h-10 object-contain">
                        @else
                            <div class="h-10 w-10 rounded-lg flex items-center justify-center" style="background: var(--primary-color);">
                                <span class="text-white font-bold text-lg">{{ substr($tenant->name, 0, 1) }}</span>
                            </div>
                        @endif
                        <div class="edit-btn" onclick="editImage('logo_url')"><i class="fa fa-pencil"></i></div>
                    </div>
                    <div class="editable-section inline-block relative" style="min-width:100px; display:flex; align-items:center; gap:6px;">
                        <span class="text-lg font-semibold" style="color: var(--primary-color);">{{ $tenant->name }}</span>
                        <button type="button" class="edit-btn" style="position:static; display:flex; margin-left:4px; background:var(--primary-color); color:#fff; width:24px; height:24px; border-radius:50%; align-items:center; justify-content:center; cursor:pointer; z-index:50; border:none; font-size:10px;" onclick="editText('agency_name','Editar Nombre')"><i class="fa fa-pencil"></i></button>
                    </div>
                @else
                    @if($settings && $settings->logo_url)
                        <img src="{{ $settings->logo_url }}" alt="{{ $tenant->name }}" class="h-10 object-contain">
                    @else
                        <div class="h-10 w-10 rounded-lg flex items-center justify-center" style="background: var(--primary-color);">
                            <span class="text-white font-bold text-lg">{{ substr($tenant->name, 0, 1) }}</span>
                        </div>
                    @endif
                    <span class="text-lg font-semibold" style="color: var(--primary-color);">{{ $tenant->name }}</span>
                @endif
            </div>
            <!-- Botón hamburguesa solo en mobile -->
            <div class="md:hidden ml-4">
                <div id="hamburger-btn" class="hamburger" onclick="toggleMenu()">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
            <!-- Menú normal en desktop -->
            <div class="hidden md:flex items-center gap-8">
                <a href="/" class="text-sm font-medium text-gray-500 hover:text-gray-900 transition" style="color: {{ $settings->navbar_links_color ?? '#64748b' }}">Inicio</a>
                <a href="{{ route('public.vehiculos') }}" class="text-sm font-medium text-gray-500 hover:text-gray-900 transition" style="color: {{ $settings->navbar_links_color ?? '#64748b' }}">Inventario</a>
                <a href="/#nosotros" class="text-sm font-medium text-gray-500 hover:text-gray-900 transition" style="color: {{ $settings->navbar_links_color ?? '#64748b' }}">Empresa</a>
                <a href="/#contacto" class="text-sm font-medium px-5 py-2 rounded-lg text-white transition hover:opacity-90" style="background: var(--primary-color);">Contactar</a>
            </div>
            <!-- Menú hamburguesa en mobile -->
            <div id="mobile-menu" class="mobile-menu md:hidden" style="background: var(--secondary-color); border-top: 1px solid var(--tertiary-color);">
                <div class="flex flex-col gap-4 p-4">
                    <a href="/" class="text-sm font-medium text-gray-500 hover:text-gray-900 transition" style="color: {{ $settings->navbar_links_color ?? '#64748b' }}">Inicio</a>
                    <a href="{{ route('public.vehiculos') }}" class="text-sm font-medium text-gray-500 hover:text-gray-900 transition" style="color: {{ $settings->navbar_links_color ?? '#64748b' }}">Inventario</a>
                    <a href="/#nosotros" class="text-sm font-medium text-gray-500 hover:text-gray-900 transition" style="color: {{ $settings->navbar_links_color ?? '#64748b' }}">Empresa</a>
                    <a href="/#contacto" class="text-sm font-medium px-5 py-2 rounded-lg text-white transition hover:opacity-90" style="background: var(--primary-color);">Contactar</a>
                </div>
            </div>
        </div>
    </nav>
    <style>
        .hamburger {
            display: block;
            width: 32px;
            height: 32px;
            cursor: pointer;
        }
        .hamburger span {
            display: block;
            height: 4px;
            margin: 6px 0;
            background: var(--primary-color);
            border-radius: 2px;
            transition: 0.3s;
        }
        .mobile-menu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            z-index: 100;
        }
        .mobile-menu.open {
            display: block;
        }
    </style>
    <script>
        function toggleMenu() {
            var menu = document.getElementById('mobile-menu');
            menu.classList.toggle('open');
        }
        document.addEventListener('click', function(e) {
            var menu = document.getElementById('mobile-menu');
            var hamburger = document.getElementById('hamburger-btn');
            if (!menu || !hamburger) return;
            if (!menu.contains(e.target) && !hamburger.contains(e.target)) {
                menu.classList.remove('open');
            }
        });
    </script>

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
