<?php

namespace App\Helpers;

/**
 * Helper de Segurança de Sessão
 */
class SessionSecurity
{
    /**
     * Tempo de expiração da sessão em segundos (30 minutos)
     */
    private static int $sessionTimeout = 1800;
    
    /**
     * Tempo para regenerar ID da sessão (5 minutos)
     */
    private static int $regenerateInterval = 300;
    
    /**
     * Inicializar sessão com configurações seguras
     */
    public static function init(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            // Configurações de segurança
            ini_set('session.cookie_httponly', 1);
            ini_set('session.cookie_samesite', 'Strict');
            ini_set('session.use_strict_mode', 1);
            ini_set('session.use_only_cookies', 1);
            
            // HTTPS apenas
            if (self::isHttps()) {
                ini_set('session.cookie_secure', 1);
            }
            
            session_start();
        }
        
        // Verificar expiração
        self::checkExpiration();
        
        // Regenerar ID periodicamente
        self::regenerateIfNeeded();
    }
    
    /**
     * Verificar se sessão expirou
     */
    public static function checkExpiration(): bool
    {
        if (isset($_SESSION['last_activity'])) {
            $idleTime = time() - $_SESSION['last_activity'];
            
            if ($idleTime > self::$sessionTimeout) {
                self::destroy();
                return true;
            }
        }
        
        $_SESSION['last_activity'] = time();
        return false;
    }
    
    /**
     * Regenerar ID da sessão periodicamente
     */
    public static function regenerateIfNeeded(): void
    {
        if (!isset($_SESSION['created_at'])) {
            $_SESSION['created_at'] = time();
            return;
        }
        
        $age = time() - $_SESSION['created_at'];
        
        if ($age > self::$regenerateInterval) {
            session_regenerate_id(true);
            $_SESSION['created_at'] = time();
        }
    }
    
    /**
     * Destruir sessão completamente
     */
    public static function destroy(): void
    {
        $_SESSION = [];
        
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }
        
        session_destroy();
    }
    
    /**
     * Verificar se está em HTTPS
     */
    private static function isHttps(): bool
    {
        return (
            (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ||
            ($_SERVER['SERVER_PORT'] ?? 80) == 443 ||
            (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')
        );
    }
    
    /**
     * Obter tempo restante da sessão em segundos
     */
    public static function getTimeRemaining(): int
    {
        if (!isset($_SESSION['last_activity'])) {
            return 0;
        }
        
        $remaining = self::$sessionTimeout - (time() - $_SESSION['last_activity']);
        return max(0, $remaining);
    }
    
    /**
     * Verificar se usuário está logado
     */
    public static function isLoggedIn(): bool
    {
        return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
    }
    
    /**
     * Obter dados do usuário logado
     */
    public static function getUser(): ?array
    {
        if (!self::isLoggedIn()) {
            return null;
        }
        
        return [
            'id' => $_SESSION['admin_user_id'] ?? null,
            'name' => $_SESSION['admin_name'] ?? '',
            'email' => $_SESSION['admin_email'] ?? '',
            'role' => $_SESSION['admin_role'] ?? 'author',
        ];
    }
}
