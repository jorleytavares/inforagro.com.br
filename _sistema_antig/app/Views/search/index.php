<!-- Página de Busca Criativa -->
<section class="search-page">
    <div class="container">
        <!-- Header com campo de busca -->
        <header class="search-header">
            <div class="search-icon-big">🔍</div>
            <h1>Encontre o que precisa no <span class="text-gradient">InforAgro</span></h1>
            <p class="search-subtitle">Milhares de artigos sobre agronegócio, agricultura, pecuária e sustentabilidade</p>
            
            <form class="search-form-hero" action="/buscar" method="GET">
                <div class="search-input-wrapper">
                    <span class="search-input-icon">🌾</span>
                    <input type="search" name="q" value="<?= htmlspecialchars($query ?? '') ?>" 
                           placeholder="O que você quer saber sobre o agro?" autofocus autocomplete="off">
                    <button type="submit" class="btn btn-primary btn-search">
                        <span>Buscar</span>
                        <span class="btn-icon">→</span>
                    </button>
                </div>
            </form>
        </header>
        
        <?php if (!empty($query)): ?>
        <!-- Resultados da Busca -->
            <?php if (!empty($posts)): ?>
            <!-- Resultados da Busca -->
            <div class="search-results-section">
                <div class="search-results-header">
                    <p class="search-results-count">
                        <span class="count-number"><?= $totalResults ?? count($posts) ?></span> 
                        resultado<?= ($totalResults ?? count($posts)) !== 1 ? 's' : '' ?> para 
                        "<span class="count-query"><?= htmlspecialchars($query) ?></span>"
                    </p>
                </div>
            
            <!-- Lista de Resultados -->
            <div class="search-results-list">
                <?php foreach ($posts as $post): ?>
                <article class="search-result-card">
                    <?php if (!empty($post['featured_image'])): ?>
                    <a href="/<?= htmlspecialchars($post['category_slug']) ?>/<?= htmlspecialchars($post['slug']) ?>" class="result-image">
                        <img src="<?= htmlspecialchars($post['featured_image']) ?>" alt="<?= htmlspecialchars($post['title']) ?>" loading="lazy">
                    </a>
                    <?php endif; ?>
                    <div class="result-content">
                        <div class="result-meta-top">
                            <span class="result-category"><?= htmlspecialchars($post['category_name'] ?? 'Artigo') ?></span>
                            <span class="result-date"><?= date('d/m/Y', strtotime($post['published_at'])) ?></span>
                        </div>
                        <h2 class="result-title">
                            <a href="/<?= htmlspecialchars($post['category_slug']) ?>/<?= htmlspecialchars($post['slug']) ?>">
                                <?= htmlspecialchars($post['title']) ?>
                            </a>
                        </h2>
                        <p class="result-excerpt"><?= htmlspecialchars($post['excerpt'] ?? '') ?></p>
                        <div class="result-meta-bottom">
                            <span class="result-author">✍ <?= htmlspecialchars($post['author_name'] ?? 'Equipe InforAgro') ?></span>
                            <?php if (!empty($post['read_time'])): ?>
                            <span class="result-read-time">⏱ <?= $post['read_time'] ?> min</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>
            
            <?php else: ?>
            <!-- Nenhum resultado -->
            <div class="search-no-results">
                <div class="no-results-icon">🌱</div>
                <h2>Essa semente ainda não germinou...</h2>
                <p class="no-results-message">
                    Não encontramos resultados para "<strong><?= htmlspecialchars($query) ?></strong>", 
                    mas isso não significa que não existe!
                </p>
                
                <div class="no-results-tips">
                    <h3>💡 Dicas para melhorar sua busca:</h3>
                    <ul>
                        <li><span class="tip-icon">✓</span> Verifique se as palavras estão escritas corretamente</li>
                        <li><span class="tip-icon">✓</span> Tente usar palavras-chave mais simples</li>
                        <li><span class="tip-icon">✓</span> Use termos relacionados ao agronegócio</li>
                        <li><span class="tip-icon">✓</span> Remova acentos ou caracteres especiais</li>
                    </ul>
                </div>
                
                <div class="no-results-suggestions">
                    <h3>🔥 Buscas populares:</h3>
                    <div class="suggestion-pills">
                        <a href="/buscar?q=safra 2026" class="pill">Safra 2026</a>
                        <a href="/buscar?q=preço soja" class="pill">Preço Soja</a>
                        <a href="/buscar?q=crédito rural" class="pill">Crédito Rural</a>
                        <a href="/buscar?q=agricultura regenerativa" class="pill">Agricultura Regenerativa</a>
                        <a href="/buscar?q=mercado de carbono" class="pill">Mercado de Carbono</a>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
        
        <?php else: ?>
        <!-- Estado inicial (sem busca) -->
        <div class="search-initial-state">
            <div class="popular-searches">
                <h2>🔥 Buscas mais populares</h2>
                <div class="popular-grid">
                    <a href="/buscar?q=soja" class="popular-item">
                        <span class="popular-icon">🌱</span>
                        <span class="popular-text">Soja</span>
                    </a>
                    <a href="/buscar?q=milho" class="popular-item">
                        <span class="popular-icon">🌽</span>
                        <span class="popular-text">Milho</span>
                    </a>
                    <a href="/buscar?q=café" class="popular-item">
                        <span class="popular-icon">☕</span>
                        <span class="popular-text">Café</span>
                    </a>
                    <a href="/buscar?q=pecuária" class="popular-item">
                        <span class="popular-icon">🐄</span>
                        <span class="popular-text">Pecuária</span>
                    </a>
                    <a href="/buscar?q=sustentabilidade" class="popular-item">
                        <span class="popular-icon">🌍</span>
                        <span class="popular-text">Sustentabilidade</span>
                    </a>
                    <a href="/buscar?q=tecnologia agrícola" class="popular-item">
                        <span class="popular-icon">🚜</span>
                        <span class="popular-text">Tecnologia</span>
                    </a>
                </div>
            </div>
            
            <div class="search-categories">
                <h2>📂 Explore por categoria</h2>
                <div class="category-cards">
                    <a href="/agricultura-e-pecuaria" class="category-card" style="--card-color: #4CAF50;">
                        <span class="category-emoji">🌾</span>
                        <h3>Agricultura e Pecuária</h3>
                        <p>Culturas, manejo, criação animal</p>
                    </a>
                    <a href="/agronegocio" class="category-card" style="--card-color: #2196F3;">
                        <span class="category-emoji">📈</span>
                        <h3>Agronegócio</h3>
                        <p>Mercado, commodities, economia</p>
                    </a>
                    <a href="/meio-ambiente-e-sustentabilidade" class="category-card" style="--card-color: #009688;">
                        <span class="category-emoji">🌿</span>
                        <h3>Sustentabilidade</h3>
                        <p>ESG, carbono, preservação</p>
                    </a>
                    <a href="/mundo-pet" class="category-card" style="--card-color: #FF9800;">
                        <span class="category-emoji">🐾</span>
                        <h3>Mundo Pet</h3>
                        <p>Pets, veterinária, cuidados</p>
                    </a>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>

<style>
/* ===== Search Page Styles ===== */
.search-page {
    padding: var(--space-2xl) 0;
    min-height: 70vh;
    background: linear-gradient(to bottom, var(--color-background) 0%, rgba(95, 125, 78, 0.05) 100%);
}

.search-header {
    text-align: center;
    margin-bottom: var(--space-3xl);
    max-width: 800px;
    margin-left: auto;
    margin-right: auto;
}

.search-icon-big {
    font-size: 4rem;
    margin-bottom: var(--space-md);
    background: #e8f5e9;
    width: 100px;
    height: 100px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
}

.search-header h1 {
    font-size: 3rem;
    line-height: 1.2;
    margin-bottom: var(--space-md);
    font-weight: 800;
    color: var(--color-text-main);
}

.text-gradient {
    background: linear-gradient(135deg, #2e7d32, #66bb6a);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    color: #2e7d32; /* Fallback */
    display: inline-block;
}

.search-subtitle {
    color: var(--color-secondary);
    font-size: 1.25rem;
    margin-bottom: var(--space-xl);
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

.search-form-hero {
    max-width: 700px;
    margin: 0 auto;
    position: relative;
    z-index: 10;
}

.search-input-wrapper {
    display: flex;
    align-items: center;
    background: white;
    border: 2px solid transparent; /* Remove borda padrão para sombra brilhar */
    border-radius: 50px; /* Mais arredondado */
    padding: var(--space-xs); /* Padding menor wrapper, maior input */
    box-shadow: 0 10px 40px rgba(0,0,0,0.08); /* Sombra mais suave e espalhada */
    transition: all 0.3s ease;
}

.search-input-wrapper:focus-within {
    transform: translateY(-2px);
    box-shadow: 0 15px 50px rgba(95, 125, 78, 0.2);
    border-color: rgba(95, 125, 78, 0.3);
}

.search-input-icon {
    font-size: 1.5rem;
    padding-left: var(--space-lg);
    padding-right: var(--space-xs);
    opacity: 0.7;
}

.search-input-wrapper input {
    flex: 1;
    border: none;
    background: none;
    font-size: 1.125rem;
    padding: var(--space-md);
    outline: none;
    color: var(--color-text-main);
}

.btn-search {
    display: flex;
    align-items: center;
    gap: var(--space-sm);
    padding: var(--space-md) var(--space-xl);
    font-size: 1rem;
    border-radius: 40px; /* Igual ao wrapper */
    font-weight: 600;
}

.btn-icon {
    transition: transform var(--transition-fast);
}

.btn-search:hover .btn-icon {
    transform: translateX(4px);
}

/* Results Section */
.search-results-header {
    margin-bottom: var(--space-xl);
    border-bottom: 2px solid var(--color-border);
    padding-bottom: var(--space-lg);
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.search-results-count {
    font-size: 1.125rem;
    color: var(--color-secondary);
}

.count-number {
    font-size: 1.5rem;
    font-weight: 800;
    color: var(--color-primary);
}

.count-query {
    color: var(--color-text-main);
    font-style: italic;
    font-weight: 600;
}

/* Result Cards */
.search-results-list {
    display: flex;
    flex-direction: column;
    gap: var(--space-lg);
}

.search-result-card {
    display: flex;
    gap: var(--space-lg);
    background: white;
    border: 1px solid transparent;
    border-radius: var(--radius-lg);
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 2px 10px rgba(0,0,0,0.03);
}

.search-result-card:hover {
    box-shadow: 0 15px 30px rgba(0,0,0,0.08);
    transform: translateY(-3px);
    border-color: rgba(95, 125, 78, 0.2);
}

.result-image {
    width: 240px; /* Maior */
    min-height: 180px;
    flex-shrink: 0;
    overflow: hidden;
}

.result-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.search-result-card:hover .result-image img {
    transform: scale(1.05);
}

.result-content {
    flex: 1;
    padding: var(--space-lg);
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.result-meta-top {
    display: flex;
    gap: var(--space-md);
    margin-bottom: var(--space-sm);
    align-items: center;
}

.result-category {
    background: rgba(95, 125, 78, 0.1);
    color: var(--color-primary);
    padding: 4px 10px;
    border-radius: var(--radius-full);
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.result-date {
    color: var(--color-secondary);
    font-size: 0.875rem;
}

.result-title {
    font-size: 1.5rem;
    margin-bottom: var(--space-sm);
    line-height: 1.3;
    font-weight: 700;
}

.result-title a {
    color: var(--color-text-main);
    text-decoration: none;
    transition: color 0.2s;
}

.result-title a:hover {
    color: var(--color-primary);
}

.result-excerpt {
    color: var(--color-secondary);
    line-height: 1.6;
    margin-bottom: var(--space-md);
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.result-meta-bottom {
    display: flex;
    gap: var(--space-lg);
    font-size: 0.875rem;
    color: var(--color-secondary);
    border-top: 1px solid var(--color-border);
    padding-top: var(--space-md);
    margin-top: auto;
}

/* No Results */
.search-no-results {
    text-align: center;
    padding: var(--space-3xl) 0;
}

.no-results-icon {
    font-size: 5rem;
    margin-bottom: var(--space-md);
    animation: floating 3s ease-in-out infinite;
}

@keyframes floating {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

.search-no-results h2 {
    font-size: 2rem;
    margin-bottom: var(--space-sm);
    color: var(--color-text-main);
}

.no-results-message {
    font-size: 1.25rem;
    color: var(--color-secondary);
    margin-bottom: var(--space-2xl);
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

.no-results-tips {
    background: white;
    border-radius: var(--radius-xl);
    padding: var(--space-2xl);
    margin-bottom: var(--space-2xl);
    text-align: left;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
}

.no-results-tips h3 {
    margin-bottom: var(--space-lg);
    font-size: 1.25rem;
    color: var(--color-text-main);
    display: flex;
    align-items: center;
    gap: var(--space-sm);
}

.no-results-tips ul {
    list-style: none;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: var(--space-md);
}

.no-results-tips li {
    display: flex;
    align-items: center;
    gap: var(--space-sm);
    color: var(--color-secondary);
    font-size: 0.95rem;
}

.tip-icon {
    color: var(--color-success);
    font-weight: bold;
    background: rgba(var(--color-success-rgb), 0.1);
    width: 24px;
    height: 24px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.8rem;
}

.no-results-suggestions h3 {
    margin-bottom: var(--space-lg);
    font-size: 1.25rem;
    color: var(--color-text-main);
}

.suggestion-pills {
    display: flex;
    flex-wrap: wrap;
    gap: var(--space-sm);
    justify-content: center;
}

.pill {
    background: white;
    padding: var(--space-sm) var(--space-lg);
    border-radius: var(--radius-full);
    color: var(--color-text-main);
    text-decoration: none;
    font-size: 0.95rem;
    font-weight: 500;
    transition: all var(--transition-fast);
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    border: 1px solid transparent;
}

.pill:hover {
    background: var(--color-primary);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(95, 125, 78, 0.3);
}

/* Initial State */
.search-initial-state {
    display: flex;
    flex-direction: column;
    gap: var(--space-3xl);
}

.popular-searches h2, .search-categories h2 {
    text-align: center;
    margin-bottom: var(--space-xl);
    font-size: 1.75rem;
}

.popular-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: var(--space-lg);
    max-width: 900px;
    margin: 0 auto;
}

.popular-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: var(--space-md);
    padding: var(--space-xl) var(--space-lg);
    background: white;
    border-radius: var(--radius-xl);
    text-decoration: none;
    color: var(--color-text-main);
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0,0,0,0.03);
    text-align: center;
}

.popular-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.08);
}

.popular-icon {
    font-size: 2.5rem;
    transition: transform 0.3s ease;
}

.popular-item:hover .popular-icon {
    transform: scale(1.1);
}

.popular-text {
    font-weight: 600;
    font-size: 1.05rem;
}

.search-categories {
    max-width: 1000px;
    margin: 0 auto;
    width: 100%;
}

.category-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: var(--space-lg);
}

.category-card {
    background: white;
    border-radius: var(--radius-xl);
    padding: var(--space-xl);
    text-decoration: none;
    color: var(--color-text-main);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.03);
    border: 1px solid transparent;
}

.category-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.08);
    border-color: rgba(0,0,0,0.05);
}

.category-emoji {
    font-size: 3rem;
    display: block;
    margin-bottom: var(--space-md);
}

.category-card h3 {
    margin-bottom: var(--space-xs);
    font-size: 1.25rem;
    font-weight: 700;
}

.category-card p {
    color: var(--color-secondary);
    font-size: 0.9rem;
    line-height: 1.5;
}

@media (max-width: 768px) {
    .search-header h1 {
        font-size: 2rem;
    }
    
    .search-input-wrapper {
        padding: 5px;
    }
    
    .btn-search {
        padding: var(--space-sm) var(--space-lg);
    }
    
    .search-result-card {
        flex-direction: column;
    }
    
    .result-image {
        width: 100%;
        min-height: 200px;
    }
    
    .no-results-tips ul {
        grid-template-columns: 1fr;
    }
}
</style>
