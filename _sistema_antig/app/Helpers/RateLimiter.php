<?php

namespace App\Helpers;

use App\Core\Database;

/**
 * Helper de Rate Limiting
 * Protege contra ataques de força bruta
 */
class RateLimiter
{
    private static int $maxAttempts = 5;
    private static int $decayMinutes = 15;
    
    /**
     * Verificar se IP/email está bloqueado
     */
    public static function tooManyAttempts(string $key): bool
    {
        self::cleanup();
        
        try {
            $result = Database::fetch(
                "SELECT COUNT(*) as attempts FROM login_attempts 
                 WHERE attempt_key = ? AND created_at > DATE_SUB(NOW(), INTERVAL ? MINUTE)",
                [$key, self::$decayMinutes]
            );
            
            return ($result['attempts'] ?? 0) >= self::$maxAttempts;
        } catch (\Exception $e) {
            return false; // Se tabela não existe, não bloqueia
        }
    }
    
    /**
     * Registrar tentativa falha
     */
    public static function hit(string $key): void
    {
        try {
            Database::query(
                "INSERT INTO login_attempts (attempt_key, ip_address, created_at) VALUES (?, ?, NOW())",
                [$key, $_SERVER['REMOTE_ADDR'] ?? '']
            );
        } catch (\Exception $e) {
            // Tabela pode não existir ainda
        }
    }
    
    /**
     * Limpar tentativas após login bem-sucedido
     */
    public static function clear(string $key): void
    {
        try {
            Database::query("DELETE FROM login_attempts WHERE attempt_key = ?", [$key]);
        } catch (\Exception $e) {}
    }
    
    /**
     * Obter tempo restante de bloqueio em segundos
     */
    public static function availableIn(string $key): int
    {
        try {
            $result = Database::fetch(
                "SELECT created_at FROM login_attempts 
                 WHERE attempt_key = ? 
                 ORDER BY created_at DESC LIMIT 1",
                [$key]
            );
            
            if ($result) {
                $lastAttempt = strtotime($result['created_at']);
                $unblockTime = $lastAttempt + (self::$decayMinutes * 60);
                return max(0, $unblockTime - time());
            }
        } catch (\Exception $e) {}
        
        return 0;
    }
    
    /**
     * Limpar tentativas antigas
     */
    private static function cleanup(): void
    {
        try {
            Database::query(
                "DELETE FROM login_attempts WHERE created_at < DATE_SUB(NOW(), INTERVAL ? MINUTE)",
                [self::$decayMinutes * 2]
            );
        } catch (\Exception $e) {}
    }
}
