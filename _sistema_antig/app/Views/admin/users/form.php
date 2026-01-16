<!-- Formulário de Usuário -->
<?php if (!empty($_GET['error'])): ?>
<div class="alert alert-error"><?= htmlspecialchars($_GET['error']) ?></div>
<?php endif; ?>

<form action="<?= $isEdit ? '/admin/users/' . $user['id'] . '/update' : '/admin/users/store' ?>" method="POST" enctype="multipart/form-data">
    <?= $csrfField ?? '' ?>
    <div class="card">
        <div class="card-header">
            <h2 class="card-title"><?= $isEdit ? 'Editar Usuário' : 'Novo Usuário' ?></h2>
        </div>
        
        <div style="padding: 1.5rem;">
            <!-- Avatar -->
            <div class="form-group" style="margin-bottom: 2rem;">
                <label class="form-label">Avatar</label>
                <div style="display: flex; align-items: center; gap: 1.5rem;">
                    <div id="avatar-preview" style="width: 100px; height: 100px; border-radius: 50%; background: var(--admin-border); display: flex; align-items: center; justify-content: center; overflow: hidden;">
                        <?php if (!empty($user['avatar'])): ?>
                            <img src="<?= htmlspecialchars($user['avatar']) ?>" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover;">
                        <?php else: ?>
                            <span style="font-size: 2.5rem;">👤</span>
                        <?php endif; ?>
                    </div>
                    <div>
                        <input type="file" id="avatar" name="avatar" accept="image/*" class="form-control" style="max-width: 300px;">
                        <small class="text-muted" style="display: block; margin-top: 0.5rem;">JPG, PNG ou GIF. Máx 2MB.</small>
                        <?php if (!empty($user['avatar'])): ?>
                        <input type="hidden" name="current_avatar" value="<?= htmlspecialchars($user['avatar']) ?>">
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <!-- Nome -->
                <div class="form-group">
                    <label class="form-label" for="name">Nome *</label>
                    <input type="text" id="name" name="name" class="form-control" 
                           value="<?= htmlspecialchars($user['name'] ?? '') ?>" required>
                </div>
                
                <!-- E-mail -->
                <div class="form-group">
                    <label class="form-label" for="email">E-mail *</label>
                    <input type="email" id="email" name="email" class="form-control" 
                           value="<?= htmlspecialchars($user['email'] ?? '') ?>" required>
                </div>
            </div>
            
            <div class="form-row">
                <!-- Senha -->
                <div class="form-group">
                    <label class="form-label" for="password">
                        Senha <?= $isEdit ? '<small class="text-muted">(deixe vazio para manter)</small>' : '*' ?>
                    </label>
                    <input type="password" id="password" name="password" class="form-control" 
                           <?= $isEdit ? '' : 'required' ?> minlength="6">
                </div>
                
                <!-- Função -->
                <div class="form-group">
                    <label class="form-label" for="role">Função *</label>
                    <select id="role" name="role" class="form-control" required>
                        <?php foreach ($roles as $value => $label): ?>
                        <option value="<?= $value ?>" <?= ($user['role'] ?? 'editor') === $value ? 'selected' : '' ?>>
                            <?= htmlspecialchars($label) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Salvar Alterações' : 'Criar Usuário' ?></button>
                <a href="/admin/users" class="btn btn-secondary">Cancelar</a>
            </div>
        </div>
    </div>
</form>

<script>
document.getElementById('avatar').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file && file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('avatar-preview');
            preview.innerHTML = '<img src="' + e.target.result + '" alt="Preview" style="width: 100%; height: 100%; object-fit: cover;">';
        };
        reader.readAsDataURL(file);
    }
});
</script>
