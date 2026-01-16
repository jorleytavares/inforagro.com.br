<x-layout>
    <x-slot:title>Busca por "{{ $query }}" | InforAgro</x-slot>

    <div class="category-header">
        <div class="container">
            <h1 class="category-title">Resultados para: "{{ $query }}"</h1>
            <p class="category-description">Encontramos {{ $posts->total() }} publicações.</p>
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
                <div class="empty-state">
                    <p>Nenhuma publicação encontrada para sua busca.</p>
                    <a href="/" class="btn btn-primary">Voltar para Home</a>
                </div>
            @endif
        </div>
    </section>
</x-layout>
