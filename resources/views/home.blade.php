<x-layout>
    <x-slot:title>InforAgro - Notícias do Agronegócio</x-slot>

    <!-- Hero Section -->
    <div class="relative bg-white overflow-hidden">
        <div class="absolute inset-0">
            <div class="absolute inset-0 bg-gradient-to-r from-slate-100 to-white mix-blend-multiply"></div>
        </div>
        <div class="relative pt-6 pb-16 sm:pb-24 lg:pb-32 container mx-auto px-4 sm:px-6 lg:px-8">
            <main class="mt-16 sm:mt-24">
                <div class="lg:grid lg:grid-cols-12 lg:gap-8 items-center">
                    <div class="sm:text-center md:max-w-2xl md:mx-auto lg:col-span-6 lg:text-left">
                        <h1>
                            <span class="block text-sm font-semibold uppercase tracking-wide text-agro-600 sm:text-base lg:text-sm xl:text-base">Bem-vindo ao InforAgro</span>
                            <span class="mt-1 block text-4xl tracking-tight font-extrabold sm:text-5xl xl:text-6xl text-slate-900 font-display">
                                <span class="block">O Futuro do Campo</span>
                                <span class="block text-agro-600">Começa Aqui</span>
                            </span>
                        </h1>
                        <p class="mt-3 text-base text-slate-500 sm:mt-5 sm:text-xl lg:text-lg xl:text-xl">
                            Acompanhe as últimas tendências de mercado, tecnologia agrícola, sustentabilidade e inovação para o produtor rural.
                        </p>
                    </div>
                    <!-- Hero Image / Featured Post Placeholder -->
                    <div class="mt-12 relative sm:max-w-lg sm:mx-auto lg:mt-0 lg:max-w-none lg:mx-0 lg:col-span-6 lg:flex lg:items-center">
                        <div class="relative mx-auto w-full rounded-2xl shadow-xl lg:max-w-md overflow-hidden transform transition hover:scale-105 duration-500">
                             @if(isset($featuredPosts) && $featuredPosts->isNotEmpty())
                                <div class="relative h-96 w-full">
                                    <img class="absolute inset-0 h-full w-full object-cover" 
                                         src="{{ $featuredPosts->first()->featured_image ? asset('storage/' . $featuredPosts->first()->featured_image) : 'https://placehold.co/800x600?text=InforAgro' }}" 
                                         alt="{{ $featuredPosts->first()->title }}">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                                    <div class="absolute bottom-0 left-0 p-6 text-white">
                                        <span class="inline-block px-3 py-1 bg-agro-600 text-xs font-bold uppercase tracking-wider mb-2 rounded-full">Destaque</span>
                                        <h2 class="text-2xl font-bold leading-tight mb-2">{{ $featuredPosts->first()->title }}</h2>
                                        <a href="{{ url($featuredPosts->first()->category->slug . '/' . $featuredPosts->first()->slug) }}" class="text-sm font-medium hover:underline text-agro-100">Ler matéria completa &rarr;</a>
                                    </div>
                                </div>
                             @else
                                <div class="bg-slate-200 h-96 w-full flex items-center justify-center text-slate-400">
                                    <span>Sem destaques no momento</span>
                                </div>
                             @endif
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Latest Posts Grid -->
    <section class="bg-slate-50 py-16">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-end mb-10 gap-4">
                <div>
                    <h2 class="text-3xl font-extrabold tracking-tight text-slate-900 font-display">Últimas Publicações</h2>
                    <p class="mt-2 text-lg text-slate-500">Notícias frescas para manter você atualizado.</p>
                </div>
                <a href="#" class="text-agro-600 hover:text-agro-700 font-medium flex items-center gap-1 transition-colors">
                    Ver arquivo completo <span aria-hidden="true">&rarr;</span>
                </a>
            </div>

            <div class="grid gap-10 md:grid-cols-2 lg:grid-cols-3">
                @if(isset($latestPosts) && $latestPosts->isNotEmpty())
                    @foreach ($latestPosts as $post)
                    <article class="flex flex-col rounded-2xl shadow-sm hover:shadow-lg transition-shadow bg-white overflow-hidden border border-slate-100 group">
                        <div class="flex-shrink-0 h-48 w-full relative overflow-hidden">
                            <img class="h-full w-full object-cover transform group-hover:scale-110 transition-transform duration-700" 
                                src="{{ $post->featured_image ? asset('storage/' . $post->featured_image) : 'https://placehold.co/600x400?text=News' }}" 
                                alt="{{ $post->title }}">
                            @if($post->category)
                            <span class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm text-slate-800 text-xs font-bold px-3 py-1 rounded-full shadow-sm">
                                {{ $post->category->name }}
                            </span>
                            @endif
                        </div>
                        <div class="flex-1 p-6 flex flex-col justify-between">
                            <div class="flex-1">
                                <div class="flex items-center text-sm text-slate-500 mb-3 gap-3">
                                    <time datetime="{{ $post->published_at }}">{{ \Carbon\Carbon::parse($post->published_at)->format('d/m/Y') }}</time>
                                    <span aria-hidden="true">&middot;</span>
                                    <span>{{ $post->read_time ?? '5' }} min leitura</span>
                                </div>
                                <a href="{{ url($post->category->slug . '/' . $post->slug) }}" class="block mt-2">
                                    <h3 class="text-xl font-bold text-slate-900 group-hover:text-agro-600 transition-colors line-clamp-2">
                                        {{ $post->title }}
                                    </h3>
                                    <p class="mt-3 text-base text-slate-500 line-clamp-3 leading-relaxed">
                                        {{ Str::limit($post->meta_description ?? strip_tags($post->content), 120) }}
                                    </p>
                                </a>
                            </div>
                            <div class="mt-6 flex items-center">
                                <div class="flex-shrink-0">
                                    <span class="sr-only">{{ $post->author->name ?? 'Redação' }}</span>
                                    <div class="h-10 w-10 rounded-full bg-slate-200 flex items-center justify-center text-slate-500 font-bold text-xs uppercase">
                                        {{ substr($post->author->name ?? 'IA', 0, 2) }}
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-slate-900">
                                        {{ $post->author->name ?? 'Redação InforAgro' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </article>
                    @endforeach
                @else
                    <div class="col-span-3 text-center py-10">
                        <p class="text-slate-500">Nenhum post encontrado. Execute o Seed para popular o site.</p>
                        <a href="/run-seed" class="text-agro-600 font-bold hover:underline mt-2 inline-block">Executar Seed Agora</a>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="bg-white py-16">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-slate-900 mb-8 font-display">Explore por Categorias</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                @if(isset($categories) && $categories->isNotEmpty())
                    @foreach($categories as $cat)
                    <a href="{{ url($cat->slug) }}" class="flex flex-col items-center justify-center p-6 bg-slate-50 rounded-xl hover:bg-agro-50 hover:scale-105 transition-all group border border-slate-100">
                        @if($cat->icon)
                        <span class="text-3xl mb-3 group-hover:scale-110 transition-transform block">{{ $cat->icon }}</span>
                        @endif
                        <span class="text-sm font-medium text-slate-700 group-hover:text-agro-700 text-center">{{ $cat->name }}</span>
                    </a>
                    @endforeach
                @endif
            </div>
        </div>
    </section>
</x-layout>
