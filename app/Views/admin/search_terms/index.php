<div class="header-actions">
    <h1 class="page-title">Monitor de Buscas</h1>
    <a href="/admin/search-terms" class="btn btn-secondary btn-sm">Atualizar</a>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-value"><?= number_format($stats['total_searches']) ?></div>
        <div class="stat-label">Total de Buscas</div>
    </div>
    <div class="stat-card" style="border-left: 4px solid #f44336;">
        <div class="stat-value"><?= number_format($stats['zero_results']) ?></div>
        <div class="stat-label">Sem Resultados</div>
    </div>
    <div class="stat-card">
        <div class="stat-value"><?= number_format($stats['today_searches']) ?></div>
        <div class="stat-label">Buscas Hoje</div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">Termos Não Encontrados (Oportunidades de Conteúdo)</h2>
        <small class="text-muted">Usuários estão buscando por isso e não encontraram nada.</small>
    </div>
    
    <?php if (!empty($notFoundTerms)): ?>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Termo Buscado</th>
                <th>Tentativas</th>
                <th>Última Tentativa</th>
                <th>Ação Recomendada</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($notFoundTerms as $term): ?>
            <tr>
                <td>
                    <strong style="color: #d32f2f; font-size: 1.1em;"><?= htmlspecialchars($term['term']) ?></strong>
                </td>
                <td>
                    <span class="badge badge-secondary"><?= $term['attempts'] ?>x</span>
                </td>
                <td><?= date('d/m/Y H:i', strtotime($term['last_attempt'])) ?></td>
                <td>
                    <a href="/admin/posts/create?title=<?= urlencode(ucfirst($term['term'])) ?>" class="btn btn-primary btn-sm">
                        Criar Post Sobre Isso
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
    <div class="empty-state">
        <p>Ótimo! Parece que seus usuários estão encontrando tudo o que procuram (ou ainda não houve buscas sem resultado).</p>
    </div>
    <?php endif; ?>
</div>

<style>
.badge-secondary {
    background: #e0e0e0;
    color: #333;
    padding: 4px 8px;
    border-radius: 4px;
}
.text-muted {
    color: #666;
    font-size: 0.9em;
    display: block;
    margin-top: 4px;
}
</style>
