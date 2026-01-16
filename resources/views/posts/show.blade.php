<x-layout>
    <x-slot:title>{{ $post->meta_title ?? $post->title }}</x-slot>
    <x-slot:description>{{ $post->meta_description ?? Str::limit(strip_tags($post->content), 160) }}</x-slot>
    <x-slot:ogImage>{{ $post->featured_image ? asset('storage/' . $post->featured_image) : null }}</x-slot>

    <!-- Article -->
    <article class="article" itemscope itemtype="https://schema.org/NewsArticle">
        <!-- Header -->
        <header class="article-header">
            <div class="container container-article">
                <div class="article-meta-top">
                    <a href="{{ url($post->category->slug) }}" class="article-category">
                        {{ $post->category->name }}
                    </a>
                    <span class="article-read-time">{{ $post->read_time ?? 5 }} min de leitura</span>
                </div>
                
                <h1 class="article-title" itemprop="headline">{{ $post->title }}</h1>
                
                @if($post->subtitle)
                <p class="article-excerpt" style="font-size: 1.5rem; color: var(--color-secondary); margin-bottom: var(--space-lg); line-height: 1.4;">{{ $post->subtitle }}</p>
                @elseif($post->excerpt)
                <p class="article-excerpt" itemprop="description">{{ $post->excerpt }}</p>
                @endif
                
                <div class="article-author-bar">
                    <div class="author-info">
                        <div class="author-avatar-placeholder">
                            {{ strtoupper(substr($post->author->name ?? 'E', 0, 1)) }}
                        </div>
                        <div>
                            <span class="author-name" itemprop="author">{{ $post->author->name ?? 'Equipe InfoRagro' }}</span>
                            <time class="article-date" datetime="{{ $post->published_at }}" itemprop="datePublished">
                                {{ $post->published_at->format('d \d\e F \d\e Y') }}
                            </time>
                        </div>
                    </div>
                    
                    <div class="article-share">
                        <span>Compartilhar:</span>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(url($post->category->slug . '/' . $post->slug)) }}&text={{ urlencode($post->title) }}" target="_blank" rel="noopener" class="share-btn" aria-label="Compartilhar no X">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865l8.875 11.633Z"/>
                            </svg>
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url($post->category->slug . '/' . $post->slug)) }}" target="_blank" rel="noopener" class="share-btn" aria-label="Compartilhar no Facebook">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
                            </svg>
                        </a>
                        <a href="https://wa.me/?text={{ urlencode($post->title . ' - ' . url($post->category->slug . '/' . $post->slug)) }}" target="_blank" rel="noopener" class="share-btn" aria-label="Compartilhar no WhatsApp">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </header>
        
        <!-- Featured Image -->
        @if($post->featured_image)
        <figure class="article-featured-image">
            <div class="container container-article">
                <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" itemprop="image" style="max-width: 100%; height: auto; width: 100%; border-radius: 12px;">
                @if($post->featured_image_caption)
                <figcaption>{{ $post->featured_image_caption }}</figcaption>
                @endif
            </div>
        </figure>
        @endif
        
        <!-- Content -->
        <div class="article-content" itemprop="articleBody">
            <div class="container container-article">
                <div class="content-body">
                    {!! $post->content !!}
                </div>
                
                <!-- Tags -->
                @if($post->tags->isNotEmpty())
                <div class="article-tags">
                    <span>Tags:</span>
                    @foreach($post->tags as $tag)
                    <a href="{{ url('tag/' . $tag->slug) }}" class="tag-link">{{ $tag->name }}</a>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
        
        <!-- Author Box -->
        <aside class="author-box">
            <div class="container container-article">
                <div class="author-box-inner">
                    <div class="author-box-avatar-placeholder">
                        {{ strtoupper(substr($post->author->name ?? 'E', 0, 1)) }}
                    </div>
                    <div class="author-box-info">
                        <span class="author-box-label">Escrito por</span>
                        <h3 class="author-box-name">{{ $post->author->name ?? 'Equipe InfoRagro' }}</h3>
                        <p class="author-box-bio">Equipe de redação do portal InfoRagro.</p>
                    </div>
                </div>
            </div>
        </aside>
    </article>
    
    <!-- Related Posts -->
    @if($relatedPosts->isNotEmpty())
    <section class="section related-posts">
        <div class="container">
            <header class="section-header">
                <h2 class="section-title">Artigos Relacionados</h2>
            </header>
            <div class="posts-grid">
                @foreach($relatedPosts as $related)
                <x-post-card :post="$related" />
                @endforeach
            </div>
        </div>
    </section>
    @endif
    
    @push('scripts')
    <script>
        // Track View
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
