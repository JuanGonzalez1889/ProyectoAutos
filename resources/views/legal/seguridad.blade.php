@extends('layouts.public')
@section('title', 'Seguridad')
@section('content')
<div class="min-h-screen flex items-center justify-center bg-[hsl(var(--background))]">
    <div class="max-w-3xl w-full bg-[hsl(var(--card))] rounded-xl shadow-lg p-8 border border-[hsl(var(--border))]">
        <h1 class="text-2xl font-bold mb-6 text-[hsl(var(--primary))]">Seguridad</h1>
        <p class="mb-4 text-[hsl(var(--foreground))]">En AutoWeb Pro, la seguridad de tus datos es nuestra prioridad. Implementamos medidas para proteger la información de nuestros usuarios.</p>
        <h2 class="text-lg font-semibold mt-8 mb-2 text-[hsl(var(--primary))]">1. Medidas de Seguridad</h2>
        <ul class="list-disc ml-6 mb-4 text-[hsl(var(--foreground))]">
            <li>Cifrado de datos sensibles.</li>
            <li>Control de acceso y autenticación.</li>
            <li>Monitoreo constante de la plataforma.</li>
        </ul>
        <h2 class="text-lg font-semibold mt-8 mb-2 text-[hsl(var(--primary))]">2. Recomendaciones para Usuarios</h2>
        <ul class="list-disc ml-6 mb-4 text-[hsl(var(--foreground))]">
            <li>Usa contraseñas seguras y cámbialas periódicamente.</li>
            <li>No compartas tus credenciales.</li>
            <li>Reporta cualquier actividad sospechosa a soporte@autowebpro.com.</li>
        </ul>
        <h2 class="text-lg font-semibold mt-8 mb-2 text-[hsl(var(--primary))]">3. Contacto</h2>
        <p class="text-[hsl(var(--foreground))]">Si tienes dudas sobre seguridad, comunícate con nuestro equipo de soporte.</p>
    </div>
</div>
@endsection
