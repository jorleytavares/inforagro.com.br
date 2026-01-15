<?php

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

/**
 * Model de Categorias
 */
class Category extends Model
{
    protected static string $table = 'categories';
    
    /**
     * Obter categorias principais (silos)
     */
    public static function getMainCategories(): array
    {
        return Database::fetchAll(
            "SELECT * FROM categories WHERE parent_id IS NULL AND is_active = 1 ORDER BY sort_order"
        );
    }
    
    /**
     * Obter subcategorias de uma categoria
     */
    public static function getSubcategories(int $parentId): array
    {
        return Database::fetchAll(
            "SELECT * FROM categories WHERE parent_id = ? AND is_active = 1 ORDER BY sort_order",
            [$parentId]
        );
    }
    
    /**
     * Buscar categoria por slug
     */
    public static function findBySlug(string $slug): ?array
    {
        return Database::fetch(
            "SELECT * FROM categories WHERE slug = ? AND is_active = 1",
            [$slug]
        );
    }
    
    /**
     * Obter categoria com sua categoria pai
     */
    public static function getWithParent(string $slug): ?array
    {
        $category = self::findBySlug($slug);
        
        if ($category && $category['parent_id']) {
            $category['parent'] = self::find($category['parent_id']);
        }
        
        return $category;
    }
    
    /**
     * Obter hierarquia completa (para breadcrumb)
     */
    public static function getBreadcrumb(int $categoryId): array
    {
        $breadcrumb = [];
        $category = self::find($categoryId);
        
        while ($category) {
            array_unshift($breadcrumb, [
                'name' => $category['name'],
                'url' => '/' . $category['slug']
            ]);
            
            $category = $category['parent_id'] ? self::find($category['parent_id']) : null;
        }
        
        // Adicionar Home no início
        array_unshift($breadcrumb, ['name' => 'Início', 'url' => '/']);
        
        return $breadcrumb;
    }
    
    /**
     * Contar posts em uma categoria
     */
    public static function countPosts(int $categoryId): int
    {
        $result = Database::fetch(
            "SELECT COUNT(*) as total FROM posts WHERE category_id = ? AND status = 'published'",
            [$categoryId]
        );
        return (int) ($result['total'] ?? 0);
    }
}
