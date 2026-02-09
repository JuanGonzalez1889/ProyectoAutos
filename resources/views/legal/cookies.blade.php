@extends('layouts.public')
@section('title', 'Política de Cookies')
@section('content')
<div class="min-h-screen flex items-center justify-center bg-[hsl(var(--background))]">
    <div class="max-w-3xl w-full bg-[hsl(var(--card))] rounded-xl shadow-lg p-8 border border-[hsl(var(--border))]">
        <h1 class="text-2xl font-bold mb-6 text-[hsl(var(--primary))]">Política de Cookies</h1>
        <p class="mb-4 text-[hsl(var(--foreground))]">AutoWeb Pro utiliza cookies para mejorar la experiencia del usuario y analizar el uso de la plataforma.</p>
        <h2 class="text-lg font-semibold mt-8 mb-2 text-[hsl(var(--primary))]">1. ¿Qué son las cookies?</h2>
        <p class="mb-4 text-[hsl(var(--foreground))]">Las cookies son pequeños archivos que se almacenan en tu dispositivo para recordar tus preferencias y actividad.</p>
        <h2 class="text-lg font-semibold mt-8 mb-2 text-[hsl(var(--primary))]">2. Uso de Cookies</h2>
        <ul class="list-disc ml-6 mb-4 text-[hsl(var(--foreground))]">
            <li>Recordar preferencias de usuario.</li>
            <li>Analizar el tráfico y uso de la plataforma.</li>
            <li>Mejorar la seguridad y funcionalidad.</li>
        </ul>
        <h2 class="text-lg font-semibold mt-8 mb-2 text-[hsl(var(--primary))]">3. Gestión de Cookies</h2>
        <p class="mb-4 text-[hsl(var(--foreground))]">Puedes configurar tu navegador para rechazar o eliminar cookies, pero esto puede afectar la funcionalidad de la plataforma.</p>
        <h2 class="text-lg font-semibold mt-8 mb-2 text-[hsl(var(--primary))]">4. Contacto</h2>
        <p class="text-[hsl(var(--foreground))]">Si tienes preguntas sobre nuestra política de cookies, contáctanos a soporte@autowebpro.com.</p>
    </div>
</div>
@endsection
