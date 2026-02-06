@extends('public.templates.minimalista-base')
@section('content')
<style>
    .vehiculo-card-text {
        color: #222;
    }
    @media (prefers-color-scheme: dark) {
        .vehiculo-card-text {
            color: #fff;
        }
    }
    .vehiculo-card-auto {
        color: var(--auto-text-color, #222);
    }
    .vehiculo-card-bg {
        background: var(--secondary-color);
        border-color: var(--primary-color);
    }
</style>
<script>
    // Lógica para calcular color de texto según fondo secundario
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
<div class="max-w-6xl mx-auto px-4 py-12" style="font-family: {{ $settings->font_family ?? 'inherit' }};">
    <h1 class="text-4xl font-bold mb-8" style="color: var(--primary-color)">Vehículos Disponibles</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($vehicles as $vehicle)
            <div class="rounded-xl shadow-lg overflow-hidden border flex flex-col vehiculo-card-bg">
                <div class="relative">
                    <img src="{{ $vehicle->main_image }}" alt="{{ $vehicle->title }}" class="w-full h-56 object-cover">
                    <span class="absolute top-2 left-2 text-white text-xs px-3 py-1 rounded" style="background: var(--primary-color);">{{ $vehicle->year }}</span>
                    <span class="absolute top-2 right-2 text-white text-xs px-3 py-1 rounded" style="background: var(--primary-color);">${{ number_format($vehicle->price) }}</span>
                </div>
                <div class="p-5 flex-1 flex flex-col">
                    <h2 class="text-2xl font-bold mb-1 vehiculo-card-auto">{{ $vehicle->title }}</h2>
                    <p class="mb-2 vehiculo-card-auto">{{ $vehicle->brand }} {{ $vehicle->model }}</p>
                    <p class="text-sm mb-4 flex-1 vehiculo-card-auto">{{ Str::limit($vehicle->description, 80) }}</p>
                    <a href="{{ route('public.vehiculos.show', $vehicle->id) }}" class="mt-auto inline-block px-4 py-2 rounded font-semibold text-center transition" style="background: var(--primary-color); color: var(--secondary-color);">Ver más</a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
