<!-- Configurações do Site -->
<?php if (!empty($_GET['success'])): ?>
<div class="alert alert-success">Configurações salvas com sucesso!</div>
<?php endif; ?>
<?php if (!empty($_GET['cache'])): ?>
<div class="alert alert-success">Cache limpo com sucesso!</div>
<?php endif; ?>
<?php if (!empty($_GET['cf_cleared'])): ?>
<div class="alert alert-success">Cache do Cloudflare limpo com sucesso! ☁️</div>
<?php endif; ?>

<form action="/admin/settings/update" method="POST">
    <?= $csrfField ?? '' ?>
    <div class="card" style="margin-bottom: 1.5rem;">
        <div class="card-header">
            <h2 class="card-title">Configurações Gerais</h2>
        </div>
        
        <div style="padding: 1.5rem;">
            <div class="form-group">
                <label class="form-label">Nome do Site</label>
                <input type="text" name="site_name" class="form-control" 
                       value="<?= htmlspecialchars($settings['site_name'] ?? 'InfoRagro') ?>">
            </div>
            
            <div class="form-group">
                <label class="form-label">Descrição do Site</label>
                <textarea name="site_description" class="form-control" rows="3"><?= htmlspecialchars($settings['site_description'] ?? '') ?></textarea>
            </div>
            
            <div class="form-group">
                <label class="form-label">Palavras-chave (SEO)</label>
                <input type="text" name="site_keywords" class="form-control" 
                       value="<?= htmlspecialchars($settings['site_keywords'] ?? '') ?>" 
                       placeholder="agronegócio, agricultura, pecuária, sustentabilidade">
            </div>
            
            <div class="form-group">
                <label class="form-label">E-mail de Contato</label>
                <input type="email" name="contact_email" class="form-control" 
                       value="<?= htmlspecialchars($settings['contact_email'] ?? '') ?>">
            </div>
        </div>
    </div>
    
    <div class="card" style="margin-bottom: 1.5rem;">
        <div class="card-header">
            <h2 class="card-title">Integrações</h2>
        </div>
        
        <div style="padding: 1.5rem;">
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Google Analytics ID</label>
                    <input type="text" name="analytics_id" class="form-control" 
                           value="<?= htmlspecialchars($settings['analytics_id'] ?? '') ?>" 
                           placeholder="G-XXXXXXXXXX">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Google AdSense Client ID</label>
                    <input type="text" name="adsense_client_id" class="form-control" 
                           value="<?= htmlspecialchars($settings['adsense_client_id'] ?? '') ?>" 
                           placeholder="ca-pub-XXXXXXXXXXXXXXXX">
                </div>
            </div>
        </div>
    </div>
    
    <div class="card" style="margin-bottom: 1.5rem;">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h2 class="card-title">Cloudflare (CDN)</h2>
            <?php if (!empty($settings['cloudflare_zone_id'])): ?>
            <a href="/admin/settings/purge-cloudflare" class="btn btn-secondary btn-sm" onclick="return confirm('Isso limpará todo o cache da CDN imediatamente. Continuar?')">
                🧹 Purge Cache
            </a>
            <?php endif; ?>
        </div>
        
        <div style="padding: 1.5rem;">
            <div class="alert alert-info" style="margin-bottom: 1rem; font-size: 0.85rem; background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd;">
                Preencha os dados abaixo para habilitar a limpeza de cache automática e manual do Cloudflare.
            </div>
            <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label class="form-label">E-mail da Conta</label>
                    <input type="email" name="cloudflare_email" class="form-control" 
                           value="<?= htmlspecialchars($settings['cloudflare_email'] ?? '') ?>" 
                           placeholder="Ex: seu@email.com">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Global API Key</label>
                    <input type="password" name="cloudflare_api_key" class="form-control" 
                           value="<?= htmlspecialchars($settings['cloudflare_api_key'] ?? '') ?>" 
                           placeholder="Chave Global da API (não compartilhe)">
                </div>
            </div>
             <div class="form-group">
                <label class="form-label">Zone ID (ID da Zona)</label>
                <input type="text" name="cloudflare_zone_id" class="form-control" 
                       value="<?= htmlspecialchars($settings['cloudflare_zone_id'] ?? '') ?>" 
                       placeholder="Ex: 907c471881cafe7b09f50f8636620c27">
            </div>
        </div>
    </div>
    
    <div class="card" style="margin-bottom: 1.5rem;">
        <div class="card-header">
            <h2 class="card-title">Redes Sociais</h2>
        </div>
        
        <div style="padding: 1.5rem;">
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Facebook</label>
                    <input type="url" name="facebook_url" class="form-control" 
                           value="<?= htmlspecialchars($settings['facebook_url'] ?? '') ?>">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Twitter/X</label>
                    <input type="url" name="twitter_url" class="form-control" 
                           value="<?= htmlspecialchars($settings['twitter_url'] ?? '') ?>">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Instagram</label>
                    <input type="url" name="instagram_url" class="form-control" 
                           value="<?= htmlspecialchars($settings['instagram_url'] ?? '') ?>">
                </div>
                
                <div class="form-group">
                    <label class="form-label">YouTube</label>
                    <input type="url" name="youtube_url" class="form-control" 
                           value="<?= htmlspecialchars($settings['youtube_url'] ?? '') ?>">
                </div>
            </div>
        </div>
    </div>
    
    <div class="card" style="margin-bottom: 1.5rem;">
        <div class="card-header">
            <h2 class="card-title">HTML e Scripts Personalizados (Avançado)</h2>
        </div>
        
        <div style="padding: 1.5rem;">
            <div class="alert alert-warning" style="margin-bottom: 1rem; font-size: 0.875rem; background: #fffbeb; color: #92400e; border: 1px solid #fcd34d;">
                ⚠️ <strong>Atenção:</strong> Insira scripts apenas de fontes confiáveis. Código malicioso pode quebrar o site.
            </div>

            <div class="form-group">
                <label class="form-label">Head Code (dentro de &lt;head&gt;)</label>
                <textarea name="custom_head" class="form-control" rows="4" 
                    style="font-family: monospace; font-size: 0.875rem;" 
                    placeholder="<script>...</script> ou <meta ...>"><?= htmlspecialchars($settings['custom_head'] ?? '') ?></textarea>
            </div>
            
            <div class="form-group">
                <label class="form-label">Body Start (logo após &lt;body&gt;)</label>
                <textarea name="custom_body_start" class="form-control" rows="4" 
                    style="font-family: monospace; font-size: 0.875rem;" 
                    style="margin-top: 1rem;"
                    placeholder="Scripts de GTM (noscript), Pixel, etc."><?= htmlspecialchars($settings['custom_body_start'] ?? '') ?></textarea>
            </div>
            
            <div class="form-group">
                <label class="form-label">Scripts de Rodapé (antes de &lt;/body&gt;)</label>
                <textarea name="custom_footer" class="form-control" rows="4" 
                    style="font-family: monospace; font-size: 0.875rem;" 
                    placeholder="Scripts de chat, analytics extras, etc."><?= htmlspecialchars($settings['custom_footer'] ?? '') ?></textarea>
            </div>
        </div>
    </div>
    
    <div class="card" style="margin-bottom: 1.5rem;">
        <div class="card-header">
            <h2 class="card-title">Rodapé</h2>
        </div>
        
        <div style="padding: 1.5rem;">
            <div class="form-group">
                <label class="form-label">Texto do Rodapé</label>
                <textarea name="footer_text" class="form-control" rows="2"><?= htmlspecialchars($settings['footer_text'] ?? '') ?></textarea>
            </div>
            
            <div class="form-group">
                <label class="form-label">Texto de Copyright</label>
                <input type="text" name="copyright_text" class="form-control" 
                       value="<?= htmlspecialchars($settings['copyright_text'] ?? '© ' . date('Y') . ' InfoRagro. Todos os direitos reservados.') ?>">
            </div>
        </div>
    </div>
    
    <div style="display: flex; gap: 1rem; justify-content: space-between;">
        <button type="submit" class="btn btn-primary">Salvar Configurações</button>
        <a href="/admin/settings/clear-cache" class="btn btn-secondary" onclick="return confirm('Limpar cache?')">Limpar Cache</a>
    </div>
</form>
