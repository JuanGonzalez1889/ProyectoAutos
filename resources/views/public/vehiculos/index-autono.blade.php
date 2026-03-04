@extends('public.templates.autono-base')
@section('content')
<div class="max-w-[1280px] mx-auto px-6 py-16">
    <div class="mb-10">
        <p class="text-sm uppercase tracking-[0.2em] mb-1" style="color: var(--text-muted-on-secondary);">Inventario</p>
        <h1 class="text-4xl font-semibold" style="color: var(--text-on-secondary);">Vehículos Disponibles</h1>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        @forelse($vehicles as $vehicle)
            <article class="rounded-2xl overflow-hidden transition hover:-translate-y-1 hover:shadow-xl" style="border: 1px solid var(--border-on-secondary); background: var(--secondary-color);">
                <a href="{{ route('public.vehiculos.show', $vehicle->id) }}">
                    <img src="{{ $vehicle->main_image }}" alt="{{ $vehicle->title }}" class="w-full h-56 object-cover">
                </a>
                <div class="p-5">
                    <h2 class="text-xl font-semibold mb-1 line-clamp-1" style="color: var(--text-on-secondary);">{{ $vehicle->title }}</h2>
                    <p class="text-sm mb-3" style="color: var(--text-muted-on-secondary);">{{ $vehicle->brand }} {{ $vehicle->model }} · {{ $vehicle->year }}</p>
                    <p class="text-sm mb-4 line-clamp-2" style="color: var(--text-muted-on-secondary);">{{ Str::limit($vehicle->description, 100) }}</p>
                    <div class="flex items-center justify-between gap-3">
                        <span class="font-bold text-lg" style="color: var(--text-on-secondary);">${{ number_format($vehicle->price) }}</span>
                        <a href="{{ route('public.vehiculos.show', $vehicle->id) }}" class="px-5 py-2 rounded-full text-sm font-medium transition hover:opacity-85" style="background: var(--primary-color); color: var(--text-on-primary);">Ver más</a>
                    </div>
                </div>
            </article>
        @empty
            <div class="col-span-full text-center py-16" style="color: var(--text-muted-on-secondary);">
                <p class="text-lg">Aún no hay vehículos publicados.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
