<?php

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

/**
 * Model de Posts/Artigos
 */
class Post extends Model
{
    protected static string $table = 'posts';
    
    /**
     * Obter posts publicados com paginação
     */
    public static function getPublished(int $limit = 12, int $offset = 0): array
    {
        return Database::fetchAll(
            "SELECT p.*, c.name as category_name, c.slug as category_slug, a.name as author_name, a.slug as author_slug
             FROM posts p
             LEFT JOIN categories c ON p.category_id = c.id
             LEFT JOIN authors a ON p.author_id = a.id
             WHERE p.status = 'published' AND p.published_at <= NOW()
             ORDER BY p.published_at DESC
             LIMIT ? OFFSET ?",
            [$limit, $offset]
        );
    }
    
    /**
     * Obter posts por categoria
     */
    public static function getByCategory(int $categoryId, int $limit = 12, int $offset = 0): array
    {
        // Incluir subcategorias
        $categoryIds = [$categoryId];
        $subcategories = Category::getSubcategories($categoryId);
        foreach ($subcategories as $sub) {
            $categoryIds[] = $sub['id'];
        }
        
        $placeholders = implode(',', array_fill(0, count($categoryIds), '?'));
        $params = array_merge($categoryIds, [$limit, $offset]);
        
        return Database::fetchAll(
            "SELECT p.*, c.name as category_name, c.slug as category_slug, a.name as author_name
             FROM posts p
             LEFT JOIN categories c ON p.category_id = c.id
             LEFT JOIN authors a ON p.author_id = a.id
             WHERE p.category_id IN ({$placeholders}) AND p.status = 'published' AND p.published_at <= NOW()
             ORDER BY p.published_at DESC
             LIMIT ? OFFSET ?",
            $params
        );
    }
    
    /**
     * Buscar post por slug com dados relacionados
     */
    public static function findBySlug(string $slug): ?array
    {
        return Database::fetch(
            "SELECT p.*, c.name as category_name, c.slug as category_slug, 
                    a.name as author_name, a.slug as author_slug, a.bio as author_bio, a.avatar as author_avatar
             FROM posts p
             LEFT JOIN categories c ON p.category_id = c.id
             LEFT JOIN authors a ON p.author_id = a.id
             WHERE p.slug = ? AND p.status = 'published'",
            [$slug]
        );
    }
    
    /**
     * Obter posts relacionados (mesmo silo)
     */
    public static function getRelated(int $postId, int $categoryId, int $limit = 4): array
    {
        return Database::fetchAll(
            "SELECT p.*, c.name as category_name, c.slug as category_slug
             FROM posts p
             LEFT JOIN categories c ON p.category_id = c.id
             WHERE p.id != ? AND p.category_id = ? AND p.status = 'published'
             ORDER BY p.published_at DESC
             LIMIT ?",
            [$postId, $categoryId, $limit]
        );
    }
    
    /**
     * Obter posts em destaque
     */
    public static function getFeatured(int $limit = 6): array
    {
        return Database::fetchAll(
            "SELECT p.*, c.name as category_name, c.slug as category_slug, a.name as author_name
             FROM posts p
             LEFT JOIN categories c ON p.category_id = c.id
             LEFT JOIN authors a ON p.author_id = a.id
             WHERE p.status = 'published' AND p.published_at <= NOW()
             ORDER BY p.views DESC, p.published_at DESC
             LIMIT ?",
            [$limit]
        );
    }
    
    /**
     * Busca full-text
     */
    public static function search(string $query, int $limit = 20): array
    {
        $searchTerm = '%' . $query . '%';
        return Database::fetchAll(
            "SELECT p.*, c.name as category_name, c.slug as category_slug
             FROM posts p
             LEFT JOIN categories c ON p.category_id = c.id
             WHERE p.status = 'published' 
               AND (p.title LIKE ? OR p.excerpt LIKE ? OR p.content LIKE ?)
             ORDER BY p.published_at DESC
             LIMIT ?",
            [$searchTerm, $searchTerm, $searchTerm, $limit]
        );
    }
    
    /**
     * Incrementar visualizações
     */
    public static function incrementViews(int $id): void
    {
        Database::query("UPDATE posts SET views = views + 1 WHERE id = ?", [$id]);
    }
    
    /**
     * Obter tags de um post
     */
    public static function getTags(int $postId): array
    {
        return Database::fetchAll(
            "SELECT t.* FROM tags t
             INNER JOIN post_tags pt ON t.id = pt.tag_id
             WHERE pt.post_id = ?",
            [$postId]
        );
    }
    
    /**
     * Contar total de posts publicados
     */
    public static function countPublished(): int
    {
        $result = Database::fetch(
            "SELECT COUNT(*) as total FROM posts WHERE status = 'published' AND published_at <= NOW()"
        );
        return (int) ($result['total'] ?? 0);
    }
    
    /**
     * Gerar URL do post
     */
    public static function getUrl(array $post): string
    {
        return '/' . $post['category_slug'] . '/' . $post['slug'];
    }
}
