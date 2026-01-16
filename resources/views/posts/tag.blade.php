<x-layout>
    <x-slot:title>{{ $pageTitle }}</x-slot>

    <div class="category-header bg-gray-50 py-12 mb-8">
        <div class="container mx-auto px-4">
            <span class="text-sm uppercase tracking-wide text-gray-500 font-semibold">Tópico</span>
            <h1 class="text-4xl font-bold text-gray-900 mt-2">#{{ $tag->name }}</h1>
            <p class="text-xl text-gray-600 mt-2">Explorando todas as publicações sobre este tema.</p>
        </div>
    </div>

    <section class="section py-8">
        <div class="container mx-auto px-4">
            @if($posts->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($posts as $post)
                    <x-post-card :post="$post" />
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $posts->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <p class="text-xl text-gray-600 mb-6">Nenhuma publicação encontrada para esta tag.</p>
                    <a href="/" class="inline-block bg-primary hover:bg-primary-dark text-white font-bold py-3 px-6 rounded-lg transition duration-150">Voltar para Home</a>
                </div>
            @endif
        </div>
    </section>
</x-layout>
