@props(['post'])

<div class="relative group h-[500px] rounded-2xl overflow-hidden shadow-lg">
    {{-- Background Image --}}
    <div class="absolute inset-0">
        @if($post->featured_image)
            <img src="{{ Storage::url($post->featured_image) }}" 
                 alt="{{ $post->title }}" 
                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
        @else
            <div class="w-full h-full bg-slate-800"></div>
        @endif
        {{-- Gradient Overlay --}}
        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/40 to-transparent"></div>
    </div>

    {{-- Content --}}
    <div class="absolute bottom-0 left-0 w-full p-6 md:p-10">
        <a href="{{ route('category.show', $post->category->slug) }}" class="inline-block px-3 py-1 mb-4 text-xs font-bold text-white uppercase tracking-wider bg-emerald-600 rounded-lg hover:bg-emerald-700 transition-colors">
            {{ $post->category->name }}
        </a>

        <h2 class="text-3xl md:text-5xl font-extrabold text-white mb-3 leading-tight font-display drop-shadow-sm">
            <a href="{{ route('post.show', ['category' => $post->category->slug, 'post' => $post->slug]) }}" class="hover:text-emerald-400 transition-colors">
                {{ $post->title }}
            </a>
        </h2>

        @if($post->subtitle)
            <p class="text-lg text-slate-200 mb-6 max-w-2xl line-clamp-2 md:line-clamp-none">
                {{ $post->subtitle }}
            </p>
        @endif

        <div class="flex items-center text-slate-300 text-sm font-medium space-x-4">
            <div class="flex items-center">
                <span class="mr-2">Por {{ $post->author->name }}</span>
            </div>
            <span>&bull;</span>
            <span>{{ $post->published_at->format('d/m/Y') }}</span>
        </div>
    </div>
</div>
