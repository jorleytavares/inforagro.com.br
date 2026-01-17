@props(['post', 'large' => false])

<article
    {{ $attributes->class([
        'bg-white rounded-2xl border border-slate-200 shadow-md overflow-hidden flex flex-col h-full transition-transform duration-200 hover:-translate-y-1 hover:shadow-lg',
        'md:flex-row' => $large,
    ]) }}
>
    <div class="{{ $large ? 'md:w-1/2' : 'w-full' }} relative h-52 md:h-64 bg-slate-100 flex items-center justify-center overflow-hidden">
        @if($post->category)
        <span class="absolute left-4 top-4 inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wide bg-emerald-600 text-white shadow">
            {{ $post->category->name }}
        </span>
        @endif

        @if($post->featured_image && \Illuminate\Support\Facades\Storage::disk('public')->exists($post->featured_image))
        <img
            src="{{ asset('storage/' . $post->featured_image) }}"
            alt="{{ $post->title }}"
            loading="lazy"
            class="w-full h-full object-cover"
        >
        @else
        <div class="flex items-center justify-center w-20 h-20 text-slate-400 opacity-60">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="w-full h-full">
                <rect x="3" y="3" width="18" height="18" rx="2" />
                <circle cx="8.5" cy="8.5" r="1.5" />
                <path d="M21 15l-5-5L5 21" />
            </svg>
        </div>
        @endif
    </div>

    <div class="{{ $large ? 'md:w-1/2' : 'w-full' }} flex flex-col gap-3 p-5">
        <h3 class="text-lg font-semibold leading-snug text-slate-900">
            <a
                href="{{ url(($post->category->slug ?? 'sem-categoria') . '/' . $post->slug) }}"
                class="hover:text-emerald-700 transition-colors"
            >
                {{ $post->title }}
            </a>
        </h3>

        <p class="text-sm text-slate-600">
            {{ Str::limit($post->meta_description ?? '', 120) }}
        </p>

        <div class="mt-4 flex flex-wrap items-center gap-x-4 gap-y-1 text-xs text-slate-500">
            @if($post->author)
            <span class="font-medium">
                {{ $post->author->name }}
            </span>
            @endif

            <span>
                {{ $post->published_at ? $post->published_at->format('d/m/Y') : '' }}
            </span>

            @if($post->read_time)
            <span>
                {{ $post->read_time }} min de leitura
            </span>
            @endif
        </div>
    </div>
</article>
