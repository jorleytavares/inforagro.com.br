<!-- Category Header -->
<section class="category-header">
    <div class="container">
        <div class="category-info">
            <?php if (!empty($category['icon'])): ?>
            <span class="category-icon-large"><?= $category['icon'] ?></span>
            <?php endif; ?>
            <div>
                <h1 class="category-title"><?= htmlspecialchars($category['name']) ?></h1>
                <?php if (!empty($category['description'])): ?>
                <p class="category-description"><?= htmlspecialchars($category['description']) ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Subcategorias -->
<?php if (!empty($subcategories)): ?>
<section class="subcategories-bar">
    <div class="container">
        <div class="subcategories-scroll">
            <a href="/<?= htmlspecialchars($category['slug']) ?>" class="subcategory-pill active">Todos</a>
            <?php foreach ($subcategories as $sub): ?>
            <a href="/<?= htmlspecialchars($sub['slug']) ?>" class="subcategory-pill">
                <?= htmlspecialchars($sub['name']) ?>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Lista de Posts -->
<section class="section category-posts">
    <div class="container">
        <?php if (!empty($posts)): ?>
        <div class="posts-grid">
            <?php foreach ($posts as $post): ?>
            <article class="post-card">
                <div class="post-card-image">
                    <span class="post-category"><?= htmlspecialchars($post['category_name']) ?></span>
                    <?php if (!empty($post['featured_image'])): ?>
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
                    <h2 class="post-title">
                        <a href="/<?= htmlspecialchars($post['category_slug']) ?>/<?= htmlspecialchars($post['slug']) ?>">
                            <?= htmlspecialchars($post['title']) ?>
                        </a>
                    </h2>
                    <p class="post-excerpt"><?= htmlspecialchars($post['excerpt']) ?></p>
                    <div class="post-meta">
                        <span class="post-author"><?= htmlspecialchars($post['author_name'] ?? 'Equipe InfoRagro') ?></span>
                        <span class="post-date"><?= date('d/m/Y', strtotime($post['published_at'])) ?></span>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
        
        <!-- Paginação -->
        <?php if ($pagination['total'] > 1): ?>
        <nav class="pagination" aria-label="Paginação">
            <?php if ($pagination['current'] > 1): ?>
            <a href="?page=<?= $pagination['current'] - 1 ?>" class="pagination-link">&laquo; Anterior</a>
            <?php endif; ?>
            
            <span class="pagination-info">
                Página <?= $pagination['current'] ?> de <?= $pagination['total'] ?>
            </span>
            
            <?php if ($pagination['current'] < $pagination['total']): ?>
            <a href="?page=<?= $pagination['current'] + 1 ?>" class="pagination-link">Próxima &raquo;</a>
            <?php endif; ?>
        </nav>
        <?php endif; ?>
        
        <?php else: ?>
        <div class="empty-state">
            <p>Nenhum artigo encontrado nesta categoria.</p>
            <a href="/" class="btn btn-primary">Voltar para a Home</a>
        </div>
        <?php endif; ?>
    </div>
</section>
