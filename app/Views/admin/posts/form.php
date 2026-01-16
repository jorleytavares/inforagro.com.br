<?php
// Variáveis e IDs
$isEdit = $isEdit ?? false;
$post = $post ?? [];
$id = $post['id'] ?? null;
?>

<!-- Estilos Customizados para "WordPress-Look" -->
<style>
    /* Layout Base */
    .editor-layout {
        display: flex;
        gap: 20px;
        align-items: flex-start;
    }
    .editor-main {
        flex: 1;
        min-width: 0; /* Previne overflow flex */
    }
    .editor-sidebar {
        width: 300px;
        flex-shrink: 0;
        position: sticky;
        top: 20px;
    }

    /* Mobile Breakpoint - Força coluna única em telas pequenas */
    @media (max-width: 991px) {
        .editor-layout {
            flex-direction: column;
        }
        .editor-sidebar {
            width: 100%;
            position: static;
        }
    }

    /* Estilo "WordPress" - Título */
    .wp-title-input {
        width: 100%;
        padding: 10px 0;
        font-size: 1.7rem;
        font-weight: 600;
        border: none;
        background: transparent;
        outline: none;
        color: #1a202c;
    }
    .wp-title-input::placeholder {
        color: #a0aec0;
    }

    /* Estilo "WordPress" - Editor */
    .wp-editor-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        overflow: hidden;
    }
    
    .ql-toolbar.ql-snow {
        border: none !important;
        border-bottom: 1px solid #e2e8f0 !important;
        background: #f8fafc;
        padding: 12px !important;
    }
    .ql-container.ql-snow {
        border: none !important;
        font-family: 'Georgia', 'Times New Roman', serif; /* Serif para escrita confortável */
        font-size: 1.1rem;
    }
    .ql-editor {
        min-height: 500px;
        padding: 24px 32px;
        line-height: 1.8;
    }

    /* Estilo Sidebar Components */
    .wp-panel {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        margin-bottom: 16px;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    }
    .wp-panel-header {
        padding: 12px 16px;
        border-bottom: 1px solid #f1f5f9;
        font-weight: 600;
        font-size: 0.9rem;
        color: #1e293b;
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
    }
    .wp-panel-body {
        padding: 16px;
    }

    /* Imagem Destacada */
    .featured-image-box {
        background: #f8fafc;
        border: 2px dashed #cbd5e1;
        border-radius: 6px;
        min-height: 150px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
        overflow: hidden;
        position: relative;
    }
    .featured-image-box:hover {
        border-color: #94a3b8;
        background: #f1f5f9;
    }
    .featured-image-preview {
        width: 100%;
        height: auto;
        display: block;
    }

    /* Categorias */
    .category-checklist {
        max-height: 240px;
        overflow-y: auto;
        border: 1px solid #f1f5f9;
        border-radius: 4px;
        padding: 8px;
        background: #fcfcfc;
    }
</style>

<form action="<?= $isEdit ? "/admin/posts/{$id}/update" : "/admin/posts/store" ?>" method="POST" id="postForm">
    <?= $csrfField ?? '' ?>
    
    <div class="editor-layout">
        
        <!-- ============================================== -->
        <!-- COLUNA PRINCIPAL (Esquerda) -->
        <!-- ============================================== -->
        <main class="editor-main">
            
            <div class="mb-4">
                <input type="text" class="wp-title-input" id="title" name="title" 
                       value="<?= htmlspecialchars($post['title'] ?? '') ?>" required 
                       placeholder="Adicionar título" autocomplete="off">
                       
                <!-- Subtítulo e Slug (Discretos) -->
                <div class="d-flex gap-3 align-items-center mt-2">
                    <input type="text" class="form-control form-control-sm border-0 bg-transparent text-muted ps-0" 
                           id="subtitle" name="subtitle" 
                           value="<?= htmlspecialchars($post['subtitle'] ?? '') ?>" 
                           placeholder="Adicionar subtítulo (opcional)">
                    
                    <input type="hidden" id="slug" name="slug" value="<?= htmlspecialchars($post['slug'] ?? '') ?>">
                </div>
            </div>

            <!-- EDITOR VISUAL -->
            <div class="wp-editor-card mb-4">
                <!-- O Quill vai injetar a toolbar aqui automaticamente -->
                <div id="editor"></div>
                <!-- Input oculto que recebe o valor -->
                <input type="hidden" name="content" id="content">
            </div>

            <!-- SEO & SCHEMA (Accordions) -->
            <div class="accordion" id="seoAccordion">
                <div class="wp-panel">
                    <div class="wp-panel-header" onclick="togglePanel('seoBody')">
                        <span>Otimização para Motores de Busca (SEO)</span>
                        <span class="small text-muted">▼</span>
                    </div>
                    <div id="seoBody" class="wp-panel-body" style="display: none;">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Meta Title</label>
                            <input type="text" name="meta_title" class="form-control" value="<?= htmlspecialchars($post['meta_title'] ?? '') ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Meta Description</label>
                            <textarea name="meta_description" class="form-control" rows="2"><?= htmlspecialchars($post['meta_description'] ?? '') ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Schema Customizado (JSON-LD)</label>
                            <textarea name="custom_schema" class="form-control font-monospace" rows="4" style="font-size: 12px;"><?= htmlspecialchars($post['custom_schema'] ?? '') ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

        </main>

        <!-- ============================================== -->
        <!-- SIDEBAR (Direita) -->
        <!-- ============================================== -->
        <aside class="editor-sidebar">
            
            <!-- PUBLICAR -->
            <div class="wp-panel">
                <div class="wp-panel-header">Publicar</div>
                <div class="wp-panel-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <button type="submit" name="status" value="draft" class="btn btn-outline-secondary btn-sm">Salvar Rascunho</button>
                        <button type="button" class="btn btn-link btn-sm text-decoration-none text-danger" onclick="location.href='/admin/posts'">Cancelar</button>
                    </div>
                    
                    <div class="mb-3 small">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Status:</span>
                            <strong class="text-capitalize"><?= $post['status'] ?? 'Rascunho' ?></strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Visibilidade:</span>
                            <strong>Público</strong>
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" name="status" value="published" class="btn btn-primary">
                            <?= $isEdit ? 'Atualizar Post' : 'Publicar' ?>
                        </button>
                    </div>
                </div>
            </div>

            <!-- CATEGORIAS -->
            <div class="wp-panel">
                <div class="wp-panel-header">Categorias</div>
                <div class="wp-panel-body">
                    <div class="category-checklist">
                        <?php foreach ($categories as $cat): ?>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="category_id" id="cat_<?= $cat['id'] ?>" 
                                   value="<?= $cat['id'] ?>" <?= ($post['category_id'] ?? '') == $cat['id'] ? 'checked' : '' ?> required>
                            <label class="form-check-label small" for="cat_<?= $cat['id'] ?>">
                                <?= htmlspecialchars($cat['name']) ?>
                            </label>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="mt-2 text-end">
                        <a href="/admin/categories" target="_blank" class="small text-decoration-underline">Nova Categoria</a>
                    </div>
                </div>
            </div>

            <!-- IMAGEM DESTACADA -->
            <div class="wp-panel">
                <div class="wp-panel-header">Imagem Destacada</div>
                <div class="wp-panel-body">
                    <div class="featured-image-box" onclick="openMediaPicker()">
                        <img id="feat-img-preview" src="<?= htmlspecialchars($post['featured_image'] ?? '') ?>" 
                             class="featured-image-preview" style="<?= empty($post['featured_image']) ? 'display:none' : '' ?>">
                        
                        <div id="feat-img-placeholder" style="<?= !empty($post['featured_image']) ? 'display:none' : '' ?>" class="text-center text-muted">
                            <span style="font-size: 24px;">🖼️</span><br>
                            <span class="small">Definir imagem destacada</span>
                        </div>
                    </div>
                    
                    <input type="hidden" name="featured_image" id="featured_image" value="<?= htmlspecialchars($post['featured_image'] ?? '') ?>">
                    
                    <div id="feat-img-remove" class="mt-2 text-center" style="<?= empty($post['featured_image']) ? 'display:none' : '' ?>">
                        <button type="button" class="btn btn-link btn-sm text-danger p-0" onclick="removeFeaturedImage()">Remover imagem destacada</button>
                    </div>
                    
                    <div class="mt-2">
                        <input type="text" name="featured_image_caption" class="form-control form-control-sm" placeholder="Legenda da imagem" value="<?= htmlspecialchars($post['featured_image_caption'] ?? '') ?>">
                    </div>
                </div>
            </div>

            <!-- AUTO-SAVE NOTICE -->
             <div class="text-center text-muted small mt-2">
                 Autores disponíveis: <?= count($authors) ?>
                 <input type="hidden" name="author_id" value="<?= $post['author_id'] ?? ($_SESSION['user_id'] ?? 1) ?>">
             </div>

        </aside>

    </div>
</form>

<!-- Scripts Locais (Quill) -->
<link href="/assets/css/quill.snow.css" rel="stylesheet">
<script src="/assets/js/quill.min.js"></script>

<script>
    // Toggle Panel Function
    function togglePanel(id) {
        var el = document.getElementById(id);
        el.style.display = el.style.display === 'none' ? 'block' : 'none';
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Init Quill
        var quill = new Quill('#editor', {
            theme: 'snow',
            placeholder: 'Comece a escrever...',
            modules: {
                toolbar: [
                    [{ 'header': [2, 3, 4, false] }],
                    ['bold', 'italic', 'underline', 'link'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    ['blockquote', 'image', 'clean']
                ]
            }
        });

        // Load Content
        try {
            var content = <?= json_encode($post['content'] ?? '') ?>;
            if(content) quill.root.innerHTML = content;
        } catch(e){}

        // Sync Form
        document.getElementById('postForm').addEventListener('submit', function() {
            document.getElementById('content').value = quill.root.innerHTML;
        });

        // Sticky Title to Slug
        document.getElementById('title').addEventListener('blur', function() {
            var slug = document.getElementById('slug');
            if(!slug.value) {
                slug.value = this.value.toLowerCase()
                    .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/^-+|-+$/g, '');
            }
        });

        // Media Picker
        window.openMediaPicker = function() {
            window.open('/admin/media?picker=1', 'media_picker', 'width=850,height=600');
        };

        window.selectMedia = function(url) {
            document.getElementById('featured_image').value = url;
            document.getElementById('feat-img-preview').src = url;
            document.getElementById('feat-img-preview').style.display = 'block';
            document.getElementById('feat-img-placeholder').style.display = 'none';
            document.getElementById('feat-img-remove').style.display = 'block';
        };

        window.removeFeaturedImage = function() {
            document.getElementById('featured_image').value = '';
            document.getElementById('feat-img-preview').src = '';
            document.getElementById('feat-img-preview').style.display = 'none';
            document.getElementById('feat-img-placeholder').style.display = 'block';
            document.getElementById('feat-img-remove').style.display = 'none';
        };
    });
</script>
