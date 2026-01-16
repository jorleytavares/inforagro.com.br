<?php

namespace App\Controllers\Admin;

use App\Core\Database;

/**
 * Controlador de Configurações (Admin)
 */
class SettingsController extends DashboardController
{
    /**
     * Página de configurações
     */
    public function index(): void
    {
        $this->requireRole('admin');
        $settings = [];
        try {
            $rows = Database::fetchAll("SELECT * FROM settings");
            foreach ($rows as $row) {
                $settings[$row['setting_key']] = $row['setting_value'];
            }
        } catch (\Exception $e) {}
        
        $this->adminView('settings.index', [
            'pageTitle' => 'Configurações | Admin InforAgro',
            'settings' => $settings,
        ]);
    }
    
    /**
     * Salvar configurações
     */
    public function update(): void
    {
        $this->requireRole('admin');
        $this->verifyCsrf();
        
        $fields = [
            'site_name', 'site_description', 'site_keywords',
            'contact_email', 'analytics_id', 'adsense_client_id',
            'facebook_url', 'twitter_url', 'instagram_url', 'youtube_url',
            'footer_text', 'copyright_text',
            'custom_head', 'custom_body_start', 'custom_footer',
            'cloudflare_email', 'cloudflare_api_key', 'cloudflare_zone_id'
        ];
        
        try {
            foreach ($fields as $key) {
                $value = $_POST[$key] ?? '';
                
                // Verificar se existe
                $existing = Database::fetch(
                    "SELECT id FROM settings WHERE setting_key = ?",
                    [$key]
                );
                
                if ($existing) {
                    Database::query(
                        "UPDATE settings SET setting_value = ? WHERE setting_key = ?",
                        [$value, $key]
                    );
                } else {
                    Database::query(
                        "INSERT INTO settings (setting_key, setting_value) VALUES (?, ?)",
                        [$key, $value]
                    );
                }
            }
            
            header('Location: /admin/settings?success=1');
        } catch (\Exception $e) {
            header('Location: /admin/settings?error=' . urlencode($e->getMessage()));
        }
        exit;
    }
    
    /**
     * Limpar Cache Local
     */
    public function clearCache(): void
    {
        // ... (manter existente) ...
        $this->requireRole('admin');
        // $this->verifyCsrf(); (Removido verificação estrita aqui se vier via GET, mas ideal é POST)
        
        // Limpar cache (se houver sistema de cache implementado)
        $cacheDir = ROOT_PATH . '/storage/cache';
        
        if (is_dir($cacheDir)) {
            $files = glob($cacheDir . '/*');
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file);
                }
            }
        }
        
        header('Location: /admin/settings?cache=cleared');
        exit;
    }

    /**
     * Limpar Cache Cloudflare
     */
    public function purgeCloudflare(): void
    {
        $this->requireRole('admin');
        
        $email = \App\Helpers\Settings::get('cloudflare_email');
        $key = \App\Helpers\Settings::get('cloudflare_api_key');
        $zoneId = \App\Helpers\Settings::get('cloudflare_zone_id');
        
        if (!$email || !$key || !$zoneId) {
            header('Location: /admin/settings?error=' . urlencode('Configure as credenciais do Cloudflare primeiro.'));
            exit;
        }
        
        $url = "https://api.cloudflare.com/client/v4/zones/{$zoneId}/purge_cache";
        
        $data = json_encode(['purge_everything' => true]);
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'X-Auth-Email: ' . $email,
            'X-Auth-Key: ' . $key,
            'Content-Type: application/json'
        ]);
        
        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode === 200) {
            header('Location: /admin/settings?cf_cleared=1');
        } else {
            $response = json_decode($result, true);
            $error = $response['errors'][0]['message'] ?? 'Erro desconhecido ao limpar cache.';
            header('Location: /admin/settings?error=' . urlencode('Cloudflare: ' . $error));
        }
        exit;
    }
    public function fixDb(): void
    {
        $this->requireRole('admin');
        
        $updates = [
            "ALTER TABLE posts ADD COLUMN meta_title VARCHAR(255) NULL AFTER status",
            "ALTER TABLE posts ADD COLUMN meta_description TEXT NULL AFTER meta_title",
            "ALTER TABLE posts ADD COLUMN focus_keyword VARCHAR(255) NULL AFTER meta_description",
            "ALTER TABLE posts ADD COLUMN featured_image_caption VARCHAR(255) NULL AFTER featured_image",
            "ALTER TABLE posts ADD COLUMN read_time INT DEFAULT 0 AFTER content",
            "ALTER TABLE posts ADD COLUMN word_count INT DEFAULT 0 AFTER read_time",
            "ALTER TABLE posts ADD COLUMN custom_schema TEXT NULL AFTER content"
        ];
        
        $log = [];
        
        foreach ($updates as $sql) {
            try {
                Database::query($sql);
                $log[] = "Success: " . substr($sql, 0, 50) . "...";
            } catch (\Exception $e) {
                $log[] = "Error/Exists: " . $e->getMessage();
            }
        }
        
        echo "<pre><h3>Database Fix Report</h3>";
        print_r($log);
        echo "<br><a href='/admin/posts'>Voltar para Posts</a>";
        exit;
    }
}
