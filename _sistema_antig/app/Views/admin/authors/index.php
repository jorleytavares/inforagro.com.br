<!-- Lista de Autores -->
<?php if (!empty($_GET['success'])): ?>
<div class="alert alert-success">
    <?php if ($_GET['success'] === 'created'): ?>Autor criado com sucesso!
    <?php elseif ($_GET['success'] === 'updated'): ?>Autor atualizado com sucesso!
    <?php endif; ?>
</div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">Autores</h2>
        <a href="/admin/authors/create" class="btn btn-primary">+ Novo Autor</a>
    </div>
    
    <?php if (!empty($authors)): ?>
    <table class="table">
        <thead>
            <tr>
                <th>Avatar</th>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Posts</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($authors as $author): ?>
            <tr>
                <td>
                    <?php if (!empty($author['avatar'])): ?>
                    <img src="<?= htmlspecialchars($author['avatar']) ?>" alt="" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                    <?php else: ?>
                    <div style="width: 40px; height: 40px; border-radius: 50%; background: var(--admin-primary); color: white; display: flex; align-items: center; justify-content: center; font-weight: 600;">
                        <?= strtoupper(substr($author['name'], 0, 1)) ?>
                    </div>
                    <?php endif; ?>
                </td>
                <td><strong><?= htmlspecialchars($author['name']) ?></strong></td>
                <td><?= htmlspecialchars($author['email'] ?? '-') ?></td>
                <td><?= $author['post_count'] ?? 0 ?></td>
                <td>
                    <?php if ($author['is_active']): ?>
                        <span class="badge badge-success">Ativo</span>
                    <?php else: ?>
                        <span class="badge badge-secondary">Inativo</span>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="/admin/authors/<?= $author['id'] ?>/edit" class="btn btn-secondary btn-sm">Editar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
    <div class="empty-state">
        <p>Nenhum autor cadastrado.</p>
        <a href="/admin/authors/create" class="btn btn-primary">Criar Autor</a>
    </div>
    <?php endif; ?>
</div>
