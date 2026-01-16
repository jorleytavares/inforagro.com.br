<!-- Lista de Posts -->
<?php if (!empty($_GET['success'])): ?>
<div class="alert alert-success">
    <?php if ($_GET['success'] === 'created'): ?>Post criado com sucesso!
    <?php elseif ($_GET['success'] === 'updated'): ?>Post atualizado com sucesso!
    <?php elseif ($_GET['success'] === 'deleted'): ?>Post excluído com sucesso!
    <?php endif; ?>
</div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">Todos os Posts</h2>
        <a href="/admin/posts/create" class="btn btn-primary">+ Novo Post</a>
    </div>
    
    <!-- Filtros -->
    <div style="padding: 1rem 1.5rem; border-bottom: 1px solid var(--admin-border); background: var(--admin-bg);">
        <form method="GET" action="/admin/posts" style="display: flex; gap: 1rem; align-items: center; flex-wrap: wrap;">
            <input type="text" name="search" class="form-control" placeholder="Buscar por título..." 
                   value="<?= htmlspecialchars($filters['search'] ?? '') ?>" style="width: 220px;">
            
            <select name="status" class="form-control" style="width: 200px;">
                <option value="">Todos os Status</option>
                <option value="published" <?= ($filters['status'] ?? '') === 'published' ? 'selected' : '' ?>>Publicados</option>
                <option value="draft" <?= ($filters['status'] ?? '') === 'draft' ? 'selected' : '' ?>>Rascunhos</option>
            </select>
            
            <select name="category" class="form-control" style="width: 200px;">
                <option value="">Todas Categorias</option>
                <?php foreach ($categories ?? [] as $cat): ?>
                <option value="<?= $cat['id'] ?>" <?= ($filters['category'] ?? '') == $cat['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat['name']) ?>
                </option>
                <?php endforeach; ?>
            </select>
            
            <button type="submit" class="btn btn-secondary">Filtrar</button>
            
            <?php if (!empty($filters['search']) || !empty($filters['status']) || !empty($filters['category'])): ?>
            <a href="/admin/posts" class="btn btn-link" style="color: var(--admin-text-muted);">Limpar</a>
            <?php endif; ?>
            
            <span style="margin-left: auto; font-size: 0.875rem; color: var(--admin-text-muted);">
                <?= count($posts) ?> post(s)
            </span>
        </form>
    </div>
    
    <?php if (!empty($posts)): ?>
    <table class="table">
        <thead>
            <tr>
                <th style="width: 60px;">Img</th>
                <th>Título</th>
                <th>Categoria</th>
                <th>Autor</th>
                <th>Status</th>
                <th>Views</th>
                <th>Data</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($posts as $post): ?>
            <tr>
                <td>
                    <?php if (!empty($post['featured_image'])): ?>
                        <img src="<?= htmlspecialchars($post['featured_image']) ?>" style="width: 50px; height: 36px; object-fit: cover; border-radius: 4px;" loading="lazy">
                    <?php else: ?>
                        <div style="width: 50px; height: 36px; background: #e2e8f0; border-radius: 4px;"></div>
                    <?php endif; ?>
                </td>
                <td>
                    <strong><?= htmlspecialchars(mb_substr($post['title'], 0, 50)) ?><?= mb_strlen($post['title']) > 50 ? '...' : '' ?></strong>
                </td>
                <td><?= htmlspecialchars($post['category_name'] ?? '-') ?></td>
                <td><?= htmlspecialchars($post['author_name'] ?? '-') ?></td>
                <td>
                    <?php if ($post['status'] === 'published'): ?>
                        <span class="badge badge-success">Publicado</span>
                    <?php elseif ($post['status'] === 'draft'): ?>
                        <span class="badge badge-secondary">Rascunho</span>
                    <?php else: ?>
                        <span class="badge badge-warning"><?= ucfirst($post['status']) ?></span>
                    <?php endif; ?>
                </td>
                <td><?= number_format($post['views'] ?? 0) ?></td>
                <td><?= date('d/m/Y', strtotime($post['created_at'])) ?></td>
                <td>
                    <a href="/admin/posts/<?= $post['id'] ?>/edit" class="btn btn-secondary btn-sm">Editar</a>
                    <form action="/admin/posts/<?= $post['id'] ?>/delete" method="POST" style="display:inline" onsubmit="return confirm('Excluir este post?')">
                        <?= $csrfField ?? '<input type="hidden" name="_csrf" value="'.($_SESSION['csrf_token'] ?? '').'">' ?>
                        <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
    <div class="empty-state">
        <p>Nenhum post cadastrado.</p>
        <a href="/admin/posts/create" class="btn btn-primary">Criar Primeiro Post</a>
    </div>
    <?php endif; ?>
</div>
