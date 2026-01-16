<!-- Página 404 - Temática Agro -->
<section class="error-page">
    <div class="container">
        <div class="error-content">
            <div class="error-icon">🌾</div>
            <span class="error-code">404</span>
            <h1>Eita! Essa colheita não deu certo...</h1>
            <p class="error-tagline">Parece que essa página foi para o pasto e não voltou!</p>
            <p class="error-description">
                O conteúdo que você procura pode ter sido movido, deletado ou talvez nunca tenha existido. 
                <br>Mas não se preocupe, temos muita informação boa esperando por você!
            </p>
            
            <div class="error-suggestions">
                <h3>🔍 O que você pode fazer:</h3>
                <ul>
                    <li>Verificar se o endereço está digitado corretamente</li>
                    <li>Usar nossa busca para encontrar o que precisa</li>
                    <li>Explorar nossas categorias principais</li>
                </ul>
            </div>
            
            <div class="error-actions">
                <a href="/" class="btn btn-primary btn-lg">
                    <span>🏠</span> Voltar ao Início
                </a>
                <a href="/buscar" class="btn btn-outline btn-lg">
                    <span>🔍</span> Fazer uma Busca
                </a>
            </div>
            
            <div class="error-categories">
                <p class="error-categories-title">Ou explore nossas editorias:</p>
                <div class="error-category-links">
                    <a href="/agricultura-e-pecuaria" class="error-category-tag">🌱 Agricultura</a>
                    <a href="/agronegocio" class="error-category-tag">📈 Agronegócio</a>
                    <a href="/meio-ambiente-e-sustentabilidade" class="error-category-tag">🌍 Sustentabilidade</a>
                    <a href="/mundo-pet" class="error-category-tag">🐾 Mundo Pet</a>
                </div>
            </div>
            
            <p class="error-humor">
                <em>"No campo, quem não erra, não acerta. Vamos tentar de novo?" 🚜</em>
            </p>
        </div>
    </div>
</section>

<style>
.error-page {
    min-height: 80vh;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: var(--space-2xl) var(--space-lg);
}

.error-content {
    max-width: 600px;
    margin: 0 auto;
}

.error-icon {
    font-size: 5rem;
    margin-bottom: var(--space-md);
    animation: sway 3s ease-in-out infinite;
}

@keyframes sway {
    0%, 100% { transform: rotate(-5deg); }
    50% { transform: rotate(5deg); }
}

.error-code {
    display: block;
    font-size: 8rem;
    font-weight: 800;
    color: var(--color-primary);
    line-height: 1;
    margin-bottom: var(--space-md);
    text-shadow: 4px 4px 0 rgba(95, 125, 78, 0.2);
}

.error-content h1 {
    font-size: 2rem;
    color: var(--color-text-main);
    margin-bottom: var(--space-sm);
}

.error-tagline {
    font-size: 1.25rem;
    color: var(--color-primary);
    font-weight: 500;
    margin-bottom: var(--space-md);
}

.error-description {
    color: var(--color-secondary);
    line-height: 1.7;
    margin-bottom: var(--space-xl);
}

.error-suggestions {
    background: var(--color-surface);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-lg);
    padding: var(--space-lg);
    margin-bottom: var(--space-xl);
    text-align: left;
}

.error-suggestions h3 {
    font-size: 1rem;
    margin-bottom: var(--space-md);
    color: var(--color-text-main);
}

.error-suggestions ul {
    list-style: none;
    margin: 0;
    padding: 0;
}

.error-suggestions li {
    padding: var(--space-xs) 0;
    color: var(--color-secondary);
    padding-left: 1.5rem;
    position: relative;
}

.error-suggestions li::before {
    content: '✓';
    position: absolute;
    left: 0;
    color: var(--color-primary);
    font-weight: bold;
}

.error-actions {
    display: flex;
    gap: var(--space-md);
    justify-content: center;
    flex-wrap: wrap;
    margin-bottom: var(--space-xl);
}

.error-categories {
    margin-bottom: var(--space-xl);
}

.error-categories-title {
    font-size: 0.875rem;
    color: var(--color-secondary);
    margin-bottom: var(--space-md);
}

.error-category-links {
    display: flex;
    gap: var(--space-sm);
    justify-content: center;
    flex-wrap: wrap;
}

.error-category-tag {
    display: inline-flex;
    align-items: center;
    gap: var(--space-xs);
    padding: var(--space-sm) var(--space-md);
    background: var(--color-surface);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-full);
    color: var(--color-text-main);
    text-decoration: none;
    font-size: 0.875rem;
    transition: all var(--transition-fast);
}

.error-category-tag:hover {
    background: var(--color-primary);
    color: white;
    border-color: var(--color-primary);
    transform: translateY(-2px);
}

.error-humor {
    color: var(--color-secondary);
    font-size: 0.9375rem;
    opacity: 0.8;
}

@media (max-width: 480px) {
    .error-code {
        font-size: 5rem;
    }
    
    .error-content h1 {
        font-size: 1.5rem;
    }
    
    .error-actions {
        flex-direction: column;
    }
    
    .error-actions .btn {
        width: 100%;
        justify-content: center;
    }
}
</style>
