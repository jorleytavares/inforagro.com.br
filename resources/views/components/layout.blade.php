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

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Lexend:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('head-scripts')
</head>
<body class="bg-slate-50 text-slate-900 font-sans antialiased flex flex-col min-h-screen">

    <!-- Header / Navigation -->
    <header class="fixed w-full top-0 z-50 glass-nav transition-all duration-300">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center gap-2">
                    <a href="{{ url('/') }}" class="flex items-center gap-2 group">
                        <div class="w-10 h-10 bg-gradient-to-br from-agro-500 to-agro-700 rounded-xl flex items-center justify-center text-white shadow-lg group-hover:scale-105 transition-transform">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                            </svg>
                        </div>
                        <div>
                            <span class="font-display font-bold text-2xl tracking-tight text-slate-900">Infor<span class="text-agro-600">Agro</span></span>
                        </div>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <nav class="hidden md:flex space-x-1">
                    @if(isset($globalCategories) && $globalCategories->count() > 0)
                        @foreach($globalCategories as $cat)
                        <a href="{{ url($cat->slug) }}" class="px-4 py-2 rounded-lg text-sm font-medium text-slate-600 hover:text-agro-700 hover:bg-agro-50 transition-colors">
                            {{ $cat->name }}
                        </a>
                        @endforeach
                    @endif
                </nav>

                <!-- Actions -->
                <div class="flex items-center gap-3">
                    <button class="p-2 text-slate-500 hover:text-agro-600 hover:bg-slate-100 rounded-full transition-colors" aria-label="Buscar">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                    <!-- Newsletter Button (Desktop) -->
                    <a href="#newsletter" class="hidden sm:inline-flex items-center justify-center px-5 py-2 border border-transparent text-sm font-medium rounded-full text-white bg-agro-600 hover:bg-agro-700 shadow-sm transition-all hover:shadow-md gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M2.94 6.34A2 2 0 0 1 4.6 5h10.8a2 2 0 0 1 1.66.94l-7.06 4.12a1 1 0 0 1-1 0L2.94 6.34Z" />
                            <path d="M2 8.25v5.5A2.25 2.25 0 0 0 4.25 16h11.5A2.25 2.25 0 0 0 18 13.75v-5.5l-6.47 3.78a3 3 0 0 1-3.06 0L2 8.25Z" />
                        </svg>
                        <span>Inscrever-se</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main id="main-content" class="flex-grow pt-20">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 mt-12 pt-16 pb-8">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <!-- Brand -->
                <div class="col-span-1 md:col-span-1">
                    <a href="/" class="flex items-center gap-2 mb-4">
                        <span class="font-display font-bold text-xl text-slate-900">Infor<span class="text-agro-600">Agro</span></span>
                    </a>
                    <p class="text-slate-500 text-sm leading-relaxed">
                        O portal de referência para o produtor rural moderno. Informação, tecnologia e mercado na palma da sua mão.
                    </p>
                    <div class="flex gap-4 mt-6">
                        <a href="#" class="text-slate-400 hover:text-agro-600 transition-colors">
                            <span class="sr-only">Instagram</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none">
                                <rect x="3" y="3" width="18" height="18" rx="5" ry="5" stroke="currentColor" stroke-width="1.6" />
                                <circle cx="12" cy="12" r="4" stroke="currentColor" stroke-width="1.6" />
                                <circle cx="17" cy="7" r="1.2" fill="currentColor" />
                            </svg>
                        </a>
                        <a href="#" class="text-slate-400 hover:text-agro-600 transition-colors">
                            <span class="sr-only">X</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none">
                                <path d="M6 5l5.2 6.4L6 19h2.2L12 13.7 15.8 19H18l-5.2-7.6L18 5h-2.2L12 10.3 8.2 5H6z" fill="currentColor" />
                            </svg>
                        </a>
                        <a href="#" class="text-slate-400 hover:text-agro-600 transition-colors">
                            <span class="sr-only">LinkedIn</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2" stroke="currentColor" stroke-width="1.6" />
                                <rect x="7" y="10" width="2" height="7" fill="currentColor" />
                                <rect x="7" y="7" width="2" height="2" fill="currentColor" />
                                <path d="M13 10h1.6A2.4 2.4 0 0 1 17 12.4V17h-2v-4c0-.6-.4-1-1-1h-1v5h-2v-7h2z" fill="currentColor" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Links 1 -->
                <div>
                    <h3 class="font-bold text-slate-900 mb-4">Editorias</h3>
                    <ul class="space-y-3 text-sm text-slate-600 w-full">
                        @if(isset($globalCategories) && $globalCategories->count() > 0)
                            @foreach($globalCategories as $cat)
                            <li><a href="{{ url($cat->slug) }}" class="hover:text-agro-600 transition-colors">{{ $cat->name }}</a></li>
                            @endforeach
                        @else
                            <li><span class="text-slate-400">Sem categorias</span></li>
                        @endif
                    </ul>
                </div>

                <!-- Links 2 -->
                <div>
                    <h3 class="font-bold text-slate-900 mb-4">Institucional</h3>
                    <ul class="space-y-3 text-sm text-slate-600 w-full">
                        <li><a href="{{ url('/sobre') }}" class="hover:text-agro-600 transition-colors">Sobre Nós</a></li>
                        <li><a href="{{ url('/contato') }}" class="hover:text-agro-600 transition-colors">Anuncie</a></li>
                        <li><a href="{{ url('/contato') }}" class="hover:text-agro-600 transition-colors">Contato</a></li>
                        <li><a href="{{ url('/privacidade') }}" class="hover:text-agro-600 transition-colors">Privacidade</a></li>
                    </ul>
                </div>

                <!-- Newsletter Widget -->
                <div id="newsletter">
                    <h3 class="font-bold text-slate-900 mb-4">Receba novidades</h3>
                    <form action="{{ url('/newsletter') }}" method="POST" class="flex flex-col gap-3">
                        @csrf
                        <input type="email" name="email" placeholder="Seu melhor e-mail" class="px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-agro-500 focus:border-transparent text-sm w-full" required>
                        <button type="submit" class="px-4 py-2 bg-agro-600 hover:bg-agro-700 text-white font-medium rounded-lg text-sm w-full transition-colors shadow-sm">
                            Assinar Newsletter
                        </button>
                    </form>
                </div>
            </div>

            <div class="border-t border-slate-100 pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-slate-500">
                <p>&copy; {{ date('Y') }} InforAgro. Todos os direitos reservados.</p>
                <p>Desenvolvido com tecnologia de ponta.</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
