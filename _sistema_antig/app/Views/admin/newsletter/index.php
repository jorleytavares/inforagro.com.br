<div class="header-actions" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
    <h1 class="page-title" style="margin: 0;">Newsletter</h1>
    <a href="/admin/newsletter/export" class="btn btn-primary btn-sm" style="display: inline-flex; align-items: center; gap: 8px;">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
            <polyline points="7 10 12 15 17 10"></polyline>
            <line x1="12" y1="15" x2="12" y2="3"></line>
        </svg>
        Exportar CSV
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">Assinantes (<?= count($subscribers) ?>)</h2>
    </div>
    
    <?php if (!empty($subscribers)): ?>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th width="50">ID</th>
                    <th>E-mail</th>
                    <th>Status</th>
                    <th>Data Inscrição</th>
                    <th>IP</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($subscribers as $sub): ?>
                <tr>
                    <td>#<?= $sub['id'] ?></td>
                    <td>
                        <strong><?= htmlspecialchars($sub['email']) ?></strong>
                    </td>
                    <td>
                        <span class="badge badge-success" style="background: #e6fffa; color: #047481;">
                            <?= ucfirst($sub['status']) ?>
                        </span>
                    </td>
                    <td><?= date('d/m/Y H:i', strtotime($sub['created_at'])) ?></td>
                    <td class="text-muted" style="font-size: 0.85em;"><?= $sub['ip_address'] ?? '-' ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
    <div class="empty-state">
        <p>Nenhum assinante encontrado ainda.</p>
    </div>
    <?php endif; ?>
</div>
