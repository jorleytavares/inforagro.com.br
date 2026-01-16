<!-- Formulário de Categoria -->
<form action="<?= $isEdit ? '/admin/categories/' . $category['id'] . '/update' : '/admin/categories/store' ?>" method="POST">
    <?= $csrfField ?? '' ?>
    <div class="card">
        <div class="card-header">
            <h2 class="card-title"><?= $isEdit ? 'Editar Categoria' : 'Nova Categoria' ?></h2>
        </div>
        
        <div style="padding: 1.5rem;">
            <div class="form-row">
                <!-- Nome -->
                <div class="form-group">
                    <label class="form-label" for="name">Nome *</label>
                    <input type="text" id="name" name="name" class="form-control" 
                           value="<?= htmlspecialchars($category['name'] ?? '') ?>" required>
                </div>
                
                <!-- Slug -->
                <div class="form-group">
                    <label class="form-label" for="slug">Slug <small class="text-muted" style="font-weight: normal;">(Deixe vazio para gerar automaticamente)</small></label>
                    <input type="text" id="slug" name="slug" class="form-control" 
                           value="<?= htmlspecialchars($category['slug'] ?? '') ?>" placeholder="gerado-automaticamente">
                </div>
            </div>
            
            <!-- Categoria Pai -->
            <div class="form-group">
                <label class="form-label" for="parent_id">Categoria Pai (se subcategoria)</label>
                <select id="parent_id" name="parent_id" class="form-control">
                    <option value="">Nenhuma (categoria principal)</option>
                    <?php foreach ($parentCategories as $parent): ?>
                    <option value="<?= $parent['id'] ?>" <?= ($category['parent_id'] ?? '') == $parent['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($parent['name']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <!-- Descrição -->
            <div class="form-group">
                <label class="form-label" for="description">Descrição</label>
                <textarea id="description" name="description" class="form-control" rows="3"><?= htmlspecialchars($category['description'] ?? '') ?></textarea>
            </div>
            
            <div class="form-row">
                <!-- Ícone -->
                <div class="form-group">
                    <label class="form-label" for="icon">Ícone (Emoji)</label>
                    <input type="text" id="icon" name="icon" class="form-control" 
                           value="<?= htmlspecialchars($category['icon'] ?? '') ?>" 
                           placeholder="🌾">
                </div>
                
                <!-- Cor -->
                <div class="form-group">
                    <label class="form-label" for="color">Cor</label>
                    <input type="color" id="color" name="color" class="form-control" 
                           value="<?= htmlspecialchars($category['color'] ?? '#5F7D4E') ?>" 
                           style="height: 42px; padding: 0.25rem;">
                </div>
            </div>
            
            <hr style="margin: 2rem 0; border: none; border-top: 1px solid #e2e8f0;">
            
            <h3 style="margin-bottom: 1.5rem; font-size: 1.125rem;">SEO</h3>
            
            <div class="form-group">
                <label class="form-label" for="meta_title">Meta Title</label>
                <input type="text" id="meta_title" name="meta_title" class="form-control" 
                       value="<?= htmlspecialchars($category['meta_title'] ?? '') ?>" maxlength="60">
            </div>
            
            <div class="form-group">
                <label class="form-label" for="meta_description">Meta Description</label>
                <textarea id="meta_description" name="meta_description" class="form-control" rows="2" 
                          maxlength="160"><?= htmlspecialchars($category['meta_description'] ?? '') ?></textarea>
            </div>
            
            <div class="form-row">
                <!-- Ordem -->
                <div class="form-group">
                    <label class="form-label" for="sort_order">Ordem de Exibição</label>
                    <input type="number" id="sort_order" name="sort_order" class="form-control" 
                           value="<?= $category['sort_order'] ?? 0 ?>">
                </div>
                
                <!-- Ativo -->
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <div style="padding-top: 0.5rem;">
                        <label>
                            <input type="checkbox" name="is_active" value="1" 
                                   <?= ($category['is_active'] ?? true) ? 'checked' : '' ?>>
                            Categoria ativa
                        </label>
                    </div>
                </div>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Salvar Alterações' : 'Criar Categoria' ?></button>
                <a href="/admin/categories" class="btn btn-secondary">Cancelar</a>
            </div>
        </div>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');
    
    // Função para converter texto em slug
    function slugify(text) {
        return text.toString().toLowerCase()
            .normalize('NFD').replace(/[\u0300-\u036f]/g, '') // Remove acentos
            .replace(/\s+/g, '-')           // Substitui espaços por -
            .replace(/[^\w\-]+/g, '')       // Remove caracteres especiais
            .replace(/\-\-+/g, '-')         // Remove hifens duplicados
            .replace(/^-+/, '')             // Remove hifen do início
            .replace(/-+$/, '');            // Remove hifen do final
    }

    // Gerar slug ao digitar nome
    nameInput.addEventListener('input', function() {
        // Apenas se o slug estiver vazio ou se o usuário não tiver editado manualmente
        // Vamos usar a regra: se slug vazio, preenche.
        if (!slugInput.value) {
            slugInput.value = slugify(this.value);
        }
    });

    // Permitir regenerar slug clicando duas vezes no label ou input
    slugInput.addEventListener('dblclick', function() {
        this.value = slugify(nameInput.value);
    });
});
</script>
