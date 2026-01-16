<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Models\Post;
use App\Models\Category;

/**
 * Controlador de Sitemap XML
 */
class SitemapController extends Controller
{
    private string $baseUrl = 'https://www.inforagro.com.br';
    
    /**
     * Sitemap index principal
     */
    public function index(): void
    {
        header('Content-Type: application/xml; charset=utf-8');
        
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        
        // Sitemap de páginas estáticas
        $xml .= $this->sitemapEntry('/sitemap-pages.xml');
        
        // Sitemap de categorias
        $xml .= $this->sitemapEntry('/sitemap-categories.xml');
        
        // Sitemap de posts
        $xml .= $this->sitemapEntry('/sitemap-posts.xml');
        
        $xml .= '</sitemapindex>';
        
        echo $xml;
    }
    
    /**
     * Sitemap de páginas estáticas
     */
    public function pages(): void
    {
        header('Content-Type: application/xml; charset=utf-8');
        
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        
        // Páginas estáticas
        $pages = [
            ['url' => '/', 'priority' => '1.0', 'changefreq' => 'daily'],
            ['url' => '/sobre', 'priority' => '0.6', 'changefreq' => 'monthly'],
            ['url' => '/contato', 'priority' => '0.5', 'changefreq' => 'monthly'],
            ['url' => '/buscar', 'priority' => '0.4', 'changefreq' => 'weekly'],
        ];
        
        foreach ($pages as $page) {
            $xml .= $this->urlEntry(
                $this->baseUrl . $page['url'],
                date('Y-m-d'),
                $page['changefreq'],
                $page['priority']
            );
        }
        
        $xml .= '</urlset>';
        
        echo $xml;
    }
    
    /**
     * Sitemap de categorias
     */
    public function categories(): void
    {
        header('Content-Type: application/xml; charset=utf-8');
        
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        
        try {
            $categories = Database::fetchAll(
                "SELECT slug, updated_at FROM categories WHERE is_active = 1 ORDER BY parent_id IS NULL DESC"
            );
            
            foreach ($categories as $cat) {
                $xml .= $this->urlEntry(
                    $this->baseUrl . '/' . $cat['slug'],
                    date('Y-m-d', strtotime($cat['updated_at'] ?? 'now')),
                    'weekly',
                    '0.8'
                );
            }
        } catch (\Exception $e) {
            // Banco não disponível
        }
        
        $xml .= '</urlset>';
        
        echo $xml;
    }
    
    /**
     * Sitemap de posts
     */
    public function posts(): void
    {
        header('Content-Type: application/xml; charset=utf-8');
        
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" ';
        $xml .= 'xmlns:news="http://www.google.com/schemas/sitemap-news/0.9" ';
        $xml .= 'xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">' . "\n";
        
        try {
            $posts = Database::fetchAll(
                "SELECT p.slug, p.title, p.published_at, p.updated_at, p.featured_image, c.slug as category_slug
                 FROM posts p
                 LEFT JOIN categories c ON p.category_id = c.id
                 WHERE p.status = 'published'
                 ORDER BY p.published_at DESC
                 LIMIT 1000"
            );
            
            foreach ($posts as $post) {
                $url = $this->baseUrl . '/' . $post['category_slug'] . '/' . $post['slug'];
                $lastmod = date('Y-m-d', strtotime($post['updated_at'] ?? $post['published_at']));
                
                $xml .= "  <url>\n";
                $xml .= "    <loc>" . htmlspecialchars($url) . "</loc>\n";
                $xml .= "    <lastmod>{$lastmod}</lastmod>\n";
                $xml .= "    <changefreq>monthly</changefreq>\n";
                $xml .= "    <priority>0.7</priority>\n";
                
                // Google News
                $pubDate = date('Y-m-d', strtotime($post['published_at']));
                $xml .= "    <news:news>\n";
                $xml .= "      <news:publication>\n";
                $xml .= "        <news:name>InfoRagro</news:name>\n";
                $xml .= "        <news:language>pt</news:language>\n";
                $xml .= "      </news:publication>\n";
                $xml .= "      <news:publication_date>{$pubDate}</news:publication_date>\n";
                $xml .= "      <news:title>" . htmlspecialchars($post['title']) . "</news:title>\n";
                $xml .= "    </news:news>\n";
                
                // Imagem
                if (!empty($post['featured_image'])) {
                    $imageUrl = $this->baseUrl . $post['featured_image'];
                    $xml .= "    <image:image>\n";
                    $xml .= "      <image:loc>" . htmlspecialchars($imageUrl) . "</image:loc>\n";
                    $xml .= "      <image:title>" . htmlspecialchars($post['title']) . "</image:title>\n";
                    $xml .= "    </image:image>\n";
                }
                
                $xml .= "  </url>\n";
            }
        } catch (\Exception $e) {
            // Banco não disponível
        }
        
        $xml .= '</urlset>';
        
        echo $xml;
    }
    
    /**
     * Gerar entrada de sitemap index
     */
    private function sitemapEntry(string $path): string
    {
        return "  <sitemap>\n" .
               "    <loc>" . $this->baseUrl . $path . "</loc>\n" .
               "    <lastmod>" . date('Y-m-d') . "</lastmod>\n" .
               "  </sitemap>\n";
    }
    
    /**
     * Gerar entrada de URL
     */
    private function urlEntry(string $url, string $lastmod, string $changefreq, string $priority): string
    {
        return "  <url>\n" .
               "    <loc>" . htmlspecialchars($url) . "</loc>\n" .
               "    <lastmod>{$lastmod}</lastmod>\n" .
               "    <changefreq>{$changefreq}</changefreq>\n" .
               "    <priority>{$priority}</priority>\n" .
               "  </url>\n";
    }
}
