<x-layout>
    <x-slot:title>Home | InforAgro</x-slot>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <span class="hero-badge">Portal do Agronegócio</span>
                <h1 class="hero-title">Notícias e Análises sobre o <span class="text-primary">Agronegócio Brasileiro</span></h1>
                <p class="hero-subtitle">Agricultura, pecuária, mercado agro, sustentabilidade e mundo pet. Informação de qualidade para produtores rurais e profissionais do setor.</p>
                <div class="hero-actions">
                    <a href="#ultimas-noticias" class="btn btn-primary btn-lg">Últimas Notícias</a>
                    <a href="/sobre" class="btn btn-outline btn-lg">Sobre o InfoRagro</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Categorias Principais (Silos) -->
    <section class="section categories-bar">
        <div class="container">
            <div class="categories-scroll">
                @foreach ($categories as $category)
                <a href="{{ url($category->slug) }}" class="category-pill" style="--cat-color: {{ $category->color ?? '#5F7D4E' }}">
                    <span class="category-icon">{{ $category->icon ?? '📰' }}</span>
                    <span class="category-name">{{ $category->name }}</span>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Artigos em Destaque -->
    <section class="section featured-posts" id="ultimas-noticias">
        <div class="container">
            <header class="section-header">
                <h2 class="section-title">Destaques</h2>
                <p class="section-subtitle">As notícias mais importantes do agronegócio</p>
            </header>
            
            <div class="posts-grid posts-grid-featured">
                @foreach ($featuredPosts->take(3) as $index => $post)
                <x-post-card :post="$post" :large="$index === 0" />
                @endforeach
            </div>
        </div>
    </section>

    <!-- Últimas Notícias -->
    <section class="section latest-posts">
        <div class="container">
            <header class="section-header">
                <h2 class="section-title">Últimas Publicações</h2>
                <a href="{{ url('agricultura-e-pecuaria') }}" class="section-link">Ver todas →</a>
            </header>
            
            <div class="posts-grid">
                @foreach ($latestPosts as $post)
                <x-post-card :post="$post" />
                @endforeach
            </div>
            
            <div class="section-cta">
                <a href="{{ url('agricultura-e-pecuaria') }}" class="btn btn-outline">Carregar Mais Artigos</a>
            </div>
        </div>
    </section>

    <!-- Newsletter CTA -->
    <section class="section newsletter-section">
        <div class="container">
            <div class="newsletter-box">
                <div class="newsletter-content">
                    <span class="newsletter-icon">📧</span>
                    <h2>Receba as Notícias do Agro</h2>
                    <p>Assine nossa newsletter e receba as principais notícias do agronegócio diretamente no seu e-mail. Sem spam, apenas conteúdo relevante.</p>
                </div>
                <form class="newsletter-form-inline" action="{{ url('/newsletter') }}" method="POST">
                    @csrf
                    <input type="email" name="email" placeholder="Digite seu melhor e-mail" required>
                    <button type="submit" class="btn btn-primary">Inscrever-se Grátis</button>
                </form>
            </div>
        </div>
    </section>
</x-layout>
