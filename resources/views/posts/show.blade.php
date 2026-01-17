<x-layout>
    <x-slot:title>{{ $post->meta_title ?? $post->title }}</x-slot>
    <x-slot:description>{{ $post->meta_description ?? Str::limit(strip_tags($post->content), 160) }}</x-slot>
    <x-slot:ogImage>{{ $post->featured_image ? asset('storage/' . $post->featured_image) : null }}</x-slot>

    <article class="pb-16" itemscope itemtype="https://schema.org/NewsArticle">
        <header class="bg-white border-b border-slate-200">
            <div class="container mx-auto px-4 max-w-3xl py-10">
                <div class="flex flex-wrap items-center gap-3 mb-4 text-sm text-slate-600">
                    <a
                        href="{{ url($post->category->slug) }}"
                        class="inline-flex items-center rounded-full bg-emerald-600 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-white"
                    >
                        {{ $post->category->name }}
                    </a>
                    <span class="text-xs text-slate-500">
                        {{ $post->read_time ?? 5 }} min de leitura
                    </span>
                </div>

                <h1 class="text-3xl md:text-4xl font-bold tracking-tight text-slate-900 mb-4" itemprop="headline">
                    {{ $post->title }}
                </h1>

                @if($post->subtitle)
                <p class="text-lg text-emerald-700 mb-6 leading-snug">
                    {{ $post->subtitle }}
                </p>
                @elseif($post->excerpt)
                <p class="text-lg text-slate-600 mb-6" itemprop="description">
                    {{ $post->excerpt }}
                </p>
                @endif

                <div class="flex flex-wrap items-center justify-between gap-4 pt-6 border-t border-slate-200">
                    <div class="flex items-center gap-3">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-emerald-600 text-white font-semibold">
                            {{ strtoupper(substr($post->author->name ?? 'E', 0, 1)) }}
                        </div>
                        <div class="flex flex-col">
                            <span class="font-medium" itemprop="author">
                                {{ $post->author->name ?? 'Equipe InfoRagro' }}
                            </span>
                            <time class="text-xs text-slate-500" datetime="{{ $post->published_at }}" itemprop="datePublished">
                                {{ $post->published_at->locale('pt_BR')->translatedFormat('d \d\e F \d\e Y') }}
                            </time>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 text-xs text-slate-500">
                        <span>Compartilhar:</span>
                        <a
                            href="https://twitter.com/intent/tweet?url={{ urlencode(url($post->category->slug . '/' . $post->slug)) }}&text={{ urlencode($post->title) }}"
                            target="_blank"
                            rel="noopener"
                            aria-label="Compartilhar no X"
                            class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-slate-100 text-slate-600 hover:bg-emerald-600 hover:text-white transition-colors"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865l8.875 11.633Z" />
                            </svg>
                        </a>
                        <a
                            href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url($post->category->slug . '/' . $post->slug)) }}"
                            target="_blank"
                            rel="noopener"
                            aria-label="Compartilhar no Facebook"
                            class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-slate-100 text-slate-600 hover:bg-emerald-600 hover:text-white transition-colors"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z" />
                            </svg>
                        </a>
                        <a
                            href="https://wa.me/?text={{ urlencode($post->title . ' - ' . url($post->category->slug . '/' . $post->slug)) }}"
                            target="_blank"
                            rel="noopener"
                            aria-label="Compartilhar no WhatsApp"
                            class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-slate-100 text-slate-600 hover:bg-emerald-600 hover:text-white transition-colors"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </header>

        @if($post->featured_image)
        <figure class="bg-slate-50 py-6">
            <div class="container mx-auto px-4 max-w-3xl">
                <img
                    src="{{ asset('storage/' . $post->featured_image) }}"
                    alt="{{ $post->title }}"
                    itemprop="image"
                    class="w-full h-auto rounded-xl shadow-sm"
                >
                @if($post->featured_image_caption)
                <figcaption class="mt-2 text-xs text-slate-500">
                    {{ $post->featured_image_caption }}
                </figcaption>
                @endif
            </div>
        </figure>
        @endif

        <div class="bg-slate-50 py-10" itemprop="articleBody">
            <div class="container mx-auto px-4 max-w-3xl">
                <div class="prose prose-slate max-w-none">
                    {!! $post->content !!}
                </div>

                @if($post->tags->isNotEmpty())
                <div class="mt-8 pt-6 border-t border-slate-200 flex flex-wrap items-center gap-2">
                    <span class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                        Tags:
                    </span>
                    @foreach($post->tags as $tag)
                    <a
                        href="{{ url('tag/' . $tag->slug) }}"
                        class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-700 hover:bg-emerald-600 hover:text-white transition-colors"
                    >
                        {{ $tag->name }}
                    </a>
                    @endforeach
                </div>
                @endif
            </div>
        </div>

        <aside class="bg-white border-y border-slate-200 py-10">
            <div class="container mx-auto px-4 max-w-3xl">
                <div class="flex items-center gap-4">
                    <div class="flex h-20 w-20 items-center justify-center rounded-full bg-emerald-600 text-white text-3xl font-semibold">
                        {{ strtoupper(substr($post->author->name ?? 'E', 0, 1)) }}
                    </div>
                    <div class="space-y-1">
                        <span class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Escrito por
                        </span>
                        <h3 class="text-lg font-semibold text-slate-900">
                            {{ $post->author->name ?? 'Equipe InfoRagro' }}
                        </h3>
                        <p class="text-sm text-slate-600">
                            Equipe de redação do portal InfoRagro.
                        </p>
                    </div>
                </div>
            </div>
        </aside>
    </article>

    @if($relatedPosts->isNotEmpty())
    <section class="mt-12 border-t border-slate-100 bg-white py-12">
        <div class="container mx-auto px-4">
            <header class="mb-6">
                <h2 class="text-2xl font-bold text-slate-900">
                    Artigos Relacionados
                </h2>
            </header>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($relatedPosts as $related)
                <x-post-card :post="$related" />
                @endforeach
            </div>
        </div>
    </section>
    @endif

    @push('scripts')
    <script>
        fetch('/api/view', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ post_id: {{ $post->id }} })
        }).catch(e => console.error(e));
    </script>
    @endpush
</x-layout>
