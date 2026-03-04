<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ isset($settings) && $settings->logo_url ? $settings->logo_url : '/storage/icono.png' }}">
    <title>{{ $tenant->name ?? 'Agencia de Autos' }} - Vehículos en Venta</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

        /* Estilo Glassmorphism */
        .glass { 
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.15);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.25);
        }
        .btn-gradient {
            background: linear-gradient(135deg, var(--primary-color), var(--tertiary-color));
            color: #fff;
        }

        @if(isset($editMode) && $editMode)
        .editable-section { position: relative; outline: 2px dashed rgba(59,130,246,0.4); outline-offset: 4px; }
        .editable-section:hover .edit-btn,
        .editable-section .edit-btn:hover,
        .editable-section .edit-btn:focus {
            display: flex !important;
        }
        .edit-btn { display: inline-flex !important; align-items: center; justify-content: center; background: #3b82f6 !important; color: #fff !important; border-radius: 50%; font-size: 18px !important; padding: 4px !important; margin-left: 6px; cursor: pointer; z-index: 9999 !important; box-shadow: 0 2px 8px rgba(0,0,0,0.15); border: none; position: absolute; top: 8px; right: 8px; }
        @endif
    </style>
</head>
<body style="background: radial-gradient(circle at 20% 50%, rgba(0, 208, 132, 0.08), transparent 50%), radial-gradient(circle at 80% 80%, rgba(255, 170, 0, 0.06), transparent 50%), var(--secondary-color);" class="text-white">
    <!-- Navbar -->
    <nav class="sticky top-0 z-50" style="background: rgba(255,255,255,0.06); backdrop-filter: blur(12px); border-bottom: 1px solid rgba(255,255,255,0.15);">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between relative">
            <div class="flex items-center gap-3">
                @if(isset($editMode) && $editMode)
                    <div class="editable-section inline-block relative">
                        @if($settings && $settings->logo_url)
                            <img src="{{ $settings->logo_url }}" alt="{{ $tenant->name }}" class="h-10 object-contain">
                        @else
                            <div class="h-10 w-10 rounded-lg" style="background-color: var(--primary-color);"></div>
                        @endif
                        <div class="edit-btn" onclick="editImage('logo_url')"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="18" height="18" fill="currentColor" style="vertical-align:middle"><path d="M12.146 2.146a1 1 0 0 1 1.414 0l.294.294a1 1 0 0 1 0 1.414l-8.5 8.5a1 1 0 0 1-.293.207l-2.5 1.25a.5.5 0 0 1-.66-.66l1.25-2.5a1 1 0 0 1 .207-.293l8.5-8.5zm1.414-1.414a2 2 0 0 0-2.828 0l-8.5 8.5a2 2 0 0 0-.414.586l-1.25 2.5A1.5 1.5 0 0 0 2.5 14.5l2.5-1.25a2 2 0 0 0 .586-.414l8.5-8.5a2 2 0 0 0 0-2.828l-.294-.294z"/></svg></div>
                    </div>
                    @php
                        $showAgencyName = isset($tenant->name) && trim($tenant->name) !== '';
                    @endphp
                    <div class="editable-section inline-block relative ml-2 align-middle" style="min-width: 120px; min-height: 40px; display: flex; align-items: center; gap: 8px;">
                        @if($showAgencyName)
                            <span class="text-xl font-bold" style="color: {{ $settings->agency_name_color ?? '#fff' }}; min-width: 80px; display: inline-block;">{{ $tenant->name }}</span>
                        @endif
                        <button type="button" class="edit-btn" style="position:static; display:flex; margin-left:4px; background:#3b82f6; color:#fff; width:32px; height:32px; border-radius:50%; align-items:center; justify-content:center; cursor:pointer; box-shadow:0 2px 8px rgba(0,0,0,0.3); z-index:50; border:none;" onclick="editText('agency_name','Editar Nombre de Agencia')"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="14" height="14" fill="currentColor" style="vertical-align:middle"><path d="M12.146.854a.5.5 0 0 1 .708 0l2.292 2.292a.5.5 0 0 1 0 .708l-9.5 9.5a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l9.5-9.5z"/></svg></button>
                    </div>
                @else
                    @if($settings && $settings->logo_url)
                        <img src="{{ $settings->logo_url }}" alt="{{ $tenant->name }}" class="h-10 object-contain">
                    @else
                        <div class="h-10 w-10 rounded-lg" style="background-color: var(--primary-color);"></div>
                    @endif
                    <span class="text-xl font-bold text-white align-middle">{{ $tenant->name }}</span>
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
            background: rgba(30,41,59,0.98);
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

    <!-- Inicio -->
    <div id="inicio"></div>

    <!-- Hero Section -->
    <div class="relative min-h-[600px] flex items-center justify-center overflow-hidden">
        @if(isset($editMode) && $editMode)
            <div class="absolute inset-0">
                @if($settings && $settings->banner_url)
                    <img src="{{ $settings->banner_url }}" alt="Banner" class="absolute inset-0 w-full h-full object-cover">
                @endif
                <div class="editable-section" style="position:absolute; top:16px; right:16px; z-index:51; width:40px; height:40px; display:flex; align-items:center; justify-content:center;">
                    <button type="button" class="edit-btn" style="position:static; display:flex; background:#3b82f6; color:#fff; width:40px; height:40px; border-radius:50%; align-items:center; justify-content:center; cursor:pointer; box-shadow:0 2px 8px rgba(0,0,0,0.3); z-index:51; border:none;" onclick="editImage('banner_url')"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="14" height="14" fill="currentColor" style="vertical-align:middle"><path d="M12.146.854a.5.5 0 0 1 .708 0l2.292 2.292a.5.5 0 0 1 0 .708l-9.5 9.5a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l9.5-9.5z"/></svg></button>
                </div>
            </div>
        @else
            @if($settings && $settings->banner_url)
                <img src="{{ $settings->banner_url }}" alt="Banner" class="absolute inset-0 w-full h-full object-cover">
            @endif
        @endif
        <div class="absolute inset-0" style="background: radial-gradient(ellipse at top, rgba(255,255,255,0.08), transparent), linear-gradient(135deg, rgba(0,0,0,0.4), rgba(0,0,0,0.2))"></div>
        <div class="relative text-center text-white px-4">
            <div class="glass inline-block px-10 py-8 rounded-3xl">
                @if(isset($editMode) && $editMode)
                    <div class="editable-section inline-block max-w-2xl mx-auto mb-6">
                        <p class="text-xl md:text-2xl font-extralight tracking-wide opacity-90" style="color: {{ $settings->home_description_color ?? '#fff' }}">{{ $settings->home_description ?? 'Descubre nuestro catálogo premium de vehículos' }}</p>
                        <div class="edit-btn" onclick="editText('home_description','Editar Descripción Principal')"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="14" height="14" fill="currentColor" style="vertical-align:middle"><path d="M12.146.854a.5.5 0 0 1 .708 0l2.292 2.292a.5.5 0 0 1 0 .708l-9.5 9.5a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l9.5-9.5z"/></svg></div>
                    </div>
                @else
                    <p class="text-xl md:text-2xl max-w-2xl mx-auto font-extralight tracking-wide opacity-90 mb-6" style="color: {{ $settings->home_description_color ?? '#fff' }}">{{ $settings->home_description ?? 'Descubre nuestro catálogo premium de vehículos' }}</p>
                @endif
                <div class="w-full flex justify-center mt-6">
                  <a href="{{ route('public.vehiculos') }}" class="inline-block px-10 py-4 rounded-xl font-medium transition hover:opacity-90 hover:scale-105 transform btn-gradient shadow-lg">
                      Ver Catálogo ↓
                  </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Vehículos Section -->
    @if($settings->show_vehicles && $vehicles->count() > 0)
        <div id="vehiculos" class="py-20 px-4">
            <div class="max-w-7xl mx-auto">
                <div class="mb-16 text-center">
                    <h3 class="text-5xl font-light tracking-tight mb-4 auto-contrast-title" style="letter-spacing: -0.02em;">Nuestro Catálogo</h3>
                    <p class="text-gray-300 text-lg">{{ $vehicles->count() }} vehículos disponibles</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    @foreach($vehicles as $vehicle)
                        <div class="group rounded-2xl overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 glass">
                            <a href="{{ route('public.vehiculos.show', $vehicle->id) }}" class="block relative h-40 bg-gray-700 overflow-hidden">
                                <img src="{{ $vehicle->main_image }}" alt="{{ $vehicle->title }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                <div class="absolute top-2 left-2">
                                    <span class="px-2 py-1 rounded text-xs font-bold" style="background-color: var(--primary-color); color: var(--secondary-color);">
                                        {{ $vehicle->year }}
                                    </span>
                                </div>
                                <div class="absolute top-2 right-2">
                                    <span class="px-2 py-1 rounded text-xs font-bold text-white" style="background-color: var(--primary-color);">
                                        ${{ number_format($vehicle->price) }}
                                    </span>
                                </div>
                            </a>

                            <div class="p-4">
                                <a href="{{ route('public.vehiculos.show', $vehicle->id) }}" class="block"><h4 class="text-lg font-bold mb-2 line-clamp-1 hover:underline">{{ $vehicle->title }}</h4></a>
                                
                                <div class="text-xs text-gray-300 mb-3">
                                    <p>{{ $vehicle->brand }} {{ $vehicle->model }}</p>
                                </div>

                                <p class="text-gray-400 text-xs mb-3 line-clamp-2">{{ Str::limit($vehicle->description, 60) }}</p>

                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings->whatsapp ?? '') }}?text=Hola! Estoy interesado en el {{ urlencode($vehicle->title) }}"
                                    target="_blank"
                                    class="w-full py-2 rounded text-xs font-bold text-white transition hover:shadow-lg text-center flex items-center justify-center gap-1.5" 
                                    style="background: #25d366;">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                    Consultar por WhatsApp
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- Nosotros Section -->
    <div id="nosotros" class="py-20 px-4" style="background: linear-gradient(135deg, rgba(255,255,255,0.05), rgba(0,0,0,0.05));">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div class="glass p-8 rounded-3xl">
                    <h3 class="text-5xl font-light tracking-tight mb-6 auto-contrast-title" style="letter-spacing: -0.02em;">Sobre Nosotros</h3>
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
                        <div class="editable-section">
                            <p class="text-lg mb-8 leading-loose whitespace-pre-line font-light" style="color: {{ $settings->nosotros_description_color ?? '#222' }}">{{ $settings->nosotros_description ?? 'Somos una agencia de autos con más de 15 años de experiencia en el mercado automotriz.\n\nNuestro equipo de profesionales está comprometido en brindarte la mejor atención y asesoramiento.' }}</p>
                            <div class="edit-btn" onclick="editText('nosotros_description','Editar Sección Nosotros')"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="14" height="14" fill="currentColor" style="vertical-align:middle"><path d="M12.146.854a.5.5 0 0 1 .708 0l2.292 2.292a.5.5 0 0 1 0 .708l-9.5 9.5a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l9.5-9.5z"/></svg></div>
                        </div>
                        <div class="editable-section flex gap-6 mt-4">
                            <div class="text-center">
                                <div class="text-4xl font-bold" style="color: var(--primary-color);">{{ $settings->stat1 ?? '150+' }}</div>
                                <p class="text-gray-300">{{ $settings->stat1_label ?? 'Autos Vendidos' }}</p>
                            </div>
                            <div class="text-center">
                                <div class="text-4xl font-bold" style="color: var(--primary-color);">{{ $settings->stat2 ?? '98%' }}</div>
                                <p class="text-gray-300">{{ $settings->stat2_label ?? 'Clientes Satisfechos' }}</p>
                            </div>
                            <div class="text-center">
                                <div class="text-4xl font-bold" style="color: var(--primary-color);">{{ $settings->stat3 ?? '24h' }}</div>
                                <p class="text-gray-300">{{ $settings->stat3_label ?? 'Atención al Cliente' }}</p>
                            </div>
                            <div class="edit-btn self-center" onclick="editStats()"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="14" height="14" fill="currentColor" style="vertical-align:middle"><path d="M12.146.854a.5.5 0 0 1 .708 0l2.292 2.292a.5.5 0 0 1 0 .708l-9.5 9.5a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l9.5-9.5z"/></svg></div>
                        </div>
                    @else
                        <p class="text-lg mb-8 leading-loose whitespace-pre-line font-light" style="color: {{ $settings->nosotros_description_color ?? '#222' }}">{{ $settings->nosotros_description ?? 'Somos una agencia de autos con más de 15 años de experiencia en el mercado automotriz.\n\nNuestro equipo de profesionales está comprometido en brindarte la mejor atención y asesoramiento.' }}</p>
                        <div class="flex gap-6 mt-4">
                            <div class="text-center">
                                <div class="text-4xl font-bold" style="color: var(--primary-color);">{{ $settings->stat1 ?? '150+' }}</div>
                                <p class="text-gray-300">{{ $settings->stat1_label ?? 'Autos Vendidos' }}</p>
                            </div>
                            <div class="text-center">
                                <div class="text-4xl font-bold" style="color: var(--primary-color);">{{ $settings->stat2 ?? '98%' }}</div>
                                <p class="text-gray-300">{{ $settings->stat2_label ?? 'Clientes Satisfechos' }}</p>
                            </div>
                            <div class="text-center">
                                <div class="text-4xl font-bold" style="color: var(--primary-color);">{{ $settings->stat3 ?? '24h' }}</div>
                                <p class="text-gray-300">{{ $settings->stat3_label ?? 'Atención al Cliente' }}</p>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="h-96 rounded-3xl overflow-hidden shadow-2xl glass @if(isset($editMode) && $editMode) editable-section @endif">
                    <img src="{{ $settings->nosotros_url ?? 'https://images.unsplash.com/photo-1487730116645-74489c95b41b?w=600&h=500&fit=crop' }}" alt="Nosotros" class="w-full h-full object-cover">
                    @if(isset($editMode) && $editMode)
                        <div class="edit-btn" onclick="editImage('nosotros_url')"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="14" height="14" fill="currentColor" style="vertical-align:middle"><path d="M12.146.854a.5.5 0 0 1 .708 0l2.292 2.292a.5.5 0 0 1 0 .708l-9.5 9.5a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l9.5-9.5z"/></svg></div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Contacto Section -->
    @if($settings->show_contact_form)
        <div id="contacto" class="py-20 px-4" style="background-color: rgba(0,0,0,0.2);">
            <div class="max-w-7xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    <div class="glass p-8 rounded-3xl">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-5xl font-light tracking-tight text-white" style="letter-spacing: -0.02em;">Contacta con Nosotros</h3>
                            @if(isset($editMode) && $editMode)
                                <button onclick="editContact()" class="ml-4 bg-blue-600 text-white text-xs px-3 py-1 rounded shadow">Editar contacto</button>
                            @endif
                        </div>
                        <p class="text-gray-300 mb-8 text-lg">{{ $settings->contact_message ?? 'Estamos disponibles para responder todas tus preguntas.' }}</p>

                        <div class="space-y-6">
                            @if($settings->phone)
                                <div class="flex items-start gap-4">
                                    <span class="text-3xl">📞</span>
                                    <div>
                                        <p class="font-bold text-white text-lg">Teléfono</p>
                                        <a href="tel:{{ $settings->phone }}" class="text-gray-300 hover:text-white transition">{{ $settings->phone }}</a>
                                    </div>
                                </div>
                            @endif

                            @if($settings->email)
                                <div class="flex items-start gap-4">
                                    <span class="text-3xl">✉️</span>
                                    <div>
                                        <p class="font-bold text-white text-lg">Email</p>
                                        <a href="mailto:{{ $settings->email }}" class="text-gray-300 hover:text-white transition">{{ $settings->email }}</a>
                                    </div>
                                </div>
                            @endif

                            @if($settings->whatsapp)
                                <div class="flex items-start gap-4">
                                    <span class="text-3xl">💬</span>
                                    <div>
                                        <p class="font-bold text-white text-lg">WhatsApp</p>
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings->whatsapp) }}" target="_blank" class="text-gray-300 hover:text-white transition">{{ $settings->whatsapp }}</a>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="mt-10 flex gap-4">
                            @if($settings->facebook_url)
                                <a href="{{ $settings->facebook_url }}" target="_blank" class="text-3xl hover:scale-125 transition">📘</a>
                            @endif
                            @if($settings->instagram_url)
                                <a href="{{ $settings->instagram_url }}" target="_blank" class="text-3xl hover:scale-125 transition">📷</a>
                            @endif
                            @if($settings->linkedin_url)
                                <a href="{{ $settings->linkedin_url }}" target="_blank" class="text-3xl hover:scale-125 transition">💼</a>
                            @endif
                        </div>
                    </div>

                    <form action="{{ \App\Helpers\RouteHelper::publicContactRoute() }}" method="POST" class="space-y-5 glass p-8 rounded-3xl">
                        @csrf
                        <input type="text" name="name" placeholder="Tu Nombre" required class="w-full px-5 py-3 rounded-lg bg-gray-700 text-white placeholder-gray-400 focus:outline-none focus:ring-2" style="--tw-ring-color: var(--primary-color);">
                        <input type="email" name="email" placeholder="Tu Email" required class="w-full px-5 py-3 rounded-lg bg-gray-700 text-white placeholder-gray-400 focus:outline-none focus:ring-2" style="--tw-ring-color: var(--primary-color);">
                        <input type="tel" name="phone" placeholder="Tu Teléfono" required class="w-full px-5 py-3 rounded-lg bg-gray-700 text-white placeholder-gray-400 focus:outline-none focus:ring-2" style="--tw-ring-color: var(--primary-color);">
                        <textarea name="message" placeholder="Tu Mensaje" rows="4" required class="w-full px-5 py-3 rounded-lg bg-gray-700 text-white placeholder-gray-400 focus:outline-none focus:ring-2" style="--tw-ring-color: var(--primary-color);"></textarea>
                        <input type="hidden" name="vehicle_id" id="vehicle_id">
                        <button type="submit" class="w-full py-3 rounded-lg font-bold text-white transition hover:shadow-2xl" style="background: linear-gradient(135deg, var(--primary-color), var(--tertiary-color));">
                            Enviar Mensaje
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Footer -->
    <footer class="py-8 px-4" style="background-color: rgba(0,0,0,0.5); border-top: 1px solid rgba(255,255,255,0.1);">
        <div class="max-w-7xl mx-auto text-center">
            <p class="text-gray-400">© {{ date('Y') }} {{ $tenant->name }}. Todos los derechos reservados.</p>
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
</html>
