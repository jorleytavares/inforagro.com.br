@props(['post', 'large' => false])

<article {{ $attributes->class(['post-card', 'post-card-large' => $large]) }}>
    <div class="post-card-image">
        @if($post->category)
        <span class="post-category">{{ $post->category->name }}</span>
        @endif
        
        @if($post->featured_image)
        <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" loading="lazy">
        @else
        <div class="post-image-placeholder">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <rect x="3" y="3" width="18" height="18" rx="2"/>
                <circle cx="8.5" cy="8.5" r="1.5"/>
                <path d="M21 15l-5-5L5 21"/>
            </svg>
        </div>
        @endif
    </div>
    
    <div class="post-card-content">
        <h3 class="post-title">
            <a href="{{ url(($post->category->slug ?? 'sem-categoria') . '/' . $post->slug) }}">
                {{ $post->title }}
            </a>
        </h3>
        
        <p class="post-excerpt">{{ Str::limit($post->meta_description ?? '', 120) }}</p>
        
        <div class="post-meta">
            @if($post->author)
            <span class="post-author">{{ $post->author->name }}</span>
            @endif
            
            <span class="post-date">
                {{ $post->published_at ? $post->published_at->format('d/m/Y') : '' }}
            </span>
            
            @if($post->read_time)
            <span class="post-read-time">{{ $post->read_time }} min de leitura</span>
            @endif
        </div>
    </div>
</article>
