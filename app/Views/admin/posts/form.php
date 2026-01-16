<?php
// Garantir variáveis padrão
$isEdit = $isEdit ?? false;
$post = $post ?? [];
$id = $post['id'] ?? null;
?>

<!-- Layout Container -->
<div class="row">
    <div class="col-md-12">
        <h2 class="mb-4"><?= $isEdit ? 'Editar Post' : 'Criar Novo Post' ?></h2>
        
        <form action="<?= $isEdit ? "/admin/posts/{$id}/update" : "/admin/posts/store" ?>" method="POST" id="postForm">
            <?= $csrfField ?? '' ?>
            
            <div class="row">
                <!-- Coluna Principal -->
                <div class="col-lg-9">
                    
                    <!-- Card Título e Conteúdo -->
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <!-- Título -->
                            <div class="mb-3">
                                <label for="title" class="form-label fw-bold">Título</label>
                                <input type="text" class="form-control form-control-lg" id="title" name="title" 
                                       value="<?= htmlspecialchars($post['title'] ?? '') ?>" required 
                                       placeholder="Digite o título do artigo aqui...">
                            </div>

                            <!-- Slug Hidden -->
                            <input type="hidden" id="slug" name="slug" value="<?= htmlspecialchars($post['slug'] ?? '') ?>">
                            
                            <!-- Subtítulo -->
                            <div class="mb-3">
                                <label for="subtitle" class="form-label">Subtítulo</label>
                                <input type="text" class="form-control" id="subtitle" name="subtitle" 
                                       value="<?= htmlspecialchars($post['subtitle'] ?? '') ?>" 
                                       placeholder="Um gancho curto para o artigo (opcional)">
                            </div>
                            
                            <!-- Editor Quill -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Conteúdo</label>
                                
                                <!-- Toolbar container será gerado automaticamente pelo Quill -->
                                <div id="editor" style="height: 500px; background: white;"></div>
                                <input type="hidden" name="content" id="content">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Card SEO / Schema -->
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-light">
                            <h5 class="card-title mb-0">Configurações de SEO</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="meta_title" class="form-label">Meta Title (Opcional)</label>
                                <input type="text" class="form-control" id="meta_title" name="meta_title" 
                                       value="<?= htmlspecialchars($post['meta_title'] ?? '') ?>" maxlength="60">
                                <div class="form-text">Deixe em branco para usar o título do post.</div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="meta_description" class="form-label">Meta Description</label>
                                <textarea class="form-control" id="meta_description" name="meta_description" rows="2" maxlength="160"><?= htmlspecialchars($post['meta_description'] ?? '') ?></textarea>
                            </div>

                            <hr>
                            
                            <div class="mb-3">
                                <label for="custom_schema" class="form-label">Schema JSON-LD Adicional</label>
                                <textarea class="form-control font-monospace config-code" id="custom_schema" name="custom_schema" rows="5" 
                                          style="font-size: 13px; color: #d63384; background: #f8f9fa;"
                                          placeholder='<script type="application/ld+json">...</script>'><?= htmlspecialchars($post['custom_schema'] ?? '') ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Coluna Lateral -->
                <div class="col-lg-3">
                    
                    <!-- Card Publicar -->
                    <div class="card mb-3 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0">Publicação</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="draft" <?= ($post['status'] ?? '') === 'draft' ? 'selected' : '' ?>>Rascunho</option>
                                    <option value="published" <?= ($post['status'] ?? '') === 'published' ? 'selected' : '' ?>>Publicado</option>
                                    <option value="pending" <?= ($post['status'] ?? '') === 'pending' ? 'selected' : '' ?>>Pendente</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Autor</label>
                                <select name="author_id" class="form-select">
                                    <?php foreach ($authors as $author): ?>
                                    <option value="<?= $author['id'] ?>" <?= ($post['author_id'] ?? 1) == $author['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($author['name']) ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Atualizar' : 'Publicar' ?></button>
                                <?php if($isEdit): ?>
                                <a href="/admin/posts" class="btn btn-outline-secondary">Cancelar</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Card Categorias -->
                    <div class="card mb-3 shadow-sm">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Categoria</h6>
                        </div>
                        <div class="card-body category-list-scroll" style="max-height: 200px; overflow-y: auto;">
                            <?php foreach ($categories as $cat): ?>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="category_id" id="cat_<?= $cat['id'] ?>" value="<?= $cat['id'] ?>" 
                                    <?= ($post['category_id'] ?? '') == $cat['id'] ? 'checked' : '' ?> required>
                                <label class="form-check-label" for="cat_<?= $cat['id'] ?>">
                                    <?= htmlspecialchars($cat['name']) ?>
                                </label>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Card Imagem Destacada -->
                    <div class="card mb-3 shadow-sm">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Imagem de Capa</h6>
                        </div>
                        <div class="card-body text-center">
                            <div class="mb-2 img-preview-container" style="background: #e9ecef; min-height: 120px; border-radius: 4px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                                <img id="preview-image" src="<?= htmlspecialchars($post['featured_image'] ?? '') ?>" 
                                     style="max-width: 100%; display: <?= empty($post['featured_image']) ? 'none' : 'block' ?>;">
                                <span class="text-muted small" id="preview-placeholder" style="display: <?= empty($post['featured_image']) ? 'block' : 'none' ?>;">Sem imagem</span>
                            </div>
                            
                            <input type="hidden" name="featured_image" id="featured_image" value="<?= htmlspecialchars($post['featured_image'] ?? '') ?>">
                            
                            <div class="btn-group w-100 btn-group-sm">
                                <button type="button" class="btn btn-outline-primary" onclick="openMediaPicker()">Selecionar</button>
                                <button type="button" class="btn btn-outline-danger" onclick="clearImage()">Remover</button>
                            </div>
                            
                            <div class="mt-2">
                                <input type="text" name="featured_image_caption" class="form-control form-control-sm" placeholder="Legenda da foto" value="<?= htmlspecialchars($post['featured_image_caption'] ?? '') ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Scripts Essenciais (Local Assets to bypass CSP) -->
<link href="/assets/css/quill.snow.css" rel="stylesheet">
<script src="/assets/js/quill.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Configurar Quill
    var quill = new Quill('#editor', {
        theme: 'snow',
        placeholder: 'Escreva seu texto aqui...',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                ['blockquote', 'code-block'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'color': [] }, { 'background': [] }],
                ['link', 'image', 'video'],
                ['clean']
            ]
        }
    });

    // 2. Carregar Conteúdo Seguro
    var initialContent = <?= json_encode($post['content'] ?? '') ?>;
    if (initialContent) {
        quill.root.innerHTML = initialContent;
    }

    // 3. Sync no Submit
    var form = document.getElementById('postForm');
    form.onsubmit = function() {
        var content = document.querySelector('input[name=content]');
        content.value = quill.root.innerHTML;
    };

    // 4. Slug Generator
    var title = document.getElementById('title');
    var slug = document.getElementById('slug');
    if(title) {
        title.addEventListener('blur', function() {
            if(!slug.value) {
                slug.value = this.value.toLowerCase()
                    .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/^-+|-+$/g, '');
            }
        });
    }

    // 5. Media Picker (Callback)
    window.openMediaPicker = function() {
        window.open('/admin/media?picker=1', 'media_picker', 'width=800,height=600');
    }
    
    window.selectMedia = function(url) {
        document.getElementById('featured_image').value = url;
        document.getElementById('preview-image').src = url;
        document.getElementById('preview-image').style.display = 'block';
        document.getElementById('preview-placeholder').style.display = 'none';
    }

    window.clearImage = function() {
        document.getElementById('featured_image').value = '';
        document.getElementById('preview-image').src = '';
        document.getElementById('preview-image').style.display = 'none';
        document.getElementById('preview-placeholder').style.display = 'block';
    }
});
</script>
