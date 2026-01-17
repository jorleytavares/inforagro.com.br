<x-layout>
    <x-slot:title>{{ $category->name }} | InforAgro</x-slot>
    <x-slot:description>{{ $category->description ?? 'Notícias sobre ' . $category->name }}</x-slot>

    <div class="bg-white border-b border-slate-200 py-10">
        <div class="container mx-auto px-4">
            <h1 class="text-3xl md:text-4xl font-bold text-slate-900">
                {{ $category->name }}
            </h1>
            @if($category->description)
            <p class="mt-3 text-lg text-slate-600">
                {{ $category->description }}
            </p>
            @endif
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
                <p class="text-slate-600">
                    Nenhuma publicação encontrada nesta categoria.
                </p>
            @endif
        </div>
    </section>
</x-layout>
