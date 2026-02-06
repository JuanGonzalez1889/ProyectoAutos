<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $tenant->name ?? 'Agencia de Autos' }} - Vehículos en Venta</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --primary-color: {{ $settings && $settings->primary_color ? $settings->primary_color : '#00d084' }};
            --secondary-color: {{ $settings && $settings->secondary_color ? $settings->secondary_color : '#0a0f14' }};
        }
        
        .primary-bg {
            background-color: var(--primary-color);
        }
        
        .secondary-bg {
            background-color: var(--secondary-color);
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-white shadow sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                @if($settings && $settings->logo_url)
                    <img src="{{ $settings->logo_url }}" alt="{{ $tenant->name }}" class="h-10 object-contain">
                @else
                    <div class="h-10 w-10 rounded-lg" style="background-color: #{{ $settings->primary_color ?? '00d084' }}"></div>
                @endif
                <h1 class="text-xl font-bold text-gray-900">{{ $tenant->name }}</h1>
            </div>
            <div class="flex gap-6 items-center">
                <a href="#inicio" class="transition" style="color: {{ $settings->navbar_links_color ?? 'var(--navbar-text-color, #222)' }}">Inicio</a>
                <a href="{{ route('public.vehiculos') }}" class="transition" style="color: {{ $settings->navbar_links_color ?? 'var(--navbar-text-color, #222)' }}">Vehículos</a>
                <a href="#nosotros" class="transition" style="color: {{ $settings->navbar_links_color ?? 'var(--navbar-text-color, #222)' }}">Nosotros</a>
                <a href="#contacto" class="transition" style="color: {{ $settings->navbar_links_color ?? 'var(--navbar-text-color, #222)' }}">Contacto</a>
                <a href="{{ route('login') }}" class="px-4 py-2 rounded-lg font-medium transition" style="background-color: {{ $settings && $settings->primary_color ? $settings->primary_color : '#00d084' }}; color: white;">
                    Panel Admin
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative h-96 bg-gray-900 text-white overflow-hidden">
        @if($settings && $settings->banner_url)
            <img src="{{ $settings->banner_url }}" alt="Banner" class="absolute inset-0 w-full h-full object-cover opacity-50">
        @endif
        
        <div class="absolute inset-0" style="background: linear-gradient(135deg, {{ $settings && $settings->primary_color ? $settings->primary_color : '#00d084' }}dd, {{ $settings && $settings->secondary_color ? $settings->secondary_color : '#0a0f14' }}dd)"></div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex flex-col justify-center">
            <h2 class="text-5xl font-bold mb-4 auto-contrast-title">{{ $tenant->name }}</h2>
            <p class="text-xl text-gray-100 max-w-2xl">
                {{ $settings->home_description ?? 'Descubre nuestro catálogo de vehículos de calidad con las mejores opciones del mercado.' }}
            </p>
        </div>
    </div>

    <!-- Vehículos Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        @if($settings->show_vehicles && $vehicles->count() > 0)
            <div class="mb-12">
                <h3 class="text-3xl font-bold mb-2 auto-contrast-title">Nuestros Vehículos</h3>
                <p class="text-gray-600">Tenemos {{ $vehicles->count() }} vehículos disponibles</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($vehicles as $vehicle)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition transform hover:scale-105">
                        <!-- Imagen -->
                        <div class="relative h-56 bg-gray-200 overflow-hidden">
                            <img src="{{ $vehicle->main_image }}" alt="{{ $vehicle->title }}" class="w-full h-full object-cover">
                            <div class="absolute top-4 left-4">
                                <span class="px-3 py-1 bg-white text-gray-900 rounded-full text-sm font-semibold">
                                    {{ $vehicle->year }}
                                </span>
                            </div>
                            <div class="absolute top-4 right-4">
                                <span class="px-3 py-1 text-white rounded-full text-sm font-semibold" style="background-color: {{ $settings && $settings->primary_color ? $settings->primary_color : '#00d084' }};">
                                    ${{ number_format($vehicle->price) }}
                                </span>
                            </div>
                        </div>

                        <!-- Contenido -->
                        <div class="p-4">
                            <h4 class="text-lg font-bold text-gray-900 mb-2">{{ $vehicle->title }}</h4>
                            
                            <div class="grid grid-cols-3 gap-2 mb-4 text-sm text-gray-600">
                                <div>
                                    <p class="font-semibold">Marca</p>
                                    <p>{{ $vehicle->brand }}</p>
                                </div>
                                <div>
                                    <p class="font-semibold">Modelo</p>
                                    <p>{{ $vehicle->model }}</p>
                                </div>
                                <div>
                                    <p class="font-semibold">Km</p>
                                    <p>{{ number_format($vehicle->kilometers) }}</p>
                                </div>
                            </div>

                            <p class="text-sm text-gray-600 mb-4">{{ Str::limit($vehicle->description, 100) }}</p>

                            <button type="button" 
                                    onclick="openContactForm('{{ $vehicle->id }}', '{{ $vehicle->title }}')"
                                    class="w-full py-2 rounded-lg font-semibold text-white transition" 
                                    style="background-color: {{ $settings && $settings->primary_color ? $settings->primary_color : '#00d084' }};">
                                Consultar por este vehículo
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @elseif(!$settings->show_vehicles)
            <div class="text-center py-12">
                <p class="text-gray-600 text-lg">El catálogo de vehículos no está disponible en este momento.</p>
            </div>
        @else
            <div class="text-center py-12">
                <p class="text-gray-600 text-lg">No hay vehículos disponibles en este momento.</p>
            </div>
        @endif
    </div>

    <!-- Contacto Section -->
    @if($settings->show_contact_form)
        <div class="py-16" style="background-color: {{ $settings && $settings->secondary_color ? $settings->secondary_color : '#0a0f14' }}; opacity: 0.95;">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Información -->
                    <div>
                        <h3 class="text-3xl font-bold mb-6 auto-contrast-title">Contacta con Nosotros</h3>
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
                        <p class="text-gray-200 mb-6">{{ $settings->contact_message ?? 'Estamos disponibles para responder todas tus preguntas.' }}</p>

                        <div class="space-y-4">
                            @if($settings->phone)
                                <div class="flex items-start gap-4">
                                    <span class="text-2xl">📞</span>
                                    <div>
                                        <p class="font-semibold text-white">Teléfono</p>
                                        <p class="text-gray-200">{{ $settings->phone }}</p>
                                    </div>
                                </div>
                            @endif

                            @if($settings->email)
                                <div class="flex items-start gap-4">
                                    <span class="text-2xl">✉️</span>
                                    <div>
                                        <p class="font-semibold text-white">Email</p>
                                        <p class="text-gray-200">{{ $settings->email }}</p>
                                    </div>
                                </div>
                            @endif

                            @if($settings->whatsapp)
                                <div class="flex items-start gap-4">
                                    <span class="text-2xl">💬</span>
                                    <div>
                                        <p class="font-semibold text-white">WhatsApp</p>
                                        <p class="text-gray-200">{{ $settings->whatsapp }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Redes Sociales -->
                        <div class="mt-8 flex gap-4">
                            @if($settings->facebook_url)
                                <a href="{{ $settings->facebook_url }}" target="_blank" class="text-2xl hover:scale-110 transition">📘</a>
                            @endif
                            @if($settings->instagram_url)
                                <a href="{{ $settings->instagram_url }}" target="_blank" class="text-2xl hover:scale-110 transition">📷</a>
                            @endif
                            @if($settings->linkedin_url)
                                <a href="{{ $settings->linkedin_url }}" target="_blank" class="text-2xl hover:scale-110 transition">💼</a>
                            @endif
                        </div>
                    </div>

                    <!-- Formulario -->
                    <form action="{{ \App\Helpers\RouteHelper::publicContactRoute() }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-semibold text-white mb-2">Nombre</label>
                            <input type="text" name="name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white text-gray-900 focus:outline-none focus:ring-2" style="--tw-ring-color: {{ $settings && $settings->primary_color ? $settings->primary_color : '#00d084' }};">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-white mb-2">Email</label>
                            <input type="email" name="email" required class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white text-gray-900 focus:outline-none focus:ring-2" style="--tw-ring-color: {{ $settings && $settings->primary_color ? $settings->primary_color : '#00d084' }};">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-white mb-2">Teléfono</label>
                            <input type="tel" name="phone" required class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white text-gray-900 focus:outline-none focus:ring-2" style="--tw-ring-color: {{ $settings && $settings->primary_color ? $settings->primary_color : '#00d084' }};">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-white mb-2">Mensaje</label>
                            <textarea name="message" rows="4" required class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white text-gray-900 focus:outline-none focus:ring-2" style="--tw-ring-color: {{ $settings && $settings->primary_color ? $settings->primary_color : '#00d084' }};"></textarea>
                        </div>

                        <input type="hidden" name="vehicle_id" id="vehicle_id">

                        <button type="submit" 
                                class="w-full py-3 rounded-lg font-semibold text-white transition hover:opacity-90" 
                                style="background-color: {{ $settings && $settings->primary_color ? $settings->primary_color : '#00d084' }};">
                            Enviar Mensaje
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-gray-400">© {{ date('Y') }} {{ $tenant->name }}. Todos los derechos reservados.</p>
            <p class="text-gray-500 text-sm mt-2">Powered by Proyecto Autos</p>
        </div>
    </footer>

    <script>
        function openContactForm(vehicleId, vehicleTitle) {
            document.getElementById('vehicle_id').value = vehicleId;
            document.querySelector('form textarea[name="message"]').focus();
            document.querySelector('form textarea[name="message"]').value = `Consulta por vehículo: ${vehicleTitle}`;
            window.scrollTo({ top: document.querySelector('form').offsetTop - 100, behavior: 'smooth' });
        }
    </script>
</body>
</html>
