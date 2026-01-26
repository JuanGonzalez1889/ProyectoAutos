<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $tenant->name ?? 'Agencia de Autos' }} - Vehículos en Venta</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --primary-color: {{ $settings && $settings->primary_color ? $settings->primary_color : '#00d084' }};
            --secondary-color: {{ $settings && $settings->secondary_color ? $settings->secondary_color : '#0a0f14' }};
            --tertiary-color: {{ $settings && $settings->tertiary_color ? $settings->tertiary_color : '#ffaa00' }};
        }

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
        .editable-section:hover .edit-btn { display: flex; }
        .edit-btn { position: absolute; top: 8px; right: 8px; background: #3b82f6; color: #fff; width: 32px; height: 32px; border-radius: 50%; display: none; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 2px 8px rgba(0,0,0,0.3); z-index: 50; }
        @endif
    </style>
</head>
<body style="background: radial-gradient(circle at 20% 50%, rgba(0, 208, 132, 0.08), transparent 50%), radial-gradient(circle at 80% 80%, rgba(255, 170, 0, 0.06), transparent 50%), var(--secondary-color);" class="text-white">
    <!-- Navbar -->
    <nav class="sticky top-0 z-50" style="background: rgba(255,255,255,0.06); backdrop-filter: blur(12px); border-bottom: 1px solid rgba(255,255,255,0.15);">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                @if($settings && $settings->logo_url)
                    <img src="{{ $settings->logo_url }}" alt="{{ $tenant->name }}" class="h-10 object-contain">
                @else
                    <div class="h-10 w-10 rounded-lg" style="background-color: var(--primary-color);"></div>
                @endif
                @if(isset($editMode) && $editMode)
                    <div class="editable-section inline-block">
                        <h1 class="text-xl font-bold text-white">{{ $tenant->name }}</h1>
                        <div class="edit-btn" onclick="editText('agency_name','Editar Nombre de Agencia')"><i class="fa fa-pencil"></i></div>
                    </div>
                @else
                    <h1 class="text-xl font-bold text-white">{{ $tenant->name }}</h1>
                @endif
            </div>
            <div class="flex items-center gap-8">
                <div class="hidden md:flex gap-8">
                    <a href="#inicio" class="text-white hover:opacity-80 transition font-medium">Inicio</a>
                    <a href="#vehiculos" class="text-white hover:opacity-80 transition font-medium">Vehículos</a>
                    <a href="#nosotros" class="text-white hover:opacity-80 transition font-medium">Nosotros</a>
                    <a href="#contacto" class="text-white hover:opacity-80 transition font-medium">Contacto</a>
                </div>
                <a href="{{ route('login') }}" class="px-4 py-2 rounded-lg font-medium text-white transition hover:opacity-80" style="background-color: var(--primary-color);">
                    Panel Admin
                </a>
            </div>
        </div>
    </nav>

    <!-- Inicio -->
    <div id="inicio"></div>

    <!-- Hero Section -->
    <div class="relative min-h-[600px] flex items-center justify-center overflow-hidden">
        @if($settings && $settings->banner_url)
            <div class="@if(isset($editMode) && $editMode) editable-section @endif">
                <img src="{{ $settings->banner_url }}" alt="Banner" class="absolute inset-0 w-full h-full object-cover">
                @if(isset($editMode) && $editMode)
                    <div class="edit-btn" onclick="editImage('banner_url')"><i class="fa fa-pencil"></i></div>
                @endif
            </div>
        @endif
        <div class="absolute inset-0" style="background: radial-gradient(ellipse at top, rgba(255,255,255,0.08), transparent), linear-gradient(135deg, rgba(0,0,0,0.4), rgba(0,0,0,0.2))"></div>
        
        <div class="relative text-center text-white px-4">
            <div class="glass inline-block px-10 py-8 rounded-3xl">
                <h2 class="text-6xl md:text-8xl font-light tracking-tight mb-6" style="letter-spacing: -0.03em;">{{ $tenant->name }}</h2>
                @if(isset($editMode) && $editMode)
                        <div class="editable-section inline-block max-w-2xl mx-auto">
                            <p class="text-xl md:text-2xl font-extralight tracking-wide opacity-90">{{ $settings->home_description ?? 'Descubre nuestro catálogo premium de vehículos' }}</p>
                        <div class="edit-btn" onclick="editText('home_description','Editar Descripción Principal')"><i class="fa fa-pencil"></i></div>
                    </div>
                @else
                    <p class="text-xl md:text-2xl max-w-2xl mx-auto font-extralight tracking-wide opacity-90">{{ $settings->home_description ?? 'Descubre nuestro catálogo premium de vehículos' }}</p>
                @endif
                <a href="#vehiculos" class="mt-8 inline-block px-10 py-4 rounded-xl font-medium transition hover:opacity-90 hover:scale-105 transform btn-gradient shadow-lg">
                    Ver Catálogo ↓
                </a>
            </div>
        </div>
    </div>

    <!-- Vehículos Section -->
    @if($settings->show_vehicles && $vehicles->count() > 0)
        <div id="vehiculos" class="py-20 px-4">
            <div class="max-w-7xl mx-auto">
                <div class="mb-16 text-center">
                    <h3 class="text-5xl font-light tracking-tight mb-4" style="letter-spacing: -0.02em;">Nuestro Catálogo</h3>
                    <p class="text-gray-300 text-lg">{{ $vehicles->count() }} vehículos disponibles</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    @foreach($vehicles as $vehicle)
                        <div class="group rounded-2xl overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 glass">
                            <div class="relative h-40 bg-gray-700 overflow-hidden">
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
                            </div>

                            <div class="p-4">
                                <h4 class="text-lg font-bold mb-2 line-clamp-1">{{ $vehicle->title }}</h4>
                                
                                <div class="text-xs text-gray-300 mb-3">
                                    <p>{{ $vehicle->brand }} {{ $vehicle->model }}</p>
                                </div>

                                <p class="text-gray-400 text-xs mb-3 line-clamp-2">{{ Str::limit($vehicle->description, 60) }}</p>

                                <button type="button" 
                                    onclick="openContactForm('{{ $vehicle->id }}', '{{ $vehicle->title }}')"
                                    class="w-full py-2 rounded text-xs font-bold text-white transition hover:shadow-lg" 
                                    style="background: linear-gradient(135deg, var(--primary-color), var(--tertiary-color));">
                                    Consultar
                                </button>
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
                    <h3 class="text-5xl font-light tracking-tight mb-6" style="letter-spacing: -0.02em;">Sobre Nosotros</h3>
                    @if(isset($editMode) && $editMode)
                        <div class="editable-section">
                            <p class="text-gray-300 text-lg mb-8 leading-loose whitespace-pre-line font-light">{{ $settings->nosotros_description ?? 'Somos una agencia de autos con más de 15 años de experiencia en el mercado automotriz.\n\nNuestro equipo de profesionales está comprometido en brindarte la mejor atención y asesoramiento.' }}</p>
                            <div class="edit-btn" onclick="editText('nosotros_description','Editar Sección Nosotros')"><i class="fa fa-pencil"></i></div>
                        </div>
                    @else
                        <p class="text-gray-300 text-lg mb-8 leading-loose whitespace-pre-line font-light">{{ $settings->nosotros_description ?? 'Somos una agencia de autos con más de 15 años de experiencia en el mercado automotriz.\n\nNuestro equipo de profesionales está comprometido en brindarte la mejor atención y asesoramiento.' }}</p>
                    @endif
                    <div class="flex gap-6">
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
                        @if(isset($editMode) && $editMode)
                            <div class="relative">
                                <div class="edit-btn" onclick="editStats()"><i class="fa fa-pencil"></i></div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="h-96 rounded-3xl overflow-hidden shadow-2xl glass @if(isset($editMode) && $editMode) editable-section @endif">
                    <img src="{{ $settings->nosotros_url ?? 'https://images.unsplash.com/photo-1487730116645-74489c95b41b?w=600&h=500&fit=crop' }}" alt="Nosotros" class="w-full h-full object-cover">
                    @if(isset($editMode) && $editMode)
                        <div class="edit-btn" onclick="editImage('nosotros_url')"><i class="fa fa-pencil"></i></div>
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
                        <h3 class="text-5xl font-light tracking-tight text-white mb-6" style="letter-spacing: -0.02em;">Contacta con Nosotros</h3>
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

                    <form action="{{ route('public.contact') }}" method="POST" class="space-y-5 glass p-8 rounded-3xl">
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
