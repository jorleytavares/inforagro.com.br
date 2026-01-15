<!-- Lista de Usuários -->
<?php if (!empty($_GET['success'])): ?>
<div class="alert alert-success">
    <?php if ($_GET['success'] === 'created'): ?>Usuário criado com sucesso!
    <?php elseif ($_GET['success'] === 'updated'): ?>Usuário atualizado com sucesso!
    <?php elseif ($_GET['success'] === 'deleted'): ?>Usuário excluído com sucesso!
    <?php endif; ?>
</div>
<?php endif; ?>

<?php if (!empty($_GET['error'])): ?>
<div class="alert alert-error"><?= htmlspecialchars($_GET['error']) ?></div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">Usuários</h2>
        <a href="/admin/users/create" class="btn btn-primary">+ Novo Usuário</a>
    </div>
    
    <?php if (!empty($users)): ?>
    <table class="table">
        <thead>
            <tr>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Função</th>
                <th>Criado em</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><strong><?= htmlspecialchars($user['name']) ?></strong></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td>
                    <?php 
                    $roleLabels = ['admin' => 'Administrador', 'editor' => 'Editor', 'author' => 'Autor'];
                    $role = $user['role'] ?? 'editor';
                    ?>
                    <span class="badge <?= $role === 'admin' ? 'badge-success' : 'badge-secondary' ?>">
                        <?= $roleLabels[$role] ?? ucfirst($role) ?>
                    </span>
                </td>
                <td><?= date('d/m/Y', strtotime($user['created_at'])) ?></td>
                <td>
                    <a href="/admin/users/<?= $user['id'] ?>/edit" class="btn btn-secondary btn-sm">Editar</a>
                    <?php if (!isset($_SESSION['admin_id']) || $_SESSION['admin_id'] != $user['id']): ?>
                    <form action="/admin/users/<?= $user['id'] ?>/delete" method="POST" style="display:inline" onsubmit="return confirm('Excluir este usuário?')">
                        <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                    </form>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
    <div class="empty-state">
        <p>Nenhum usuário cadastrado.</p>
        <a href="/admin/users/create" class="btn btn-primary">Criar Primeiro Usuário</a>
    </div>
    <?php endif; ?>
</div>
