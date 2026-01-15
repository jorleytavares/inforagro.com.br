<?php

namespace App\Helpers;

/**
 * Helper de Cache Simples
 * 
 * Armazena dados em cache por um tempo definido
 */
class CacheHelper
{
    private static string $cacheDir = '';
    
    /**
     * Inicializar diretório de cache
     */
    private static function init(): void
    {
        if (empty(self::$cacheDir)) {
            self::$cacheDir = ROOT_PATH . '/storage/cache';
            
            if (!is_dir(self::$cacheDir)) {
                mkdir(self::$cacheDir, 0755, true);
            }
        }
    }
    
    /**
     * Obter item do cache
     */
    public static function get(string $key): mixed
    {
        self::init();
        
        $file = self::getFilePath($key);
        
        if (!file_exists($file)) {
            return null;
        }
        
        $data = unserialize(file_get_contents($file));
        
        // Verificar expiração
        if ($data['expires'] < time()) {
            unlink($file);
            return null;
        }
        
        return $data['value'];
    }
    
    /**
     * Armazenar item no cache
     */
    public static function set(string $key, mixed $value, int $ttl = 3600): void
    {
        self::init();
        
        $file = self::getFilePath($key);
        
        $data = [
            'expires' => time() + $ttl,
            'value' => $value,
        ];
        
        file_put_contents($file, serialize($data));
    }
    
    /**
     * Remover item do cache
     */
    public static function delete(string $key): void
    {
        self::init();
        
        $file = self::getFilePath($key);
        
        if (file_exists($file)) {
            unlink($file);
        }
    }
    
    /**
     * Limpar todo o cache
     */
    public static function clear(): void
    {
        self::init();
        
        $files = glob(self::$cacheDir . '/*.cache');
        
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }
    
    /**
     * Lembrar (get or set)
     */
    public static function remember(string $key, int $ttl, callable $callback): mixed
    {
        $value = self::get($key);
        
        if ($value !== null) {
            return $value;
        }
        
        $value = $callback();
        self::set($key, $value, $ttl);
        
        return $value;
    }
    
    /**
     * Obter caminho do arquivo de cache
     */
    private static function getFilePath(string $key): string
    {
        return self::$cacheDir . '/' . md5($key) . '.cache';
    }
}
