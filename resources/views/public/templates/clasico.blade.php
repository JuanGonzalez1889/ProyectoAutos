<!DOCTYPE html>
<html lang="es">
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
<body class="bg-white">
    @php($template = 'clasico')
    <!-- Header Clásico -->
    <header style="background-color: var(--secondary-color);" class="text-white sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-6 py-4 relative">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-4">
                    @if(isset($editMode) && $editMode)
                        <div class="editable-section inline-block relative">
                            @if($settings && $settings->logo_url)
                                <img src="{{ $settings->logo_url }}" alt="{{ $tenant->name }}" class="h-10 object-contain">
                            @else
                                <div class="h-10 w-10 rounded flex items-center justify-center bg-gray-700">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                </div>
                            @endif
                            <div class="edit-btn" onclick="editImage('logo_url')">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="18" height="18" fill="currentColor" style="vertical-align:middle"><path d="M12.146 2.146a1 1 0 0 1 1.414 0l.294.294a1 1 0 0 1 0 1.414l-8.5 8.5a1 1 0 0 1-.293.207l-2.5 1.25a.5.5 0 0 1-.66-.66l1.25-2.5a1 1 0 0 1 .207-.293l8.5-8.5zm1.414-1.414a2 2 0 0 0-2.828 0l-8.5 8.5a2 2 0 0 0-.414.586l-1.25 2.5A1.5 1.5 0 0 0 2.5 14.5l2.5-1.25a2 2 0 0 0 .586-.414l8.5-8.5a2 2 0 0 0 0-2.828l-.294-.294z"/></svg>
                            </div>
                        </div>
                        <div class="editable-section inline-block relative ml-2">
                            <h1 class="text-2xl font-bold" style="color: {{ $settings->agency_name_color ?? '#fff' }}">{{ $tenant->name }}</h1>
                            <div class="edit-btn" onclick="editText('agency_name', 'Editar Nombre de Agencia')">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="18" height="18" fill="currentColor" style="vertical-align:middle"><path d="M12.146 2.146a1 1 0 0 1 1.414 0l.294.294a1 1 0 0 1 0 1.414l-8.5 8.5a1 1 0 0 1-.293.207l-2.5 1.25a.5.5 0 0 1-.66-.66l1.25-2.5a1 1 0 0 1 .207-.293l8.5-8.5zm1.414-1.414a2 2 0 0 0-2.828 0l-8.5 8.5a2 2 0 0 0-.414.586l-1.25 2.5A1.5 1.5 0 0 0 2.5 14.5l2.5-1.25a2 2 0 0 0 .586-.414l8.5-8.5a2 2 0 0 0 0-2.828l-.294-.294z"/></svg>
                            </div>
                        </div>
                    @else
                        <div class="inline-block relative">
                            @if($settings && $settings->logo_url)
                                <img src="{{ $settings->logo_url }}" alt="{{ $tenant->name }}" class="h-10 object-contain">
                            @else
                                <div class="h-10 w-10 rounded flex items-center justify-center bg-gray-700">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                </div>
                            @endif
                        </div>
                        <h1 class="text-2xl font-bold">{{ $tenant->name }}</h1>
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
                <div class="hidden md:flex items-center gap-6">
                    <a href="#inicio" class="font-medium" style="color: {{ $settings->navbar_links_color ?? 'var(--navbar-text-color, #fff)' }}">Inicio</a>
                    <a href="{{ route('public.vehiculos') }}" class="font-medium" style="color: {{ $settings->navbar_links_color ?? 'var(--navbar-text-color, #fff)' }}">Vehículos</a>
                    <a href="#nosotros" class="font-medium" style="color: {{ $settings->navbar_links_color ?? 'var(--navbar-text-color, #fff)' }}">Nosotros</a>
                    <a href="#contacto" class="font-medium" style="color: {{ $settings->navbar_links_color ?? 'var(--navbar-text-color, #fff)' }}">Contacto</a>
                </div>
                <!-- Menú hamburguesa en mobile -->
                <div id="mobile-menu" class="mobile-menu md:hidden">
                    <div class="flex flex-col gap-4 p-4">
                        <a href="#inicio" class="font-medium" style="color: {{ $settings->navbar_links_color ?? 'var(--navbar-text-color, #fff)' }}">Inicio</a>
                        <a href="{{ route('public.vehiculos') }}" class="font-medium" style="color: {{ $settings->navbar_links_color ?? 'var(--navbar-text-color, #fff)' }}">Vehículos</a>
                        <a href="#nosotros" class="font-medium" style="color: {{ $settings->navbar_links_color ?? 'var(--navbar-text-color, #fff)' }}">Nosotros</a>
                        <a href="#contacto" class="font-medium" style="color: {{ $settings->navbar_links_color ?? 'var(--navbar-text-color, #fff)' }}">Contacto</a>
                    </div>
                </div>
            </div>
        </div>
    </header>
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
            background: var(--navbar-text-color, #fff);
            border-radius: 2px;
            transition: 0.3s;
        }
        .mobile-menu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            background: var(--secondary-color);
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

    <!-- Banner Clásico -->
    <div class="relative w-full h-64 md:h-80 lg:h-96 flex items-center justify-center bg-gray-200 overflow-hidden">
        @if(isset($editMode) && $editMode)
            <div class="editable-section w-full h-full relative">
                @if($settings && $settings->banner_url)
                    <img src="{{ $settings->banner_url }}" alt="Banner" class="absolute inset-0 w-full h-full object-cover opacity-80">
                @else
                    <div class="w-full h-full flex items-center justify-center bg-gray-700">
                        <svg class="w-16 h-16 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                @endif
                <div class="edit-btn absolute top-4 right-4 z-20" onclick="editImage('banner_url')">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="18" height="18" fill="currentColor" style="vertical-align:middle"><path d="M12.146 2.146a1 1 0 0 1 1.414 0l.294.294a1 1 0 0 1 0 1.414l-8.5 8.5a1 1 0 0 1-.293.207l-2.5 1.25a.5.5 0 0 1-.66-.66l1.25-2.5a1 1 0 0 1 .207-.293l8.5-8.5zm1.414-1.414a2 2 0 0 0-2.828 0l-8.5 8.5a2 2 0 0 0-.414.586l-1.25 2.5A1.5 1.5 0 0 0 2.5 14.5l2.5-1.25a2 2 0 0 0 .586-.414l8.5-8.5a2 2 0 0 0 0-2.828l-.294-.294z"/></svg>
                </div>
            </div>
            <div class="editable-section absolute inset-0 flex flex-col items-center justify-center z-10">
                <h1 class="text-5xl md:text-6xl font-black text-white drop-shadow-lg text-center">
                    <span style="color: {{ $settings->home_description_color ?? '#fff' }}">
                        {{ $settings->home_description ?? 'Bienvenido a nuestra agencia' }}
                    </span>
                </h1>
                <div class="edit-btn" onclick="editText('home_description', 'Editar Texto del Banner')">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="18" height="18" fill="currentColor" style="vertical-align:middle"><path d="M12.146 2.146a1 1 0 0 1 1.414 0l.294.294a1 1 0 0 1 0 1.414l-8.5 8.5a1 1 0 0 1-.293.207l-2.5 1.25a.5.5 0 0 1-.66-.66l1.25-2.5a1 1 0 0 1 .207-.293l8.5-8.5zm1.414-1.414a2 2 0 0 0-2.828 0l-8.5 8.5a2 2 0 0 0-.414.586l-1.25 2.5A1.5 1.5 0 0 0 2.5 14.5l2.5-1.25a2 2 0 0 0 .586-.414l8.5-8.5a2 2 0 0 0 0-2.828l-.294-.294z"/></svg>
                </div>
            </div>
        @else
            <div class="relative w-full h-full flex items-center justify-center">
                @if($settings && $settings->banner_url)
                    <img src="{{ $settings->banner_url }}" alt="Banner" class="absolute inset-0 w-full h-full object-cover opacity-80">
                @else
                    <div class="w-full h-full flex items-center justify-center bg-gray-700">
                        <svg class="w-16 h-16 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                @endif
            </div>
            <div class="absolute inset-0 flex flex-col items-center justify-center z-10">
                <h1 class="text-5xl md:text-6xl font-black text-white drop-shadow-lg text-center">{{ $settings->home_description ?? 'Bienvenido a nuestra agencia' }}</h1>
            </div>
        @endif
    </div>

    <!-- Inicio -->
    

    <!-- Sección de Vehículos -->
    @if($settings->show_vehicles && $vehicles->count() > 0)
        <div id="vehiculos" class="max-w-6xl mx-auto px-6 py-16 border-b" style="border-color: rgba(255,255,255,0.1);">
            <h2 class="text-4xl font-bold mb-12 text-center auto-contrast-title">Nuestros Vehículos</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">
                @foreach($vehicles as $vehicle)
                    <div class="border-2 rounded-lg overflow-hidden hover:shadow-xl hover:-translate-y-2 transition transform" style="border-color: var(--primary-color);">
                        <img src="{{ $vehicle->main_image }}" alt="{{ $vehicle->title }}" class="w-full h-40 object-cover">
                        <div class="p-4">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="text-lg font-bold flex-1">{{ $vehicle->title }}</h3>
                                <span class="font-bold text-sm" style="color: var(--primary-color);">${{ number_format($vehicle->price) }}</span>
                            </div>
                            <p class="text-gray-400 text-xs mb-2">{{ $vehicle->brand }} {{ $vehicle->model }} · {{ $vehicle->year }}</p>
                            <p class="text-gray-300 text-xs mb-3 line-clamp-1">{{ Str::limit($vehicle->description, 60) }}</p>

                            <button onclick="openForm('{{ $vehicle->id }}', '{{ $vehicle->title }}')" class="w-full py-2 text-white font-semibold rounded text-xs transition hover:opacity-90" style="background: linear-gradient(135deg, var(--primary-color), var(--tertiary-color));">
                                Ver Detalles
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Nosotros Section -->
    <div class="max-w-6xl mx-auto px-6 py-16 border-b" style="border-color: rgba(255,255,255,0.1);">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-4xl font-bold auto-contrast-title" style="color: var(--primary-color);">Sobre Nosotros</h2>
                <script>
                // Contraste automático para títulos principales y de sección
                function getContrastYIQ(hexcolor) {
                    hexcolor = hexcolor.replace('#', '');
                    if(hexcolor.length === 3) hexcolor = hexcolor.split('').map(x=>x+x).join('');
                    var r = parseInt(hexcolor.substr(0,2),16);
                    var g = parseInt(hexcolor.substr(2,2),16);
                    var b = parseInt(hexcolor.substr(4,2),16);
                    var yiq = ((r*299)+(g*587)+(b*114))/1000;
                    return (yiq >= 180) ? '#222' : '#fff';
                }
                function applyTitleContrast() {
                    let bg = getComputedStyle(document.body).backgroundColor;
                    let hex = window.getComputedStyle(document.body).getPropertyValue('--secondary-color') || '#fff';
                    if(hex.startsWith('#')) {
                        // ok
                    } else if(bg) {
                        // fallback: rgb to hex
                        let rgb = bg.match(/\d+/g);
                        if(rgb) hex = '#' + rgb.map(x=>(+x).toString(16).padStart(2,'0')).join('');
                    }
                    document.querySelectorAll('.auto-contrast-title').forEach(el=>{
                        el.style.color = getContrastYIQ(hex.trim());
                    });
                }
                document.addEventListener('DOMContentLoaded', applyTitleContrast);
                window.addEventListener('settings:updated', applyTitleContrast);
                </script>
            @if(isset($editMode) && $editMode)
                <button onclick="editText('nosotros_description','Texto de Nosotros')" class="bg-blue-600 text-white text-xs px-3 py-1 rounded">Editar texto</button>
            @endif
        </div>
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <div>
                @if(isset($editMode) && $editMode)
                    <div class="editable-section relative mb-4">
                        <p class="text-lg mb-8 leading-relaxed whitespace-pre-line" style="color: {{ $settings->nosotros_description_color ?? '#222' }}">
                            {{ $settings->nosotros_description ?? 'Cuéntale a tus usuarios sobre tu agencia, experiencia y servicios.' }}
                        </p>
                        <div class="edit-btn" onclick="editText('nosotros_description', 'Editar Sección Nosotros')">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="18" height="18" fill="currentColor" style="vertical-align:middle"><path d="M12.146 2.146a1 1 0 0 1 1.414 0l.294.294a1 1 0 0 1 0 1.414l-8.5 8.5a1 1 0 0 1-.293.207l-2.5 1.25a.5.5 0 0 1-.66-.66l1.25-2.5a1 1 0 0 1 .207-.293l8.5-8.5zm1.414-1.414a2 2 0 0 0-2.828 0l-8.5 8.5a2 2 0 0 0-.414.586l-1.25 2.5A1.5 1.5 0 0 0 2.5 14.5l2.5-1.25a2 2 0 0 0 .586-.414l8.5-8.5a2 2 0 0 0 0-2.828l-.294-.294z"/></svg>
                        </div>
                    </div>
                    <div class="editable-section grid grid-cols-3 gap-4">
                        <div class="text-center p-4 rounded" style="background-color: rgba(59, 130, 246, 0.1); border: 1px solid rgb(59, 130, 246);">
                            <div class="text-3xl font-bold" style="color: var(--primary-color);">{{ $settings->stat1 ?? '150+' }}</div>
                            <p class="text-gray-600 text-sm">{{ $settings->stat1_label ?? 'Autos Vendidos' }}</p>
                        </div>
                        <div class="text-center p-4 rounded" style="background-color: rgba(59, 130, 246, 0.1); border: 1px solid rgb(59, 130, 246);">
                            <div class="text-3xl font-bold" style="color: var(--primary-color);">{{ $settings->stat2 ?? '98%' }}</div>
                            <p class="text-gray-600 text-sm">{{ $settings->stat2_label ?? 'Clientes Satisfechos' }}</p>
                        </div>
                        <div class="text-center p-4 rounded" style="background-color: rgba(59, 130, 246, 0.1); border: 1px solid rgb(59, 130, 246);">
                            <div class="text-3xl font-bold" style="color: var(--primary-color);">{{ $settings->stat3 ?? '24h' }}</div>
                            <p class="text-gray-600 text-sm">{{ $settings->stat3_label ?? 'Atención al Cliente' }}</p>
                        </div>
                        <div class="edit-btn col-span-3 flex justify-center" onclick="editStats()">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="18" height="18" fill="currentColor" style="vertical-align:middle"><path d="M12.146 2.146a1 1 0 0 1 1.414 0l.294.294a1 1 0 0 1 0 1.414l-8.5 8.5a1 1 0 0 1-.293.207l-2.5 1.25a.5.5 0 0 1-.66-.66l1.25-2.5a1 1 0 0 1 .207-.293l8.5-8.5zm1.414-1.414a2 2 0 0 0-2.828 0l-8.5 8.5a2 2 0 0 0-.414.586l-1.25 2.5A1.5 1.5 0 0 0 2.5 14.5l2.5-1.25a2 2 0 0 0 .586-.414l8.5-8.5a2 2 0 0 0 0-2.828l-.294-.294z"/></svg>
                        </div>
                    </div>
                @else
                    <p class="text-gray-700 text-lg mb-8 leading-relaxed whitespace-pre-line">
                        <span style="color: {{ $settings->nosotros_description_color ?? '#222' }}">
                            {{ $settings->nosotros_description ?? 'Cuéntale a tus usuarios sobre tu agencia, experiencia y servicios.' }}
                        </span>
                    </p>
                    <div class="grid grid-cols-3 gap-4">
                        <div class="text-center p-4 rounded" style="background-color: rgba(59, 130, 246, 0.1); border: 1px solid rgb(59, 130, 246);">
                            <div class="text-3xl font-bold" style="color: var(--primary-color);">{{ $settings->stat1 ?? '150+' }}</div>
                            <p class="text-gray-600 text-sm">{{ $settings->stat1_label ?? 'Autos Vendidos' }}</p>
                        </div>
                        <div class="text-center p-4 rounded" style="background-color: rgba(59, 130, 246, 0.1); border: 1px solid rgb(59, 130, 246);">
                            <div class="text-3xl font-bold" style="color: var(--primary-color);">{{ $settings->stat2 ?? '98%' }}</div>
                            <p class="text-gray-600 text-sm">{{ $settings->stat2_label ?? 'Clientes Satisfechos' }}</p>
                        </div>
                        <div class="text-center p-4 rounded" style="background-color: rgba(59, 130, 246, 0.1); border: 1px solid rgb(59, 130, 246);">
                            <div class="text-3xl font-bold" style="color: var(--primary-color);">{{ $settings->stat3 ?? '24h' }}</div>
                            <p class="text-gray-600 text-sm">{{ $settings->stat3_label ?? 'Atención al Cliente' }}</p>
                        </div>
                    </div>
                @endif
            </div>
            <div class="relative rounded-lg overflow-hidden shadow-xl">
                <img src="{{ $settings->nosotros_url ?? 'https://images.unsplash.com/photo-1487730116645-74489c95b41b?w=600&h=500&fit=crop' }}" alt="Nosotros" class="w-full h-full object-cover">
                @if(isset($editMode) && $editMode)
                    <button onclick="editImage('nosotros_url')" class="absolute top-2 right-2 bg-blue-600 text-white text-xs px-3 py-1 rounded shadow">Cambiar imagen</button>
                @endif
            </div>
        </div>
    </div>

    <!-- Sección de Contacto -->
    @if($settings->show_contact_form)
        <div class="py-16 px-6" style="background: linear-gradient(135deg, rgba(0,0,0,0.03), transparent);">
            <div class="max-w-4xl mx-auto bg-white/80 rounded-2xl shadow-2xl py-12 px-8 border border-gray-200" style="backdrop-filter: blur(4px);">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-900">Contáctenos</h2>
                    @if(isset($editMode) && $editMode)
                        <button onclick="editContact()" class="bg-blue-600 text-white text-xs px-3 py-1 rounded shadow">Editar contacto</button>
                    @endif
                </div>
                <div class="grid md:grid-cols-3 gap-8 mb-12">
                    @if($settings->phone)
                        <div>
                            <h3 class="font-bold text-gray-700 mb-2">Teléfono</h3>
                            <a href="tel:{{ $settings->phone }}" class="text-gray-500 hover:text-blue-700 transition">{{ $settings->phone }}</a>
                        </div>
                    @endif
                    @if($settings->email)
                        <div>
                            <h3 class="font-bold text-gray-700 mb-2">Email</h3>
                            <a href="mailto:{{ $settings->email }}" class="text-gray-500 hover:text-blue-700 transition">{{ $settings->email }}</a>
                        </div>
                    @endif
                    @if($settings->whatsapp)
                        <div>
                            <h3 class="font-bold text-gray-700 mb-2">WhatsApp</h3>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings->whatsapp) }}" target="_blank" class="text-gray-500 hover:text-blue-700 transition">{{ $settings->whatsapp }}</a>
                        </div>
                    @endif
                </div>
                <hr class="border-gray-200 mb-8">
                <form action="{{ \App\Helpers\RouteHelper::publicContactRoute() }}" method="POST" class="max-w-2xl mx-auto">
                    @csrf
                    <div class="grid md:grid-cols-2 gap-4 mb-4">
                        <input type="text" name="name" placeholder="Nombre Completo" required class="px-4 py-3 rounded-lg bg-white/90 text-gray-900 placeholder-gray-400 border border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-200">
                        <input type="email" name="email" placeholder="Correo Electrónico" required class="px-4 py-3 rounded-lg bg-white/90 text-gray-900 placeholder-gray-400 border border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-200">
                    </div>
                    <input type="tel" name="phone" placeholder="Teléfono" required class="w-full px-4 py-3 rounded-lg bg-white/90 text-gray-900 placeholder-gray-400 mb-4 border border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-200">
                    <textarea name="message" placeholder="Mensaje" rows="5" required class="w-full px-4 py-3 rounded-lg bg-white/90 text-gray-900 placeholder-gray-400 mb-4 border border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-200"></textarea>
                    <input type="hidden" name="vehicle_id" id="vehicle_id">
                    <button type="submit" class="px-8 py-3 rounded-lg text-white font-bold transition hover:opacity-90 shadow-lg" style="background: linear-gradient(135deg, var(--primary-color), var(--tertiary-color));">
                        Enviar Consulta
                    </button>
                </form>
            </div>
        </div>
    @endif

    <!-- Footer -->
    <footer style="background-color: var(--secondary-color);" class="text-white text-center py-8 border-t" style="border-color: rgba(255,255,255,0.1);">
        <p>© {{ date('Y') }} {{ $tenant->name }} - TODOS LOS DERECHOS RESERVADOS</p>
    </footer>

    <script>
        function openForm(vehicleId, title) {
            document.getElementById('vehicle_id').value = vehicleId;
            document.querySelector('textarea[name="message"]').value = `Consulta sobre: ${title}\n`;
            document.querySelector('form').scrollIntoView({ behavior: 'smooth' });
            document.querySelector('input[name="name"]').focus();
        }
    </script>
    @if(isset($editMode) && $editMode)
        @include('public.templates.partials.editor-scripts')
    @endif
</body>
</html>
