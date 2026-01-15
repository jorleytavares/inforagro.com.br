<!-- Página de Tag -->
<section class="category-header">
    <div class="container">
        <!-- Breadcrumbs -->
        <nav class="breadcrumb-nav" aria-label="Breadcrumb">
            <ol class="breadcrumb">
                <?php foreach ($breadcrumbs as $i => $crumb): ?>
                    <li class="breadcrumb-item">
                        <?php if ($i < count($breadcrumbs) - 1): ?>
                            <a href="<?= htmlspecialchars($crumb['url']) ?>"><?= htmlspecialchars($crumb['name']) ?></a>
                        <?php else: ?>
                            <span aria-current="page"><?= htmlspecialchars($crumb['name']) ?></span>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ol>
        </nav>
        
        <div class="tag-header">
            <span class="tag-icon">🏷️</span>
            <div>
                <h1 class="category-title"><?= htmlspecialchars($tag['name']) ?></h1>
                <p class="category-description">Artigos marcados com "<?= htmlspecialchars($tag['name']) ?>"</p>
            </div>
        </div>
    </div>
</section>

<section class="posts-section">
    <div class="container">
        <?php if (!empty($posts)): ?>
        <div class="posts-grid">
            <?php foreach ($posts as $post): ?>
            <article class="card-post">
                <?php if (!empty($post['featured_image'])): ?>
                <a href="/<?= htmlspecialchars($post['category_slug'] ?? 'artigos') ?>/<?= htmlspecialchars($post['slug']) ?>" class="card-post-image">
                    <img src="<?= htmlspecialchars($post['featured_image']) ?>" alt="<?= htmlspecialchars($post['title']) ?>" loading="lazy">
                </a>
                <?php endif; ?>
                <div class="card-post-content">
                    <span class="card-post-category"><?= htmlspecialchars($post['category_name'] ?? 'Artigo') ?></span>
                    <h3 class="card-post-title">
                        <a href="/<?= htmlspecialchars($post['category_slug'] ?? 'artigos') ?>/<?= htmlspecialchars($post['slug']) ?>">
                            <?= htmlspecialchars($post['title']) ?>
                        </a>
                    </h3>
                    <p class="card-post-excerpt"><?= htmlspecialchars($post['excerpt'] ?? '') ?></p>
                    <div class="card-post-meta">
                        <span class="post-author"><?= htmlspecialchars($post['author_name'] ?? 'Redação') ?></span>
                        <span class="post-read-time"><?= $post['read_time'] ?? 5 ?> min</span>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="empty-state">
            <p>Nenhum artigo encontrado com esta tag.</p>
            <a href="/" class="btn btn-primary">Voltar para Início</a>
        </div>
        <?php endif; ?>
    </div>
</section>
