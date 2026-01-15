<?php

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

/**
 * Model de Autores
 */
class Author extends Model
{
    protected static string $table = 'authors';
    
    /**
     * Buscar autor por slug
     */
    public static function findBySlug(string $slug): ?array
    {
        return Database::fetch(
            "SELECT * FROM authors WHERE slug = ? AND is_active = 1",
            [$slug]
        );
    }
    
    /**
     * Obter posts de um autor
     */
    public static function getPosts(int $authorId, int $limit = 12, int $offset = 0): array
    {
        return Database::fetchAll(
            "SELECT p.*, c.name as category_name, c.slug as category_slug
             FROM posts p
             LEFT JOIN categories c ON p.category_id = c.id
             WHERE p.author_id = ? AND p.status = 'published'
             ORDER BY p.published_at DESC
             LIMIT ? OFFSET ?",
            [$authorId, $limit, $offset]
        );
    }
    
    /**
     * Contar posts de um autor
     */
    public static function countPosts(int $authorId): int
    {
        $result = Database::fetch(
            "SELECT COUNT(*) as total FROM posts WHERE author_id = ? AND status = 'published'",
            [$authorId]
        );
        return (int) ($result['total'] ?? 0);
    }
    
    /**
     * Obter todos os autores ativos
     */
    public static function getActive(): array
    {
        return Database::fetchAll(
            "SELECT * FROM authors WHERE is_active = 1 ORDER BY name"
        );
    }
}
