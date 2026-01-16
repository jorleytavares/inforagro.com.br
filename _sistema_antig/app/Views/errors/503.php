<!-- Página 503 - Manutenção -->
<section class="maintenance-page">
    <div class="container">
        <div class="maintenance-content">
            <div class="maintenance-icon">🔧</div>
            <h1>Estamos em Manutenção</h1>
            <p class="maintenance-tagline">Voltamos em breve, melhor do que nunca!</p>
            <p class="maintenance-description">
                Estamos realizando melhorias no site para oferecer uma experiência ainda melhor.
                <br>Previsão de retorno: <strong>em breve</strong>
            </p>
            
            <div class="maintenance-progress">
                <div class="progress-bar">
                    <div class="progress-fill" style="width: 75%;"></div>
                </div>
                <p class="progress-text">Quase lá... 🚀</p>
            </div>
            
            <div class="maintenance-social">
                <p>Enquanto isso, siga-nos nas redes sociais:</p>
                <div class="social-links">
                    <a href="#" class="social-link" title="Facebook">📘</a>
                    <a href="#" class="social-link" title="Instagram">📸</a>
                    <a href="#" class="social-link" title="Twitter">🐦</a>
                </div>
            </div>
            
            <p class="maintenance-footer">
                <em>Obrigado pela paciência! O campo não para. ⏳🌾</em>
            </p>
        </div>
    </div>
</section>

<style>
.maintenance-page {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: var(--space-2xl) var(--space-lg);
    background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
}

.maintenance-content {
    max-width: 550px;
    margin: 0 auto;
    background: white;
    padding: var(--space-2xl);
    border-radius: var(--radius-xl);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
}

.maintenance-icon {
    font-size: 5rem;
    margin-bottom: var(--space-lg);
    animation: rotate 4s ease-in-out infinite;
}

@keyframes rotate {
    0%, 100% { transform: rotate(0deg); }
    25% { transform: rotate(15deg); }
    75% { transform: rotate(-15deg); }
}

.maintenance-content h1 {
    font-size: 2.5rem;
    color: var(--color-text-main);
    margin-bottom: var(--space-sm);
    font-weight: 800;
}

.maintenance-tagline {
    font-size: 1.25rem;
    color: var(--color-primary);
    font-weight: 500;
    margin-bottom: var(--space-lg);
}

.maintenance-description {
    color: var(--color-secondary);
    line-height: 1.7;
    margin-bottom: var(--space-xl);
}

.maintenance-progress {
    margin-bottom: var(--space-xl);
}

.progress-bar {
    height: 12px;
    background: var(--color-surface);
    border-radius: var(--radius-full);
    overflow: hidden;
    margin-bottom: var(--space-sm);
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--color-primary), #22c55e);
    border-radius: var(--radius-full);
    transition: width 1s ease;
    animation: shimmer 2s infinite;
}

@keyframes shimmer {
    0% { background-position: -200% 0; }
    100% { background-position: 200% 0; }
}

.progress-text {
    font-size: 0.9rem;
    color: var(--color-secondary);
}

.maintenance-social {
    margin-bottom: var(--space-xl);
}

.maintenance-social p {
    font-size: 0.9rem;
    color: var(--color-secondary);
    margin-bottom: var(--space-md);
}

.social-links {
    display: flex;
    gap: var(--space-md);
    justify-content: center;
}

.social-link {
    font-size: 2rem;
    text-decoration: none;
    transition: transform var(--transition-fast);
}

.social-link:hover {
    transform: scale(1.2);
}

.maintenance-footer {
    color: var(--color-secondary);
    font-size: 0.9375rem;
    opacity: 0.8;
}
</style>
