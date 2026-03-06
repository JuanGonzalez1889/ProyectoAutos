@extends('layouts.landing')

@section('title', 'Demo Instructivos')

@section('content')
<x-navbar ctaLabel="Comenzar hoy" ctaLink="{{ route('register') }}" />
<div class="max-w-6xl mx-auto pt-16 pb-16">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-[hsl(var(--foreground))]" style="
    margin-top: 4rem;
    text-align: center;
">Instructivos </h1>
        <p class="text-[hsl(var(--muted-foreground))] mt-1" style="
    text-align: center;
    margin-bottom: 6rem;
">Guías en videos para conocer AutoWebPRO</p>
    </div>

    <!-- Grid de Videos -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Video 1 -->
        <div class="card overflow-hidden">
            <div class="relative aspect-video bg-gray-900 rounded-t-lg overflow-hidden">
                <iframe width="560" height="315" src="https://www.youtube.com/embed/bDGn1PyXpb4?si=dGNkIA2oJqjFJgOo" title="YouTube video player" class="w-full h-full" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>
            <div class="p-4">
                <h3 class="font-semibold text-[hsl(var(--foreground))] mb-1">Primeros pasos en AutoWebPRO</h3>
                <p class="text-sm text-[hsl(var(--muted-foreground))]">Cómo configurar tu agencia, elegir plantilla y publicar tu web.</p>
                <div class="mt-3 flex items-center gap-2">
                    <span class="px-2 py-0.5 text-[10px] font-medium rounded-full bg-orange-500/20 text-orange-400">Inicio</span>
                </div>
            </div>
        </div>
        <!-- Video 2 -->
        <div class="card overflow-hidden">
            <div class="relative aspect-video bg-gray-900 rounded-t-lg overflow-hidden">
                <iframe width="560" height="315" src="https://www.youtube.com/embed/Ywd00Sj10ak?si=yPEDrBijGwm-OTzk" title="YouTube video player" class="w-full h-full" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>
            <div class="p-4">
                <h3 class="font-semibold text-[hsl(var(--foreground))] mb-1">Cómo cargar vehículos</h3>
                <p class="text-sm text-[hsl(var(--muted-foreground))]">Aprende a subir fotos, completar datos y publicar tus vehículos.</p>
                <div class="mt-3 flex items-center gap-2">
                    <span class="px-2 py-0.5 text-[10px] font-medium rounded-full bg-blue-500/20 text-blue-400">Inventario</span>
                </div>
            </div>
        </div>
        <!-- Video 3 -->
        <div class="card overflow-hidden">
            <div class="relative aspect-video bg-gray-900 rounded-t-lg overflow-hidden">
                <iframe width="560" height="315" src="https://www.youtube.com/embed/29r87Dx5ZoY?si=fBKfz6bde1ZnB4Pa" title="YouTube video player" class="w-full h-full" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>
            <div class="p-4">
                <h3 class="font-semibold text-[hsl(var(--foreground))] mb-1">Personalizar tu web</h3>
                <p class="text-sm text-[hsl(var(--muted-foreground))]">Cómo cambiar colores, logo, textos y elegir la plantilla ideal para tu agencia.</p>
                <div class="mt-3 flex items-center gap-2">
                    <span class="px-2 py-0.5 text-[10px] font-medium rounded-full bg-purple-500/20 text-purple-400">Personalización</span>
                </div>
            </div>
        </div>
        <!-- Video 4 -->
        <div class="card overflow-hidden">
            <div class="relative aspect-video bg-gray-900 rounded-t-lg overflow-hidden">
                <iframe width="560" height="315" src="https://www.youtube.com/embed/4ykc7LDXDCA?si=L4Ex0o7WD4ocwX18" title="YouTube video player" class="w-full h-full" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>
            <div class="p-4">
                <h3 class="font-semibold text-[hsl(var(--foreground))] mb-1">Gestión de leads y clientes</h3>
                <p class="text-sm text-[hsl(var(--muted-foreground))]">Cómo administrar consultas, seguimientos y convertir leads en ventas.</p>
                <div class="mt-3 flex items-center gap-2">
                    <span class="px-2 py-0.5 text-[10px] font-medium rounded-full bg-green-500/20 text-green-400">Ventas</span>
                </div>
            </div>
        </div>
        <!-- Video 5 -->
        <div class="card overflow-hidden">
            <div class="relative aspect-video bg-gray-900 rounded-t-lg overflow-hidden">
                <iframe width="560" height="315" src="https://www.youtube.com/embed/3GfQJNHGB5A?si=WK7ZcBak_eZMdVcj" title="YouTube video player" class="w-full h-full" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>
            <div class="p-4">
                <h3 class="font-semibold text-[hsl(var(--foreground))] mb-1">Dominio y publicación</h3>
                <p class="text-sm text-[hsl(var(--muted-foreground))]">Cómo conectar tu dominio propio y dejar tu web lista para el mundo.</p>
                <div class="mt-3 flex items-center gap-2">
                    <span class="px-2 py-0.5 text-[10px] font-medium rounded-full bg-orange-500/20 text-orange-400">Dominio</span>
                </div>
            </div>
        </div>
        <!-- Video 6 -->
        <div class="card overflow-hidden">
            <div class="relative aspect-video bg-gray-900 rounded-t-lg overflow-hidden">
                <iframe width="560" height="315" src="https://www.youtube.com/embed/L5nPm_FATSQ?si=e-2EAPMoRSjuxEpP" title="YouTube video player" class="w-full h-full" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>
            <div class="p-4">
                <h3 class="font-semibold text-[hsl(var(--foreground))] mb-1">Planes y facturación</h3>
                <p class="text-sm text-[hsl(var(--muted-foreground))]">Cómo elegir tu plan, pagar con MercadoPago y gestionar facturas.</p>
                <div class="mt-3 flex items-center gap-2">
                    <span class="px-2 py-0.5 text-[10px] font-medium rounded-full bg-yellow-500/20 text-yellow-400">Facturación</span>
                </div>
            </div>
        </div>

        <div class="card overflow-hidden">
            <div class="flex flex-col items-center justify-center min-h-[220px]">
                <svg class="w-16 h-16 mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-sm">Video próximamente</span>
            </div>
            <div class="p-4">
                <h3 class="font-semibold text-[hsl(var(--foreground))] mb-1">Crear nuevas tareas</h3>
                <p class="text-sm text-[hsl(var(--muted-foreground))]">Aprende a crear y gestionar nuevas tareas en tu cuenta.</p>
                <div class="mt-3 flex items-center gap-2">
                    <span class="px-2 py-0.5 text-[10px] font-medium rounded-full bg-yellow-500/20 text-yellow-400">Tareas</span>
                </div>
            </div>
        </div>

        <div class="card overflow-hidden">
            <div class="flex flex-col items-center justify-center min-h-[220px]">
                <svg class="w-16 h-16 mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-sm">Video próximamente</span>
            </div>
            <div class="p-4">
                <h3 class="font-semibold text-[hsl(var(--foreground))] mb-1">Crear nuevos Leads</h3>
                <p class="text-sm text-[hsl(var(--muted-foreground))]">Aprende a crear y gestionar nuevos leads en tu cuenta.</p>
                <div class="mt-3 flex items-center gap-2">
                    <span class="px-2 py-0.5 text-[10px] font-medium rounded-full bg-yellow-500/20 text-yellow-400">Leads</span>
                </div>
            </div>
        </div>
    </div>
    <!-- Nota -->
    <div class="mt-8 p-4 bg-[hsl(var(--secondary))]/50 border border-[hsl(var(--border))] rounded-lg">
        <p class="text-sm text-[hsl(var(--muted-foreground))]">
            <strong class="text-[hsl(var(--foreground))]">¿Tenés dudas?</strong> 
            Escribinos por WhatsApp al 
            <a href="https://wa.me/5493413365206" target="_blank" class="text-[hsl(var(--primary))] hover:underline">+54 9 341 336-5206</a> 
            y te ayudamos.
        </p>
    </div>
</div>
@endsection
