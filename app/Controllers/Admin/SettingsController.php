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
            'custom_head', 'custom_body_start', 'custom_footer'
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
     * Cache
     */
    public function clearCache(): void
    {
        $this->requireRole('admin');
        $this->verifyCsrf();
        
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
}
