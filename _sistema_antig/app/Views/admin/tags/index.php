<!-- Lista de Tags -->
<?php if (!empty($_GET['success'])): ?>
<div class="alert alert-success">
    <?php if ($_GET['success'] === 'created'): ?>Tag criada com sucesso!
    <?php elseif ($_GET['success'] === 'updated'): ?>Tag atualizada com sucesso!
    <?php elseif ($_GET['success'] === 'deleted'): ?>Tag excluída com sucesso!
    <?php endif; ?>
</div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">Tags</h2>
        <a href="/admin/tags/create" class="btn btn-primary">+ Nova Tag</a>
    </div>
    
    <?php if (!empty($tags)): ?>
    <table class="table">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Slug</th>
                <th>Posts</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tags as $tag): ?>
            <tr>
                <td><strong><?= htmlspecialchars($tag['name']) ?></strong></td>
                <td><code><?= htmlspecialchars($tag['slug']) ?></code></td>
                <td><?= $tag['post_count'] ?? 0 ?></td>
                <td>
                    <a href="/admin/tags/<?= $tag['id'] ?>/edit" class="btn btn-secondary btn-sm">Editar</a>
                    <form action="/admin/tags/<?= $tag['id'] ?>/delete" method="POST" style="display:inline" onsubmit="return confirm('Excluir esta tag?')">
                        <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
    <div class="empty-state">
        <p>Nenhuma tag cadastrada.</p>
        <a href="/admin/tags/create" class="btn btn-primary">Criar Tag</a>
    </div>
    <?php endif; ?>
</div>
