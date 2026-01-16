<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class SearchLog
{
    /**
     * Garante que a tabela search_logs existe
     */
    public static function ensureTableExists()
    {
        $conn = Database::getInstance();
        
        $sql = "CREATE TABLE IF NOT EXISTS search_logs (
            id INT AUTO_INCREMENT PRIMARY KEY,
            term VARCHAR(255) NOT NULL,
            results_count INT DEFAULT 0,
            ip_address VARCHAR(45) NULL,
            user_agent VARCHAR(255) NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_term (term),
            INDEX idx_results (results_count),
            INDEX idx_created_at (created_at)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
        
        $conn->exec($sql);
    }

    /**
     * Registra uma busca
     */
    public static function log(string $term, int $resultsCount): void
    {
        self::ensureTableExists(); // Garante tabela na primeira execução

        $conn = Database::getInstance();

        $stmt = $conn->prepare("INSERT INTO search_logs (term, results_count, ip_address, user_agent) VALUES (:term, :count, :ip, :ua)");
        
        $stmt->execute([
            ':term' => mb_strtolower(trim($term)),
            ':count' => $resultsCount,
            ':ip' => $_SERVER['REMOTE_ADDR'] ?? null,
            ':ua' => $_SERVER['HTTP_USER_AGENT'] ?? null
        ]);
    }

    /**
     * Obtém os termos mais buscados sem resultados
     * @param int $limit
     * @return array
     */
    public static function getNotFoundTerms(int $limit = 10): array
    {
        self::ensureTableExists();

        $conn = Database::getInstance();

        // Agrupa por termo, conta ocorrências e pega a data da última busca
        $sql = "SELECT term, count(*) as attempts, MAX(created_at) as last_attempt 
                FROM search_logs 
                WHERE results_count = 0 
                GROUP BY term 
                ORDER BY attempts DESC, last_attempt DESC 
                LIMIT :limit";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Obtém estatísticas gerais
     */
    public static function getStats(): array
    {
        self::ensureTableExists();
        
        $conn = Database::getInstance();
        
        return [
            'total_searches' => $conn->query("SELECT count(*) FROM search_logs")->fetchColumn(),
            'zero_results' => $conn->query("SELECT count(*) FROM search_logs WHERE results_count = 0")->fetchColumn(),
            'today_searches' => $conn->query("SELECT count(*) FROM search_logs WHERE DATE(created_at) = CURDATE()")->fetchColumn()
        ];
    }
    /**
     * Limpa o histórico de buscas
     * @return bool
     */
    public static function clearLogs(): bool
    {
        self::ensureTableExists();
        $conn = Database::getInstance();
        return (bool) $conn->exec("TRUNCATE TABLE search_logs");
    }
}
