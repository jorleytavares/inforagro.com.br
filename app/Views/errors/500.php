<!-- Página 500 - Erro Interno -->
<section class="error-page">
    <div class="container">
        <div class="error-content">
            <div class="error-icon">⚠️</div>
            <span class="error-code">500</span>
            <h1>Ops! Algo deu errado...</h1>
            <p class="error-tagline">Nosso servidor teve um probleminha técnico!</p>
            <p class="error-description">
                Estamos cientes do problema e trabalhando para resolver o mais rápido possível.
                <br>Por favor, tente novamente em alguns instantes.
            </p>
            
            <div class="error-suggestions">
                <h3>💡 Enquanto isso, você pode:</h3>
                <ul>
                    <li>Aguardar alguns segundos e tentar novamente</li>
                    <li>Voltar à página anterior</li>
                    <li>Ir para a página inicial</li>
                </ul>
            </div>
            
            <div class="error-actions">
                <a href="/" class="btn btn-primary btn-lg">
                    <span>🏠</span> Voltar ao Início
                </a>
                <a href="javascript:location.reload()" class="btn btn-outline btn-lg">
                    <span>🔄</span> Tentar Novamente
                </a>
            </div>
            
            <p class="error-humor">
                <em>"Até as melhores máquinas precisam de manutenção!" 🔧</em>
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
    animation: pulse 2s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.1); opacity: 0.8; }
}

.error-code {
    display: block;
    font-size: 8rem;
    font-weight: 800;
    color: #dc2626;
    line-height: 1;
    margin-bottom: var(--space-md);
    text-shadow: 4px 4px 0 rgba(220, 38, 38, 0.2);
}

.error-content h1 {
    font-size: 2rem;
    color: var(--color-text-main);
    margin-bottom: var(--space-sm);
}

.error-tagline {
    font-size: 1.25rem;
    color: #dc2626;
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

.error-humor {
    color: var(--color-secondary);
    font-size: 0.9375rem;
    opacity: 0.8;
}
</style>
