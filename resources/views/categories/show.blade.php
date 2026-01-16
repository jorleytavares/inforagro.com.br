<x-layout>
    <x-slot:title>{{ $category->name }} | InforAgro</x-slot>
    <x-slot:description>{{ $category->description ?? 'Notícias sobre ' . $category->name }}</x-slot>

    <div class="category-header">
        <div class="container">
            <h1 class="category-title">{{ $category->name }}</h1>
            @if($category->description)
            <p class="category-description">{{ $category->description }}</p>
            @endif
        </div>
    </div>

    <section class="section">
        <div class="container">
            @if($posts->isNotEmpty())
                <div class="posts-grid">
                    @foreach($posts as $post)
                    <x-post-card :post="$post" />
                    @endforeach
                </div>

                <div class="pagination-wrapper">
                    {{ $posts->links() }}
                </div>
            @else
                <p>Nenhuma publicação encontrada nesta categoria.</p>
            @endif
        </div>
    </section>
</x-layout>
