<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $tenant->name ?? 'Agencia de Autos' }} - Profesional</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

        /* Top bar */
        .top-bar { background: var(--primary-color); }
        .top-bar a, .top-bar span { color: rgba(255,255,255,0.85); }

        /* Vehicle row hover */
        .vehicle-row {
            transition: all 0.25s ease;
            border-bottom: 1px solid #e2e8f0;
        }
        .vehicle-row:hover {
            background: #f1f5f9;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        }

        /* Pill badges */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 3px 10px;
            border-radius: 9999px;
            font-size: 11px;
            font-weight: 500;
        }

        /* Value card */
        .value-card {
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }
        .value-card:hover {
            border-color: var(--primary-color);
            box-shadow: 0 10px 30px rgba(30,58,95,0.08);
            transform: translateY(-4px);
        }

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
<body style="background-color: var(--secondary-color); color: #334155;">

    <!-- TOP INFO BAR — solo corporativo tiene esto -->
    <div class="top-bar py-2 px-4 text-xs">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-6">
                @if($settings->phone)
                    <a href="tel:{{ $settings->phone }}" class="flex items-center gap-1.5 hover:text-white transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        {{ $settings->phone }}
                    </a>
                @endif
                @if($settings->email)
                    <a href="mailto:{{ $settings->email }}" class="flex items-center gap-1.5 hover:text-white transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        {{ $settings->email }}
                    </a>
                @endif
            </div>
            <div class="flex items-center gap-4">
                @if($settings->instagram_url)<a href="{{ $settings->instagram_url }}" target="_blank" class="hover:text-white transition">Instagram</a>@endif
                @if($settings->facebook_url)<a href="{{ $settings->facebook_url }}" target="_blank" class="hover:text-white transition">Facebook</a>@endif
                @if($settings->linkedin_url)<a href="{{ $settings->linkedin_url }}" target="_blank" class="hover:text-white transition">LinkedIn</a>@endif
            </div>
        </div>
    </div>

    <!-- NAVBAR: Logo izquierda + menú derecha — profesional, bg blanco -->
    <nav class="sticky top-0 z-50 bg-white shadow-sm border-b border-gray-100">
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
                <a href="#inicio" class="text-sm font-medium text-gray-500 hover:text-gray-900 transition" style="color: {{ $settings->navbar_links_color ?? '#64748b' }}">Inicio</a>
                <a href="{{ route('public.vehiculos') }}" class="text-sm font-medium text-gray-500 hover:text-gray-900 transition" style="color: {{ $settings->navbar_links_color ?? '#64748b' }}">Inventario</a>
                <a href="#nosotros" class="text-sm font-medium text-gray-500 hover:text-gray-900 transition" style="color: {{ $settings->navbar_links_color ?? '#64748b' }}">Empresa</a>
                <a href="#contacto" class="text-sm font-medium px-5 py-2 rounded-lg text-white transition hover:opacity-90" style="background: var(--primary-color);">Contactar</a>
            </div>
            <!-- Menú hamburguesa en mobile -->
            <div id="mobile-menu" class="mobile-menu md:hidden">
                <div class="flex flex-col gap-4 p-4 bg-white border-t border-gray-200">
                    <a href="#inicio" class="text-sm font-medium text-gray-500 hover:text-gray-900 transition" style="color: {{ $settings->navbar_links_color ?? '#64748b' }}">Inicio</a>
                    <a href="{{ route('public.vehiculos') }}" class="text-sm font-medium text-gray-500 hover:text-gray-900 transition" style="color: {{ $settings->navbar_links_color ?? '#64748b' }}">Inventario</a>
                    <a href="#nosotros" class="text-sm font-medium text-gray-500 hover:text-gray-900 transition" style="color: {{ $settings->navbar_links_color ?? '#64748b' }}">Empresa</a>
                    <a href="#contacto" class="text-sm font-medium px-5 py-2 rounded-lg text-white transition hover:opacity-90" style="background: var(--primary-color);">Contactar</a>
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

    <div id="inicio"></div>

    <!-- HERO: Full-width con gradient overlay de color corporativo — texto centrado -->
    <div class="relative min-h-[480px] flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0">
            @if(isset($editMode) && $editMode)
                <div class="editable-section w-full h-full">
                    @if($settings && $settings->banner_url)
                        <img src="{{ $settings->banner_url }}" alt="Banner" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gray-800">
                            <svg class="w-16 h-16 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                    @endif
                    <div class="edit-btn" onclick="editImage('banner_url')"><i class="fa fa-pencil"></i></div>
                </div>
            @else
                @if($settings && $settings->banner_url)
                    <img src="{{ $settings->banner_url }}" alt="Banner" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center bg-gray-800">
                        <svg class="w-16 h-16 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                @endif
            @endif
        </div>
        <!-- Degradado corporativo diagonal -->
        <div class="absolute inset-0" style="background: linear-gradient(135deg, rgba(30,58,95,0.88) 0%, rgba(30,58,95,0.6) 50%, rgba(0,0,0,0.3) 100%);"></div>
        <div class="relative z-10 text-center max-w-3xl mx-auto px-8">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-medium text-white bg-white/20 backdrop-blur-sm mb-6">
                <span class="w-1.5 h-1.5 rounded-full bg-green-400"></span>
                Atención disponible
            </div>
            @if(isset($editMode) && $editMode)
                <div class="editable-section mb-6">
                    <p class="text-xl md:text-2xl text-white/90 font-light leading-relaxed" style="color: {{ $settings->home_description_color ?? 'rgba(255,255,255,0.9)' }}">{{ $settings->home_description ?? 'Su próximo vehículo lo espera. Más de 15 años ofreciendo las mejores opciones del mercado con financiamiento a medida.' }}</p>
                    <div class="edit-btn" onclick="editText('home_description','Editar Descripción')"><i class="fa fa-pencil"></i></div>
                </div>
            @else
                <p class="text-xl md:text-2xl text-white/90 font-light leading-relaxed mb-6" style="color: {{ $settings->home_description_color ?? 'rgba(255,255,255,0.9)' }}">{{ $settings->home_description ?? 'Su próximo vehículo lo espera. Más de 15 años ofreciendo las mejores opciones del mercado con financiamiento a medida.' }}</p>
            @endif
            <div class="flex items-center justify-center gap-4">
                <a href="#vehiculos" class="px-6 py-3 bg-white text-sm font-semibold rounded-lg transition hover:bg-gray-100" style="color: var(--primary-color);">Ver Inventario</a>
                <a href="#contacto" class="px-6 py-3 border-2 border-white/40 text-white text-sm font-medium rounded-lg transition hover:bg-white/10">Solicitar Asesoría</a>
            </div>
        </div>
    </div>

    <!-- Trust indicators — barrita de confianza -->
    <div class="bg-white border-b border-gray-100 py-5">
        <div class="max-w-7xl mx-auto px-6 flex flex-wrap items-center justify-center gap-10 text-sm text-gray-500">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" style="color: var(--primary-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                <span>Garantía Certificada</span>
            </div>
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" style="color: var(--primary-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                <span>Financiamiento Flexible</span>
            </div>
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" style="color: var(--primary-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/></svg>
                <span>Transparencia Total</span>
            </div>
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" style="color: var(--primary-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Entrega Inmediata</span>
            </div>
        </div>
    </div>

    <!-- VEHÍCULOS: Vista de inventario tipo TABLA/LISTA — ÚNICO entre todos los templates -->
    @if($settings->show_vehicles && $vehicles->count() > 0)
        <div id="vehiculos" class="py-16 px-4">
            <div class="max-w-7xl mx-auto">
                <div class="flex items-end justify-between mb-8">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider mb-1" style="color: var(--primary-color);">Inventario Actual</p>
                        <h3 class="text-3xl font-bold text-gray-900">Vehículos Disponibles</h3>
                    </div>
                    <span class="badge text-white" style="background: var(--primary-color);">{{ $vehicles->count() }} unidades</span>
                </div>

                <!-- Header de tabla -->
                <div class="hidden lg:grid grid-cols-12 gap-4 px-6 py-3 bg-gray-50 rounded-t-xl border border-gray-200 text-xs font-semibold uppercase tracking-wider text-gray-500">
                    <div class="col-span-2">Imagen</div>
                    <div class="col-span-3">Vehículo</div>
                    <div class="col-span-1">Año</div>
                    <div class="col-span-2">Kilometraje</div>
                    <div class="col-span-2">Precio</div>
                    <div class="col-span-2 text-right">Acción</div>
                </div>

                <!-- Filas de inventario -->
                <div class="bg-white rounded-b-xl border border-t-0 border-gray-200 overflow-hidden lg:divide-y lg:divide-gray-100">
                    @foreach($vehicles as $vehicle)
                        <div class="vehicle-row p-4 lg:p-0">
                            <!-- Mobile: card layout -->
                            <div class="lg:hidden flex flex-col gap-3 p-2">
                                <img src="{{ $vehicle->main_image }}" alt="{{ $vehicle->title }}" class="w-full h-48 object-cover rounded-lg">
                                <div>
                                    <p class="text-xs font-medium uppercase tracking-wide text-gray-400">{{ $vehicle->brand }}</p>
                                    <h4 class="text-lg font-semibold text-gray-900">{{ $vehicle->title }}</h4>
                                    <div class="flex items-center gap-3 mt-2">
                                        <span class="badge bg-gray-100 text-gray-700">{{ $vehicle->year }}</span>
                                        <span class="badge bg-gray-100 text-gray-700">{{ number_format($vehicle->kilometers) }} km</span>
                                    </div>
                                    <div class="flex items-center justify-between mt-3">
                                        <span class="text-xl font-bold" style="color: var(--primary-color);">${{ number_format($vehicle->price) }}</span>
                                        <button type="button" onclick="openContactForm('{{ $vehicle->id }}', '{{ $vehicle->title }}')" class="px-4 py-2 text-xs font-semibold text-white rounded-lg transition hover:opacity-90" style="background: var(--primary-color);">Consultar</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Desktop: table row -->
                            <div class="hidden lg:grid grid-cols-12 gap-4 items-center px-6 py-4">
                                <div class="col-span-2">
                                    <img src="{{ $vehicle->main_image }}" alt="{{ $vehicle->title }}" class="w-28 h-20 object-cover rounded-lg">
                                </div>
                                <div class="col-span-3">
                                    <p class="text-[10px] font-semibold uppercase tracking-wider text-gray-400 mb-0.5">{{ $vehicle->brand }}</p>
                                    <h4 class="text-sm font-semibold text-gray-900">{{ $vehicle->title }}</h4>
                                    <p class="text-xs text-gray-400 mt-1">{{ Str::limit($vehicle->description, 60) }}</p>
                                </div>
                                <div class="col-span-1">
                                    <span class="badge bg-gray-100 text-gray-700">{{ $vehicle->year }}</span>
                                </div>
                                <div class="col-span-2">
                                    <span class="text-sm text-gray-600">{{ number_format($vehicle->kilometers) }} km</span>
                                </div>
                                <div class="col-span-2">
                                    <span class="text-lg font-bold" style="color: var(--primary-color);">${{ number_format($vehicle->price) }}</span>
                                </div>
                                <div class="col-span-2 text-right">
                                    <button type="button" onclick="openContactForm('{{ $vehicle->id }}', '{{ $vehicle->title }}')" class="px-5 py-2 text-xs font-semibold text-white rounded-lg transition hover:opacity-90 hover:shadow-lg" style="background: var(--primary-color);">Consultar</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="text-center mt-8">
                    <a href="{{ route('public.vehiculos') }}" class="inline-flex items-center gap-2 text-sm font-semibold transition hover:gap-3" style="color: var(--primary-color);">
                        Ver todo el inventario
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
            </div>
        </div>
    @endif

    <!-- NOSOTROS: Valores corporativos con tarjetas de pilares — estilo empresa -->
    <div id="nosotros" class="py-20 px-4" style="background: linear-gradient(to bottom, #f1f5f9, var(--secondary-color));">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center mb-16">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider mb-2" style="color: var(--primary-color);">Quiénes Somos</p>
                    <h3 class="text-3xl font-bold text-gray-900 mb-6">Nuestra Empresa</h3>
                    @if(isset($editMode) && $editMode)
                        <div class="editable-section mb-6">
                            <p class="text-gray-600 text-base leading-relaxed whitespace-pre-line" style="color: {{ $settings->nosotros_description_color ?? '#4b5563' }}">{{ $settings->nosotros_description ?? "Somos una empresa automotriz comprometida con la excelencia en el servicio.\n\nContamos con un equipo profesional dedicado a encontrar el vehículo ideal para cada cliente, con opciones de financiamiento adaptadas a sus necesidades." }}</p>
                            <div class="edit-btn" onclick="editText('nosotros_description','Editar Descripción Empresa')"><i class="fa fa-pencil"></i></div>
                        </div>
                    @else
                        <p class="text-gray-600 text-base leading-relaxed whitespace-pre-line mb-6" style="color: {{ $settings->nosotros_description_color ?? '#4b5563' }}">{{ $settings->nosotros_description ?? "Somos una empresa automotriz comprometida con la excelencia en el servicio.\n\nContamos con un equipo profesional dedicado a encontrar el vehículo ideal para cada cliente, con opciones de financiamiento adaptadas a sus necesidades." }}</p>
                    @endif
                    @if(isset($editMode) && $editMode)
                        <div class="editable-section flex gap-10 pt-6 border-t border-gray-200">
                            <div>
                                <div class="text-2xl font-bold" style="color: var(--primary-color);">{{ $settings->stat1 ?? '500+' }}</div>
                                <p class="text-xs text-gray-500 mt-0.5">{{ $settings->stat1_label ?? 'Clientes Satisfechos' }}</p>
                            </div>
                            <div>
                                <div class="text-2xl font-bold" style="color: var(--primary-color);">{{ $settings->stat2 ?? '15+' }}</div>
                                <p class="text-xs text-gray-500 mt-0.5">{{ $settings->stat2_label ?? 'Años Experiencia' }}</p>
                            </div>
                            <div>
                                <div class="text-2xl font-bold" style="color: var(--primary-color);">{{ $settings->stat3 ?? '100%' }}</div>
                                <p class="text-xs text-gray-500 mt-0.5">{{ $settings->stat3_label ?? 'Documentación Legal' }}</p>
                            </div>
                            <div class="edit-btn self-center" onclick="editStats()"><i class="fa fa-pencil"></i></div>
                        </div>
                    @else
                        <div class="flex gap-10 pt-6 border-t border-gray-200">
                            <div>
                                <div class="text-2xl font-bold" style="color: var(--primary-color);">{{ $settings->stat1 ?? '500+' }}</div>
                                <p class="text-xs text-gray-500 mt-0.5">{{ $settings->stat1_label ?? 'Clientes Satisfechos' }}</p>
                            </div>
                            <div>
                                <div class="text-2xl font-bold" style="color: var(--primary-color);">{{ $settings->stat2 ?? '15+' }}</div>
                                <p class="text-xs text-gray-500 mt-0.5">{{ $settings->stat2_label ?? 'Años Experiencia' }}</p>
                            </div>
                            <div>
                                <div class="text-2xl font-bold" style="color: var(--primary-color);">{{ $settings->stat3 ?? '100%' }}</div>
                                <p class="text-xs text-gray-500 mt-0.5">{{ $settings->stat3_label ?? 'Documentación Legal' }}</p>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="relative">
                    @if(isset($editMode) && $editMode)
                        <div class="editable-section rounded-2xl overflow-hidden shadow-xl">
                            <img src="{{ $settings->nosotros_url ?? 'https://images.unsplash.com/photo-1560958089-b8a1929cea89?w=800&h=600&fit=crop' }}" alt="Empresa" class="w-full h-80 object-cover">
                            <div class="edit-btn" onclick="editImage('nosotros_url')"><i class="fa fa-pencil"></i></div>
                        </div>
                    @else
                        <div class="rounded-2xl overflow-hidden shadow-xl">
                            <img src="{{ $settings->nosotros_url ?? 'https://images.unsplash.com/photo-1560958089-b8a1929cea89?w=800&h=600&fit=crop' }}" alt="Empresa" class="w-full h-80 object-cover">
                        </div>
                    @endif
                </div>
            </div>

            <!-- Pilares corporativos -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="value-card bg-white rounded-xl p-8 text-center">
                    <div class="w-14 h-14 rounded-xl mx-auto mb-5 flex items-center justify-center" style="background: rgba(30,58,95,0.08);">
                        <svg class="w-7 h-7" style="color: var(--primary-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <h4 class="text-lg font-bold text-gray-900 mb-2">Confianza</h4>
                    <p class="text-sm text-gray-500 leading-relaxed">Cada vehículo pasa por una inspección rigurosa de más de 100 puntos antes de ofrecerse.</p>
                </div>
                <div class="value-card bg-white rounded-xl p-8 text-center">
                    <div class="w-14 h-14 rounded-xl mx-auto mb-5 flex items-center justify-center" style="background: rgba(30,58,95,0.08);">
                        <svg class="w-7 h-7" style="color: var(--primary-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <h4 class="text-lg font-bold text-gray-900 mb-2">Atención Personal</h4>
                    <p class="text-sm text-gray-500 leading-relaxed">Un asesor dedicado acompaña cada proceso de compra de principio a fin.</p>
                </div>
                <div class="value-card bg-white rounded-xl p-8 text-center">
                    <div class="w-14 h-14 rounded-xl mx-auto mb-5 flex items-center justify-center" style="background: rgba(30,58,95,0.08);">
                        <svg class="w-7 h-7" style="color: var(--primary-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    </div>
                    <h4 class="text-lg font-bold text-gray-900 mb-2">Gestión Integral</h4>
                    <p class="text-sm text-gray-500 leading-relaxed">Tramitamos toda la documentación: transferencia, seguro y patentamiento.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- CONTACTO: Professional 2-column con info izquierda + form derecha en container -->
    @if($settings->show_contact_form)
        <div id="contacto" class="py-20 px-4 bg-white">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-12">
                    <p class="text-xs font-semibold uppercase tracking-wider mb-2" style="color: var(--primary-color);">¿Necesita asesoramiento?</p>
                    <h3 class="text-3xl font-bold text-gray-900">Contáctenos</h3>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-5 gap-0 rounded-2xl overflow-hidden border border-gray-200 shadow-lg">
                    <!-- Info Panel — izquierda -->
                    <div class="lg:col-span-2 p-10 text-white" style="background: var(--primary-color);">
                        <h4 class="text-xl font-bold mb-2">Información de Contacto</h4>
                        <p class="text-white/70 text-sm mb-10">Comuníquese con nosotros por el medio que prefiera.</p>

                        @if(isset($editMode) && $editMode)
                            <button onclick="editContact()" class="text-xs px-3 py-1 border border-white/30 text-white rounded mb-8 hover:bg-white/10 transition">Editar datos de contacto</button>
                        @endif

                        <div class="space-y-6">
                            @if($settings->phone)
                                <a href="tel:{{ $settings->phone }}" class="flex items-center gap-4 text-white/90 hover:text-white transition">
                                    <div class="w-10 h-10 rounded-lg bg-white/10 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                    </div>
                                    <span class="text-sm">{{ $settings->phone }}</span>
                                </a>
                            @endif
                            @if($settings->email)
                                <a href="mailto:{{ $settings->email }}" class="flex items-center gap-4 text-white/90 hover:text-white transition">
                                    <div class="w-10 h-10 rounded-lg bg-white/10 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    </div>
                                    <span class="text-sm">{{ $settings->email }}</span>
                                </a>
                            @endif
                            @if($settings->whatsapp)
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings->whatsapp) }}" target="_blank" class="flex items-center gap-4 text-white/90 hover:text-white transition">
                                    <div class="w-10 h-10 rounded-lg bg-white/10 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                    </div>
                                    <span class="text-sm">WhatsApp: {{ $settings->whatsapp }}</span>
                                </a>
                            @endif
                            @if($settings->address)
                                <div class="flex items-center gap-4 text-white/90">
                                    <div class="w-10 h-10 rounded-lg bg-white/10 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    </div>
                                    <span class="text-sm">{{ $settings->address }}</span>
                                </div>
                            @endif
                        </div>

                        <div class="flex gap-4 mt-14">
                            @if($settings->facebook_url)<a href="{{ $settings->facebook_url }}" target="_blank" class="w-9 h-9 rounded-lg bg-white/10 flex items-center justify-center text-white/70 hover:bg-white/20 hover:text-white transition text-xs font-bold">Fb</a>@endif
                            @if($settings->instagram_url)<a href="{{ $settings->instagram_url }}" target="_blank" class="w-9 h-9 rounded-lg bg-white/10 flex items-center justify-center text-white/70 hover:bg-white/20 hover:text-white transition text-xs font-bold">Ig</a>@endif
                            @if($settings->linkedin_url)<a href="{{ $settings->linkedin_url }}" target="_blank" class="w-9 h-9 rounded-lg bg-white/10 flex items-center justify-center text-white/70 hover:bg-white/20 hover:text-white transition text-xs font-bold">Li</a>@endif
                        </div>
                    </div>

                    <!-- Form Panel — derecha -->
                    <div class="lg:col-span-3 p-10 bg-white">
                        <form action="{{ \App\Helpers\RouteHelper::publicContactRoute() }}" method="POST" class="space-y-5">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider block mb-1.5">Nombre</label>
                                    <input type="text" name="name" required class="w-full px-4 py-3 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-100 text-gray-800 transition">
                                </div>
                                <div>
                                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider block mb-1.5">Email</label>
                                    <input type="email" name="email" required class="w-full px-4 py-3 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-100 text-gray-800 transition">
                                </div>
                            </div>
                            <div>
                                <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider block mb-1.5">Teléfono</label>
                                <input type="tel" name="phone" required class="w-full px-4 py-3 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-100 text-gray-800 transition">
                            </div>
                            <div>
                                <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider block mb-1.5">Mensaje</label>
                                <textarea name="message" rows="4" required class="w-full px-4 py-3 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-100 text-gray-800 transition resize-none"></textarea>
                            </div>
                            <input type="hidden" name="vehicle_id" id="vehicle_id">
                            <button type="submit" class="w-full py-3.5 text-sm font-semibold text-white rounded-lg transition hover:opacity-90 hover:shadow-lg" style="background: var(--primary-color);">Enviar Consulta</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- FOOTER: Multi-column corporate footer — profesional -->
    <footer class="py-12 px-4 bg-gray-900 text-gray-400">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 mb-10">
                <div class="md:col-span-2">
                    <div class="flex items-center gap-3 mb-4">
                        @if($settings && $settings->logo_url)
                            <img src="{{ $settings->logo_url }}" alt="{{ $tenant->name }}" class="h-8 object-contain brightness-200">
                        @else
                            <div class="h-8 w-8 rounded-lg flex items-center justify-center" style="background: var(--primary-color);">
                                <span class="text-white font-bold text-sm">{{ substr($tenant->name, 0, 1) }}</span>
                            </div>
                        @endif
                        <span class="text-white font-semibold">{{ $tenant->name }}</span>
                    </div>
                    <p class="text-sm leading-relaxed">{{ $settings->contact_message ?? 'Su concesionario de confianza. Vehículos verificados, financiamiento a medida y atención personalizada.' }}</p>
                </div>
                <div>
                    <h5 class="text-white text-sm font-semibold mb-4">Navegación</h5>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#inicio" class="hover:text-white transition">Inicio</a></li>
                        <li><a href="{{ route('public.vehiculos') }}" class="hover:text-white transition">Inventario</a></li>
                        <li><a href="#nosotros" class="hover:text-white transition">Empresa</a></li>
                        <li><a href="#contacto" class="hover:text-white transition">Contacto</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="text-white text-sm font-semibold mb-4">Contacto</h5>
                    <ul class="space-y-2 text-sm">
                        @if($settings->phone)<li>{{ $settings->phone }}</li>@endif
                        @if($settings->email)<li>{{ $settings->email }}</li>@endif
                        @if($settings->address)<li>{{ $settings->address }}</li>@endif
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-6 text-center text-xs">
                <p>© {{ date('Y') }} {{ $tenant->name }}. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    @if(isset($editMode) && $editMode)
    @include('public.templates.partials.editor-scripts')
    @endif

    <script>
        function openContactForm(vehicleId, vehicleTitle) {
            document.getElementById('vehicle_id').value = vehicleId;
            document.querySelector('textarea[name="message"]').value = `Consulta por: ${vehicleTitle}`;
            document.getElementById('contacto').scrollIntoView({ behavior: 'smooth' });
            document.querySelector('input[name="name"]').focus();
        }
    </script>
</body>
@if(isset($editMode) && $editMode)
    @include('public.templates.partials.editor-scripts')
@endif
</html>
