<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'InforAgro - O Portal do Agronegócio' }}</title>

    <!-- SEO & Meta -->
    <meta name="description" content="{{ $description ?? 'Notícias, cotações e tecnologia para o agronegócio brasileiro.' }}">
    <meta name="theme-color" content="#5F7D4E">

    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('assets/images/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/images/favicon-32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/favicon-16.png') }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/images/favicon.svg') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/images/apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('assets/images/site.webmanifest') }}">
    <meta name="apple-mobile-web-app-title" content="InforAgro">

    @if(isset($canonical))
    <link rel="canonical" href="{{ $canonical }}">
    @endif

    <!-- Fonts (Loaded via Vite/CSS) -->


    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Global Settings Code (Head) -->
    @if($gtmId = \App\Models\Setting::get('gtm_id'))
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','{{ $gtmId }}');</script>
    <!-- End Google Tag Manager -->
    @endif

    @if($adsenseCode = \App\Models\Setting::get('adsense_code'))
        {!! $adsenseCode !!}
    @endif

    @if($customHead = \App\Models\Setting::get('custom_head_code'))
        {!! $customHead !!}
    @endif

    @stack('head-scripts')
</head>
<body class="bg-slate-50 text-slate-900 font-sans antialiased flex flex-col min-h-screen">
    @if($gtmId = \App\Models\Setting::get('gtm_id'))
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ $gtmId }}"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    @endif

    @if($customBody = \App\Models\Setting::get('custom_body_code'))
        {!! $customBody !!}
    @endif

    <!-- Header / Navigation -->
    <x-header />

    <!-- Main Content -->
    <main id="main-content" class="flex-grow pt-20">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <x-footer />

    @stack('scripts')
</body>
</html>
