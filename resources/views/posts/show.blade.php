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
                
                @if($post->excerpt)
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
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(url($post->category->slug . '/' . $post->slug)) }}&text={{ urlencode($post->title) }}" target="_blank" rel="noopener" class="share-btn">𝕏</a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url($post->category->slug . '/' . $post->slug)) }}" target="_blank" rel="noopener" class="share-btn">f</a>
                        <a href="https://wa.me/?text={{ urlencode($post->title . ' - ' . url($post->category->slug . '/' . $post->slug)) }}" target="_blank" rel="noopener" class="share-btn">📱</a>
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
