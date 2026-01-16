<x-layout>
    <x-slot:title>{{ $pageTitle }}</x-slot>

    <div class="category-header bg-gray-50 py-12 mb-8">
        <div class="container mx-auto px-4 text-center">
            @if($author->avatar)
                <img src="{{ asset('storage/' . $author->avatar) }}" alt="{{ $author->name }}" class="w-24 h-24 rounded-full mx-auto mb-4 border-4 border-white shadow">
            @else
                <div class="w-24 h-24 rounded-full mx-auto mb-4 bg-primary text-white flex items-center justify-center text-3xl font-bold shadow border-4 border-white">
                    {{ substr($author->name, 0, 1) }}
                </div>
            @endif
            
            <h1 class="text-4xl font-bold text-gray-900">{{ $author->name }}</h1>
            
            @if($author->bio)
                <p class="text-xl text-gray-600 mt-2 max-w-2xl mx-auto">{{ $author->bio }}</p>
            @endif
            
            @if(!empty($author->social_links))
                <div class="flex justify-center gap-4 mt-4">
                    @foreach($author->social_links as $network => $link)
                        <a href="{{ $link }}" target="_blank" class="text-gray-500 hover:text-primary capitalize">
                            {{ $network }}
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <section class="section py-8">
        <div class="container mx-auto px-4">
            <h2 class="text-2xl font-bold mb-6 border-b pb-2">Artigos publicados</h2>
            
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
                    <p class="text-xl text-gray-600 mb-6">Este autor ainda não publicou artigos.</p>
                </div>
            @endif
        </div>
    </section>
</x-layout>
