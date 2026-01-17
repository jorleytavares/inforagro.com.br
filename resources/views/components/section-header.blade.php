<div class="flex items-center justify-between mb-6 border-l-4 border-emerald-500 pl-4">
    <h2 class="text-2xl font-bold font-display text-slate-800">
        {{ $slot }}
    </h2>
    @if(isset($href))
        <a href="{{ $href }}" class="group flex items-center text-sm font-semibold text-emerald-600 hover:text-emerald-700 transition-colors">
            Ver tudo
            <svg class="w-4 h-4 ml-1 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </a>
    @endif
</div>
