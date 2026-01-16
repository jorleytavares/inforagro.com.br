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
            <?php foreach ($categories as $category): ?>
            <a href="/<?= htmlspecialchars($category['slug']) ?>" class="category-pill" style="--cat-color: <?= $category['color'] ?? '#5F7D4E' ?>">
                <span class="category-icon"><?= $category['icon'] ?? '📰' ?></span>
                <span class="category-name"><?= htmlspecialchars($category['name']) ?></span>
            </a>
            <?php endforeach; ?>
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
            <?php foreach (array_slice($featuredPosts, 0, 3) as $index => $post): ?>
            <article class="post-card <?= $index === 0 ? 'post-card-large' : '' ?>">
                <div class="post-card-image">
                    <span class="post-category"><?= htmlspecialchars($post['category_name']) ?></span>
                    <?php if ($post['featured_image']): ?>
                    <img src="<?= htmlspecialchars($post['featured_image']) ?>" alt="<?= htmlspecialchars($post['title']) ?>" loading="lazy">
                    <?php else: ?>
                    <div class="post-image-placeholder">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <rect x="3" y="3" width="18" height="18" rx="2"/>
                            <circle cx="8.5" cy="8.5" r="1.5"/>
                            <path d="M21 15l-5-5L5 21"/>
                        </svg>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="post-card-content">
                    <h3 class="post-title">
                        <a href="/<?= htmlspecialchars($post['category_slug']) ?>/<?= htmlspecialchars($post['slug']) ?>">
                            <?= htmlspecialchars($post['title']) ?>
                        </a>
                    </h3>
                    <p class="post-excerpt"><?= htmlspecialchars($post['excerpt']) ?></p>
                    <div class="post-meta">
                        <span class="post-date"><?= date('d/m/Y', strtotime($post['published_at'])) ?></span>
                        <span class="post-read-time"><?= $post['read_time'] ?> min de leitura</span>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Últimas Notícias -->
<section class="section latest-posts">
    <div class="container">
        <header class="section-header">
            <h2 class="section-title">Últimas Publicações</h2>
            <a href="/agricultura-e-pecuaria" class="section-link">Ver todas →</a>
        </header>
        
        <div class="posts-grid">
            <?php foreach (array_slice($latestPosts, 0, 6) as $post): ?>
            <article class="post-card">
                <div class="post-card-image">
                    <span class="post-category"><?= htmlspecialchars($post['category_name']) ?></span>
                    <div class="post-image-placeholder">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <rect x="3" y="3" width="18" height="18" rx="2"/>
                            <circle cx="8.5" cy="8.5" r="1.5"/>
                            <path d="M21 15l-5-5L5 21"/>
                        </svg>
                    </div>
                </div>
                <div class="post-card-content">
                    <h3 class="post-title">
                        <a href="/<?= htmlspecialchars($post['category_slug']) ?>/<?= htmlspecialchars($post['slug']) ?>">
                            <?= htmlspecialchars($post['title']) ?>
                        </a>
                    </h3>
                    <p class="post-excerpt"><?= htmlspecialchars($post['excerpt']) ?></p>
                    <div class="post-meta">
                        <span class="post-author"><?= htmlspecialchars($post['author_name']) ?></span>
                        <span class="post-date"><?= date('d M', strtotime($post['published_at'])) ?></span>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
        
        <div class="section-cta">
            <a href="/agricultura-e-pecuaria" class="btn btn-outline">Carregar Mais Artigos</a>
        </div>
    </div>
</section>

<!-- Seções por Categoria -->
<section class="section category-highlights">
    <div class="container">
        <div class="category-grid">
            <?php foreach ($categories as $cat): ?>
            <div class="category-block">
                <header class="category-block-header">
                    <h3>
                        <span class="cat-icon"><?= $cat['icon'] ?? '📰' ?></span>
                        <?= htmlspecialchars($cat['name']) ?>
                    </h3>
                    <a href="/<?= htmlspecialchars($cat['slug']) ?>" class="category-link">Ver todos →</a>
                </header>
                <ul class="category-posts-list">
                    <li><a href="#">Últimas notícias de <?= htmlspecialchars($cat['name']) ?></a></li>
                </ul>
            </div>
            <?php endforeach; ?>
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
            <form class="newsletter-form-inline" action="/newsletter" method="POST">
                <input type="email" name="email" placeholder="Digite seu melhor e-mail" required>
                <button type="submit" class="btn btn-primary">Inscrever-se Grátis</button>
            </form>
        </div>
    </div>
</section>
