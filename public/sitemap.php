<?php
/**
 * Gerador de Sitemap XML Dinâmico
 * InforAgro - Portal do Agronegócio
 */

header('Content-Type: application/xml; charset=utf-8');
header('X-Robots-Tag: noindex');

// Configuração
$baseUrl = 'https://inforagro.com.br';
$today = date('Y-m-d');

// Carregar autoload e configuração
require_once __DIR__ . '/../app/Core/Config.php';
require_once __DIR__ . '/../app/Core/Database.php';

use App\Core\Database;

echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:news="http://www.google.com/schemas/sitemap-news/0.9"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
    
    <!-- Página Principal -->
    <url>
        <loc><?= $baseUrl ?>/</loc>
        <lastmod><?= $today ?></lastmod>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>
    
    <!-- Páginas Institucionais -->
    <url>
        <loc><?= $baseUrl ?>/sobre</loc>
        <changefreq>monthly</changefreq>
        <priority>0.5</priority>
    </url>
    <url>
        <loc><?= $baseUrl ?>/contato</loc>
        <changefreq>monthly</changefreq>
        <priority>0.5</priority>
    </url>
    
    <!-- Categorias -->
    <?php
    try {
        $db = Database::getInstance();
        $categories = $db->fetchAll("SELECT slug, name FROM categories ORDER BY name");
        
        foreach ($categories as $category):
    ?>
    <url>
        <loc><?= $baseUrl ?>/<?= htmlspecialchars($category['slug']) ?></loc>
        <lastmod><?= $today ?></lastmod>
        <changefreq>daily</changefreq>
        <priority>0.8</priority>
    </url>
    <?php endforeach; ?>
    
    <!-- Posts Publicados -->
    <?php
        $posts = $db->fetchAll("
            SELECT p.slug, p.title, p.featured_image, p.updated_at, c.slug as category_slug 
            FROM posts p 
            LEFT JOIN categories c ON p.category_id = c.id 
            WHERE p.status = 'published' 
            ORDER BY p.published_at DESC 
            LIMIT 1000
        ");
        
        foreach ($posts as $post):
            $postUrl = $baseUrl . '/' . $post['category_slug'] . '/' . $post['slug'];
            $lastmod = date('Y-m-d', strtotime($post['updated_at']));
    ?>
    <url>
        <loc><?= htmlspecialchars($postUrl) ?></loc>
        <lastmod><?= $lastmod ?></lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.6</priority>
        <?php if (!empty($post['featured_image'])): ?>
        <image:image>
            <image:loc><?= $baseUrl ?><?= htmlspecialchars($post['featured_image']) ?></image:loc>
            <image:title><?= htmlspecialchars($post['title']) ?></image:title>
        </image:image>
        <?php endif; ?>
    </url>
    <?php endforeach; ?>
    
    <!-- Tags -->
    <?php
        $tags = $db->fetchAll("SELECT DISTINCT slug FROM tags ORDER BY slug LIMIT 100");
        foreach ($tags as $tag):
    ?>
    <url>
        <loc><?= $baseUrl ?>/tag/<?= htmlspecialchars($tag['slug']) ?></loc>
        <changefreq>weekly</changefreq>
        <priority>0.4</priority>
    </url>
    <?php endforeach;
    } catch (Exception $e) {
        // Silenciosamente ignorar erros de banco
    }
    ?>
</urlset>
