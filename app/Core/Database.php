<?php

namespace App\Core;

use PDO;
use PDOException;

/**
 * Classe de Conexão com Banco de Dados
 * 
 * Gerencia a conexão PDO com MySQL usando padrão Singleton
 */
class Database
{
    private static ?PDO $instance = null;
    
    /**
     * Obter instância da conexão PDO
     */
    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            try {
                $host = Config::get('DB_HOST', 'localhost');
                $dbname = Config::get('DB_NAME', 'inforagro');
                $user = Config::get('DB_USER', 'root');
                $pass = Config::get('DB_PASS', '');
                
                $dsn = "mysql:host={$host};dbname={$dbname};charset=utf8mb4";
                
                self::$instance = new PDO($dsn, $user, $pass, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]);
                
            } catch (PDOException $e) {
                if (Config::isDebug()) {
                    die("Erro de conexão: " . $e->getMessage());
                }
                die("Erro ao conectar com o banco de dados.");
            }
        }
        
        return self::$instance;
    }
    
    /**
     * Executar query preparada
     */
    public static function query(string $sql, array $params = []): \PDOStatement
    {
        $stmt = self::getInstance()->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
    
    /**
     * Obter todos os resultados
     */
    public static function fetchAll(string $sql, array $params = []): array
    {
        return self::query($sql, $params)->fetchAll();
    }
    
    /**
     * Obter um único resultado
     */
    public static function fetch(string $sql, array $params = []): ?array
    {
        $result = self::query($sql, $params)->fetch();
        return $result ?: null;
    }
    
    /**
     * Obter o último ID inserido
     */
    public static function lastInsertId(): string
    {
        return self::getInstance()->lastInsertId();
    }
}
