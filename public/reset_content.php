<?php
/**
 * Script para limpar dados de exemplo e resetar categorias (Versão Autônoma)
 * ATENÇÃO: Delete este arquivo após usar!
 */

// Exibir erros para debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h2>Limpando e Resetando Categorias</h2>";

// Carregar .env manualmente
$envFile = __DIR__ . '/../.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
            list($key, $value) = explode('=', $line, 2);
            $_ENV[trim($key)] = trim($value);
        }
    }
} else {
    die("ERRO: Arquivo .env não encontrado em $envFile");
}

$host = $_ENV['DB_HOST'] ?? 'localhost';
$dbname = $_ENV['DB_NAME'] ?? '';
$user = $_ENV['DB_USER'] ?? '';
$pass = $_ENV['DB_PASS'] ?? '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // 1. Limpar tabelas de conteúdo (mantendo usuários)
    echo "<p>Limpando posts, tags e logs...</p>";
    
    // Desabilitar checagem de chave estrangeira temporariamente
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
    
    $tablesToTruncate = ['post_tags', 'tags', 'posts', 'categories', 'audit_logs', 'login_attempts'];
    
    foreach ($tablesToTruncate as $table) {
        // Verificar se tabela existe antes de limpar
        try {
            $pdo->exec("TRUNCATE TABLE $table");
            echo "Ok: Tabela <strong>$table</strong> limpa.<br>";
        } catch (Exception $e) {
            echo "Aviso: Tabela <strong>$table</strong> não encontrada ou erro ao limpar (pode ser normal).<br>";
        }
    }
    
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
    
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
        echo "<li>Criada: <strong>{$cat['name']}</strong></li>";
    }
    echo "</ul>";
    
    echo "<hr>";
    echo "<h3 style='color:green;'>LIMPEZA CONCLUÍDA COM SUCESSO!</h3>";
    echo "<p>Todos os posts de exemplo foram apagados.</p>";
    echo "<p>Apenas as 4 categorias oficiais estão ativas.</p>";
    
    echo "<hr>";
    echo "<p style='color:red;'><strong>IMPORTANTE: Delete este arquivo agora!</strong></p>";
    echo "<p>Caminho: /home/curr6441/inforagro.com.br/public/reset_content.php</p>";
    
} catch (PDOException $e) {
    echo "<h3 style='color:red;'>ERRO:</h3>";
    echo "<pre>" . $e->getMessage() . "</pre>";
}
?>
