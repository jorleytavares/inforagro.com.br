@props(['post'])

<article class="group flex items-start space-x-4 p-3 rounded-lg hover:bg-slate-50 transition-colors">
    <a href="{{ route('post.show', ['category' => $post->category->slug, 'post' => $post->slug]) }}" class="flex-shrink-0 w-24 h-24 rounded-lg overflow-hidden bg-slate-200 relative">
        @if($post->featured_image)
            <img src="{{ Storage::url($post->featured_image) }}" 
                 alt="{{ $post->title }}" 
                 class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
        @else
            <div class="w-full h-full flex items-center justify-center text-slate-400">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
        @endif
    </a>
    
    <div class="flex-1 min-w-0">
        <a href="{{ route('category.show', $post->category->slug) }}" class="text-xs font-bold text-emerald-600 uppercase tracking-wide hover:underline">
            {{ $post->category->name }}
        </a>
        
        <h4 class="text-sm font-bold text-slate-900 mt-1 mb-1 leading-snug group-hover:text-emerald-700 transition-colors line-clamp-2">
            <a href="{{ route('post.show', ['category' => $post->category->slug, 'post' => $post->slug]) }}">
                {{ $post->title }}
            </a>
        </h4>
        
        <span class="text-xs text-slate-400">{{ $post->published_at->format('d M, Y') }}</span>
    </div>
</article>
