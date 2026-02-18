<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $tenant->name ?? 'Agencia de Autos' }} - Plataforma Automotriz</title>
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
        $fontUrl = isset($googleFonts[$font]) ? 'https://fonts.googleapis.com/css?family=' . $googleFonts[$font] . ':300,400,500,600,700&display=swap' : null;
    @endphp
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @if($fontUrl)
        <link href="{{ $fontUrl }}" rel="stylesheet">
    @endif
    <style>
        :root {
            --primary-color: {{ $settings && $settings->primary_color ? $settings->primary_color : '#2563eb' }};
            --secondary-color: {{ $settings && $settings->secondary_color ? $settings->secondary_color : '#0B1120' }};
            --tertiary-color: {{ $settings && $settings->tertiary_color ? $settings->tertiary_color : '#1e40af' }};
        }
        body { font-family: {{ $settings->font_family ?? "'Inter', sans-serif" }}; }

        /* Gradient text */
        .gradient-text {
            background: linear-gradient(135deg, var(--primary-color), #60a5fa);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Glow effect */
        .glow-border {
            border: 1px solid rgba(37, 99, 235, 0.15);
            background: rgba(255,255,255,0.02);
        }
        .glow-border:hover {
            border-color: rgba(37, 99, 235, 0.4);
            box-shadow: 0 0 30px rgba(37, 99, 235, 0.08);
        }

        /* Vehicle card */
        .vehicle-card-tech {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .vehicle-card-tech:hover {
            border-color: rgba(37, 99, 235, 0.3);
            transform: translateY(-6px);
            box-shadow: 0 25px 60px rgba(0,0,0,0.4);
        }

        /* Status badge */
        .status-available { background: rgba(34,197,94,0.15); color: #22c55e; }
        .status-reserved { background: rgba(251,191,36,0.15); color: #fbbf24; }

        /* Feature card */
        .feature-card {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 16px;
            padding: 32px;
            transition: all 0.3s ease;
        }
        .feature-card:hover {
            background: rgba(255,255,255,0.05);
            border-color: rgba(37, 99, 235, 0.25);
            transform: translateY(-4px);
        }

        /* CTA section */
        .cta-gradient {
            background: linear-gradient(135deg, var(--primary-color), var(--tertiary-color));
            border-radius: 24px;
        }

        /* Search bar */
        .search-input {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.08);
            color: #fff;
            transition: all 0.25s ease;
        }
        .search-input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
            outline: none;
        }
        .search-input::placeholder { color: rgba(255,255,255,0.35); }

        @if(isset($editMode) && $editMode)
        .editable-section { position: relative; outline: 2px dashed rgba(37,99,235,0.4); outline-offset: 4px; }
        .editable-section:hover .edit-btn,
        .editable-section .edit-btn:hover,
        .editable-section .edit-btn:focus {
            display: flex !important;
        }
        .edit-btn { position: absolute; top: 8px; right: 8px; background: var(--primary-color); color: #fff; width: 32px; height: 32px; border-radius: 50%; display: none; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 2px 8px rgba(0,0,0,0.3); z-index: 50; transition: background 0.2s; }
        @endif
    </style>
</head>
<body style="background-color: var(--secondary-color);" class="text-white antialiased">

    <!-- NAVBAR: Estilo SaaS — logo izq, links centro, CTA der -->
    <nav class="sticky top-0 z-50" style="background: rgba(11,17,32,0.85); backdrop-filter: blur(20px); border-bottom: 1px solid rgba(255,255,255,0.06);">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                @if(isset($editMode) && $editMode)
                    <div class="editable-section inline-block relative">
                        @if($settings && $settings->logo_url)
                            <img src="{{ $settings->logo_url }}" alt="{{ $tenant->name }}" class="h-9 object-contain">
                        @else
                            <div class="h-9 w-9 rounded-xl flex items-center justify-center" style="background: var(--primary-color);">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            </div>
                        @endif
                        <div class="edit-btn" onclick="editImage('logo_url')"><i class="fa fa-pencil"></i></div>
                    </div>
                    <div class="editable-section inline-block relative" style="min-width:100px; display:flex; align-items:center; gap:6px;">
                        <span class="text-lg font-bold text-white">{{ $tenant->name }}</span>
                        <button type="button" class="edit-btn" style="position:static; display:flex; margin-left:4px; background:var(--primary-color); color:#fff; width:24px; height:24px; border-radius:50%; align-items:center; justify-content:center; cursor:pointer; z-index:50; border:none; font-size:10px;" onclick="editText('agency_name','Editar Nombre')"><i class="fa fa-pencil"></i></button>
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
                    <span class="text-lg font-bold text-white">{{ $tenant->name }}</span>
                @endif
            </div>
            <div class="hidden md:flex items-center gap-8">
                <a href="#inicio" class="text-sm font-medium transition hover:text-white" style="color: {{ $settings->navbar_links_color ?? 'rgba(255,255,255,0.6)' }}">Inventario</a>
                <a href="#nosotros" class="text-sm font-medium transition hover:text-white" style="color: {{ $settings->navbar_links_color ?? 'rgba(255,255,255,0.6)' }}">Nosotros</a>
                <a href="#contacto" class="text-sm font-medium transition hover:text-white" style="color: {{ $settings->navbar_links_color ?? 'rgba(255,255,255,0.6)' }}">Contacto</a>
              
            </div>
            <a href="#contacto" class="px-5 py-2.5 text-sm font-semibold text-white rounded-xl transition hover:opacity-90" style="background: var(--primary-color);">
                Solicitar Demo
            </a>
        </div>
    </nav>

    <div id="inicio"></div>

    <!-- HERO: Split — texto izq con badge + imagen der -->
    <div class="max-w-7xl mx-auto px-6 py-20">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-semibold mb-8" style="background: rgba(37,99,235,0.12); color: var(--primary-color); border: 1px solid rgba(37,99,235,0.2);">
                    <span class="w-1.5 h-1.5 rounded-full" style="background: var(--primary-color);"></span>
                    PLATAFORMA NEXT-GEN
                </div>
                @if(isset($editMode) && $editMode)
                    <div class="editable-section mb-6">
                        <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold leading-tight">
                            <span class="text-white">Eleva la Presencia </span>
                            <span class="gradient-text italic">Digital de tu Concesionario</span>
                        </h1>
                        <div class="edit-btn" onclick="editText('hero_title','Editar Título del Hero')"><i class="fa fa-pencil"></i></div>
                    </div>
                @else
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold leading-tight mb-6">
                        <span class="text-white">Eleva la Presencia </span>
                        <span class="gradient-text italic">Digital de tu Concesionario</span>
                    </h1>
                @endif
                @if(isset($editMode) && $editMode)
                    <div class="editable-section mb-8">
                        <p class="text-lg text-white/60 leading-relaxed max-w-lg" style="color: {{ $settings->home_description_color ?? 'rgba(255,255,255,0.6)' }}">{{ $settings->home_description ?? 'Gestión inteligente de inventario y CRM especializado para el sector de automóviles. La herramienta definitiva para vendedores de élite.' }}</p>
                        <div class="edit-btn" onclick="editText('home_description','Editar Descripción')"><i class="fa fa-pencil"></i></div>
                    </div>
                @else
                    <p class="text-lg text-white/60 leading-relaxed max-w-lg mb-8" style="color: {{ $settings->home_description_color ?? 'rgba(255,255,255,0.6)' }}">{{ $settings->home_description ?? 'Gestión inteligente de inventario y CRM especializado para el sector de automóviles. La herramienta definitiva para vendedores de élite.' }}</p>
                @endif
                <div class="flex flex-wrap items-center gap-4">
                    <a href="#vehiculos" class="inline-flex items-center gap-2 px-7 py-3.5 text-sm font-semibold text-white rounded-xl transition hover:opacity-90 hover:shadow-lg" style="background: var(--primary-color);">
                        Empieza Ahora
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                    <a href="#nosotros" class="inline-flex items-center gap-2 px-7 py-3.5 text-sm font-semibold text-white rounded-xl border border-white/15 transition hover:bg-white/5">
                        Ver Tour
                    </a>
                </div>
            </div>
            <div class="relative">
                @if(isset($editMode) && $editMode)
                    <div class="editable-section rounded-2xl overflow-hidden">
                        @if($settings && $settings->banner_url)
                            <img src="{{ $settings->banner_url }}" alt="Banner" class="w-full h-[380px] object-cover rounded-2xl" style="border: 1px solid rgba(255,255,255,0.06);">
                        @else
                            <div class="w-full h-[380px] rounded-2xl flex items-center justify-center" style="background: linear-gradient(135deg, rgba(37,99,235,0.15), rgba(30,64,175,0.15)); border: 1px solid rgba(255,255,255,0.06);">
                                <svg class="w-20 h-20 text-white/10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                        @endif
                        <div class="edit-btn" onclick="editImage('banner_url')"><i class="fa fa-pencil"></i></div>
                    </div>
                @else
                    @if($settings && $settings->banner_url)
                        <img src="{{ $settings->banner_url }}" alt="Banner" class="w-full h-[380px] object-cover rounded-2xl" style="border: 1px solid rgba(255,255,255,0.06);">
                    @else
                        <div class="w-full h-[380px] rounded-2xl flex items-center justify-center" style="background: linear-gradient(135deg, rgba(37,99,235,0.15), rgba(30,64,175,0.15)); border: 1px solid rgba(255,255,255,0.06);">
                            <svg class="w-20 h-20 text-white/10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                    @endif
                @endif
                <!-- Decorative glow behind image -->
                <div class="absolute -inset-1 rounded-2xl -z-10 blur-3xl opacity-20" style="background: var(--primary-color);"></div>
            </div>
        </div>
    </div>

    <!-- SEARCH BAR: Barra de búsqueda/filtro — estilo SaaS -->
    <div class="max-w-5xl mx-auto px-6 mb-16">
        <div class="flex flex-wrap items-center gap-3 p-4 rounded-2xl" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06);">
            <div class="flex items-center gap-2 flex-1 min-w-[160px]">
                <svg class="w-4 h-4 text-white/30 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" placeholder="Marca o Modelo" class="search-input w-full px-3 py-2.5 rounded-xl text-sm">
            </div>
            <select class="search-input px-4 py-2.5 rounded-xl text-sm min-w-[150px] cursor-pointer appearance-none">
                <option value="">Todos los estilos</option>
                <option>Sedán</option>
                <option>SUV</option>
                <option>Pickup</option>
                <option>Coupé</option>
            </select>
            <select class="search-input px-4 py-2.5 rounded-xl text-sm min-w-[150px] cursor-pointer appearance-none">
                <option value="">Rango de Precio</option>
                <option>Hasta $50,000</option>
                <option>$50,000 - $100,000</option>
                <option>$100,000 - $200,000</option>
                <option>Más de $200,000</option>
            </select>
            <a href="{{ route('public.vehiculos') }}" class="px-6 py-2.5 text-sm font-semibold text-white rounded-xl transition hover:opacity-90" style="background: var(--primary-color);">
                Filtrar Inventario
            </a>
        </div>
    </div>

    <!-- VEHÍCULOS: Cards 3-col con badges de estado y specs — estilo dashboard -->
    @if($settings->show_vehicles && $vehicles->count() > 0)
        <div id="vehiculos" class="pb-20 px-6">
            <div class="max-w-7xl mx-auto">
                <div class="flex items-end justify-between mb-10">
                    <div>
                        <h2 class="text-3xl font-bold text-white mb-1">Unidades Destacadas</h2>
                        <p class="text-white/40 text-sm">Gestiona y visualiza tu flota premium en tiempo real.</p>
                    </div>
                    <a href="{{ route('public.vehiculos') }}" class="text-sm font-semibold flex items-center gap-1 transition hover:gap-2" style="color: var(--primary-color);">
                        Ver catálogo completo
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($vehicles as $index => $vehicle)
                        <div class="vehicle-card-tech group">
                            <div class="relative overflow-hidden">
                                <img src="{{ $vehicle->main_image }}" alt="{{ $vehicle->title }}" class="w-full h-52 object-cover transition duration-500 group-hover:scale-105">
                                <!-- Badges top -->
                                <div class="absolute top-3 left-3 flex items-center gap-2">
                                    <span class="px-2.5 py-1 rounded-lg text-[11px] font-bold" style="background: var(--primary-color); color: white;">{{ $vehicle->year }}</span>
                                </div>
                                <div class="absolute top-3 right-3">
                                    @if($index % 3 !== 1)
                                        <span class="status-available px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider">Disponible</span>
                                    @else
                                        <span class="status-reserved px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider">Reservado</span>
                                    @endif
                                </div>
                            </div>
                            <div class="p-5">
                                <h4 class="text-base font-bold text-white mb-1">{{ $vehicle->title }}</h4>
                                <!-- Specs row -->
                                <div class="flex items-center gap-4 text-xs text-white/40 mb-4">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        {{ number_format($vehicle->kilometers / 1000, 1) }}k
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                        {{ $vehicle->transmission ?? 'AWD' }}
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                        {{ $vehicle->fuel_type ?? 'Nafta' }}
                                    </span>
                                </div>
                                <!-- Price + action -->
                                <div class="flex items-center justify-between pt-4" style="border-top: 1px solid rgba(255,255,255,0.06);">
                                    <span class="text-xl font-bold text-white">${{ number_format($vehicle->price) }}</span>
                                    <button type="button" onclick="openContactForm('{{ $vehicle->id }}', '{{ $vehicle->title }}')" class="w-10 h-10 rounded-xl flex items-center justify-center transition hover:opacity-80" style="background: rgba(37,99,235,0.12); color: var(--primary-color);">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- FEATURES: "Diseñado para la excelencia" — 3 feature cards con iconos -->
    <div id="nosotros" class="py-20 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-14">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-3">Diseñado para la excelencia</h2>
                <p class="text-white/40 text-base max-w-xl mx-auto">Nuestra tecnología te permite centrarte en lo que mejor sabes hacer: cerrar ventas de alto impacto.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="feature-card">
                    <div class="w-12 h-12 rounded-xl mb-6 flex items-center justify-center" style="background: rgba(37,99,235,0.12);">
                        <svg class="w-6 h-6" style="color: var(--primary-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">Analítica Avanzada</h3>
                    <p class="text-sm text-white/40 leading-relaxed">Visualiza el rendimiento de tus ventas y la demanda del mercado con informes predictivos.</p>
                </div>
                <div class="feature-card">
                    <div class="w-12 h-12 rounded-xl mb-6 flex items-center justify-center" style="background: rgba(37,99,235,0.12);">
                        <svg class="w-6 h-6" style="color: var(--primary-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">CRM Multi-canal</h3>
                    <p class="text-sm text-white/40 leading-relaxed">Conecta con tus clientes a través de WhatsApp, Correo y Social Media desde una única consola.</p>
                </div>
                <div class="feature-card">
                    <div class="w-12 h-12 rounded-xl mb-6 flex items-center justify-center" style="background: rgba(37,99,235,0.12);">
                        <svg class="w-6 h-6" style="color: var(--primary-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">Sincronización Total</h3>
                    <p class="text-sm text-white/40 leading-relaxed">Tu stock siempre al día en portales externos y tu web propia de forma automática y sin errores.</p>
                </div>
            </div>

            <!-- Nosotros / About section -->
            <div class="mt-20 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="relative">
                    @if(isset($editMode) && $editMode)
                        <div class="editable-section rounded-2xl overflow-hidden">
                            <img src="{{ $settings->nosotros_url ?? 'https://images.unsplash.com/photo-1560958089-b8a1929cea89?w=800&h=500&fit=crop' }}" alt="Nosotros" class="w-full h-72 object-cover rounded-2xl" style="border: 1px solid rgba(255,255,255,0.06);">
                            <div class="edit-btn" onclick="editImage('nosotros_url')"><i class="fa fa-pencil"></i></div>
                        </div>
                    @else
                        <img src="{{ $settings->nosotros_url ?? 'https://images.unsplash.com/photo-1560958089-b8a1929cea89?w=800&h=500&fit=crop' }}" alt="Nosotros" class="w-full h-72 object-cover rounded-2xl" style="border: 1px solid rgba(255,255,255,0.06);">
                    @endif
                </div>
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold mb-4" style="background: rgba(37,99,235,0.12); color: var(--primary-color);">
                        Sobre Nosotros
                    </div>
                    @if(isset($editMode) && $editMode)
                        <div class="editable-section mb-6">
                            <p class="text-base text-white/60 leading-relaxed whitespace-pre-line" style="color: {{ $settings->nosotros_description_color ?? 'rgba(255,255,255,0.6)' }}">{{ $settings->nosotros_description ?? "Somos una plataforma automotriz de nueva generación que combina tecnología de punta con la pasión por los automóviles.\n\nNuestro equipo de expertos se dedica a encontrar el vehículo perfecto para cada cliente, con opciones de financiamiento a medida y un proceso 100% transparente." }}</p>
                            <div class="edit-btn" onclick="editText('nosotros_description','Editar Descripción')"><i class="fa fa-pencil"></i></div>
                        </div>
                    @else
                        <p class="text-base text-white/60 leading-relaxed whitespace-pre-line mb-6" style="color: {{ $settings->nosotros_description_color ?? 'rgba(255,255,255,0.6)' }}">{{ $settings->nosotros_description ?? "Somos una plataforma automotriz de nueva generación que combina tecnología de punta con la pasión por los automóviles.\n\nNuestro equipo de expertos se dedica a encontrar el vehículo perfecto para cada cliente, con opciones de financiamiento a medida y un proceso 100% transparente." }}</p>
                    @endif
                    @if(isset($editMode) && $editMode)
                        <div class="editable-section flex gap-8">
                            <div>
                                <div class="text-2xl font-bold text-white">{{ $settings->stat1 ?? '500+' }}</div>
                                <p class="text-xs text-white/40 mt-0.5">{{ $settings->stat1_label ?? 'Concesionarios' }}</p>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-white">{{ $settings->stat2 ?? '98%' }}</div>
                                <p class="text-xs text-white/40 mt-0.5">{{ $settings->stat2_label ?? 'Satisfacción' }}</p>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-white">{{ $settings->stat3 ?? '24/7' }}</div>
                                <p class="text-xs text-white/40 mt-0.5">{{ $settings->stat3_label ?? 'Soporte' }}</p>
                            </div>
                            <div class="edit-btn self-center" onclick="editStats()"><i class="fa fa-pencil"></i></div>
                        </div>
                    @else
                        <div class="flex gap-8">
                            <div>
                                <div class="text-2xl font-bold text-white">{{ $settings->stat1 ?? '500+' }}</div>
                                <p class="text-xs text-white/40 mt-0.5">{{ $settings->stat1_label ?? 'Concesionarios' }}</p>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-white">{{ $settings->stat2 ?? '98%' }}</div>
                                <p class="text-xs text-white/40 mt-0.5">{{ $settings->stat2_label ?? 'Satisfacción' }}</p>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-white">{{ $settings->stat3 ?? '24/7' }}</div>
                                <p class="text-xs text-white/40 mt-0.5">{{ $settings->stat3_label ?? 'Soporte' }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- CTA SECTION: Banner con gradient y rounded corners -->
    <div class="max-w-6xl mx-auto px-6 py-12">
        <div class="cta-gradient px-10 py-16 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">¿Listo para transformar tu gestión comercial?</h2>
            <p class="text-white/80 text-base mb-8 max-w-lg mx-auto">Únete a los más de 500 concesionarios premium que ya confían en {{ $tenant->name }}.</p>
            <div class="flex flex-wrap items-center justify-center gap-4">
                <a href="#contacto" class="px-8 py-3.5 bg-white text-sm font-semibold rounded-xl transition hover:bg-gray-100" style="color: var(--primary-color);">
                    Solicitar Demo Gratuita
                </a>
                <a href="#contacto" class="px-8 py-3.5 border-2 border-white/30 text-white text-sm font-semibold rounded-xl transition hover:bg-white/10">
                    Hablar con un Experto
                </a>
            </div>
        </div>
    </div>

    <!-- CONTACTO: Modal-style contact en dark card -->
    @if($settings->show_contact_form)
        <div id="contacto" class="py-20 px-6">
            <div class="max-w-3xl mx-auto">
                <div class="text-center mb-10">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold mb-4" style="background: rgba(37,99,235,0.12); color: var(--primary-color);">
                        Contacto
                    </div>
                    <h2 class="text-3xl font-bold text-white mb-2">¿Tenés alguna consulta?</h2>
                    <p class="text-white/40 text-sm">Completá el formulario y te respondemos en menos de 24hs.</p>
                </div>

                <div class="rounded-2xl p-8" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06);">
                    <!-- Contact info -->
                    <div class="flex flex-wrap items-center justify-center gap-6 mb-8 pb-8" style="border-bottom: 1px solid rgba(255,255,255,0.06);">
                        @if(isset($editMode) && $editMode)
                            <button onclick="editContact()" class="text-xs px-3 py-1 border rounded-lg transition" style="color: var(--primary-color); border-color: var(--primary-color);">Editar datos de contacto</button>
                        @endif
                        @if($settings->phone)
                            <a href="tel:{{ $settings->phone }}" class="flex items-center gap-2 text-sm text-white/50 hover:text-white transition">
                                <svg class="w-4 h-4" style="color: var(--primary-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                {{ $settings->phone }}
                            </a>
                        @endif
                        @if($settings->email)
                            <a href="mailto:{{ $settings->email }}" class="flex items-center gap-2 text-sm text-white/50 hover:text-white transition">
                                <svg class="w-4 h-4" style="color: var(--primary-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                {{ $settings->email }}
                            </a>
                        @endif
                        @if($settings->whatsapp)
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings->whatsapp) }}" target="_blank" class="flex items-center gap-2 text-sm text-white/50 hover:text-white transition">
                                <svg class="w-4 h-4" style="color: var(--primary-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                WhatsApp
                            </a>
                        @endif
                    </div>

                    <form action="{{ \App\Helpers\RouteHelper::publicContactRoute() }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <input type="text" name="name" placeholder="Tu nombre" required class="search-input w-full px-4 py-3 rounded-xl text-sm">
                            <input type="email" name="email" placeholder="Tu email" required class="search-input w-full px-4 py-3 rounded-xl text-sm">
                        </div>
                        <input type="tel" name="phone" placeholder="Tu teléfono" required class="search-input w-full px-4 py-3 rounded-xl text-sm">
                        <textarea name="message" placeholder="Tu mensaje" rows="4" required class="search-input w-full px-4 py-3 rounded-xl text-sm resize-none"></textarea>
                        <input type="hidden" name="vehicle_id" id="vehicle_id">
                        <button type="submit" class="w-full py-3.5 text-sm font-semibold text-white rounded-xl transition hover:opacity-90 hover:shadow-lg" style="background: var(--primary-color);">
                            Enviar Mensaje
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- FOOTER: Multi-column SaaS footer -->
    <footer class="pt-16 pb-8 px-6" style="background: rgba(0,0,0,0.3); border-top: 1px solid rgba(255,255,255,0.04);">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-10 mb-12">
                <!-- Brand col -->
                <div class="col-span-2 md:col-span-1">
                    <div class="flex items-center gap-2.5 mb-4">
                        @if($settings && $settings->logo_url)
                            <img src="{{ $settings->logo_url }}" alt="{{ $tenant->name }}" class="h-8 object-contain">
                        @else
                            <div class="h-8 w-8 rounded-xl flex items-center justify-center" style="background: var(--primary-color);">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            </div>
                        @endif
                        <span class="font-bold text-white">{{ $tenant->name }}</span>
                    </div>
                    <p class="text-sm text-white/35 leading-relaxed mb-5">{{ $settings->contact_message ?? 'La solución integral de software para la gestión, marketing y ventas de vehículos.' }}</p>
                    <div class="flex gap-3">
                        @if($settings->facebook_url)<a href="{{ $settings->facebook_url }}" target="_blank" class="w-8 h-8 rounded-lg flex items-center justify-center transition text-white/40 hover:text-white" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.06);">Fb</a>@endif
                        @if($settings->instagram_url)<a href="{{ $settings->instagram_url }}" target="_blank" class="w-8 h-8 rounded-lg flex items-center justify-center transition text-white/40 hover:text-white" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.06);">Ig</a>@endif
                        @if($settings->linkedin_url)<a href="{{ $settings->linkedin_url }}" target="_blank" class="w-8 h-8 rounded-lg flex items-center justify-center transition text-white/40 hover:text-white" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.06);">Li</a>@endif
                    </div>
                </div>
                <!-- Links columns -->
                <div>
                    <h5 class="text-xs font-semibold uppercase tracking-wider text-white/60 mb-4">Producto</h5>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ route('public.vehiculos') }}" class="text-white/35 hover:text-white transition">Inventario</a></li>
                        <li><a href="#nosotros" class="text-white/35 hover:text-white transition">Nosotros</a></li>
                        <li><a href="#contacto" class="text-white/35 hover:text-white transition">Contacto</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="text-xs font-semibold uppercase tracking-wider text-white/60 mb-4">Empresa</h5>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="#nosotros" class="text-white/35 hover:text-white transition">Sobre Nosotros</a></li>
                        <li><a href="#contacto" class="text-white/35 hover:text-white transition">Contacto</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="text-xs font-semibold uppercase tracking-wider text-white/60 mb-4">Legal</h5>
                    <ul class="space-y-2.5 text-sm">
                        <li><span class="text-white/35">Privacidad</span></li>
                        <li><span class="text-white/35">Términos de Uso</span></li>
                    </ul>
                </div>
            </div>
            <div class="pt-6 flex items-center justify-between text-xs text-white/25" style="border-top: 1px solid rgba(255,255,255,0.04);">
                <p>© {{ date('Y') }} {{ $tenant->name }}. TODOS LOS DERECHOS RESERVADOS.</p>
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
