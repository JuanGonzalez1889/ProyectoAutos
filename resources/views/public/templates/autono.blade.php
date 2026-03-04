<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $tenant->name ?? 'Agencia de Autos' }} - Autono</title>
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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @if ($fontUrl)
        <link href="{{ $fontUrl }}" rel="stylesheet">
    @endif
    @php
        if (!function_exists('isDark_autono')) {
            function isDark_autono($color) {
                $color = trim($color, '#');
                if(strlen($color) == 3) $color = $color[0].$color[0].$color[1].$color[1].$color[2].$color[2];
                $r = hexdec(substr($color,0,2));
                $g = hexdec(substr($color,2,2));
                $b = hexdec(substr($color,4,2));
                return (0.299*$r + 0.587*$g + 0.114*$b) < 150;
            }
        }
        $primaryColor = $settings && $settings->primary_color ? $settings->primary_color : '#00d084';
        $secondaryColor = $settings && $settings->secondary_color ? $settings->secondary_color : '#ffffff';
        $tertiaryColor = $settings && $settings->tertiary_color ? $settings->tertiary_color : '#f3f4f6';

        $textOnSecondary = isDark_autono($secondaryColor) ? '#ffffff' : '#111827';
        $textMutedOnSecondary = isDark_autono($secondaryColor) ? '#d1d5db' : '#6b7280';
        $textOnTertiary = isDark_autono($tertiaryColor) ? '#ffffff' : '#111827';
        $textMutedOnTertiary = isDark_autono($tertiaryColor) ? '#d1d5db' : '#6b7280';
        $textOnPrimary = isDark_autono($primaryColor) ? '#ffffff' : '#111827';
        $borderOnSecondary = isDark_autono($secondaryColor) ? 'rgba(255,255,255,0.15)' : '#e5e7eb';
    @endphp
    <style>
        :root {
            --primary-color: {{ $primaryColor }};
            --secondary-color: {{ $secondaryColor }};
            --tertiary-color: {{ $tertiaryColor }};
            --text-on-secondary: {{ $textOnSecondary }};
            --text-muted-on-secondary: {{ $textMutedOnSecondary }};
            --text-on-tertiary: {{ $textOnTertiary }};
            --text-muted-on-tertiary: {{ $textMutedOnTertiary }};
            --text-on-primary: {{ $textOnPrimary }};
            --border-on-secondary: {{ $borderOnSecondary }};
        }

        body {
            font-family: {{ $settings->font_family ?? "'Inter', sans-serif" }};
            background: var(--secondary-color);
            color: var(--text-on-secondary);
        }

        .autono-hero {
            position: relative;
            min-height: 100vh;
            background-image: url('{{ $settings->banner_url ?? 'https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?w=1800&h=1200&fit=crop' }}');
            background-size: cover;
            background-position: center;
        }

        .autono-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to bottom, rgba(255, 255, 255, 0.58), rgba(255, 255, 255, 0.42));
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-title {
            letter-spacing: 0.06em;
            line-height: 1.15;
            font-weight: 400;
        }

        .autono-nav-link {
            color: {{ $settings->navbar_links_color ?? '#111827' }};
            font-weight: 500;
            transition: opacity .2s ease;
        }

        .autono-nav-link:hover {
            opacity: .7;
        }

        .autono-subscribe {
            background: var(--primary-color);
            color: #fff;
            border-radius: 10px;
            padding: 10px 18px;
            font-weight: 700;
            font-size: 20px;
            line-height: 1;
            transition: opacity .2s ease;
        }

        .autono-subscribe:hover {
            opacity: .85;
        }

        .autono-section {
            max-width: 1280px;
            margin: 0 auto;
            padding: 72px 24px;
        }

        .vehicle-card {
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid var(--border-on-secondary);
            background: var(--secondary-color);
            transition: transform .25s ease, box-shadow .25s ease;
        }

        .vehicle-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 35px rgba(0, 0, 0, 0.12);
        }

        @if (isset($editMode) && $editMode)
            .editable-section {
                position: relative;
                outline: 2px dashed rgba(37, 99, 235, .4);
                outline-offset: 5px;
            }

            .edit-btn {
                position: absolute;
                top: 8px;
                right: 8px;
                width: 32px;
                height: 32px;
                border-radius: 999px;
                background: #2563eb;
                color: #fff;
                display: none;
                align-items: center;
                justify-content: center;
                z-index: 40;
                cursor: pointer;
                font-size: 14px;
                border: 0;
            }

            .editable-section:hover .edit-btn,
            .editable-section .edit-btn:focus,
            .editable-section .edit-btn:hover {
                display: flex !important;
            }
        @endif
    </style>
</head>

<body>
    @php
        $brandName = strtoupper(trim((string) ($tenant->name ?? '')));
    @endphp
    <section class="autono-hero">
        <header class="hero-content absolute top-0 left-0 right-0 z-30">
            <div class="max-w-[1600px] mx-auto px-7 md:px-14 py-8 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    @if (isset($editMode) && $editMode)
                        <div class="editable-section inline-block relative" style="min-width: 64px; min-height: 56px;">
                            @if ($settings && $settings->logo_url)
                                <img src="{{ $settings->logo_url }}" alt="{{ $tenant->name }}" style="height: 56px; max-height: 70px; max-width: 200px; width: auto; object-fit: contain;">
                            @else
                                <span class="inline-flex items-center justify-center rounded bg-white/30 text-gray-400 text-xs" style="width: 56px; height: 56px;">Logo</span>
                            @endif
                            <button type="button" class="edit-btn" onclick="editImage('logo_url')">✎</button>
                        </div>
                        <div class="editable-section inline-block relative" style="min-width: 120px; min-height: 56px;">
                            @if ($brandName !== '')
                                <span class="text-3xl tracking-[0.35em] font-bold" style="color: {{ $settings->agency_name_color ?? '#111827' }}">{{ $brandName }}</span>
                            @else
                                <span class="inline-flex items-center text-gray-400 text-sm italic" style="height: 56px;">Nombre agencia</span>
                            @endif
                            <button type="button" class="edit-btn" onclick="editText('agency_name','Editar Nombre')">✎</button>
                        </div>
                    @else
                        @if ($settings && $settings->logo_url)
                            <img src="{{ $settings->logo_url }}" alt="{{ $tenant->name }}" style="height: 56px; max-height: 70px; max-width: 200px; width: auto; object-fit: contain;">
                        @endif
                        @if ($brandName !== '')
                            <span class="text-3xl tracking-[0.35em] font-bold" style="color: {{ $settings->agency_name_color ?? '#111827' }}">{{ $brandName }}</span>
                        @endif
                    @endif
                </div>

                <nav class="hidden md:flex items-center gap-10 text-3xl">
                    <a href="#vehiculos" class="autono-nav-link">Inicio</a>
                    <a href="{{ route('public.vehiculos') }}" class="autono-nav-link">Vehículos</a>
                    <a href="#nosotros" class="autono-nav-link">Nosotros</a>
                    <a href="#contacto" class="autono-nav-link">Contacto</a>
                    
                </nav>

                <button id="menu-toggle" class="md:hidden flex flex-col justify-center items-center w-10 h-10" aria-label="Abrir menú">
                    <span class="block w-6 h-0.5 bg-black mb-1"></span>
                    <span class="block w-6 h-0.5 bg-black mb-1"></span>
                    <span class="block w-6 h-0.5 bg-black"></span>
                </button>
            </div>
        </header>

        <div id="mobile-menu" class="md:hidden fixed inset-0 z-50 flex flex-col items-center justify-center space-y-8 text-2xl transition-all duration-300 opacity-0 pointer-events-none" style="background: var(--secondary-color);">
            <button id="menu-close" class="absolute top-6 right-6 text-black text-3xl">&times;</button>
            <a href="#vehiculos" class="autono-nav-link">Inicio</a>
            <a href="{{ route('public.vehiculos') }}" class="autono-nav-link">Vehículos</a>
            <a href="#nosotros" class="autono-nav-link">Nosotros</a>
            <a href="#contacto" class="autono-nav-link">Contacto</a>
            
        </div>

        <div class="hero-content min-h-screen flex items-center justify-center px-6 md:px-10 text-center">
            <div class="w-full max-w-6xl">
                @if (isset($editMode) && $editMode)
                    <div class="editable-section inline-block mb-8">
                        <h1 class="hero-title text-[54px] md:text-[72px] lg:text-[86px] text-black uppercase">
                            {{ $settings->hero_title ?? 'La movilidad del futuro llegó' }}
                        </h1>
                        <button type="button" class="edit-btn" onclick="editText('hero_title','Editar Título Principal')">✎</button>
                    </div>
                    <div class="editable-section max-w-5xl mx-auto">
                        <p class="text-[28px] md:text-[40px] leading-snug" style="color: {{ $settings->home_description_color ?? '#1f2937' }}">
                            {{ $settings->home_description ?? 'La experiencia de autoconducción más segura con Autono' }}
                        </p>
                        <button type="button" class="edit-btn" onclick="editText('home_description','Editar Subtítulo')">✎</button>
                    </div>
                    <button type="button" class="edit-btn" style="top:120px; right:24px; display:flex;" onclick="editImage('banner_url')">✎</button>
                @else
                    <h1 class="hero-title text-[54px] md:text-[72px] lg:text-[86px] text-black uppercase mb-8">
                        {{ $settings->hero_title ?? 'La movilidad del futuro llegó' }}
                    </h1>
                    <p class="text-[28px] md:text-[40px] leading-snug" style="color: {{ $settings->home_description_color ?? '#1f2937' }}">
                        {{ $settings->home_description ?? 'La experiencia de autoconducción más segura con Autono' }}
                    </p>
                @endif
            </div>
        </div>
    </section>

    <section id="vehiculos" class="autono-section">
        <div class="flex items-end justify-between mb-8">
            <div>
                <p class="text-sm uppercase tracking-[0.2em]" style="color: var(--text-muted-on-secondary);">Inventario</p>
                <h2 class="text-4xl font-semibold" style="color: var(--text-on-secondary);">Modelos disponibles</h2>
            </div>
            <a href="{{ route('public.vehiculos') }}" class="text-sm font-medium" style="color: var(--primary-color);">Ver todos</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
            @forelse($vehicles->take(8) as $vehicle)
                <article class="vehicle-card">
                    <img src="{{ $vehicle->main_image }}" alt="{{ $vehicle->title }}" class="w-full h-52 object-cover">
                    <div class="p-4">
                        <h3 class="text-lg font-semibold mb-1 line-clamp-1" style="color: var(--text-on-secondary);">{{ $vehicle->title }}</h3>
                        <p class="text-sm mb-3" style="color: var(--text-muted-on-secondary);">{{ $vehicle->brand }} {{ $vehicle->model }} · {{ $vehicle->year }}</p>
                        <div class="flex items-center justify-between gap-3">
                            <span class="font-bold text-lg" style="color: var(--text-on-secondary);">${{ number_format($vehicle->price) }}</span>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings->whatsapp ?? '') }}?text=Hola! Estoy interesado en el {{ urlencode($vehicle->title) }}" target="_blank" class="px-4 py-2 rounded-full text-sm text-center" style="background: #25d366; color: #fff;">💬 WhatsApp</a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-full text-center py-10" style="color: var(--text-muted-on-secondary);">Aún no hay vehículos publicados.</div>
            @endforelse
        </div>
    </section>

    <section id="nosotros" class="autono-section" style="background: var(--tertiary-color);">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
            @if (isset($editMode) && $editMode)
                <div class="editable-section">
                    <img src="{{ $settings->nosotros_url ?? 'https://images.unsplash.com/photo-1485291571150-772bcfc10da5?w=1200&h=700&fit=crop' }}" alt="Nosotros" class="w-full h-[360px] rounded-2xl object-cover">
                    <button type="button" class="edit-btn" onclick="editImage('nosotros_url')">✎</button>
                </div>
                <div class="editable-section">
                    <p class="text-sm uppercase tracking-[0.2em] mb-3" style="color: var(--text-muted-on-tertiary);">Nosotros</p>
                    <p class="text-xl leading-relaxed whitespace-pre-line" style="color: {{ $settings->nosotros_description_color ?? $textOnTertiary }}">
                        {{ $settings->nosotros_description ?? 'Combinamos tecnología, datos y asesoría humana para que cada persona encuentre el vehículo ideal con una experiencia simple, clara y segura.' }}
                    </p>
                    <button type="button" class="edit-btn" onclick="editText('nosotros_description','Editar Nosotros')">✎</button>
                </div>
            @else
                <img src="{{ $settings->nosotros_url ?? 'https://images.unsplash.com/photo-1485291571150-772bcfc10da5?w=1200&h=700&fit=crop' }}" alt="Nosotros" class="w-full h-[360px] rounded-2xl object-cover">
                <div>
                    <p class="text-sm uppercase tracking-[0.2em] mb-3" style="color: var(--text-muted-on-tertiary);">Nosotros</p>
                    <p class="text-xl leading-relaxed whitespace-pre-line" style="color: {{ $settings->nosotros_description_color ?? $textOnTertiary }}">
                        {{ $settings->nosotros_description ?? 'Combinamos tecnología, datos y asesoría humana para que cada persona encuentre el vehículo ideal con una experiencia simple, clara y segura.' }}
                    </p>
                </div>
            @endif
        </div>
    </section>

    @if (!isset($settings) || $settings->show_contact_form)
        <section id="contacto" class="autono-section">
            <div class="max-w-4xl mx-auto">
                <h3 class="text-4xl font-semibold text-center mb-4" style="color: var(--text-on-secondary);">Comunicate con nosotros</h3>
                @if (isset($editMode) && $editMode)
                    <div class="editable-section mb-8">
                        <p class="text-center text-lg" style="color: var(--text-muted-on-secondary);">{{ $settings->contact_message ?? 'Déjanos tus datos y te contactaremos con oportunidades y nuevos ingresos de vehículos.' }}</p>
                        <button type="button" class="edit-btn" onclick="editText('contact_message','Editar Mensaje de Contacto')">✎</button>
                    </div>
                @else
                    <p class="text-center text-lg mb-8" style="color: var(--text-muted-on-secondary);">{{ $settings->contact_message ?? 'Déjanos tus datos y te contactaremos con oportunidades y nuevos ingresos de vehículos.' }}</p>
                @endif

                <form action="{{ route('public.contacto') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @csrf
                    <input type="text" name="name" placeholder="Tu nombre" required class="w-full px-4 py-3 rounded-xl focus:outline-none" style="border: 1px solid var(--border-on-secondary); background: var(--secondary-color); color: var(--text-on-secondary);">
                    <input type="email" name="email" placeholder="Tu email" required class="w-full px-4 py-3 rounded-xl focus:outline-none" style="border: 1px solid var(--border-on-secondary); background: var(--secondary-color); color: var(--text-on-secondary);">
                    <input type="tel" name="phone" placeholder="Tu teléfono" required class="w-full px-4 py-3 rounded-xl focus:outline-none" style="border: 1px solid var(--border-on-secondary); background: var(--secondary-color); color: var(--text-on-secondary);">
                    <input type="text" value="{{ $settings->phone ?? '' }}" disabled class="w-full px-4 py-3 rounded-xl" style="border: 1px solid var(--border-on-secondary); background: var(--secondary-color); color: var(--text-muted-on-secondary); opacity: 0.7;">
                    <textarea name="message" rows="4" placeholder="Tu mensaje" required class="md:col-span-2 w-full px-4 py-3 rounded-xl focus:outline-none" style="border: 1px solid var(--border-on-secondary); background: var(--secondary-color); color: var(--text-on-secondary);"></textarea>
                    <input type="hidden" name="vehicle_id" id="vehicle_id">
                    <button type="submit" class="md:col-span-2 py-3 rounded-xl font-semibold" style="background: var(--primary-color); color: var(--text-on-primary);">Enviar</button>
                </form>
            </div>
        </section>
    @endif

    <footer class="py-8 text-center text-sm" style="color: var(--text-muted-on-secondary); border-top: 1px solid var(--border-on-secondary);">
        © {{ date('Y') }} {{ $tenant->name }}. Todos los derechos reservados.
    </footer>

    @if (isset($editMode) && $editMode)
        @include('public.templates.partials.editor-scripts')
    @endif

    <script>
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
            mobileMenu && mobileMenu.addEventListener('click', function(e) {
                if (e.target === mobileMenu) closeMenu();
            });
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') closeMenu();
            });
        });

        function openContactForm(vehicleId, vehicleTitle) {
            var vehicleInput = document.getElementById('vehicle_id');
            if (!vehicleInput) {
                return;
            }
            vehicleInput.value = vehicleId;
            var messageInput = document.querySelector('textarea[name="message"]');
            if (messageInput) {
                messageInput.value = `Consulta por: ${vehicleTitle}`;
            }
            document.getElementById('contacto').scrollIntoView({ behavior: 'smooth' });
        }
    </script>
</body>

</html>
