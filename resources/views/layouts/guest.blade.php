<!DOCTYPE html>
<html lang="es" style="font-size: 140%;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
<body class="bg-gray-50" style="zoom: 1.05;">
    <div class="min-h-screen">
        @yield('content')
    </div>
</body>
</html>
