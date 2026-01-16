<!-- Galeria de Mídia -->
<?php if (!empty($_GET['success'])): ?>
<div class="alert alert-success">Arquivo excluído com sucesso!</div>
<?php endif; ?>

<?php if (!empty($isPicker)): ?>
<style>
    .admin-sidebar, .sidebar-header, header { display: none !important; }
    .admin-main { margin-left: 0 !important; padding-top: 0 !important; }
    .card { box-shadow: none; border: none; }
    body { background: white; }
</style>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">Biblioteca de Mídia</h2>
        <button type="button" class="btn btn-primary" onclick="document.getElementById('file-input').click()">
            + Upload de Imagem
        </button>
    </div>
    
    <!-- Filtros -->
    <div style="padding: 1rem 1.5rem; border-bottom: 1px solid var(--admin-border); background: var(--admin-bg);">
        <div style="display: flex; gap: 1rem; align-items: center; flex-wrap: wrap;">
            <input type="text" id="media-search" class="form-control btn-sm" placeholder="Buscar arquivo..." style="max-width: 250px;">
            
            <select id="media-filter-date" class="form-control btn-sm" style="max-width: 200px;">
                <option value="all">Todas as datas</option>
                <?php
                $months = [];
                foreach ($media as $m) {
                    if (!empty($m['date'])) {
                        $month = date('Y-m', strtotime($m['date']));
                        if (!in_array($month, $months)) $months[] = $month;
                    }
                }
                rsort($months);
                foreach ($months as $month) {
                    echo '<option value="' . $month . '">' . date('m/Y', strtotime($month . '-01')) . '</option>';
                }
                ?>
            </select>
            
            <span id="media-count" style="margin-left: auto; font-size: 0.875rem; color: var(--admin-text-muted);">
                <?= count($media) ?> itens
            </span>
        </div>
    </div>

    <!-- Upload Form -->
    <div style="padding: 1.5rem; border-bottom: 1px solid var(--admin-border);">
        <form id="upload-form" enctype="multipart/form-data" style="display: none;">
            <input type="file" id="file-input" name="file" accept="image/*" onchange="uploadFile(this)">
        </form>
        <div id="upload-progress" style="display: none;">
            <div class="progress-bar">
                <div class="progress-fill" style="width: 0%"></div>
            </div>
            <p style="text-align: center; margin-top: 0.5rem; font-size: 0.875rem;">Enviando...</p>
        </div>
    </div>
    
    <?php if (!empty($media)): ?>
    <div class="media-grid" style="padding: 1.5rem; display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 1rem;">
        <?php foreach ($media as $file): 
            $fileMonth = !empty($file['date']) ? date('Y-m', strtotime($file['date'])) : '';
        ?>
        <div class="media-item" 
             data-name="<?= strtolower($file['name']) ?>"
             data-month="<?= $fileMonth ?>"
             style="position: relative; border: 1px solid var(--admin-border); border-radius: 8px; overflow: hidden;">
            
            <form method="POST" action="/admin/media/delete" style="position: absolute; top: 5px; right: 5px; z-index: 10;" onsubmit="return confirm('Excluir este arquivo permanentemente?')">
                <input type="hidden" name="_csrf" value="<?= $csrfToken ?? '' ?>">
                <input type="hidden" name="filename" value="<?= htmlspecialchars($file['path']) ?>">
                <button type="submit" class="btn btn-danger btn-sm" title="Excluir" style="padding: 0; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; border-radius: 50%;">&times;</button>
            </form>

            <img src="<?= htmlspecialchars($file['url']) ?>" alt="<?= htmlspecialchars($file['name']) ?>" 
                 style="width: 100%; height: 140px; object-fit: cover; cursor: pointer;"
                 onclick="showMediaModal('<?= htmlspecialchars($file['url']) ?>', '<?= htmlspecialchars($file['path']) ?>')">
            <div style="padding: 0.5rem; font-size: 0.75rem;">
                <div style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="<?= htmlspecialchars($file['name']) ?>">
                    <?= htmlspecialchars($file['name']) ?>
                </div>
                <div style="color: var(--admin-text-muted);">
                    <?= number_format($file['size'] / 1024, 1) ?> KB
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
    <div class="empty-state">
        <p>Nenhuma imagem na biblioteca.</p>
        <p>Clique em "Upload de Imagem" para adicionar.</p>
    </div>
    <?php endif; ?>
</div>

<!-- Modal -->
<div id="media-modal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.8); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: white; border-radius: 12px; max-width: 600px; width: 90%; padding: 1.5rem;">
        <img id="modal-image" src="" alt="" style="max-width: 100%; max-height: 400px; display: block; margin: 0 auto;">
        <div style="margin-top: 1rem;">
            <label style="font-size: 0.875rem; color: var(--admin-text-muted);">URL da imagem:</label>
            <input type="text" id="modal-url" readonly class="form-control" style="margin-top: 0.25rem;" onclick="this.select()">
        </div>
        <div style="display: flex; gap: 1rem; margin-top: 1rem;">
            <button type="button" class="btn btn-secondary" onclick="copyUrl()">Copiar URL</button>
            <?php if (!empty($isPicker)): ?>
            <button type="button" class="btn btn-primary" onclick="selectAndClose()">Usar Imagem</button>
            <?php endif; ?>
            <form method="POST" action="/admin/media/delete" style="display: inline;">
                <input type="hidden" name="_csrf" value="<?= $csrfToken ?? '' ?>">
                <input type="hidden" name="filename" id="modal-filename">
                <button type="submit" class="btn btn-danger" onclick="return confirm('Excluir esta imagem?')">Excluir</button>
            </form>
            <button type="button" class="btn btn-secondary" onclick="closeModal()" style="margin-left: auto;">Fechar</button>
        </div>
    </div>
</div>

<style>
.progress-bar { height: 8px; background: var(--admin-border); border-radius: 4px; overflow: hidden; }
.progress-fill { height: 100%; background: var(--admin-primary); transition: width 0.3s; }
</style>

<script>
function uploadFile(input) {
    if (!input.files[0]) return;
    
    const formData = new FormData();
    formData.append('file', input.files[0]);
    formData.append('_csrf', '<?= $csrfToken ?? '' ?>');
    
    document.getElementById('upload-progress').style.display = 'block';
    
    fetch('/admin/media/upload', {
        method: 'POST',
        body: formData
    })
    .then(r => r.json())
    .then(data => {
        document.getElementById('upload-progress').style.display = 'none';
        if (data.success) {
            location.reload();
        } else {
            alert(data.error || 'Erro no upload');
        }
    })
    .catch(err => {
        document.getElementById('upload-progress').style.display = 'none';
        alert('Erro no upload');
    });
}

function showMediaModal(url, filename) {
    document.getElementById('modal-image').src = url;
    document.getElementById('modal-url').value = url;
    document.getElementById('modal-filename').value = filename;
    document.getElementById('media-modal').style.display = 'flex';
}

function selectAndClose() {
    const url = document.getElementById('modal-url').value;
    if (window.opener && window.opener.selectMedia) {
        window.opener.selectMedia(url);
        window.close();
    } else {
        alert('Janela pai não detectada. Copie a URL.');
    }
}

function closeModal() {
    document.getElementById('media-modal').style.display = 'none';
}

function copyUrl() {
    const input = document.getElementById('modal-url');
    input.select();
    document.execCommand('copy');
    alert('URL copiada!');
}

// Filtros
document.getElementById('media-search').addEventListener('keyup', filterMedia);
document.getElementById('media-filter-date').addEventListener('change', filterMedia);

function filterMedia() {
    const search = document.getElementById('media-search').value.toLowerCase();
    const date = document.getElementById('media-filter-date').value;
    const items = document.querySelectorAll('.media-item');
    let visibleCount = 0;
    
    items.forEach(item => {
        const name = item.dataset.name;
        const itemDate = item.dataset.month;
        
        const matchSearch = name.includes(search);
        const matchDate = date === 'all' || itemDate === date;
        
        if (matchSearch && matchDate) {
            item.style.display = 'block';
            visibleCount++;
        } else {
            item.style.display = 'none';
        }
    });
    
    document.getElementById('media-count').textContent = visibleCount + ' itens';
}

document.getElementById('media-modal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});
</script>
