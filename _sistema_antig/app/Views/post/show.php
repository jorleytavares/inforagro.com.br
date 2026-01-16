<!-- Artigo -->
<article class="article" itemscope itemtype="https://schema.org/NewsArticle">
    <!-- Header do Artigo -->
    <header class="article-header">
        <div class="container container-article">
            <div class="article-meta-top">
                <a href="/<?= htmlspecialchars($post['category_slug']) ?>" class="article-category">
                    <?= htmlspecialchars($post['category_name']) ?>
                </a>
                <span class="article-read-time"><?= $post['read_time'] ?? 5 ?> min de leitura</span>
            </div>
            
            <h1 class="article-title" itemprop="headline"><?= htmlspecialchars($post['title']) ?></h1>
            
            <?php if (!empty($post['excerpt'])): ?>
            <p class="article-excerpt" itemprop="description"><?= htmlspecialchars($post['excerpt']) ?></p>
            <?php endif; ?>
            
            <div class="article-author-bar">
                <div class="author-info">
                    <?php if (!empty($post['author_avatar'])): ?>
                    <img src="<?= htmlspecialchars($post['author_avatar']) ?>" alt="<?= htmlspecialchars($post['author_name']) ?>" class="author-avatar">
                    <?php else: ?>
                    <div class="author-avatar-placeholder">
                        <?= strtoupper(substr($post['author_name'] ?? 'E', 0, 1)) ?>
                    </div>
                    <?php endif; ?>
                    <div>
                        <span class="author-name" itemprop="author"><?= htmlspecialchars($post['author_name'] ?? 'Equipe InfoRagro') ?></span>
                        <time class="article-date" datetime="<?= $post['published_at'] ?>" itemprop="datePublished">
                            <?= date('d \d\e F \d\e Y', strtotime($post['published_at'])) ?>
                        </time>
                    </div>
                </div>
                <div class="article-share">
                    <span>Compartilhar:</span>
                    <a href="https://twitter.com/intent/tweet?url=<?= urlencode('https://www.inforagro.com.br/' . $post['category_slug'] . '/' . $post['slug']) ?>&text=<?= urlencode($post['title']) ?>" target="_blank" rel="noopener" class="share-btn" aria-label="Compartilhar no Twitter">
                        𝕏
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode('https://www.inforagro.com.br/' . $post['category_slug'] . '/' . $post['slug']) ?>" target="_blank" rel="noopener" class="share-btn" aria-label="Compartilhar no Facebook">
                        f
                    </a>
                    <a href="https://wa.me/?text=<?= urlencode($post['title'] . ' - https://www.inforagro.com.br/' . $post['category_slug'] . '/' . $post['slug']) ?>" target="_blank" rel="noopener" class="share-btn" aria-label="Compartilhar no WhatsApp">
                        📱
                    </a>
                </div>
            </div>
        </div>
    </header>
    
    <!-- Imagem Principal -->
    <?php if (!empty($post['featured_image'])): ?>
    <figure class="article-featured-image">
        <div class="container container-article">
            <img src="<?= htmlspecialchars($post['featured_image']) ?>" alt="<?= htmlspecialchars($post['featured_image_alt'] ?? $post['title']) ?>" itemprop="image">
            <?php if (!empty($post['featured_image_caption'])): ?>
            <figcaption><?= htmlspecialchars($post['featured_image_caption']) ?></figcaption>
            <?php endif; ?>
        </div>
    </figure>
    <?php endif; ?>
    
    <!-- Conteúdo do Artigo -->
    <div class="article-content" itemprop="articleBody">
        <div class="container container-article">
            <div class="content-body">
                <?= $post['content'] ?? '<p>Conteúdo do artigo em breve.</p>' ?>
            </div>
            
            <!-- Tags -->
            <?php if (!empty($tags)): ?>
            <div class="article-tags">
                <span>Tags:</span>
                <?php foreach ($tags as $tag): ?>
                <a href="/tag/<?= htmlspecialchars($tag['slug']) ?>" class="tag-link"><?= htmlspecialchars($tag['name']) ?></a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Autor Box -->
    <aside class="author-box">
        <div class="container container-article">
            <div class="author-box-inner">
                <?php if (!empty($post['author_avatar'])): ?>
                <img src="<?= htmlspecialchars($post['author_avatar']) ?>" alt="<?= htmlspecialchars($post['author_name']) ?>" class="author-box-avatar">
                <?php else: ?>
                <div class="author-box-avatar-placeholder">
                    <?= strtoupper(substr($post['author_name'] ?? 'E', 0, 1)) ?>
                </div>
                <?php endif; ?>
                <div class="author-box-info">
                    <span class="author-box-label">Escrito por</span>
                    <h3 class="author-box-name"><?= htmlspecialchars($post['author_name'] ?? 'Equipe InfoRagro') ?></h3>
                    <p class="author-box-bio"><?= htmlspecialchars($post['author_bio'] ?? 'Equipe de redação do portal InfoRagro.') ?></p>
                </div>
            </div>
        </div>
    </aside>
</article>

<!-- Posts Relacionados -->
<?php if (!empty($relatedPosts)): ?>
<section class="section related-posts">
    <div class="container">
        <header class="section-header">
            <h2 class="section-title">Artigos Relacionados</h2>
            <a href="/<?= htmlspecialchars($post['category_slug']) ?>" class="section-link">Ver mais →</a>
        </header>
        <div class="posts-grid">
            <?php foreach ($relatedPosts as $related): ?>
            <article class="post-card">
                <div class="post-card-image">
                    <span class="post-category"><?= htmlspecialchars($related['category_name']) ?></span>
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
                        <a href="/<?= htmlspecialchars($related['category_slug']) ?>/<?= htmlspecialchars($related['slug']) ?>">
                            <?= htmlspecialchars($related['title']) ?>
                        </a>
                    </h3>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<script>
    // Incrementar visualizações via AJAX (mantém cache de página funcional)
    (function() {
        if (typeof fetch === 'function') {
            fetch('/api/view', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ post_id: <?= (int)$post['id'] ?> })
            }).catch(function(e) { console.error('Silent track error', e); });
        }
    })();
</script>
