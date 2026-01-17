<x-layout>
    <x-slot:title>Busca por "{{ $query }}" | InforAgro</x-slot>

    <div class="bg-white border-b border-slate-200 py-10">
        <div class="container mx-auto px-4">
            <h1 class="text-3xl md:text-4xl font-bold text-slate-900">
                Resultados para: "{{ $query }}"
            </h1>
            <p class="mt-3 text-lg text-slate-600">
                Encontramos {{ $posts->total() }} publicações.
            </p>
        </div>
    </div>

    <section class="py-10">
        <div class="container mx-auto px-4">
            @if($posts->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($posts as $post)
                    <x-post-card :post="$post" />
                    @endforeach
                </div>

                <div class="mt-10">
                    {{ $posts->links() }}
                </div>
            @else
                <div class="text-center py-16">
                    <p class="text-xl text-slate-600 mb-6">
                        Nenhuma publicação encontrada para sua busca.
                    </p>
                    <a
                        href="/"
                        class="inline-flex items-center px-6 py-3 rounded-lg bg-emerald-600 text-white font-semibold text-sm hover:bg-emerald-700 transition-colors"
                    >
                        Voltar para Home
                    </a>
                </div>
            @endif
        </div>
    </section>
</x-layout>
