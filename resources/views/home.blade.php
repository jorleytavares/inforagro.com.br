<x-layout>
    <x-slot:title>Home</x-slot>

    {{-- Main Container --}}
    <main class="container mx-auto px-4 py-8">

        {{-- Hero Section (Big Featured Post) --}}
        @if($heroPost)
            <section class="mb-12">
                <x-hero-post :post="$heroPost" />
            </section>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            
            {{-- Left Column (Main Content) --}}
            <div class="lg:col-span-8">

                 {{-- Latest News Grid --}}
                 @if($latestPosts->isNotEmpty())
                    <section class="mb-12">
                        <x-section-header href="{{ route('search') }}">Últimas Notícias</x-section-header>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($latestPosts as $post)
                                <x-post-card :post="$post" />
                            @endforeach
                        </div>
                    </section>
                @endif

                {{-- Dynamic Category Sections --}}
                @foreach($categorySections as $category)
                    @if($category->posts->isNotEmpty())
                        <section class="mb-12">
                            <x-section-header :href="route('category.show', $category->slug)">
                                {{ $category->name }}
                            </x-section-header>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                @foreach($category->posts as $post)
                                    <x-post-card :post="$post" />
                                @endforeach
                            </div>
                        </section>
                    @endif
                @endforeach

            </div>

            {{-- Right Column (Sidebar) --}}
            <aside class="lg:col-span-4 space-y-10">
                
                {{-- Newsletter Widget --}}
                <div class="bg-emerald-50 rounded-xl p-6 border border-emerald-100">
                    <h3 class="text-xl font-bold font-display text-emerald-900 mb-2">Inscreva-se</h3>
                    <p class="text-sm text-emerald-700 mb-4">Receba as principais notícias do agronegócio diretamente no seu e-mail.</p>
                    
                    <form action="{{ route('newsletter.subscribe') }}" method="POST" class="space-y-3">
                        @csrf
                        <input type="email" name="email" placeholder="Seu melhor e-mail" required
                               class="w-full px-4 py-3 rounded-lg border-emerald-200 focus:border-emerald-500 focus:ring-emerald-500 bg-white">
                        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 rounded-lg transition-colors shadow-sm">
                            Quero receber
                        </button>
                    </form>
                </div>

                {{-- Social Media Widget (Placeholder) --}}
                 <div class="bg-white rounded-xl p-6 border border-slate-100 shadow-sm">
                    <h3 class="text-lg font-bold font-display text-slate-800 mb-4 pb-2 border-b border-slate-100">Siga-nos</h3>
                    <div class="flex space-x-4">
                        <!-- Icons would go here, simplified text for now -->
                        <a href="#" class="text-slate-400 hover:text-emerald-500 transition-colors">Instagram</a>
                        <a href="#" class="text-slate-400 hover:text-emerald-500 transition-colors">LinkedIn</a>
                        <a href="#" class="text-slate-400 hover:text-emerald-500 transition-colors">X (Twitter)</a>
                    </div>
                </div>

                {{-- Most Read / Trending --}}
                @if(isset($mostReadPosts) && $mostReadPosts->isNotEmpty())
                    <div>
                        <x-section-header>Mais Lidas</x-section-header>
                        <div class="flex flex-col space-y-4">
                            @foreach($mostReadPosts as $post)
                                <x-post-card-horizontal :post="$post" />
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Advertisement Placeholder --}}
                <div class="bg-slate-100 rounded-xl h-64 flex items-center justify-center text-slate-400 border-2 border-dashed border-slate-200">
                    <span class="text-sm font-semibold uppercase tracking-widest">Publicidade</span>
                </div>

            </aside>

        </div>
    </main>
</x-layout>
