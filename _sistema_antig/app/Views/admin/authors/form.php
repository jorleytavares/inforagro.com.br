<!-- Formulário de Autor -->
<form action="<?= $isEdit ? '/admin/authors/' . $author['id'] . '/update' : '/admin/authors/store' ?>" method="POST" enctype="multipart/form-data">
    <?= $csrfField ?? '' ?>
    <div class="card">
        <div class="card-header">
            <h2 class="card-title"><?= $isEdit ? 'Editar Autor' : 'Novo Autor' ?></h2>
        </div>
        
        <div style="padding: 1.5rem;">
            <!-- Avatar -->
            <div class="form-group" style="margin-bottom: 2rem;">
                <label class="form-label">Avatar</label>
                <div style="display: flex; align-items: center; gap: 1.5rem;">
                    <div id="avatar-preview" style="width: 100px; height: 100px; border-radius: 50%; background: var(--admin-border); display: flex; align-items: center; justify-content: center; overflow: hidden;">
                        <?php if (!empty($author['avatar'])): ?>
                            <img src="<?= htmlspecialchars($author['avatar']) ?>" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover;">
                        <?php else: ?>
                            <span style="font-size: 2.5rem;">👤</span>
                        <?php endif; ?>
                    </div>
                    <div>
                        <input type="file" id="avatar_file" name="avatar_file" accept="image/*" class="form-control" style="max-width: 300px;">
                        <small class="text-muted" style="display: block; margin-top: 0.5rem;">JPG, PNG ou GIF. Máx 2MB.</small>
                        <?php if (!empty($author['avatar'])): ?>
                        <input type="hidden" name="current_avatar" value="<?= htmlspecialchars($author['avatar']) ?>">
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="name">Nome *</label>
                    <input type="text" id="name" name="name" class="form-control" 
                           value="<?= htmlspecialchars($author['name'] ?? '') ?>" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="slug">Slug <small class="text-muted">(deixe vazio para gerar)</small></label>
                    <input type="text" id="slug" name="slug" class="form-control" 
                           value="<?= htmlspecialchars($author['slug'] ?? '') ?>" placeholder="gerado-automaticamente">
                </div>
            </div>
            
            <div class="form-group">
                <label class="form-label" for="email">E-mail</label>
                <input type="email" id="email" name="email" class="form-control" 
                       value="<?= htmlspecialchars($author['email'] ?? '') ?>">
            </div>
            
            <div class="form-group">
                <label class="form-label" for="bio">Biografia</label>
                <textarea id="bio" name="bio" class="form-control" rows="4"><?= htmlspecialchars($author['bio'] ?? '') ?></textarea>
            </div>
            
            <hr style="margin: 2rem 0; border: none; border-top: 1px solid #e2e8f0;">
            
            <h3 style="margin-bottom: 1.5rem; font-size: 1.125rem;">Redes Sociais</h3>
            
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="website">Website</label>
                    <input type="url" id="website" name="website" class="form-control" 
                           value="<?= htmlspecialchars($author['website'] ?? '') ?>">
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="twitter">Twitter/X</label>
                    <input type="text" id="twitter" name="twitter" class="form-control" 
                           value="<?= htmlspecialchars($author['twitter'] ?? '') ?>" placeholder="@usuario">
                </div>
            </div>
            
            <div class="form-group">
                <label class="form-label" for="linkedin">LinkedIn</label>
                <input type="url" id="linkedin" name="linkedin" class="form-control" 
                       value="<?= htmlspecialchars($author['linkedin'] ?? '') ?>">
            </div>
            
            <div class="form-group">
                <label>
                    <input type="checkbox" name="is_active" value="1" 
                           <?= ($author['is_active'] ?? true) ? 'checked' : '' ?>>
                    Autor ativo
                </label>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Salvar' : 'Criar Autor' ?></button>
                <a href="/admin/authors" class="btn btn-secondary">Cancelar</a>
            </div>
        </div>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');
    
    function slugify(text) {
        return text.toString().toLowerCase()
            .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
            .replace(/\s+/g, '-')
            .replace(/[^\w\-]+/g, '')
            .replace(/\-\-+/g, '-')
            .replace(/^-+/, '')
            .replace(/-+$/, '');
    }

    nameInput.addEventListener('input', function() {
        if (!slugInput.value) {
            slugInput.value = slugify(this.value);
        }
    });

    // Preview do avatar
    document.getElementById('avatar_file').addEventListener('change', function(e) {
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
});
</script>
