<?php
/**
 * Script para limpar dados de exemplo e resetar categorias
 * ATENÇÃO: Delete este arquivo após usar!
 */

// Carregar autoload e configuração
require_once __DIR__ . '/../app/Core/Config.php';
require_once __DIR__ . '/../app/Core/Database.php';

use App\Core\Database;

// Configuração manual do DB se autoload falhar (segurança)
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

echo "<h2>Limpando e Resetando Categorias</h2>";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // 1. Limpar tabelas de conteúdo (mantendo usuários)
    echo "<p>Limpando posts e tags...</p>";
    $pdo->exec("DELETE FROM post_tags");
    $pdo->exec("DELETE FROM tags");
    $pdo->exec("DELETE FROM posts");
    $pdo->exec("DELETE FROM categories");
    
    // Resetar AUTO_INCREMENT
    $pdo->exec("ALTER TABLE categories AUTO_INCREMENT = 1");
    $pdo->exec("ALTER TABLE posts AUTO_INCREMENT = 1");
    $pdo->exec("ALTER TABLE tags AUTO_INCREMENT = 1");
    
    // 2. Inserir Categorias Oficiais
    echo "<p>Inserindo categorias oficiais...</p>";
    
    $categories = [
        [
            'name' => 'Agricultura e Pecuária',
            'slug' => 'agricultura-e-pecuaria',
            'description' => 'Notícias e técnicas sobre produção agrícola e criação animal.'
        ],
        [
            'name' => 'Agronegócio',
            'slug' => 'agronegocio',
            'description' => 'Mercado, economia, cotações e gestão do agronegócio.'
        ],
        [
            'name' => 'Meio Ambiente e Sustentabilidade',
            'slug' => 'meio-ambiente-e-sustentabilidade',
            'description' => 'Práticas sustentáveis, preservação e legislação ambiental.'
        ],
        [
            'name' => 'Mundo Pet',
            'slug' => 'mundo-pet',
            'description' => 'Tudo sobre animais de estimação, cuidados e mercado pet.'
        ]
    ];
    
    $stmt = $pdo->prepare("INSERT INTO categories (name, slug, description, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())");
    
    echo "<ul>";
    foreach ($categories as $cat) {
        $stmt->execute([$cat['name'], $cat['slug'], $cat['description']]);
        echo "li>Criada: <strong>{$cat['name']}</strong></li>";
    }
    echo "</ul>";
    
    echo "<hr>";
    echo "<p style='color:green;'><strong>LIMPEZA CONCLUÍDA COM SUCESSO!</strong></p>";
    echo "<p>Todos os posts de exemplo foram apagados.</p>";
    echo "<p>Apenas as 4 categorias oficiais estão ativas.</p>";
    
    echo "<hr>";
    echo "<p style='color:red;'><strong>IMPORTANTE: Delete este arquivo agora!</strong></p>";
    echo "<p>Caminho: /home/curr6441/inforagro.com.br/public/reset_content.php</p>";
    
} catch (PDOException $e) {
    echo "<p style='color:red;'>ERRO: " . $e->getMessage() . "</p>";
}
?>
