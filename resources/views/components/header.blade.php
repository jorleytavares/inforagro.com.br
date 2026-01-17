<header 
    class="fixed w-full top-0 z-50 transition-all duration-300 border-b border-transparent"
    x-data="{ 
        scrolled: false, 
        mobileMenuOpen: false,
        init() {
            window.addEventListener('scroll', () => {
                this.scrolled = window.scrollY > 20;
            });
            this.scrolled = window.scrollY > 20;
        }
    }"
    :class="{ 
        'bg-white/80 backdrop-blur-md border-slate-200 shadow-sm py-2': scrolled, 
        'bg-transparent py-4': !scrolled && !mobileMenuOpen,
        'bg-white': mobileMenuOpen
    }"
>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16 transition-all duration-300">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center gap-2 z-50">
                <a href="{{ url('/') }}" class="flex items-center gap-2 group">
                    <div 
                        class="w-10 h-10 rounded-xl flex items-center justify-center text-white shadow-lg group-hover:scale-105 transition-transform bg-gradient-to-br from-agro-500 to-agro-700"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                    </div>
                    <div>
                        <span class="font-display font-bold text-2xl tracking-tight text-slate-900 leading-none">
                            Infor<span class="text-agro-600">Agro</span>
                        </span>
                    </div>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <nav class="hidden md:flex space-x-1">
                @if(isset($globalCategories) && $globalCategories->count() > 0)
                    @foreach($globalCategories as $cat)
                    <a href="{{ url($cat->slug) }}" 
                       class="px-4 py-2 rounded-lg text-sm font-medium transition-colors hover:text-agro-700 hover:bg-agro-50"
                       :class="scrolled ? 'text-slate-600' : 'text-slate-700'"
                    >
                        {{ $cat->name }}
                    </a>
                    @endforeach
                @endif
            </nav>

            <!-- Actions (Desktop) -->
            <div class="hidden md:flex items-center gap-3">
                <button class="p-2 text-slate-500 hover:text-agro-600 hover:bg-slate-100 rounded-full transition-colors" aria-label="Buscar">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
                <a href="#newsletter" class="inline-flex items-center justify-center px-5 py-2 border border-transparent text-sm font-medium rounded-full text-white bg-agro-600 hover:bg-agro-700 shadow-sm transition-all hover:shadow-md gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M2.94 6.34A2 2 0 0 1 4.6 5h10.8a2 2 0 0 1 1.66.94l-7.06 4.12a1 1 0 0 1-1 0L2.94 6.34Z" />
                        <path d="M2 8.25v5.5A2.25 2.25 0 0 0 4.25 16h11.5A2.25 2.25 0 0 0 18 13.75v-5.5l-6.47 3.78a3 3 0 0 1-3.06 0L2 8.25Z" />
                    </svg>
                    <span>Inscrever-se</span>
                </a>
            </div>

            <!-- Mobile Hamburger -->
            <div class="flex md:hidden items-center z-50">
                <button 
                    @click="mobileMenuOpen = !mobileMenuOpen" 
                    type="button" 
                    class="p-2 rounded-md text-slate-600 hover:text-slate-900 focus:outline-none"
                    aria-controls="mobile-menu" 
                    :aria-expanded="mobileMenuOpen"
                >
                    <span class="sr-only">Abrir menu principal</span>
                    <!-- Icon options (conditional) -->
                    <svg class="h-6 w-6" x-show="!mobileMenuOpen" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                    <svg class="h-6 w-6" x-show="mobileMenuOpen" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu (Fullscreen Overlay) -->
    <div 
        x-show="mobileMenuOpen"
        x-transition:enter="duration-200 ease-out"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="duration-100 ease-in"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="fixed inset-0 z-40 bg-white md:hidden pt-20 px-4 pb-6 overflow-y-auto"
        id="mobile-menu"
        style="display: none;"
    >
        <div class="flex flex-col gap-6 mt-4">
            <!-- Search Mobile -->
            <form action="{{ route('search') }}" method="GET" class="relative">
                <input 
                    type="text" 
                    name="q"
                    class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-agro-500 focus:border-transparent" 
                    placeholder="Buscar notícias..."
                >
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </form>

            <nav class="space-y-1">
                @if(isset($globalCategories) && $globalCategories->count() > 0)
                    @foreach($globalCategories as $cat)
                    <a href="{{ url($cat->slug) }}" 
                       class="block px-4 py-3 rounded-lg text-base font-medium text-slate-900 hover:bg-slate-50 border-l-4 border-transparent hover:border-agro-500 transition-all"
                    >
                        {{ $cat->name }}
                    </a>
                    @endforeach
                @else
                    <p class="text-sm text-slate-500 text-center py-4">Nenhuma categoria encontrada.</p>
                @endif
            </nav>

            <div class="border-t border-slate-100 pt-6">
                <a href="#newsletter" @click="mobileMenuOpen = false" class="flex w-full items-center justify-center px-4 py-3 border border-transparent text-base font-medium rounded-xl text-white bg-agro-600 hover:bg-agro-700 shadow-sm gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M2.94 6.34A2 2 0 0 1 4.6 5h10.8a2 2 0 0 1 1.66.94l-7.06 4.12a1 1 0 0 1-1 0L2.94 6.34Z" />
                        <path d="M2 8.25v5.5A2.25 2.25 0 0 0 4.25 16h11.5A2.25 2.25 0 0 0 18 13.75v-5.5l-6.47 3.78a3 3 0 0 1-3.06 0L2 8.25Z" />
                    </svg>
                     Receber Novidades
                </a>
            </div>
            
            <div class="space-y-2 text-center text-sm text-slate-500 mt-auto pb-8">
                <a href="{{ url('/sobre') }}" class="block p-2">Sobre</a>
                <a href="{{ url('/contato') }}" class="block p-2">Contato</a>
                <a href="{{ url('/privacidade') }}" class="block p-2">Privacidade</a>
            </div>
        </div>
    </div>
</header>
