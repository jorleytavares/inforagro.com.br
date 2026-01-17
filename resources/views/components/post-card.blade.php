@props(['post'])

<article class="group flex flex-col h-full bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden border border-slate-100">
    <a href="{{ route('post.show', ['category' => $post->category->slug, 'post' => $post->slug]) }}" class="block overflow-hidden aspect-video relative">
        @if($post->featured_image)
            <img src="{{ Storage::url($post->featured_image) }}" 
                 alt="{{ $post->title }}" 
                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
        @else
            <div class="w-full h-full bg-slate-100 flex items-center justify-center text-slate-300">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
        @endif
        
        <div class="absolute top-3 left-3">
            <span class="inline-block px-3 py-1 text-xs font-bold text-white uppercase tracking-wider bg-emerald-600 rounded-full shadow-sm">
                {{ $post->category->name }}
            </span>
        </div>
    </a>

    <div class="flex flex-col flex-grow p-5">
        <div class="flex items-center text-xs text-slate-500 mb-3 space-x-2">
            <span>{{ $post->published_at->format('d M, Y') }}</span>
            <span>&bull;</span>
            <span>{{ $post->read_time ?? 5 }} min leitura</span>
        </div>

        <h3 class="text-lg font-bold text-slate-900 mb-2 leading-tight group-hover:text-emerald-700 transition-colors">
            <a href="{{ route('post.show', ['category' => $post->category->slug, 'post' => $post->slug]) }}">
                {{ $post->title }}
            </a>
        </h3>

        @if($post->subtitle)
            <p class="text-slate-600 text-sm line-clamp-2 mb-4">
                {{ $post->subtitle }}
            </p>
        @endif

        <div class="mt-auto pt-4 border-t border-slate-50 flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <div class="w-6 h-6 rounded-full bg-slate-200 overflow-hidden">
                    <!-- Placeholder avatar if no user avatar -->
                    <svg class="w-full h-full text-slate-400 p-1" fill="currentColor" viewBox="0 0 24 24"><path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                </div>
                <span class="text-xs font-medium text-slate-700">{{ $post->author->name }}</span>
            </div>
        </div>
    </div>
</article>
