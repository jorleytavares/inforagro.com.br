<?php

namespace App\Core;

/**
 * Classe de Configuração
 * 
 * Carrega e gerencia as configurações da aplicação
 */
class Config
{
    private static array $config = [];
    
    /**
     * Carregar configurações do arquivo .env ou variáveis de ambiente
     */
    public static function load(): void
    {
        // Carregar do arquivo .env se existir
        $envFile = ROOT_PATH . '/.env';
        if (file_exists($envFile)) {
            $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                // Ignorar comentários
                if (strpos(trim($line), '#') === 0) {
                    continue;
                }
                
                // Parsear KEY=VALUE
                if (strpos($line, '=') !== false) {
                    list($key, $value) = explode('=', $line, 2);
                    $key = trim($key);
                    $value = trim($value);
                    
                    self::$config[$key] = $value;
                    
                    // Também definir como variável de ambiente
                    if (!getenv($key)) {
                        putenv("$key=$value");
                    }
                }
            }
        }
        
        // Sobrescrever com variáveis de ambiente do Docker/Sistema
        $envVars = ['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS', 'APP_ENV', 'APP_DEBUG'];
        foreach ($envVars as $var) {
            if (getenv($var)) {
                self::$config[$var] = getenv($var);
            }
        }
    }
    
    /**
     * Obter valor de configuração
     */
    public static function get(string $key, $default = null)
    {
        // Carregar configurações se ainda não foram carregadas
        if (empty(self::$config)) {
            self::load();
        }
        
        return self::$config[$key] ?? $default;
    }
    
    /**
     * Verificar se está em modo debug
     */
    public static function isDebug(): bool
    {
        return self::get('APP_DEBUG', 'false') === 'true';
    }
}

// Carregar configurações automaticamente
Config::load();
