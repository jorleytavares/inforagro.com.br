<!-- Página de Autor -->
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
        
        <div class="author-page-header">
            <div class="author-page-avatar">
                <?php if (!empty($author['avatar'])): ?>
                    <img src="<?= htmlspecialchars($author['avatar']) ?>" alt="<?= htmlspecialchars($author['name']) ?>">
                <?php else: ?>
                    <div class="author-avatar-placeholder-large">
                        <?= strtoupper(substr($author['name'], 0, 1)) ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="author-page-info">
                <h1 class="author-page-name"><?= htmlspecialchars($author['name']) ?></h1>
                <?php if (!empty($author['bio'])): ?>
                    <p class="author-page-bio"><?= htmlspecialchars($author['bio']) ?></p>
                <?php endif; ?>
                <div class="author-socials">
                    <?php if (!empty($author['twitter'])): ?>
                        <a href="https://twitter.com/<?= htmlspecialchars($author['twitter']) ?>" target="_blank" class="social-link">𝕏</a>
                    <?php endif; ?>
                    <?php if (!empty($author['linkedin'])): ?>
                        <a href="<?= htmlspecialchars($author['linkedin']) ?>" target="_blank" class="social-link">in</a>
                    <?php endif; ?>
                    <?php if (!empty($author['website'])): ?>
                        <a href="<?= htmlspecialchars($author['website']) ?>" target="_blank" class="social-link">🌐</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="posts-section">
    <div class="container">
        <h2>Artigos de <?= htmlspecialchars($author['name']) ?></h2>
        
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
                        <span class="post-read-time"><?= $post['read_time'] ?? 5 ?> min de leitura</span>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="empty-state">
            <p>Este autor ainda não publicou artigos.</p>
        </div>
        <?php endif; ?>
    </div>
</section>
