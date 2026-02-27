<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $tenant->name ?? 'Agencia de Autos' }} - Plataforma Digital</title>
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
        $fontUrl = isset($googleFonts[$font])
            ? 'https://fonts.googleapis.com/css?family=' . $googleFonts[$font] . ':300,400,500,600,700,800&display=swap'
            : null;
    @endphp
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    @if ($fontUrl)
        <link href="{{ $fontUrl }}" rel="stylesheet">
    @endif
    <style>
        :root {
            --primary-color: {{ $settings && $settings->primary_color ? $settings->primary_color : '#2563eb' }};
            --secondary-color: {{ $settings && $settings->secondary_color ? $settings->secondary_color : '#fafbff' }};
            --tertiary-color: {{ $settings && $settings->tertiary_color ? $settings->tertiary_color : '#e0e7ff' }};
        }

        body {
            font-family: {{ $settings->font_family ?? "'Inter', sans-serif" }};
        }

        /* Gradient text */
        .gradient-text-light {
            background: linear-gradient(135deg, var(--primary-color), #7c3aed);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Soft card */
        .soft-card {
            background: var(--tertiary-color);
            border: 1px solid #f0f0f5;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .soft-card:hover {
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.08);
            transform: translateY(-4px);
        }

        /* Vehicle card light */
        .vehicle-card-light {
            background: var(--tertiary-color);
            border: 1px solid #f0f0f5;
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.35s ease;
        }

        .vehicle-card-light:hover {
            box-shadow: 0 16px 48px rgba(0, 0, 0, 0.08);
            transform: translateY(-4px);
        }

        /* Status badges */
        .status-available-light {
            background: #ecfdf5;
            color: #059669;
        }

        .status-reserved-light {
            background: #fef3c7;
            color: #d97706;
        }

        /* Feature card light */
        .feature-card-light {
            background: var(--tertiary-color);
            border: 1px solid #f0f0f5;
            border-radius: 16px;
            padding: 28px;
            transition: all 0.3s ease;
        }

        .feature-card-light:hover {
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.06);
            border-color: rgba(37, 99, 235, 0.15);
            transform: translateY(-3px);
        }

        /* CTA dark section */
        .cta-dark {
            background: linear-gradient(135deg, #0f172a, #1e293b);
            border-radius: 24px;
        }

        /* Configurator widget */
        .config-widget {
            background: var(--tertiary-color);
            border: 1px solid #f0f0f5;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.08);
        }

        /* Subtle bg sections */
        .bg-subtle {
            background: var(--secondary-color);
        }

        @if (isset($editMode) && $editMode)
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

    <!-- NAVBAR: Color secundario -->
    <nav class="sticky top-0 z-50" style="background: var(--secondary-color); backdrop-filter: blur(20px); border-bottom: 1px solid var(--tertiary-color);">
        <div class="max-w-7xl mx-auto px-6 py-3.5 flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                @if (isset($editMode) && $editMode)
                    <div class="editable-section inline-block relative">
                        @if ($settings && $settings->logo_url)
                            <img src="{{ $settings->logo_url }}" alt="{{ $tenant->name }}" class="h-9 object-contain">
                        @else
                            <div class="h-9 w-9 rounded-xl flex items-center justify-center"
                                style="background: var(--primary-color);">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                        @endif
                        <div class="edit-btn" onclick="editImage('logo_url')"><i class="fa fa-pencil"></i></div>
                    </div>
                    <div class="editable-section inline-block relative"
                        style="min-width:100px; display:flex; align-items:center; gap:6px;">
                        <span class="text-lg font-bold text-gray-900"
                            style="color: {{ $settings->agency_name_color ?? '#111827' }}">{{ $tenant->name }}</span>
                        <button type="button" class="edit-btn"
                            style="position:static; display:flex; margin-left:4px; background:var(--primary-color); color:#fff; width:24px; height:24px; border-radius:50%; align-items:center; justify-content:center; cursor:pointer; z-index:50; border:none; font-size:10px;"
                            onclick="editText('agency_name','Editar Nombre')"><i class="fa fa-pencil"></i></button>
                    </div>
                @else
                    <div class="inline-block relative">
                        @if ($settings && $settings->logo_url)
                            <img src="{{ $settings->logo_url }}" alt="{{ $tenant->name }}" class="h-9 object-contain">
                        @else
                            <div class="h-9 w-9 rounded-xl flex items-center justify-center"
                                style="background: var(--primary-color);">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                        @endif
                    </div>
                    <span class="text-lg font-bold text-gray-900"
                        style="color: {{ $settings->agency_name_color ?? '#111827' }}">{{ $tenant->name }}</span>
                @endif
            </div>
            <!-- Menú Desktop -->
            <div class="hidden md:flex items-center gap-7">
                <a href="#vehiculos" class="text-sm font-medium transition hover:text-gray-900"
                    style="color: {{ $settings->navbar_links_color ?? '#6b7280' }}">Inventario</a>
                <a href="#nosotros" class="text-sm font-medium transition hover:text-gray-900"
                    style="color: {{ $settings->navbar_links_color ?? '#6b7280' }}">Nosotros</a>
                <a href="#contacto" class="text-sm font-medium transition hover:text-gray-900"
                    style="color: {{ $settings->navbar_links_color ?? '#6b7280' }}">Contacto</a>
            </div>

            <!-- Botón Hamburguesa Mobile -->
            <button id="menu-toggle"
                class="md:hidden flex flex-col justify-center items-center w-10 h-10 focus:outline-none ml-2"
                aria-label="Abrir menú">
                <span class="block w-6 h-0.5 bg-gray-900 mb-1 transition-all"></span>
                <span class="block w-6 h-0.5 bg-gray-900 mb-1 transition-all"></span>
                <span class="block w-6 h-0.5 bg-gray-900 transition-all"></span>
            </button>
        </div>
        <!-- Menú Mobile -->
        <div id="mobile-menu"
            class="md:hidden fixed inset-0 z-50 flex flex-col items-center justify-center space-y-8 text-lg font-semibold transition-all duration-300 opacity-0 pointer-events-none" style="background: var(--secondary-color);">
            <button id="menu-close" class="absolute top-6 right-6 text-gray-900 text-3xl focus:outline-none"
                aria-label="Cerrar menú">&times;</button>
            <a href="#vehiculos" class="navbar-link-auto text-gray-900">Vehículos</a>
            <a href="#nosotros" class="navbar-link-auto text-gray-900">Nosotros</a>
            <a href="#contacto" class="navbar-link-auto text-gray-900">Contacto</a>
            
        </div>
        </div>
    </nav>

    <div id="inicio"></div>

    <!-- HERO: Split — texto izq con badge + widget configurador der -->
    <div class="max-w-7xl mx-auto px-6 pt-16 pb-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-semibold mb-8"
                    style="background: rgba(37,99,235,0.08); color: var(--primary-color); border: 1px solid rgba(37,99,235,0.12);">
                    <span class="w-1.5 h-1.5 rounded-full" style="background: var(--primary-color);"></span>
                    Agencia de Autos
                </div>
                
                @if (isset($editMode) && $editMode)
                    <div class="editable-section mb-6 relative">
                        <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold leading-tight">
                            <span class="text-white">{{ $settings->hero_title ?? 'Eleva la Presencia Digital de tu Concesionario' }}</span>
                        </h1>
                        <button type="button" class="edit-btn" style="position:absolute; top:8px; right:8px; background:var(--primary-color); color:#fff; width:32px; height:32px; border-radius:50%; display:flex; align-items:center; justify-content:center; cursor:pointer; z-index:50; border:none;" onclick="editText('hero_title','Editar Título del Hero')"><i class="fa fa-pencil"></i></button>
                    </div>
                @else
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold leading-tight mb-6">
                        <span class="text-white">{{ $settings->hero_title ?? 'Eleva la Presencia Digital de tu Concesionario' }}</span>
                    </h1>
                @endif
                @if (isset($editMode) && $editMode)
                    <div class="editable-section mb-8">
                        <p class="text-base leading-relaxed max-w-lg"
                            style="color: {{ $settings->home_description_color ?? '#6b7280' }}">
                            {{ $settings->home_description ?? 'Gestión inteligente de inventario y CRM especializado para el sector de automóviles. La herramienta definitiva para vendedores de élite.' }}
                        </p>
                        <div class="edit-btn" onclick="editText('home_description','Editar Descripción')"><i
                                class="fa fa-pencil"></i></div>
                    </div>
                @else
                    <p class="text-base leading-relaxed max-w-lg mb-8"
                        style="color: {{ $settings->home_description_color ?? '#6b7280' }}">
                        {{ $settings->home_description ?? 'Gestión inteligente de inventario y CRM especializado para el sector de automóviles. La herramienta definitiva para vendedores de élite.' }}
                    </p>
                @endif
                <div class="flex flex-wrap items-center gap-3">
                    <a href="#vehiculos"
                        class="inline-flex items-center gap-2 px-7 py-3.5 text-sm font-semibold text-white rounded-full transition hover:opacity-90 hover:shadow-lg"
                        style="background: var(--primary-color);">
                        Ver Vehículos
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                    
                </div>
            </div>
            
        </div>
    </div>

    <!-- SHOWCASE: Banner full-width con imagen + overlay -->
    <div class="max-w-7xl mx-auto px-6 mb-16">
        <div class="relative rounded-3xl overflow-hidden min-h-[300px]">
            @if (isset($editMode) && $editMode)
                <div class="editable-section w-full h-full absolute inset-0">
                    @if ($settings && $settings->banner_url)
                        <img src="{{ $settings->banner_url }}" alt="Showcase"
                            class="w-full h-full object-cover min-h-[300px]">
                    @else
                        <div class="w-full min-h-[300px] flex items-center justify-center bg-gray-700">
                            <svg class="w-16 h-16 text-white/20" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif
                    <button type="button" class="edit-btn" style="position:absolute; top:16px; right:16px; background:var(--primary-color); color:#fff; width:40px; height:40px; border-radius:50%; display:flex; align-items:center; justify-content:center; cursor:pointer; z-index:51; border:none;" onclick="editImage('banner_url')"><i class="fa fa-pencil"></i></button>
                </div>
            @else
                @if ($settings && $settings->banner_url)
                    <img src="{{ $settings->banner_url }}" alt="Showcase"
                        class="w-full h-full object-cover absolute inset-0 min-h-[300px]">
                @else
                    <div class="w-full min-h-[300px] absolute inset-0 flex items-center justify-center bg-gray-700">
                        <svg class="w-16 h-16 text-white/20" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                @endif
            @endif
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
        </div>
    </div

    <!-- VEHÍCULOS: Cards 3-col con badges, specs y pricing — fondo claro -->
    @if ($settings->show_vehicles && $vehicles->count() > 0)
        <div id="vehiculos" class="pb-20 px-6">
            <div class="max-w-7xl mx-auto">
                <div class="flex items-end justify-between mb-10">
                    <div>
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-1">Unidades Destacadas</h2>
                        <p class="text-gray-400 text-sm">Gestioná y visualizá tu flota premium en tiempo real.</p>
                    </div>
                    <a href="{{ route('public.vehiculos') }}"
                        class="text-sm font-semibold flex items-center gap-1 transition hover:gap-2"
                        style="color: var(--primary-color);">
                        Ver catálogo completo
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($vehicles as $index => $vehicle)
                        <div class="vehicle-card-light group">
                            <div class="relative overflow-hidden">
                                <img src="{{ $vehicle->main_image }}" alt="{{ $vehicle->title }}"
                                    class="w-full h-52 object-cover transition duration-500 group-hover:scale-105">
                                <div class="absolute top-3 right-3">
                                    @if ($index % 3 !== 1)
                                        <span
                                            class="status-available-light px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider">Disponible</span>
                                    @else
                                        <span
                                            class="status-reserved-light px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider">Reservado</span>
                                    @endif
                                </div>
                            </div>
                            <div class="p-5">
                                <div class="flex items-center gap-2 mb-1">
                                    <span
                                        class="text-[10px] font-bold uppercase tracking-wider text-gray-400">{{ $vehicle->year }}</span>
                                    <span class="text-gray-200">·</span>
                                    <span
                                        class="text-[10px] font-bold uppercase tracking-wider text-gray-400">{{ $vehicle->brand }}</span>
                                </div>
                                <h4 class="text-base font-bold text-gray-900 mb-3">{{ $vehicle->title }}</h4>
                                <!-- Specs row -->
                                <div class="flex items-center gap-4 text-xs text-gray-400 mb-4">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" style="color: var(--primary-color);" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ number_format($vehicle->kilometers / 1000, 1) }}k
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" style="color: var(--primary-color);" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                        </svg>
                                        {{ $vehicle->transmission ?? 'AWD' }}
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" style="color: var(--primary-color);" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                                        </svg>
                                        {{ $vehicle->fuel_type ?? 'Nafta' }}
                                    </span>
                                </div>
                                <!-- Price + action -->
                                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                    <span
                                        class="text-xl font-bold text-gray-900">${{ number_format($vehicle->price) }}</span>
                                    <button type="button"
                                        onclick="openContactForm('{{ $vehicle->id }}', '{{ $vehicle->title }}')"
                                        class="w-10 h-10 rounded-xl flex items-center justify-center transition hover:shadow-md"
                                        style="background: rgba(37,99,235,0.08); color: var(--primary-color);">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- FEATURES: "Diseñado para la excelencia" — 3 cards con íconos coloreados -->
    <div id="nosotros" class="py-20 px-6 bg-subtle">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-14">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-3 italic">Te ayudamos con tu próximo vehículo</h2>
                <p class="text-gray-400 text-base max-w-xl mx-auto">Nuestro objetivo es facilitarte la mejor experiencia en la compra de tu próximo automóvil.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="feature-card-light">
                    <div class="w-12 h-12 rounded-xl mb-5 flex items-center justify-center"
                        style="background: rgba(37,99,235,0.08);">
                        <svg class="w-6 h-6" style="color: var(--primary-color);" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Stock de vehículos</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">Visualiza nuestro inventario de vehículos disponibles en tiempo real.</p>
                </div>
                <div class="feature-card-light">
                    <div class="w-12 h-12 rounded-xl mb-5 flex items-center justify-center"
                        style="background: rgba(124,58,237,0.08);">
                        <svg class="w-6 h-6" style="color: #7c3aed;" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Clientes satisfechos</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">Nuestros clientes confían en nosotros y están satisfechos con nuestros servicios.</p>
                </div>
                <div class="feature-card-light">
                    <div class="w-12 h-12 rounded-xl mb-5 flex items-center justify-center"
                        style="background: rgba(6,182,212,0.08);">
                        <svg class="w-6 h-6" style="color: #06b6d4;" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Financiación</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">Ofrecemos opciones de financiación flexibles para que puedas adquirir tu vehículo de manera cómoda y segura.</p>
                </div>
            </div>

            <!-- Nosotros / About -->
            <div class="mt-20 grid grid-cols-1 lg:grid-cols-2 gap-14 items-center">
                <div class="relative">
                    @if (isset($editMode) && $editMode)
                        <div class="editable-section rounded-2xl overflow-hidden">
                            <img src="{{ $settings->nosotros_url ?? 'https://images.unsplash.com/photo-1560958089-b8a1929cea89?w=800&h=500&fit=crop' }}"
                                alt="Nosotros" class="w-full h-72 object-cover rounded-2xl shadow-lg">
                            <div class="edit-btn" onclick="editImage('nosotros_url')"><i class="fa fa-pencil"></i>
                            </div>
                        </div>
                    @else
                        <img src="{{ $settings->nosotros_url ?? 'https://images.unsplash.com/photo-1560958089-b8a1929cea89?w=800&h=500&fit=crop' }}"
                            alt="Nosotros" class="w-full h-72 object-cover rounded-2xl shadow-lg">
                    @endif
                </div>
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold mb-4"
                        style="background: rgba(37,99,235,0.08); color: var(--primary-color);">
                        Sobre Nosotros
                    </div>
                    @if (isset($editMode) && $editMode)
                        <div class="editable-section mb-6">
                            <p class="text-base text-gray-500 leading-relaxed whitespace-pre-line"
                                style="color: {{ $settings->nosotros_description_color ?? '#6b7280' }}">
                                {{ $settings->nosotros_description ?? "Somos una plataforma automotriz de nueva generación que combina tecnología de punta con la pasión por los automóviles.\n\nNuestro equipo de expertos se dedica a encontrar el vehículo perfecto para cada cliente, con opciones de financiamiento a medida y un proceso 100% transparente." }}
                            </p>
                            <div class="edit-btn" onclick="editText('nosotros_description','Editar Descripción')"><i
                                    class="fa fa-pencil"></i></div>
                        </div>
                    @else
                        <p class="text-base text-gray-500 leading-relaxed whitespace-pre-line mb-6"
                            style="color: {{ $settings->nosotros_description_color ?? '#6b7280' }}">
                            {{ $settings->nosotros_description ?? "Somos una plataforma automotriz de nueva generación que combina tecnología de punta con la pasión por los automóviles.\n\nNuestro equipo de expertos se dedica a encontrar el vehículo perfecto para cada cliente, con opciones de financiamiento a medida y un proceso 100% transparente." }}
                        </p>
                    @endif
                    @if (isset($editMode) && $editMode)
                        <div class="editable-section flex gap-8 pt-6 border-t border-gray-200">
                            <div>
                                <div class="text-2xl font-bold text-gray-900">{{ $settings->stat1 ?? '500+' }}</div>
                                <p class="text-xs text-gray-400 mt-0.5">
                                    {{ $settings->stat1_label ?? 'Concesionarios' }}</p>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-gray-900">{{ $settings->stat2 ?? '98%' }}</div>
                                <p class="text-xs text-gray-400 mt-0.5">{{ $settings->stat2_label ?? 'Satisfacción' }}
                                </p>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-gray-900">{{ $settings->stat3 ?? '24/7' }}</div>
                                <p class="text-xs text-gray-400 mt-0.5">{{ $settings->stat3_label ?? 'Soporte' }}</p>
                            </div>
                            <div class="edit-btn self-center" onclick="editStats()"><i class="fa fa-pencil"></i>
                            </div>
                        </div>
                    @else
                        <div class="flex gap-8 pt-6 border-t border-gray-200">
                            <div>
                                <div class="text-2xl font-bold text-gray-900">{{ $settings->stat1 ?? '500+' }}</div>
                                <p class="text-xs text-gray-400 mt-0.5">
                                    {{ $settings->stat1_label ?? 'Concesionarios' }}</p>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-gray-900">{{ $settings->stat2 ?? '98%' }}</div>
                                <p class="text-xs text-gray-400 mt-0.5">{{ $settings->stat2_label ?? 'Satisfacción' }}
                                </p>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-gray-900">{{ $settings->stat3 ?? '24/7' }}</div>
                                <p class="text-xs text-gray-400 mt-0.5">{{ $settings->stat3_label ?? 'Soporte' }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- CTA SECTION: Banner oscuro con rounded corners -->
    <div class="max-w-6xl mx-auto px-6 py-14">
        <div class="cta-dark px-10 py-16 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4 italic">¿Listo para tu próximo vehículo?</h2>
            <p class="text-white/60 text-base mb-8 max-w-lg mx-auto">Únete a cientos de clientes que ya confiaron en {{ $tenant->name }}.</p>
            <div class="flex flex-wrap items-center justify-center gap-4">
                
                <a href="#vehiculos"
                    class="px-8 py-3.5 border-2 border-white/25 text-white text-sm font-semibold rounded-full transition hover:bg-white/10">
                    Ver vehículos disponibles
                </a>
            </div>
        </div>
    </div>

    <!-- CONTACTO: Card centrada clean -->
    @if ($settings->show_contact_form)
        <div id="contacto" class="py-16 px-6">
            <div class="max-w-3xl mx-auto">
                <div class="text-center mb-10">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold mb-4"
                        style="background: rgba(37,99,235,0.08); color: var(--primary-color);">
                        Contacto
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">¿Tenés alguna consulta?</h2>
                    <p class="text-gray-400 text-sm">Completá el formulario y te respondemos en menos de 24hs.</p>
                </div>

                <div class="soft-card p-8">
                    <!-- Contact info -->
                    <div class="flex flex-wrap items-center justify-center gap-6 mb-8 pb-8 border-b border-gray-100">
                        @if (isset($editMode) && $editMode)
                            <button onclick="editContact()" class="text-xs px-3 py-1 border rounded-lg transition"
                                style="color: var(--primary-color); border-color: var(--primary-color);">Editar datos
                                de contacto</button>
                        @endif
                        @if ($settings->phone)
                            <a href="tel:{{ $settings->phone }}"
                                class="flex items-center gap-2 text-sm text-gray-400 hover:text-gray-700 transition">
                                <svg class="w-4 h-4" style="color: var(--primary-color);" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                {{ $settings->phone }}
                            </a>
                        @endif
                        @if ($settings->email)
                            <a href="mailto:{{ $settings->email }}"
                                class="flex items-center gap-2 text-sm text-gray-400 hover:text-gray-700 transition">
                                <svg class="w-4 h-4" style="color: var(--primary-color);" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                {{ $settings->email }}
                            </a>
                        @endif
                        @if ($settings->whatsapp)
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings->whatsapp) }}"
                                target="_blank"
                                class="flex items-center gap-2 text-sm text-gray-400 hover:text-gray-700 transition">
                                <svg class="w-4 h-4" style="color: var(--primary-color);" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                                WhatsApp
                            </a>
                        @endif
                    </div>

                    <form action="{{ \App\Helpers\RouteHelper::publicContactRoute() }}" method="POST"
                        class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <input type="text" name="name" placeholder="Tu nombre" required
                                class="w-full px-4 py-3 text-sm bg-gray-50 border border-gray-200 rounded-xl text-gray-800 placeholder-gray-400 focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-50 transition">
                            <input type="email" name="email" placeholder="Tu email" required
                                class="w-full px-4 py-3 text-sm bg-gray-50 border border-gray-200 rounded-xl text-gray-800 placeholder-gray-400 focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-50 transition">
                        </div>
                        <input type="tel" name="phone" placeholder="Tu teléfono" required
                            class="w-full px-4 py-3 text-sm bg-gray-50 border border-gray-200 rounded-xl text-gray-800 placeholder-gray-400 focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-50 transition">
                        <textarea name="message" placeholder="Tu mensaje" rows="4" required
                            class="w-full px-4 py-3 text-sm bg-gray-50 border border-gray-200 rounded-xl text-gray-800 placeholder-gray-400 focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-50 transition resize-none"></textarea>
                        <input type="hidden" name="vehicle_id" id="vehicle_id">
                        <button type="submit"
                            class="w-full py-3.5 text-sm font-semibold text-white rounded-xl transition hover:opacity-90 hover:shadow-lg"
                            style="background: var(--primary-color);">
                            Enviar Mensaje
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- FOOTER: Multi-column light/dark footer -->
    <footer class="pt-14 pb-8 px-6 bg-gray-900 text-gray-400">
        <div class="max-w-2xl mx-auto">
            <div class="grid grid-cols-2 md:grid-cols-2 gap-10 mb-12">
                <div class="col-span-2 md:col-span-1">
                    <div class="flex items-center gap-2.5 mb-4">
                        @if ($settings && $settings->logo_url)
                            <img src="{{ $settings->logo_url }}" alt="{{ $tenant->name }}"
                                class="h-8 object-contain brightness-200">
                        @else
                            <div class="h-8 w-8 rounded-xl flex items-center justify-center"
                                style="background: var(--primary-color);">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                        @endif
                        <span class="font-bold text-white">{{ $tenant->name }}</span>
                    </div>
                    <p class="text-sm text-gray-500 leading-relaxed mb-5">
                        {{ $settings->contact_message ?? 'Te ayudamos con la gestión de tu próximo vehículo.' }}
                    </p>
                    <div class="flex gap-3">
                        @if ($settings->facebook_url)
                            <a href="{{ $settings->facebook_url }}" target="_blank"
                                class="w-8 h-8 rounded-lg flex items-center justify-center bg-gray-800 text-gray-500 hover:text-white transition text-xs font-bold">Fb</a>
                        @endif
                        @if ($settings->instagram_url)
                            <a href="{{ $settings->instagram_url }}" target="_blank"
                                class="w-8 h-8 rounded-lg flex items-center justify-center bg-gray-800 text-gray-500 hover:text-white transition text-xs font-bold">Ig</a>
                        @endif
                        @if ($settings->linkedin_url)
                            <a href="{{ $settings->linkedin_url }}" target="_blank"
                                class="w-8 h-8 rounded-lg flex items-center justify-center bg-gray-800 text-gray-500 hover:text-white transition text-xs font-bold">Li</a>
                        @endif
                    </div>
                </div>
                <div>
                    <h5 class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-4">Producto</h5>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ route('public.vehiculos') }}"
                                class="text-gray-500 hover:text-white transition">Vehículos</a></li>
                        <li><a href="#nosotros" class="text-gray-500 hover:text-white transition">Nosotros</a></li>
                        <li><a href="#contacto" class="text-gray-500 hover:text-white transition">Contacto</a></li>
                    </ul>
                </div>
              
            </div>
            <div class="pt-6 flex items-center justify-between text-xs text-gray-600"
                style="border-top: 1px solid rgba(255,255,255,0.06);">
                <p>© {{ date('Y') }} {{ $tenant->name }}. TODOS LOS DERECHOS RESERVADOS.</p>
            </div>
        </div>
    </footer>

    @if (isset($editMode) && $editMode)
        @include('public.templates.partials.editor-scripts')
    @endif

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
            if (menuToggle && mobileMenu) {
                menuToggle.addEventListener('click', openMenu);
            }
            if (menuClose && mobileMenu) {
                menuClose.addEventListener('click', closeMenu);
            }
            // Cerrar menú al hacer click fuera
            mobileMenu && mobileMenu.addEventListener('click', function(e) {
                if (e.target === mobileMenu) closeMenu();
            });
            // Cerrar menú con ESC
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') closeMenu();
            });
        });

        function openContactForm(vehicleId, vehicleTitle) {
            document.getElementById('vehicle_id').value = vehicleId;
            document.querySelector('textarea[name="message"]').value = `Consulta por: ${vehicleTitle}`;
            document.getElementById('contacto').scrollIntoView({
                behavior: 'smooth'
            });
            document.querySelector('input[name="name"]').focus();
        }
    </script>
</body>
@if (isset($editMode) && $editMode)
    @include('public.templates.partials.editor-scripts')
@endif

</html>
