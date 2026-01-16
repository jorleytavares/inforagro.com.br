<?php

namespace App\Helpers;

use App\Core\Database;

/**
 * Helper de Logs de Auditoria
 */
class AuditLog
{
    /**
     * Registrar ação
     */
    public static function log(
        string $action,
        ?string $entityType = null,
        ?int $entityId = null,
        ?array $oldData = null,
        ?array $newData = null
    ): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        try {
            Database::query(
                "INSERT INTO audit_logs (user_id, action, entity_type, entity_id, old_data, new_data, ip_address, user_agent, created_at) 
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())",
                [
                    $_SESSION['admin_user_id'] ?? null,
                    $action,
                    $entityType,
                    $entityId,
                    $oldData ? json_encode($oldData) : null,
                    $newData ? json_encode($newData) : null,
                    $_SERVER['REMOTE_ADDR'] ?? null,
                    $_SERVER['HTTP_USER_AGENT'] ?? null,
                ]
            );
        } catch (\Exception $e) {
            // Tabela pode não existir ainda
        }
    }
    
    /**
     * Atalhos para ações comuns
     */
    public static function created(string $entityType, int $entityId, array $data): void
    {
        self::log('create', $entityType, $entityId, null, $data);
    }
    
    public static function updated(string $entityType, int $entityId, array $oldData, array $newData): void
    {
        self::log('update', $entityType, $entityId, $oldData, $newData);
    }
    
    public static function deleted(string $entityType, int $entityId, array $data): void
    {
        self::log('delete', $entityType, $entityId, $data, null);
    }
    
    public static function login(int $userId): void
    {
        self::log('login', 'user', $userId);
    }
    
    public static function logout(): void
    {
        self::log('logout', 'user', $_SESSION['admin_user_id'] ?? null);
    }
}
