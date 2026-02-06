{{-- SEO Meta Tags --}}
<title>{{ $title }}</title>
<meta name="description" content="{{ $description }}">
@if($keywords)
    <meta name="keywords" content="{{ $keywords }}">
@endif

{{-- Open Graph / Facebook --}}
<meta property="og:type" content="{{ $type }}">
<meta property="og:url" content="{{ $url }}">
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:image" content="{{ $image }}">
<meta property="og:site_name" content="{{ config('app.name') }}">

{{-- Twitter --}}
<meta name="twitter:card" content="{{ $twitterCard }}">
<meta name="twitter:url" content="{{ $url }}">
<meta name="twitter:title" content="{{ $title }}">
<meta name="twitter:description" content="{{ $description }}">
<meta name="twitter:image" content="{{ $image }}">

{{-- Additional SEO --}}
<meta name="robots" content="index, follow">
<meta name="author" content="{{ config('app.name') }}">
<link rel="canonical" href="{{ $url }}">
