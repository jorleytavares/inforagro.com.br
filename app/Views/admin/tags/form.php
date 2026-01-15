<!-- Formulário de Tag -->
<form action="<?= $isEdit ? '/admin/tags/' . $tag['id'] . '/update' : '/admin/tags/store' ?>" method="POST">
    <?= $csrfField ?? '' ?>
    <div class="card">
        <div class="card-header">
            <h2 class="card-title"><?= $isEdit ? 'Editar Tag' : 'Nova Tag' ?></h2>
        </div>
        
        <div style="padding: 1.5rem;">
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="name">Nome *</label>
                    <input type="text" id="name" name="name" class="form-control" 
                           value="<?= htmlspecialchars($tag['name'] ?? '') ?>" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="slug">Slug</label>
                    <input type="text" id="slug" name="slug" class="form-control" 
                           value="<?= htmlspecialchars($tag['slug'] ?? '') ?>" 
                           placeholder="gerado-automaticamente">
                </div>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Salvar' : 'Criar Tag' ?></button>
                <a href="/admin/tags" class="btn btn-secondary">Cancelar</a>
            </div>
        </div>
    </div>
</form>
