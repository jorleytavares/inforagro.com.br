<?php

namespace App\Helpers;

/**
 * Helper de Analytics e Publicidade
 * 
 * Gera scripts para Google Analytics 4 e Google AdSense
 */
class AnalyticsHelper
{
    /**
     * Gerar script do Google Analytics 4
     */
    public static function getGoogleAnalytics(?string $measurementId = null): string
    {
        if (empty($measurementId)) {
            return '';
        }
        
        return <<<HTML
<!-- Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id={$measurementId}"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', '{$measurementId}', {
        'anonymize_ip': true,
        'cookie_flags': 'SameSite=None;Secure'
    });
</script>
HTML;
    }
    
    /**
     * Gerar script do Google AdSense
     */
    public static function getAdSenseScript(?string $clientId = null): string
    {
        if (empty($clientId)) {
            return '';
        }
        
        return <<<HTML
<!-- Google AdSense -->
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client={$clientId}"
     crossorigin="anonymous"></script>
HTML;
    }
    
    /**
     * Gerar bloco de anúncio
     */
    public static function getAdUnit(string $slot, string $format = 'auto', bool $fullWidth = true): string
    {
        return <<<HTML
<!-- Ad Unit -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-format="{$format}"
     data-ad-slot="{$slot}"
     data-full-width-responsive="{($fullWidth ? 'true' : 'false')}"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
HTML;
    }
    
    /**
     * Gerar placeholder de anúncio (para desenvolvimento)
     */
    public static function getAdPlaceholder(string $size = '728x90'): string
    {
        $sizes = [
            '728x90' => ['width' => 728, 'height' => 90],
            '300x250' => ['width' => 300, 'height' => 250],
            '336x280' => ['width' => 336, 'height' => 280],
            '160x600' => ['width' => 160, 'height' => 600],
            '300x600' => ['width' => 300, 'height' => 600],
        ];
        
        $dim = $sizes[$size] ?? $sizes['728x90'];
        
        return <<<HTML
<div class="ad-placeholder" style="
    width: {$dim['width']}px;
    max-width: 100%;
    height: {$dim['height']}px;
    background: linear-gradient(135deg, #f1f5f9 25%, #e2e8f0 50%, #f1f5f9 75%);
    border: 2px dashed #cbd5e1;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #64748b;
    font-size: 14px;
    margin: 16px auto;
">
    📢 Espaço publicitário ({$size})
</div>
HTML;
    }
}
