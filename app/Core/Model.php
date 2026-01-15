<?php

namespace App\Core;

/**
 * Model Base
 * 
 * Classe base para todos os models da aplicação
 */
abstract class Model
{
    protected static string $table = '';
    protected static string $primaryKey = 'id';
    
    /**
     * Obter todos os registros
     */
    public static function all(): array
    {
        $table = static::$table;
        return Database::fetchAll("SELECT * FROM {$table}");
    }
    
    /**
     * Buscar por ID
     */
    public static function find(int $id): ?array
    {
        $table = static::$table;
        $pk = static::$primaryKey;
        return Database::fetch("SELECT * FROM {$table} WHERE {$pk} = ?", [$id]);
    }
    
    /**
     * Buscar por condição
     */
    public static function where(string $column, $value): array
    {
        $table = static::$table;
        return Database::fetchAll("SELECT * FROM {$table} WHERE {$column} = ?", [$value]);
    }
    
    /**
     * Buscar primeiro por condição
     */
    public static function whereFirst(string $column, $value): ?array
    {
        $table = static::$table;
        return Database::fetch("SELECT * FROM {$table} WHERE {$column} = ? LIMIT 1", [$value]);
    }
    
    /**
     * Inserir novo registro
     */
    public static function create(array $data): int
    {
        $table = static::$table;
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        
        Database::query(
            "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})",
            array_values($data)
        );
        
        return (int) Database::lastInsertId();
    }
    
    /**
     * Atualizar registro
     */
    public static function update(int $id, array $data): bool
    {
        $table = static::$table;
        $pk = static::$primaryKey;
        
        $setParts = [];
        foreach (array_keys($data) as $column) {
            $setParts[] = "{$column} = ?";
        }
        $setClause = implode(', ', $setParts);
        
        $values = array_values($data);
        $values[] = $id;
        
        Database::query("UPDATE {$table} SET {$setClause} WHERE {$pk} = ?", $values);
        
        return true;
    }
    
    /**
     * Deletar registro
     */
    public static function delete(int $id): bool
    {
        $table = static::$table;
        $pk = static::$primaryKey;
        
        Database::query("DELETE FROM {$table} WHERE {$pk} = ?", [$id]);
        
        return true;
    }
    
    /**
     * Contar registros
     */
    public static function count(): int
    {
        $table = static::$table;
        $result = Database::fetch("SELECT COUNT(*) as total FROM {$table}");
        return (int) ($result['total'] ?? 0);
    }
}
