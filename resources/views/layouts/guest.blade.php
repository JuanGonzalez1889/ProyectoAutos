<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/storage/icono.png">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    {{-- SEO Meta Tags --}}
    @hasSection('seo')
        @yield('seo')
    @else
        <x-seo />
    @endif
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- Google Analytics 4 --}}
    <x-analytics />
</head>
<body class="bg-[hsl(var(--background))] text-[hsl(var(--foreground))] lg:overflow-hidden">
    @yield('content')
</body>
</html>
