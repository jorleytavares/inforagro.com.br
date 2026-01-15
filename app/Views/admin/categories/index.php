<!-- Lista de Categorias -->
<?php if (!empty($_GET['success'])): ?>
<div class="alert alert-success">
    <?php if ($_GET['success'] === 'created'): ?>Categoria criada com sucesso!
    <?php elseif ($_GET['success'] === 'updated'): ?>Categoria atualizada com sucesso!
    <?php endif; ?>
</div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">Todas as Categorias</h2>
        <a href="/admin/categories/create" class="btn btn-primary">+ Nova Categoria</a>
    </div>
    
    <?php if (!empty($categories)): ?>
    <table class="table">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Slug</th>
                <th>Pai</th>
                <th>Posts</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $cat): ?>
            <tr>
                <td>
                    <?php if (!empty($cat['icon'])): ?>
                    <span style="margin-right: 0.5rem;"><?= $cat['icon'] ?></span>
                    <?php endif; ?>
                    <strong><?= htmlspecialchars($cat['name']) ?></strong>
                </td>
                <td><code><?= htmlspecialchars($cat['slug']) ?></code></td>
                <td><?= htmlspecialchars($cat['parent_name'] ?? '-') ?></td>
                <td><?= $cat['post_count'] ?? 0 ?></td>
                <td>
                    <?php if ($cat['is_active']): ?>
                        <span class="badge badge-success">Ativo</span>
                    <?php else: ?>
                        <span class="badge badge-secondary">Inativo</span>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="/admin/categories/<?= $cat['id'] ?>/edit" class="btn btn-secondary btn-sm">Editar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
    <div class="empty-state">
        <p>Nenhuma categoria cadastrada.</p>
        <a href="/admin/categories/create" class="btn btn-primary">Criar Primeira Categoria</a>
    </div>
    <?php endif; ?>
</div>
