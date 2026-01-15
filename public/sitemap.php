<?php
/**
 * Gerador de Sitemap XML Dinâmico
 * InforAgro - Portal do Agronegócio
 */

// Configuração
$baseUrl = 'https://inforagro.com.br';
$today = date('Y-m-d');

header('Content-Type: application/xml; charset=utf-8');

echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

// Página Principal
echo '<url>';
echo '<loc>' . $baseUrl . '/</loc>';
echo '<lastmod>' . $today . '</lastmod>';
echo '<changefreq>daily</changefreq>';
echo '<priority>1.0</priority>';
echo '</url>';

// Páginas Institucionais
echo '<url><loc>' . $baseUrl . '/sobre</loc><changefreq>monthly</changefreq><priority>0.5</priority></url>';
echo '<url><loc>' . $baseUrl . '/contato</loc><changefreq>monthly</changefreq><priority>0.5</priority></url>';

// Tentar carregar categorias e posts do banco
try {
    // Carregar configuração
    $envFile = __DIR__ . '/../.env';
    if (file_exists($envFile)) {
        $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
                list($key, $value) = explode('=', $line, 2);
                $_ENV[trim($key)] = trim($value);
            }
        }
    }
    
    $host = $_ENV['DB_HOST'] ?? 'localhost';
    $dbname = $_ENV['DB_NAME'] ?? '';
    $user = $_ENV['DB_USER'] ?? '';
    $pass = $_ENV['DB_PASS'] ?? '';
    
    if ($dbname && $user) {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Categorias
        $stmt = $pdo->query("SELECT slug FROM categories ORDER BY name");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '<url>';
            echo '<loc>' . $baseUrl . '/' . htmlspecialchars($row['slug']) . '</loc>';
            echo '<lastmod>' . $today . '</lastmod>';
            echo '<changefreq>daily</changefreq>';
            echo '<priority>0.8</priority>';
            echo '</url>';
        }
        
        // Posts
        $stmt = $pdo->query("
            SELECT p.slug, p.updated_at, c.slug as cat_slug 
            FROM posts p 
            LEFT JOIN categories c ON p.category_id = c.id 
            WHERE p.status = 'published' 
            ORDER BY p.published_at DESC 
            LIMIT 500
        ");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $postUrl = $baseUrl . '/' . $row['cat_slug'] . '/' . $row['slug'];
            $lastmod = date('Y-m-d', strtotime($row['updated_at']));
            echo '<url>';
            echo '<loc>' . htmlspecialchars($postUrl) . '</loc>';
            echo '<lastmod>' . $lastmod . '</lastmod>';
            echo '<changefreq>weekly</changefreq>';
            echo '<priority>0.6</priority>';
            echo '</url>';
        }
        
        // Tags
        $stmt = $pdo->query("SELECT slug FROM tags ORDER BY slug LIMIT 50");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '<url>';
            echo '<loc>' . $baseUrl . '/tag/' . htmlspecialchars($row['slug']) . '</loc>';
            echo '<changefreq>weekly</changefreq>';
            echo '<priority>0.4</priority>';
            echo '</url>';
        }
    }
} catch (Exception $e) {
    // Silenciosamente ignorar erros
}

echo '</urlset>';
