@php
    // Base layout for innovador template — vehicle detail pages
@endphp
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/storage/icono.png">
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

        @if(isset($editMode) && $editMode)
            .editable-section {
                position: relative;
                outline: 2px dashed rgba(37, 99, 235, 0.35);
                outline-offset: 4px;
            }
            .editable-section:hover .edit-btn,
            .editable-section .edit-btn:hover,
            .editable-section .edit-btn:focus {
                display: flex !important;
            }
            .edit-btn {
                position: absolute;
                top: 8px;
                right: 8px;
                background: var(--primary-color);
                color: #fff;
                width: 32px;
                height: 32px;
                border-radius: 50%;
                display: none;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
                z-index: 50;
                transition: background 0.2s;
            }
        @endif
    </style>
</head>
<body style="background-color: var(--secondary-color);" class="text-gray-800 antialiased">
    @php($template = 'innovador')

    <!-- NAVBAR: Color secundario -->
    <nav class="sticky top-0 z-50" style="background: var(--secondary-color); backdrop-filter: blur(20px); border-bottom: 1px solid var(--tertiary-color);">
        <div class="max-w-7xl mx-auto px-6 py-3.5 flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                @if(isset($editMode) && $editMode)
                    <div class="editable-section inline-block relative">
                        @if($settings && $settings->logo_url)
                            <img src="{{ $settings->logo_url }}" alt="{{ $tenant->name }}" class="h-9 object-contain">
                        @else
                            <div class="h-9 w-9 rounded-xl flex items-center justify-center" style="background: var(--primary-color);">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            </div>
                        @endif
                        <div class="edit-btn" onclick="editImage('logo_url')"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="14" height="14" fill="currentColor" style="vertical-align:middle"><path d="M12.146.854a.5.5 0 0 1 .708 0l2.292 2.292a.5.5 0 0 1 0 .708l-9.5 9.5a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l9.5-9.5z"/></svg></div>
                    </div>
                    <div class="editable-section inline-block relative" style="min-width:100px; display:flex; align-items:center; gap:6px;">
                        <span class="text-lg font-bold text-gray-900" style="color: {{ $settings->agency_name_color ?? '#111827' }}">{{ $tenant->name }}</span>
                        <button type="button" class="edit-btn" style="position:static; display:flex; margin-left:4px; background:var(--primary-color); color:#fff; width:24px; height:24px; border-radius:50%; align-items:center; justify-content:center; cursor:pointer; z-index:50; border:none; font-size:10px;" onclick="editText('agency_name','Editar Nombre')"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="14" height="14" fill="currentColor" style="vertical-align:middle"><path d="M12.146.854a.5.5 0 0 1 .708 0l2.292 2.292a.5.5 0 0 1 0 .708l-9.5 9.5a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l9.5-9.5z"/></svg></button>
                    </div>
                @else
                    <div class="inline-block relative">
                        @if($settings && $settings->logo_url)
                            <img src="{{ $settings->logo_url }}" alt="{{ $tenant->name }}" class="h-9 object-contain">
                        @else
                            <div class="h-9 w-9 rounded-xl flex items-center justify-center" style="background: var(--primary-color);">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            </div>
                        @endif
                    </div>
                    <span class="text-lg font-bold text-gray-900" style="color: {{ $settings->agency_name_color ?? '#111827' }}">{{ $tenant->name }}</span>
                @endif
            </div>
            <!-- Menú Desktop -->
            <div class="hidden md:flex items-center gap-7">
                <a href="/" class="text-sm font-medium transition hover:text-gray-900" style="color: {{ $settings->navbar_links_color ?? '#6b7280' }}">Inicio</a>
                <a href="{{ route('public.vehiculos') }}" class="text-sm font-medium transition hover:text-gray-900" style="color: {{ $settings->navbar_links_color ?? '#6b7280' }}">Vehículos</a>
                <a href="/#nosotros" class="text-sm font-medium transition hover:text-gray-900" style="color: {{ $settings->navbar_links_color ?? '#6b7280' }}">Nosotros</a>
                <a href="/#contacto" class="text-sm font-medium transition hover:text-gray-900" style="color: {{ $settings->navbar_links_color ?? '#6b7280' }}">Contacto</a>
            </div>

            <!-- Botón Hamburguesa Mobile -->
            <button id="menu-toggle" class="md:hidden flex flex-col justify-center items-center w-10 h-10 focus:outline-none ml-2" aria-label="Abrir menú">
                <span class="block w-6 h-0.5 bg-gray-900 mb-1 transition-all"></span>
                <span class="block w-6 h-0.5 bg-gray-900 mb-1 transition-all"></span>
                <span class="block w-6 h-0.5 bg-gray-900 transition-all"></span>
            </button>
        </div>
        <!-- Menú Mobile -->
        <div id="mobile-menu" class="md:hidden fixed inset-0 z-50 flex flex-col items-center justify-center space-y-8 text-lg font-semibold transition-all duration-300 opacity-0 pointer-events-none" style="background: var(--secondary-color);">
            <button id="menu-close" class="absolute top-6 right-6 text-gray-900 text-3xl focus:outline-none" aria-label="Cerrar menú">&times;</button>
            <a href="/" class="text-sm font-medium transition hover:text-gray-900" style="color: {{ $settings->navbar_links_color ?? '#6b7280' }}">Inicio</a>
            <a href="{{ route('public.vehiculos') }}" class="navbar-link-auto text-gray-900">Vehículos</a>
            <a href="/#nosotros" class="navbar-link-auto text-gray-900">Nosotros</a>
            <a href="/#contacto" class="navbar-link-auto text-gray-900">Contacto</a>
        </div>
        </div>
    </nav>

    @yield('content')

    <!-- Footer -->
    <footer class="py-8 text-center text-xs text-gray-400 bg-gray-900" style="border-top: 1px solid rgba(255,255,255,0.06);">
        © {{ date('Y') }} {{ $tenant->name }}. Todos los derechos reservados.
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
