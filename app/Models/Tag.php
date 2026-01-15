<?php

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

/**
 * Model de Tags
 */
class Tag extends Model
{
    protected static string $table = 'tags';
    
    /**
     * Buscar tag por slug
     */
    public static function findBySlug(string $slug): ?array
    {
        return Database::fetch("SELECT * FROM tags WHERE slug = ?", [$slug]);
    }
    
    /**
     * Obter posts de uma tag
     */
    public static function getPosts(int $tagId, int $limit = 12, int $offset = 0): array
    {
        return Database::fetchAll(
            "SELECT p.*, c.name as category_name, c.slug as category_slug
             FROM posts p
             INNER JOIN post_tags pt ON p.id = pt.post_id
             LEFT JOIN categories c ON p.category_id = c.id
             WHERE pt.tag_id = ? AND p.status = 'published'
             ORDER BY p.published_at DESC
             LIMIT ? OFFSET ?",
            [$tagId, $limit, $offset]
        );
    }
    
    /**
     * Obter tags mais usadas
     */
    public static function getPopular(int $limit = 20): array
    {
        return Database::fetchAll(
            "SELECT t.*, COUNT(pt.post_id) as post_count
             FROM tags t
             INNER JOIN post_tags pt ON t.id = pt.tag_id
             GROUP BY t.id
             ORDER BY post_count DESC
             LIMIT ?",
            [$limit]
        );
    }
}
