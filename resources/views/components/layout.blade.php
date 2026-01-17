<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'InforAgro' }}</title>
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    @stack('head-scripts')
</head>
<body>
    <header class="header">
        <div class="container">
            <a href="{{ url('/') }}" class="logo">InforAgro</a>
        </div>
    </header>

    <main id="main-content">
        {{ $slot }}
    </main>

    <footer class="footer">
        <div class="container">
            <p>&copy; {{ date('Y') }} InforAgro</p>
        </div>
    </footer>

    <script src="{{ asset('assets/js/main.js') }}" defer></script>
    @stack('scripts')
</body>
</html>
