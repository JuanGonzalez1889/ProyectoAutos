<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $tenant->name ?? 'Agencia de Autos' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --primary-color: {{ $settings && $settings->primary_color ? $settings->primary_color : '#00d084' }};
            --secondary-color: {{ $settings && $settings->secondary_color ? $settings->secondary_color : '#0a0f14' }};
            --tertiary-color: {{ $settings && $settings->tertiary_color ? $settings->tertiary_color : '#ffaa00' }};
        }
    </style>
</head>
<body style="background-color: var(--secondary-color);" class="text-white">
    @php($template = 'minimalista')
    <!-- Navbar Minimalista -->
    <nav class="bg-gray-800 border-b border-gray-700 sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-3">
                @if($settings && $settings->logo_url)
                    <img src="{{ $settings->logo_url }}" alt="{{ $tenant->name }}" class="h-8 object-contain">
                @endif
                <span class="font-semibold text-white">{{ $tenant->name }}</span>
            </div>
            <div class="flex items-center gap-6">
                <div class="hidden md:flex gap-6">
                    <a href="#inicio" class="text-sm text-gray-300 hover:text-white transition">Inicio</a>
                    <a href="#vehiculos" class="text-sm text-gray-300 hover:text-white transition">Vehículos</a>
                    <a href="#nosotros" class="text-sm text-gray-300 hover:text-white transition">Nosotros</a>
                    <a href="#contacto" class="text-sm text-gray-300 hover:text-white transition">Contacto</a>
                </div>
                <a href="{{ route('login') }}" class="text-sm font-medium text-white py-2 px-4 rounded" style="background-color: var(--primary-color);">
                    Admin
                </a>
            </div>
        </div>
    </nav>

    <!-- Inicio -->
    <div id="inicio"></div>

    <!-- Hero Simple -->
    <div class="max-w-6xl mx-auto px-6 py-16 border-b border-gray-700">
        <div class="flex items-center gap-3">
            <h1 class="text-5xl font-bold mb-4">{{ $tenant->name }}</h1>
        </div>
        <div class="relative">
            <p class="text-xl text-gray-300 max-w-2xl whitespace-pre-line">
                {{ $settings->home_description ?? 'Descubre nuestros vehículos' }}
            </p>
            @if(isset($editMode) && $editMode)
                <button onclick="editText('home_description','Texto de Inicio')" class="absolute -top-3 -right-3 bg-blue-600 text-white text-xs px-2 py-1 rounded shadow">Editar</button>
            @endif
        </div>
    </div>

    <!-- Vehículos Lista Vertical -->
    @if($settings->show_vehicles && $vehicles->count() > 0)
        <div class="max-w-6xl mx-auto px-6 py-12 border-b border-gray-700">
            <h2 class="text-3xl font-bold mb-8">Vehículos Disponibles</h2>
            <div class="space-y-3">
                @foreach($vehicles as $vehicle)
                    <div class="bg-gray-800 p-4 rounded-lg border border-gray-700 hover:border-gray-600 hover:shadow-lg hover:-translate-y-1 transition transform" style="border-color: rgba(255,255,255,0.1);">
                        <div class="flex gap-4">
                            <div class="w-32 h-32 bg-gray-700 rounded flex-shrink-0">
                                <img src="{{ $vehicle->main_image }}" alt="{{ $vehicle->title }}" class="w-full h-full object-cover rounded">
                            </div>
                            <div class="flex-1">
                                <h3 class="text-xl font-bold mb-1">{{ $vehicle->title }}</h3>
                                <p class="text-gray-400 text-sm mb-2">{{ $vehicle->brand }} {{ $vehicle->model }} - {{ $vehicle->year }}</p>
                                <div class="flex gap-4 mb-3 text-sm">
                                    <div><span class="text-gray-400">Km:</span> <span class="font-semibold text-white">{{ number_format($vehicle->kilometers) }}</span></div>
                                    <div><span class="text-gray-400">Precio:</span> <span class="font-semibold text-lg" style="color: var(--primary-color);">${{ number_format($vehicle->price) }}</span></div>
                                </div>
                                <p class="text-gray-300 text-sm mb-3 line-clamp-2">{{ Str::limit($vehicle->description, 150) }}</p>
                                <button onclick="openForm('{{ $vehicle->id }}', '{{ $vehicle->title }}')" class="px-4 py-2 rounded text-white text-sm font-medium transition hover:opacity-90" style="background: linear-gradient(135deg, var(--primary-color), var(--tertiary-color));">
                                    Consultar
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Nosotros Section -->
    <div id="nosotros" class="max-w-6xl mx-auto px-6 py-12 border-b border-gray-700">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-3xl font-bold">Sobre Nosotros</h2>
            @if(isset($editMode) && $editMode)
                <button onclick="editText('nosotros_description','Texto de Nosotros')" class="bg-blue-600 text-white text-xs px-3 py-1 rounded">Editar texto</button>
            @endif
        </div>
        <div class="grid md:grid-cols-2 gap-8 items-start">
            <div class="space-y-4 text-gray-300">
                <p class="text-lg leading-relaxed whitespace-pre-line">{{ $settings->nosotros_description ?? 'Cuéntale a tus usuarios sobre tu agencia, experiencia y servicios.' }}</p>
                <div class="grid grid-cols-3 gap-4 mt-6 pt-6 border-t border-gray-700">
                    <div class="text-center">
                        <div class="text-3xl font-bold" style="color: var(--primary-color);">{{ $settings->stat1 ?? '150+' }}</div>
                        <p class="text-gray-400 text-sm">{{ $settings->stat1_label ?? 'Autos Vendidos' }}</p>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold" style="color: var(--primary-color);">{{ $settings->stat2 ?? '98%' }}</div>
                        <p class="text-gray-400 text-sm">{{ $settings->stat2_label ?? 'Clientes Satisfechos' }}</p>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold" style="color: var(--primary-color);">{{ $settings->stat3 ?? '24h' }}</div>
                        <p class="text-gray-400 text-sm">{{ $settings->stat3_label ?? 'Atención al Cliente' }}</p>
                    </div>
                </div>
                @if(isset($editMode) && $editMode)
                    <button onclick="editStats()" class="mt-2 bg-blue-600 text-white text-xs px-3 py-1 rounded">Editar estadísticas</button>
                @endif
            </div>
            <div class="relative rounded overflow-hidden border border-gray-700">
                <img src="{{ $settings->nosotros_url ?? 'https://images.unsplash.com/photo-1487730116645-74489c95b41b?w=900&h=600&fit=crop' }}" alt="Nosotros" class="w-full h-full object-cover">
                @if(isset($editMode) && $editMode)
                    <button onclick="editImage('nosotros_url')" class="absolute top-2 right-2 bg-blue-600 text-white text-xs px-3 py-1 rounded shadow">Cambiar imagen</button>
                @endif
            </div>
        </div>
    </div>

    <!-- Contacto Simple -->
    @if($settings->show_contact_form)
        <div id="contacto" class="bg-gray-800 py-16 px-6 border-t border-gray-700">
            <div class="max-w-6xl mx-auto">
                <h2 class="text-3xl font-bold mb-12">Contacto</h2>
                
                <div class="grid md:grid-cols-2 gap-12">
                    <div>
                        <p class="text-gray-300 mb-6">{{ $settings->contact_message }}</p>
                        @if($settings->phone)
                            <p class="mb-2"><strong class="text-white">Teléfono:</strong> <a href="tel:{{ $settings->phone }}" class="text-gray-300 hover:text-white transition">{{ $settings->phone }}</a></p>
                        @endif
                        @if($settings->email)
                            <p class="mb-2"><strong class="text-white">Email:</strong> <a href="mailto:{{ $settings->email }}" class="text-gray-300 hover:text-white transition">{{ $settings->email }}</a></p>
                        @endif
                        @if($settings->whatsapp)
                            <p class="mb-4"><strong class="text-white">WhatsApp:</strong> <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings->whatsapp) }}" target="_blank" class="text-gray-300 hover:text-white transition">{{ $settings->whatsapp }}</a></p>
                        @endif
                    </div>

                    <form action="{{ route('public.contact') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="text" name="name" placeholder="Nombre" required class="w-full px-4 py-2 border border-gray-600 rounded bg-gray-700 text-white placeholder-gray-400">
                        <input type="email" name="email" placeholder="Email" required class="w-full px-4 py-2 border border-gray-600 rounded bg-gray-700 text-white placeholder-gray-400">
                        <input type="tel" name="phone" placeholder="Teléfono" required class="w-full px-4 py-2 border border-gray-600 rounded bg-gray-700 text-white placeholder-gray-400">
                        <textarea name="message" placeholder="Mensaje" rows="4" required class="w-full px-4 py-2 border border-gray-600 rounded bg-gray-700 text-white placeholder-gray-400"></textarea>
                        <input type="hidden" name="vehicle_id" id="vehicle_id">
                        <button type="submit" class="w-full py-2 rounded text-white font-medium transition hover:opacity-90" style="background: linear-gradient(135deg, var(--primary-color), var(--tertiary-color));">
                            Enviar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Footer -->
    <footer class="bg-gray-900 py-8 text-center text-gray-400 text-sm border-t border-gray-700">
        © {{ date('Y') }} {{ $tenant->name }}
    </footer>

    <script>
        function openForm(vehicleId, title) {
            document.getElementById('vehicle_id').value = vehicleId;
            document.querySelector('textarea[name="message"]').value = `Consulta: ${title}`;
            document.querySelector('form').scrollIntoView({ behavior: 'smooth' });
        }
    </script>
    @if(isset($editMode) && $editMode)
        @include('public.templates.partials.editor-scripts')
    @endif
</body>
</html>
