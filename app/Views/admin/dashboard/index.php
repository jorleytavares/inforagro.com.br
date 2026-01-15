<style>
    .dashboard-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 1.5rem;
    }
    @media(max-width: 992px) {
        .dashboard-grid { grid-template-columns: 1fr; }
    }
    .quick-list-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }
    .quick-list-item:last-child { border-bottom: none; }
    .term-count {
        background: rgba(95, 125, 78, 0.1);
        color: var(--admin-primary);
        padding: 0.2rem 0.6rem;
        border-radius: 99px;
        font-size: 0.75rem;
        font-weight: 700;
    }
    .chart-container {
        position: relative; 
        height: 300px; 
        width: 100%;
    }
</style>

<!-- KPI Cards -->
<div class="stats-grid" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));">
    <div class="stat-card glass-panel">
        <div class="stat-value"><?= $stats['total_posts'] ?></div>
        <div class="stat-label">Total de Posts</div>
    </div>
    <div class="stat-card glass-panel">
        <div class="stat-value text-success"><?= $stats['published_posts'] ?></div>
        <div class="stat-label">Publicados</div>
    </div>
    <div class="stat-card glass-panel">
        <div class="stat-value text-primary"><?= $stats['total_categories'] ?></div>
        <div class="stat-label">Categorias Ativas</div>
    </div>
    <div class="stat-card glass-panel">
        <div class="stat-value" style="color: #6366f1;"><?= $stats['newsletter_total'] ?? 0 ?></div>
        <div class="stat-label">Assinantes Newsletter</div>
    </div>
    <div class="stat-card glass-panel">
        <div class="stat-value"><?= number_format($stats['total_views']) ?></div>
        <div class="stat-label">Visualizações Totais</div>
    </div>
</div>

<div class="dashboard-grid">
    <!-- Esquerda (Principal) -->
    <div class="main-column">
        
        <!-- Gráfico de Buscas -->
        <div class="card glass-panel mb-4">
            <div class="card-header border-0">
                <h2 class="card-title">Volume de Buscas (7 dias)</h2>
            </div>
            <div class="card-body" style="padding: 1.5rem;">
                <div class="chart-container">
                    <canvas id="searchChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Tabela de Posts -->
        <div class="card glass-panel">
            <div class="card-header border-0">
                <h2 class="card-title">Posts Recentes</h2>
                <a href="/admin/posts/create" class="btn btn-primary btn-sm">+ Novo Post</a>
            </div>
            
            <?php if (!empty($recentPosts)): ?>
            <div style="overflow-x: auto;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Categoria</th>
                            <th>Status</th>
                            <th>Data</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentPosts as $post): ?>
                        <tr>
                            <td>
                                <strong><?= htmlspecialchars($post['title']) ?></strong>
                            </td>
                            <td><?= htmlspecialchars($post['category_name'] ?? '-') ?></td>
                            <td>
                                <?php if ($post['status'] === 'published'): ?>
                                    <span class="badge badge-success">Publicado</span>
                                <?php elseif ($post['status'] === 'draft'): ?>
                                    <span class="badge badge-secondary">Rascunho</span>
                                <?php else: ?>
                                    <span class="badge badge-warning"><?= ucfirst($post['status']) ?></span>
                                <?php endif; ?>
                            </td>
                            <td><?= date('d/m/Y', strtotime($post['created_at'])) ?></td>
                            <td>
                                <a href="/admin/posts/<?= $post['id'] ?>/edit" class="btn btn-secondary btn-sm" style="padding: 0.2rem 0.5rem;">Editar</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <div class="empty-state" style="padding: 4rem 2rem; text-align: center; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                <p style="margin-bottom: 1.5rem; color: #64748b; font-size: 1.1rem;">Nenhum post encontrado.</p>
                <a href="/admin/posts/create" class="btn btn-primary" style="padding: 0.75rem 1.5rem; font-weight: 600;">Criar Primeiro Post</a>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Direita (Insights) -->
    <div class="side-column">
        
        <!-- Top Buscas -->
        <div class="card glass-panel mb-4">
            <div class="card-header border-0">
                <h2 class="card-title">Top Termos Buscados</h2>
                <a href="/admin/search-terms" class="btn btn-link btn-sm text-muted" style="text-decoration: none; font-size: 0.8rem;">Ver tudo</a>
            </div>
            <div class="card-body" style="padding: 0 1.5rem 1.5rem;">
                <?php if (!empty($topTerms)): ?>
                    <?php foreach ($topTerms as $term): ?>
                    <div class="quick-list-item">
                        <span style="font-weight: 500;"><?= htmlspecialchars($term['term']) ?></span>
                        <span class="term-count"><?= $term['count'] ?></span>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted text-center py-3">Sem dados ainda.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Oportunidades (Sem resultados) -->
        <div class="card glass-panel">
            <div class="card-header border-0">
                <h2 class="card-title text-danger">Oportunidades</h2>
                <span class="text-muted" style="font-size: 0.75rem;">(Sem resultados)</span>
            </div>
            <div class="card-body" style="padding: 0 1.5rem 1.5rem;">
                <?php if (!empty($missingTerms)): ?>
                    <?php foreach ($missingTerms as $term): ?>
                    <div class="quick-list-item">
                        <span style="color: #64748b;"><?= htmlspecialchars($term['term']) ?></span>
                        <span class="term-count" style="background: rgba(239, 68, 68, 0.1); color: #ef4444;"><?= $term['attempts'] ?></span>
                    </div>
                    <?php endforeach; ?>
                    <div class="mt-3 text-center">
                        <small class="text-muted">Crie conteúdo sobre estes temas!</small>
                    </div>
                <?php else: ?>
                    <p class="text-muted text-center py-3">Nenhum termo perdido.</p>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Newsletter (Novos Inscritos) -->
        <div class="card glass-panel mt-4">
            <div class="card-header border-0">
                <h2 class="card-title" style="color: #6366f1;">Novos Assinantes</h2>
                <a href="/admin/newsletter" class="btn btn-link btn-sm text-muted" style="text-decoration: none; font-size: 0.8rem;">Ver todos</a>
            </div>
            <div class="card-body" style="padding: 0 1.5rem 1.5rem;">
                <?php if (!empty($recentSubscribers)): ?>
                    <?php foreach ($recentSubscribers as $sub): ?>
                    <div class="quick-list-item">
                        <span style="font-weight: 500; overflow: hidden; text-overflow: ellipsis; max-width: 180px;white-space: nowrap;"><?= htmlspecialchars($sub['email']) ?></span>
                        <span style="font-size: 0.75rem; color: #94a3b8;"><?= date('d/m', strtotime($sub['created_at'])) ?></span>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted text-center py-3">Nenhum assinante recente.</p>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Links Rápidos -->
         <div class="card glass-panel mt-4" style="background: linear-gradient(135deg, #5F7D4E, #3E5232); color: white; border: none;">
            <div class="card-body" style="padding: 1.5rem; text-align: center;">
                <h3 style="color: white; margin-bottom: 0.5rem; font-size: 1.25rem;">Precisa de Ajuda?</h3>
                <p style="font-size: 0.9rem; opacity: 0.9; margin-bottom: 1.5rem; color: rgba(255,255,255,0.9);">Consulte a documentação ou contate o suporte.</p>
                <a href="#" style="display: inline-block; background: #ffffff; color: #5F7D4E; border: none; font-weight: 700; padding: 0.6rem 1.2rem; border-radius: 8px; text-decoration: none; font-size: 0.9rem;">Ver Documentação</a>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('searchChart').getContext('2d');
        
        const chartData = <?= json_encode($chartData ?? ['labels' => [], 'data' => []]) ?>;
        
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: chartData.labels,
                datasets: [{
                    label: 'Buscas',
                    data: chartData.data,
                    borderColor: '#5F7D4E',
                    backgroundColor: 'rgba(95, 125, 78, 0.1)',
                    borderWidth: 3,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#5F7D4E',
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0,0,0,0.05)',
                            drawBorder: false
                        },
                        ticks: { stepSize: 1 }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    });
</script>
