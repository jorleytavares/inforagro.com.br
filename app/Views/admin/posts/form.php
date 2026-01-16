<!-- Formulário de Post com Layout WordPress -->
<form action="<?= $isEdit ? '/admin/posts/' . $post['id'] . '/update' : '/admin/posts/store' ?>" method="POST">
    <?= $csrfField ?? '' ?>
    <div style="display: flex; gap: 20px; align-items: flex-start; flex-wrap: wrap;">
        
        <!-- COLUNA PRINCIPAL (Conteúdo) -->
        <div style="flex: 1; min-width: 600px;">
            <h2 class="mb-4"><?= $isEdit ? 'Editar Post' : 'Novo Post' ?></h2>
            
            <div class="card mb-3">
                <div class="card-body" style="padding: 1.5rem;">
                    <!-- Título -->
                    <div class="form-group mb-3">
                        <label class="form-label" for="title">Título *</label>
                        <input type="text" id="title" name="title" class="form-control form-control-lg" 
                               style="font-size: 1.25rem; font-weight: 600;"
                               value="<?= htmlspecialchars($post['title'] ?? '') ?>" required>
                    </div>

                    <!-- Subtítulo -->
                    <div class="form-group mb-3">
                        <label class="form-label" for="subtitle">Subtítulo (Opcional)</label>
                        <input type="text" id="subtitle" name="subtitle" class="form-control" 
                               value="<?= htmlspecialchars($post['subtitle'] ?? '') ?>" placeholder="Subtítulo">
                    </div>

                    <!-- Slug (Hidden) -->
                    <input type="hidden" id="slug" name="slug" value="<?= htmlspecialchars($post['slug'] ?? '') ?>">

                    <!-- Conteúdo (TinyMCE) -->
                    <div class="form-group">
                        <textarea id="content" name="content" class="form-control tinymce-editor"><?= htmlspecialchars($post['content'] ?? '') ?></textarea>
                    </div>
                </div>
            </div>

            <!-- SEO -->
            <div class="card mb-3">
                <div class="card-header bg-light">
                    <h3 class="card-title h6 mb-0">Otimização para Motores de Busca (SEO)</h3>
                </div>
                <div class="card-body" style="padding: 1rem;">
                    <div class="form-group">
                        <label class="form-label" for="custom_schema">Schema Markup Personalizado (JSON-LD)</label>
                        <textarea id="custom_schema" name="custom_schema" class="form-control" rows="8" 
                                  style="font-family: monospace; font-size: 0.9rem; background: #282c34; color: #abb2bf;"
                                  placeholder='<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Article",
  ...
}
</script>'><?= htmlspecialchars($post['custom_schema'] ?? '') ?></textarea>
                        <small class="text-muted d-block mt-2">Insira o código JSON-LD completo, incluindo as tags &lt;script&gt;.</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- COLUNA LATERAL (Sidebar) -->
        <div style="width: 300px; flex-shrink: 0;">
            
            <!-- Painel Publicar -->
            <div class="card mb-3">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h3 class="card-title h6 mb-0">Publicar</h3>
                </div>
                <div class="card-body" style="padding: 1rem;">
                    
                    <div class="form-group mb-3">
                        <label class="form-label mb-1">Status:</label>
                        <select id="status" name="status" class="form-control form-select-sm">
                            <option value="draft" <?= ($post['status'] ?? 'draft') === 'draft' ? 'selected' : '' ?>>📝 Rascunho</option>
                            <option value="published" <?= ($post['status'] ?? '') === 'published' ? 'selected' : '' ?>>✅ Publicado</option>
                            <option value="pending" <?= ($post['status'] ?? '') === 'pending' ? 'selected' : '' ?>>⏳ Pendente</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label mb-1">Autor:</label>
                        <select id="author_id" name="author_id" class="form-control form-select-sm" required>
                            <?php foreach ($authors as $author): ?>
                            <option value="<?= $author['id'] ?>" <?= ($post['author_id'] ?? 1) == $author['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($author['name']) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary w-100"><?= $isEdit ? 'Atualizar' : 'Publicar' ?></button>
                    </div>
                    <?php if ($isEdit): ?>
                    <div class="mt-2 text-center">
                        <a href="/admin/posts" class="text-danger small text-decoration-none">Mover para lixeira</a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Painel Formato / Categoria -->
            <div class="card mb-3">
                <div class="card-header bg-light">
                    <h3 class="card-title h6 mb-0">Categorias</h3>
                </div>
                <div class="card-body" style="padding: 1rem;">
                    <div class="form-group mb-3">
                        <label class="form-label mb-2" style="font-size: 0.9rem; font-weight: 600;">Categoria Principal</label>
                        <div class="category-list-check" style="max-height: 200px; overflow-y: auto; border: 1px solid #dee2e6; border-radius: 4px; padding: 0.75rem; background: #fff;">
                            <?php foreach ($categories as $cat): ?>
                            <div class="form-check mb-1">
                                <input class="form-check-input" type="radio" name="category_id" id="cat_<?= $cat['id'] ?>" value="<?= $cat['id'] ?>" <?= ($post['category_id'] ?? '') == $cat['id'] ? 'checked' : '' ?> required>
                                <label class="form-check-label" for="cat_<?= $cat['id'] ?>" style="font-size: 0.9rem;">
                                    <?= htmlspecialchars($cat['name']) ?>
                                </label>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <div class="form-group mt-3 pt-3 border-top">
                        <label class="form-label mb-1">Tipo de Conteúdo:</label>
                        <select id="content_type" name="content_type" class="form-control form-select-sm">
                            <option value="article" <?= ($post['content_type'] ?? '') === 'article' ? 'selected' : '' ?>>📰 Artigo</option>
                            <option value="news" <?= ($post['content_type'] ?? '') === 'news' ? 'selected' : '' ?>>📢 Notícia</option>
                            <option value="pillar" <?= ($post['content_type'] ?? '') === 'pillar' ? 'selected' : '' ?>>📚 Pillar Page</option>
                            <option value="guide" <?= ($post['content_type'] ?? '') === 'guide' ? 'selected' : '' ?>>📖 Guia Completo</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Painel Tags -->
            <div class="card mb-3">
                <div class="card-header bg-light">
                    <h3 class="card-title h6 mb-0">Tags</h3>
                </div>
                <div class="card-body" style="padding: 1rem;">
                    
                    <div id="tags-input-wrapper" style="border: 1px solid #dee2e6; border-radius: 4px; padding: 6px; background: #fff; display: flex; flex-wrap: wrap; gap: 6px; align-items: center; min-height: 42px; cursor: text;" onclick="document.getElementById('tag-input').focus()">
                        <div id="tags-visual-list" style="display: contents;"></div>
                        <input type="text" id="tag-input" list="tags-datalist" placeholder="Nova tag..." 
                               style="border: none; outline: none; flex: 1; font-size: 0.9rem; min-width: 100px; color: #495057; background: transparent;">
                    </div>
                    
                    <input type="hidden" name="tags" id="tags-hidden">
                    <datalist id="tags-datalist">
                        <?php if(!empty($allTags)): foreach($allTags as $t): ?>
                        <option value="<?= htmlspecialchars($t) ?>">
                        <?php endforeach; endif; ?>
                    </datalist>
                    <small class="form-text text-muted mt-2 d-block">Separe com vírgulas ou Enter.</small>
                    
                    <style>
                        .tag-chip {
                            background: #e9ecef;
                            padding: 2px 8px;
                            border-radius: 12px;
                            font-size: 0.8rem;
                            display: inline-flex;
                            align-items: center;
                            gap: 6px;
                            border: 1px solid #dee2e6;
                        }
                        .tag-chip button {
                            background: none; border: none; cursor: pointer; color: #999; font-weight: bold; padding: 0; line-height: 1;
                        }
                        .tag-chip button:hover { color: #dc3545; }
                    </style>
                </div>
            </div>

            <!-- Painel Imagem Destacada -->
            <div class="card mb-3">
                <div class="card-header bg-light">
                    <h3 class="card-title h6 mb-0">Imagem Destacada</h3>
                </div>
                <div class="card-body p-0" style="padding: 0;">
                    <div class="featured-image-container" style="background: #f8f9fa; min-height: 160px; display: flex; flex-direction: column; align-items: center; justify-content: center; position: relative;">
                        
                        <!-- State: Empty -->
                        <div id="featured-image-empty" style="text-align: center; padding: 2rem; <?= !empty($post['featured_image']) ? 'display:none' : '' ?>">
                            <div style="font-size: 2.5rem; color: #dee2e6; margin-bottom: 0.5rem; cursor: pointer;" onclick="openMediaPicker()">📷</div>
                            <button type="button" class="btn btn-link text-decoration-none p-0" onclick="openMediaPicker()" style="font-weight: 500;">Definir imagem destacada</button>
                        </div>

                        <!-- State: Filled -->
                        <div id="featured-image-filled" style="width: 100%; <?= empty($post['featured_image']) ? 'display:none' : '' ?>">
                            <img id="preview-img" src="<?= htmlspecialchars($post['featured_image'] ?? '') ?>" style="width: 100%; height: auto; display: block; max-height: 250px; object-fit: cover; cursor: pointer;" onclick="openMediaPicker()">
                            
                            <div style="padding: 1rem; background: #fff; border-top: 1px solid #dee2e6;">
                                <label class="form-label" style="font-size: 0.75rem; color: #6c757d; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Legenda</label>
                                <textarea name="featured_image_caption" class="form-control form-control-sm mb-3" rows="2" 
                                          placeholder="Escreva uma legenda..." style="font-size: 0.85rem; resize: none; background: #f8f9fa; border-color: #dee2e6;"><?= htmlspecialchars($post['featured_image_caption'] ?? '') ?></textarea>
                                
                                <div style="display: flex; gap: 0.5rem;">
                                     <button type="button" class="btn btn-sm btn-outline-primary flex-grow-1" onclick="openMediaPicker()">Trocar</button>
                                     <button type="button" class="btn btn-sm btn-outline-danger flex-grow-1" onclick="removeFeaturedImage()">Remover</button>
                                </div>
                            </div>
                        </div>
                        
                        <input type="hidden" id="featured_image" name="featured_image" value="<?= htmlspecialchars($post['featured_image'] ?? '') ?>">
                    </div>
                </div>
            </div>

        </div>
    </div>
</form>

<!-- TinyMCE CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js" referrerpolicy="origin"></script>
<script>
// Inicializar TinyMCE Profissional
tinymce.init({
    selector: '.tinymce-editor',
    height: 600,
    menubar: true, // Habilitar menu superior
    statusbar: true,
    language: 'pt_BR',
    plugins: [
        'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
        'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
        'insertdatetime', 'media', 'table', 'help', 'wordcount', 'codesample',
        'emoticons', 'directionality', 'nonbreaking', 'pagebreak', 'visualchars'
    ],
    // Toolbar Profissional estilo Clássico
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat | fullscreen code',
    
    // Configurações de estilo e fonte
    font_family_formats: 'Inter=Inter,sans-serif;Andale Mono=andale mono,times;Arial=arial,helvetica,sans-serif;Book Antiqua=book antiqua,palatino;Courier New=courier new,courier;Georgia=georgia,palatino;Helvetica=helvetica;Symbol=symbol;Tahoma=tahoma,arial,helvetica,sans-serif;Times New Roman=times new roman,times;Verdana=verdana,geneva',
    
    content_style: `
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap');
        body { font-family: 'Inter', sans-serif; font-size: 16px; line-height: 1.7; color: #333; max-width: 850px; margin: 0 auto; padding: 20px; }
        h1,h2,h3,h4,h5,h6 { font-weight: 600; margin-top: 1.5em; margin-bottom: 0.5em; }
        p { margin-bottom: 1em; }
        img { max-width: 100%; height: auto; border-radius: 4px; }
    `,
    
    // Upload de Imagens
    images_upload_url: '/admin/media/tinymce-upload?token=<?= $tinymceToken ?? "" ?>',
    automatic_uploads: true,
    file_picker_types: 'image media',
    image_title: true,
    image_caption: true,
    
    // Reutilizar o callback existente se necessário, mas melhorando a integração
    file_picker_callback: function (cb, value, meta) {
        // Guardar callback globalmente
        window.tinyMceCallback = cb;
        // Abrir media picker
        window.open('/admin/media?picker=1&type=' + meta.filetype, 'media-picker', 'width=900,height=600');
    }
});

// Adicionar listener global para o media picker
window.selectMediaForTiny = function(url) {
    if (window.tinyMceCallback) {
        window.tinyMceCallback(url);
        window.tinyMceCallback = null;
    }
}

// Auto-gerar slug a partir do título
document.getElementById('title').addEventListener('blur', function() {
    const slugField = document.getElementById('slug');
    if (!slugField.value) {
        let slug = this.value.toLowerCase()
            .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/^-|-$/g, '');
        slugField.value = slug;
    }
});

// Contadores SEO
const updateCount = (id, targetId) => {
    const el = document.getElementById(id);
    if(el) document.getElementById(targetId).textContent = el.value.length;
};
['meta_title', 'meta_description'].forEach(id => {
    const el = document.getElementById(id);
    if(el) {
        el.addEventListener('input', () => updateCount(id, id === 'meta_title' ? 'meta-title-count' : 'meta-desc-count'));
        updateCount(id, id === 'meta_title' ? 'meta-title-count' : 'meta-desc-count');
    }
});

// Seletor de Mídia e Imagem Destacada
function openMediaPicker() {
    window.open('/admin/media?picker=1', 'media-picker', 'width=900,height=600');
}

window.selectMedia = function(url) {
    const input = document.getElementById('featured_image');
    if (input) input.value = url;
    
    // Atualizar Preview
    const previewImg = document.getElementById('preview-img');
    if(previewImg) previewImg.src = url;
    
    const emptyState = document.getElementById('featured-image-empty');
    if(emptyState) emptyState.style.display = 'none';
    
    const filledState = document.getElementById('featured-image-filled');
    if(filledState) filledState.style.display = 'block';
};

window.removeFeaturedImage = function() {
    document.getElementById('featured_image').value = '';
    document.getElementById('preview-img').src = '';
    document.getElementById('featured-image-filled').style.display = 'none';
    document.getElementById('featured-image-empty').style.display = 'block';
};

// Tags System
let tags = <?= json_encode($currentTags ?? []) ?>;
const tagsContainer = document.getElementById('tags-visual-list');
const tagsInput = document.getElementById('tag-input');
const tagsHidden = document.getElementById('tags-hidden');

function renderTags() {
    tagsContainer.innerHTML = '';
    tags.forEach((tag, index) => {
        const chip = document.createElement('span');
        chip.className = 'tag-chip';
        chip.innerHTML = `${tag} <button type="button" onclick="removeTag(${index})">&times;</button>`;
        tagsContainer.appendChild(chip);
    });
    tagsHidden.value = tags.join(',');
}

function addTag(name) {
    name = name.trim();
    if (!name) return;
    if (!tags.includes(name)) {
        tags.push(name);
        renderTags();
    }
    tagsInput.value = '';
}

window.removeTag = function(index) {
    tags.splice(index, 1);
    renderTags();
}

tagsInput.addEventListener('keydown', function(e) {
    if (e.key === 'Enter' || e.key === ',') {
        e.preventDefault();
        addTag(this.value);
    }
});

renderTags();
</script>
