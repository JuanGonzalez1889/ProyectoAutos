@extends('public.templates.moderno-base')
@section('content')
<style>
    .vehiculo-card-auto {
        color: var(--auto-text-color, #222);
    }
</style>
<script>
    (function() {
        function getContrastYIQ(hexcolor){
            hexcolor = hexcolor.replace('#', '');
            if(hexcolor.length === 3) hexcolor = hexcolor.split('').map(x=>x+x).join('');
            var r = parseInt(hexcolor.substr(0,2),16);
            var g = parseInt(hexcolor.substr(2,2),16);
            var b = parseInt(hexcolor.substr(4,2),16);
            var yiq = ((r*299)+(g*587)+(b*114))/1000;
            return (yiq >= 180) ? '#222' : '#fff';
        }
        var root = document.documentElement;
        var bg = getComputedStyle(root).getPropertyValue('--secondary-color').trim();
        if(bg.startsWith('rgb')) {
            var rgb = bg.match(/\d+/g);
            var hex = '#' + rgb.map(x=>(+x).toString(16).padStart(2,'0')).join('');
            bg = hex;
        }
        root.style.setProperty('--auto-text-color', getContrastYIQ(bg));
    })();
</script>
<div class="max-w-4xl mx-auto px-4 py-12" style="font-family: {{ $settings->font_family ?? 'inherit' }};">
    <div class="flex flex-col md:flex-row gap-8">
        <div class="md:w-1/2">
            <img src="{{ $vehicle->main_image }}" alt="{{ $vehicle->title }}" class="w-full h-80 object-cover rounded-2xl mb-4">
        </div>
        <div class="md:w-1/2 flex flex-col">
            <h1 class="text-3xl font-extrabold mb-2 vehiculo-card-auto">{{ $vehicle->title }}</h1>
            <div class="flex gap-4 mb-2">
                <span class="text-white text-xs px-3 py-1 rounded" style="background: var(--primary-color);">Año: {{ $vehicle->year }}</span>
                <span class="text-white text-xs px-3 py-1 rounded" style="background: var(--primary-color);">Precio: ${{ number_format($vehicle->price) }}</span>
            </div>
            <p class="mb-4 vehiculo-card-auto">{{ $vehicle->brand }} {{ $vehicle->model }}</p>
            <p class="mb-6 vehiculo-card-auto">{{ $vehicle->description }}</p>
            <ul class="mb-6 text-sm vehiculo-card-auto">
                <li><strong>Kilómetros:</strong> {{ number_format($vehicle->kilometers) }}</li>
                <li><strong>Color:</strong> {{ $vehicle->color ?? '-' }}</li>
                <li><strong>Combustible:</strong> {{ $vehicle->fuel_type ?? '-' }}</li>
                <li><strong>Transmisión:</strong> {{ $vehicle->transmission ?? '-' }}</li>
            </ul>
            <form action="{{ route('public.contacto') }}" method="POST" class="mb-4">
                @csrf
                <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">
                <input type="text" name="name" placeholder="Tu Nombre" required class="w-full px-4 py-2 mb-2 rounded vehiculo-card-auto" style="background: var(--secondary-color);">
                <input type="email" name="email" placeholder="Tu Email" required class="w-full px-4 py-2 mb-2 rounded vehiculo-card-auto" style="background: var(--secondary-color);">
                <input type="tel" name="phone" placeholder="Tu Teléfono" required class="w-full px-4 py-2 mb-2 rounded vehiculo-card-auto" style="background: var(--secondary-color);">
                <textarea name="message" placeholder="Mensaje" rows="3" required class="w-full px-4 py-2 mb-2 rounded vehiculo-card-auto" style="background: var(--secondary-color);"></textarea>
                <button type="submit" class="w-full py-2 rounded font-semibold" style="background: var(--primary-color); color: var(--secondary-color);">Consultar</button>
            </form>
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $vehicle->whatsapp ?? $settings->whatsapp ?? '') }}?text=Hola! Estoy interesado en el {{ $vehicle->title }}" target="_blank" class="w-full py-2 rounded font-semibold text-center block" style="background: var(--tertiary-color); color: var(--primary-color);">Consultar por WhatsApp</a>
        </div>
    </div>
</div>
@endsection
