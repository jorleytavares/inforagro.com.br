<?php

namespace App\Helpers;

use App\Core\Database;

/**
 * Helper para acessar configurações do site em qualquer lugar
 */
class Settings
{
    private static array $cache = [];
    private static bool $loaded = false;

    /**
     * Obter valor de uma configuração
     */
    public static function get(string $key, $default = null)
    {
        self::load();
        
        return self::$cache[$key] ?? $default;
    }

    /**
     * Carregar todas as configurações do banco (com cache na requisição)
     */
    private static function load(): void
    {
        if (self::$loaded) {
            return;
        }

        try {
            $rows = Database::fetchAll("SELECT setting_key, setting_value FROM settings");
            foreach ($rows as $row) {
                self::$cache[$row['setting_key']] = $row['setting_value'];
            }
        } catch (\Exception $e) {
            // Silencioso em caso de erro no banco (instalação/migração)
        }
        
        self::$loaded = true;
    }
}
