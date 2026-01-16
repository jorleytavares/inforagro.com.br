<!-- Página de Contato -->
<section class="page-content">
    <div class="container container-article">
        <header class="page-header">
            <h1>Contato</h1>
            <p class="page-subtitle">Entre em contato com a equipe do InfoRagro</p>
        </header>
        
        <div class="contact-grid">
            <div class="contact-info">
                <h2>Fale Conosco</h2>
                <p>Estamos sempre abertos para ouvir você. Entre em contato para:</p>
                <ul>
                    <li>Sugestões de pautas</li>
                    <li>Parcerias comerciais</li>
                    <li>Dúvidas sobre nosso conteúdo</li>
                    <li>Reportar erros ou correções</li>
                </ul>
                
                <div class="contact-channels">
                    <div class="contact-channel">
                        <span class="channel-icon">📧</span>
                        <div>
                            <strong>E-mail</strong>
                            <p>contato@inforagro.com.br</p>
                        </div>
                    </div>
                    <div class="contact-channel">
                        <span class="channel-icon">📍</span>
                        <div>
                            <strong>Localização</strong>
                            <p>São Paulo, Brasil</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="contact-form-wrapper">
                <?php if (!empty($success)): ?>
                <div class="alert alert-success">
                    <strong>Mensagem enviada!</strong> Obrigado pelo contato. Responderemos em breve.
                </div>
                <?php endif; ?>
                
                <form class="contact-form" action="/contato" method="POST">
                    <div class="form-group">
                        <label for="name">Nome *</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">E-mail *</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="subject">Assunto</label>
                        <select id="subject" name="subject">
                            <option value="geral">Dúvida Geral</option>
                            <option value="pauta">Sugestão de Pauta</option>
                            <option value="parceria">Parceria Comercial</option>
                            <option value="correcao">Correção de Conteúdo</option>
                            <option value="outro">Outro</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="message">Mensagem *</label>
                        <textarea id="message" name="message" rows="5" required></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-lg">Enviar Mensagem</button>
                </form>
            </div>
        </div>
    </div>
</section>
