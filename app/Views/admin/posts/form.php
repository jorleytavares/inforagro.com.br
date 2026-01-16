<?php
// Garantir variáveis para evitar erros de undefined
$isEdit = $isEdit ?? false;
$post = $post ?? [];
$categories = $categories ?? [];
$authors = $authors ?? [];
$allTags = $allTags ?? [];
$currentTags = $currentTags ?? [];
?>

<!-- Form Actions -->
<form action="<?= $isEdit ? '/admin/posts/' . $post['id'] . '/update' : '/admin/posts/store' ?>" method="POST" id="postForm">
    <?= $csrfField ?? '' ?>
    
    <div style="display: flex; gap: 24px; align-items: flex-start; flex-wrap: wrap;">
        
        <!-- ========================================== -->
        <!-- COLUNA ESQUERDA (Conteúdo Principal) -->
        <!-- ========================================== -->
        <div style="flex: 1; min-width: 600px;">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h3 mb-0"><?= $isEdit ? 'Editar Post' : 'Novo Post' ?></h2>
            </div>
            
            <!-- Card Principal -->
            <div class="card mb-4">
                <div class="card-body">
                    
                    <!-- Título -->
                    <div class="form-group mb-4">
                        <label class="form-label text-muted small text-uppercase fw-bold">Título</label>
                        <input type="text" id="title" name="title" class="form-control form-control-lg fw-bold" 
                               style="font-size: 1.5rem;"
                               value="<?= htmlspecialchars($post['title'] ?? '') ?>" 
                               placeholder="Digite o título do post aqui..." required>
                    </div>

                    <!-- Subtítulo -->
                    <div class="form-group mb-4">
                        <label class="form-label text-muted small text-uppercase fw-bold">Subtítulo (Opcional)</label>
                        <input type="text" id="subtitle" name="subtitle" class="form-control" 
                               value="<?= htmlspecialchars($post['subtitle'] ?? '') ?>" 
                               placeholder="Um breve subtítulo ou gancho...">
                    </div>

                    <!-- Slug (Automático/Hidden) -->
                    <input type="hidden" id="slug" name="slug" value="<?= htmlspecialchars($post['slug'] ?? '') ?>">

                    <!-- Editor de Conteúdo (Quill) -->
                    <div class="form-group">
                        <label class="form-label text-muted small text-uppercase fw-bold">Conteúdo</label>
                        <!-- Container do Editor -->
                        <div id="editor-container" style="height: 600px; font-family: 'Inter', sans-serif; font-size: 16px; background: white;"></div>
                        <!-- Input Hidden para envio -->
                        <input type="hidden" name="content" id="content">
                    </div>
                    
                </div>
            </div>

            <!-- Card Schema (JSON-LD) -->
            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="card-title h6 mb-0">Schema Markup Customizado (JSON-LD)</h3>
                </div>
                <div class="card-body">
                    <div class="alert alert-info py-2 small">
                        O sistema gera automaticamente o Schema de <b>Article</b>. Use este campo apenas para schemas adicionais (ex: FAQ, Review).
                    </div>
                    <textarea id="custom_schema" name="custom_schema" class="form-control" rows="6" 
                              style="font-family: monospace; font-size: 0.85rem; background: #282c34; color: #abb2bf;"
                              placeholder='<script type="application/ld+json">...</script>'><?= htmlspecialchars($post['custom_schema'] ?? '') ?></textarea>
                </div>
            </div>

        </div>

        <!-- ========================================== -->
        <!-- COLUNA DIREITA (Sidebar) -->
        <!-- ========================================== -->
        <div style="width: 320px; flex-shrink: 0;">
            
            <!-- Card Publicar -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h3 class="card-title h6 mb-0">Publicação</h3>
                </div>
                <div class="card-body">
                    
                    <!-- Status -->
                    <div class="form-group mb-3">
                        <label class="form-label small">Status</label>
                        <select name="status" class="form-control form-select-sm">
                            <option value="draft" <?= ($post['status'] ?? 'draft') === 'draft' ? 'selected' : '' ?>>📝 Rascunho</option>
                            <option value="published" <?= ($post['status'] ?? '') === 'published' ? 'selected' : '' ?>>✅ Publicado</option>
                            <option value="pending" <?= ($post['status'] ?? '') === 'pending' ? 'selected' : '' ?>>⏳ Pendente</option>
                        </select>
                    </div>

                    <!-- Autor -->
                    <div class="form-group mb-4">
                        <label class="form-label small">Autor</label>
                        <select name="author_id" class="form-control form-select-sm">
                            <?php foreach ($authors as $author): ?>
                            <option value="<?= $author['id'] ?>" <?= ($post['author_id'] ?? 1) == $author['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($author['name']) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Botão Ação -->
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary w-100 py-2">
                            <?= $isEdit ? 'Atualizar Post' : 'Publicar Post' ?>
                        </button>
                    </div>
                    
                    <?php if ($isEdit): ?>
                    <div class="text-center mt-3">
                        <a href="/admin/posts" class="text-danger small text-decoration-none">Mover para Lixeira</a>
                    </div>
                    <?php endif; ?>

                </div>
            </div>

            <!-- Card Categorias -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h3 class="card-title h6 mb-0">Categorias</h3>
                </div>
                <div class="card-body">
                    <div class="category-list" style="max-height: 250px; overflow-y: auto; border: 1px solid #e2e8f0; border-radius: 6px; padding: 10px;">
                        <?php foreach ($categories as $cat): ?>
                        <div class="form-check mb-1">
                            <input class="form-check-input" type="radio" name="category_id" id="cat_<?= $cat['id'] ?>" 
                                   value="<?= $cat['id'] ?>" 
                                   <?= ($post['category_id'] ?? '') == $cat['id'] ? 'checked' : '' ?> required>
                            <label class="form-check-label small" for="cat_<?= $cat['id'] ?>">
                                <?= htmlspecialchars($cat['name']) ?>
                            </label>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="mt-3 pt-3 border-top">
                        <label class="form-label small">Tipo de Conteúdo</label>
                        <select name="content_type" class="form-control form-select-sm">
                            <option value="article" <?= ($post['content_type'] ?? '') === 'article' ? 'selected' : '' ?>>📰 Artigo</option>
                            <option value="news" <?= ($post['content_type'] ?? '') === 'news' ? 'selected' : '' ?>>📢 Notícia</option>
                            <option value="pillar" <?= ($post['content_type'] ?? '') === 'pillar' ? 'selected' : '' ?>>📚 Pillar Page</option>
                            <option value="guide" <?= ($post['content_type'] ?? '') === 'guide' ? 'selected' : '' ?>>📖 Guia Completo</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Card Tags -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h3 class="card-title h6 mb-0">Tags</h3>
                </div>
                <div class="card-body">
                    <div id="tags-input-container" style="border: 1px solid #cbd5e1; padding: 5px; border-radius: 6px; min-height: 40px; background: #fff; cursor: text;">
                        <div id="tags-list" style="display: flex; flex-wrap: wrap; gap: 4px; margin-bottom: 4px;"></div>
                        <input type="text" id="tag-input" list="tags-datalist" placeholder="Add tag..." 
                               style="border: none; outline: none; width: 100%; font-size: 0.9rem; background: transparent;">
                    </div>
                    <input type="hidden" name="tags" id="tags-hidden" value="">
                    
                    <datalist id="tags-datalist">
                        <?php foreach($allTags as $t): ?>
                        <option value="<?= htmlspecialchars($t) ?>">
                        <?php endforeach; ?>
                    </datalist>
                    <small class="text-muted d-block mt-2">Pressione Enter ou vírgula para adicionar.</small>
                </div>
            </div>

            <!-- Card Imagem Destacada -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h3 class="card-title h6 mb-0">Imagem Destacada</h3>
                </div>
                <div class="card-body p-0">
                    <div style="background: #f8fafc; min-height: 180px; display: flex; align-items: center; justify-content: center; position: relative; border-bottom: 1px solid #e2e8f0;">
                        
                        <!-- Empty State -->
                        <div id="feat-img-empty" class="text-center p-3" style="<?= !empty($post['featured_image']) ? 'display: none;' : '' ?>">
                            <div class="mb-2" style="font-size: 2rem;">🖼️</div>
                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="openMediaPicker()">
                                Selecionar Imagem
                            </button>
                        </div>

                        <!-- Filled State -->
                        <div id="feat-img-filled" style="width: 100%; <?= empty($post['featured_image']) ? 'display: none;' : '' ?>">
                            <img id="feat-img-preview" src="<?= htmlspecialchars($post['featured_image'] ?? '') ?>" 
                                 style="width: 100%; height: auto; max-height: 250px; object-fit: cover; display: block;">
                        </div>

                        <input type="hidden" name="featured_image" id="featured_image" value="<?= htmlspecialchars($post['featured_image'] ?? '') ?>">
                    </div>
                    
                    <div id="feat-img-actions" class="p-3 bg-white" style="<?= empty($post['featured_image']) ? 'display: none;' : '' ?>">
                        <div class="mb-2">
                            <label class="form-label small text-muted">Legenda</label>
                            <input type="text" name="featured_image_caption" class="form-control form-control-sm" 
                                   value="<?= htmlspecialchars($post['featured_image_caption'] ?? '') ?>" placeholder="Legenda da imagem...">
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-sm btn-outline-primary flex-grow-1" onclick="openMediaPicker()">Trocar</button>
                            <button type="button" class="btn btn-sm btn-outline-danger flex-grow-1" onclick="removeFeaturedImage()">Remover</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</form>

<!-- ========================================== -->
<!-- SCRIPTS -->
<!-- ========================================== -->

<!-- 1. Quill Editor (JSDelivr - CSP Friendly) -->
<link href="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.snow.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // --- 1. Inicializar Quill ---
    var quill = new Quill('#editor-container', {
        theme: 'snow',
        placeholder: 'Escreva seu conteúdo incrível aqui...',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'align': [] }],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['link', 'image', 'video', 'blockquote', 'code-block'],
                ['clean']
            ]
        }
    });

    // Carregar conteúdo inicial (Seguro)
    try {
        var initialContent = <?= json_encode($post['content'] ?? '') ?>;
        if (initialContent) {
            quill.root.innerHTML = initialContent;
        }
    } catch(e) { console.error('Quill Init Error:', e); }

    // Sincronizar ao enviar
    var form = document.getElementById('postForm');
    form.addEventListener('submit', function() {
        document.getElementById('content').value = quill.root.innerHTML;
        document.getElementById('tags-hidden').value = tags.join(',');
    });

    // --- 2. Gerador de Slug ---
    var titleInput = document.getElementById('title');
    var slugInput = document.getElementById('slug');
    
    titleInput.addEventListener('blur', function() {
        if (!slugInput.value) {
            let slug = this.value.toLowerCase()
                .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/^-+|-+$/g, '');
            slugInput.value = slug;
        }
    });

    // --- 3. Sistema de Tags ---
    var tags = <?= json_encode($currentTags ?? []) ?>;
    var tagsList = document.getElementById('tags-list');
    var tagInput = document.getElementById('tag-input');

    function renderTags() {
        tagsList.innerHTML = '';
        tags.forEach((tag, index) => {
            let span = document.createElement('span');
            span.style.cssText = "background: #e2e8f0; padding: 2px 8px; border-radius: 12px; font-size: 0.85rem; display: flex; align-items: center; gap: 5px;";
            span.innerHTML = `${tag} <span onclick="removeTag(${index})" style="cursor: pointer; color: #ef4444; font-weight: bold;">&times;</span>`;
            tagsList.appendChild(span);
        });
    }

    tagInput.addEventListener('keydown', function(e) {
        if(e.key === 'Enter' || e.key === ',') {
            e.preventDefault();
            let val = this.value.trim();
            if(val && !tags.includes(val)) {
                tags.push(val);
                renderTags();
            }
            this.value = '';
        }
    });

    // Focar no input ao clicar no container
    document.getElementById('tags-input-container').addEventListener('click', function() {
        tagInput.focus();
    });

    window.removeTag = function(index) {
        tags.splice(index, 1);
        renderTags();
    };

    renderTags(); // Init

    // --- 4. Gerenciador de Mídia ---
    window.openMediaPicker = function() {
        window.open('/admin/media?picker=1', 'media_picker', 'width=900,height=600');
    };

    // Callback chamado pelo popup
    window.selectMedia = function(url) {
        document.getElementById('featured_image').value = url;
        document.getElementById('feat-img-preview').src = url;
        
        document.getElementById('feat-img-empty').style.display = 'none';
        document.getElementById('feat-img-filled').style.display = 'block';
        document.getElementById('feat-img-actions').style.display = 'block';
    };

    window.removeFeaturedImage = function() {
        document.getElementById('featured_image').value = '';
        document.getElementById('feat-img-preview').src = '';
        
        document.getElementById('feat-img-empty').style.display = 'block';
        document.getElementById('feat-img-filled').style.display = 'none';
        document.getElementById('feat-img-actions').style.display = 'none';
    };
});
</script>
