<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>{{ $title ?? 'InforAgro - Portal do Agronegócio Brasileiro' }}</title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="{{ $description ?? 'Portal de notícias, análises e referências sobre o agronegócio brasileiro. Agricultura, pecuária, mercado agro, sustentabilidade e mundo pet.' }}">
    <meta name="keywords" content="{{ $keywords ?? 'agronegócio, agricultura, pecuária, agro, notícias agro, mercado agrícola, sustentabilidade, mundo pet' }}">
    <meta name="author" content="InforAgro - Portal do Agronegócio">
    <meta name="robots" content="{{ $robots ?? 'index, follow' }}">
    <meta name="language" content="pt-BR">
    <meta name="theme-color" content="#5F7D4E">
    
    @if(isset($canonical))
    <link rel="canonical" href="{{ $canonical }}">
    @endif
    
    <!-- Open Graph -->
    <meta property="og:type" content="{{ $ogType ?? 'website' }}">
    <meta property="og:site_name" content="InforAgro">
    <meta property="og:title" content="{{ $title ?? 'InforAgro' }}">
    <meta property="og:description" content="{{ $description ?? '' }}">
    <meta property="og:url" content="{{ request()->url() }}">
    <meta property="og:image" content="{{ $ogImage ?? asset('assets/images/og-default.jpg') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Atkinson+Hyperlegible:ital,wght@0,400;0,700;1,400&family=Lexend:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/images/favicon.svg') }}">
    
    <!-- Schema.org Organization -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "InfoAgro",
        "url": "https://www.infoagro.com.br",
        "logo": "{{ asset('assets/images/logo.png') }}",
        "sameAs": [
            "https://twitter.com/infoagro",
            "https://facebook.com/infoagro",
            "https://instagram.com/infoagro"
        ]
    }
    </script>

    <!-- Scripts -->
    @stack('head-scripts')
</head>
<body>
    <!-- Skip Link -->
    <a href="#main-content" class="skip-link">Pular para o conteúdo principal</a>
    
    <!-- Header -->
    <header class="header" id="header">
        <div class="container">
            <nav class="nav" aria-label="Navegação principal">
                <a href="{{ url('/') }}" class="logo" aria-label="InforAgro - Página inicial">
                    <span class="logo-icon" aria-hidden="true">🌿</span>
                    <span class="logo-text">InforAgro</span>
                </a>
                
                @php
                    $globalCategories = \App\Models\Category::all(); // TODO: Add logic for 'main' categories
                @endphp
                
                <ul class="nav-menu" id="nav-menu" role="menubar">
                    @foreach ($globalCategories as $cat)
                    <li role="none">
                        <a href="{{ url($cat->slug) }}" class="nav-link" role="menuitem">{{ $cat->name }}</a>
                    </li>
                    @endforeach
                </ul>
                
                <div class="nav-actions">
                    <button class="btn-search" id="btn-search-toggle" aria-label="Abrir busca">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8"/>
                            <path d="M21 21l-4.35-4.35"/>
                        </svg>
                    </button>
                    <!-- Mobile Menu Button -->
                    <button class="btn-menu" id="btn-menu" aria-label="Abrir menu">
                        <span></span><span></span><span></span>
                    </button>
                </div>
            </nav>
        </div>
    </header>
    
    <!-- Search Dropdown -->
    <div class="search-dropdown" id="search-dropdown">
        <div class="container">
            <form class="search-dropdown-form" action="{{ url('/buscar') }}" method="GET">
                <div class="search-dropdown-wrapper">
                    <span class="search-dropdown-icon">🔍</span>
                    <input type="search" name="q" placeholder="Digite sua busca..." autocomplete="off">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                    <button type="button" class="search-dropdown-close" id="btn-search-close">✕</button>
                </div>
            </form>
        </div>
    </div>
    

    
    <!-- Main Content -->
    <main id="main-content">
        {{ $slot }}
    </main>
    
    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <a href="/" class="logo">
                        <span class="logo-icon">🌿</span>
                        <span class="logo-text">InforAgro</span>
                    </a>
                    <p class="footer-tagline">Portal de notícias e referências sobre o agronegócio brasileiro.</p>
                </div>
                
                <div class="footer-links">
                    <h3>Categorias</h3>
                    <ul>
                        @foreach ($globalCategories as $cat)
                        <li><a href="{{ url($cat->slug) }}">{{ $cat->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
                
                <div class="footer-links">
                    <h3>Institucional</h3>
                    <ul>
                        <li><a href="{{ url('/sobre') }}">Sobre</a></li>
                        <li><a href="{{ url('/contato') }}">Contato</a></li>
                    </ul>
                </div>
                
                <div class="footer-newsletter">
                    <h3>Newsletter</h3>
                    <form action="{{ url('/newsletter') }}" method="POST">
                        @csrf
                        <input type="email" name="email" placeholder="Seu e-mail" required>
                        <button type="submit" class="btn btn-primary">Inscrever</button>
                    </form>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} InforAgro. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>
    
    <script src="{{ asset('assets/js/main.js') }}" defer></script>
    @stack('scripts')
</body>
</html>
