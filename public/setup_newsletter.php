<?php
/**
 * Script para criar tabela de newsletter (Versão Autônoma)
 * ATENÇÃO: Delete este arquivo após usar!
 */

// Exibir erros para debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h2>Criando Tabela Newsletter</h2>";

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
    die("ERRO: Arquivo .env não encontrado.");
}

$host = $_ENV['DB_HOST'] ?? 'localhost';
$dbname = $_ENV['DB_NAME'] ?? '';
$user = $_ENV['DB_USER'] ?? '';
$pass = $_ENV['DB_PASS'] ?? '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = "CREATE TABLE IF NOT EXISTS newsletter_subscribers (
        id INT AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(255) NOT NULL UNIQUE,
        ip_address VARCHAR(45) NULL,
        status ENUM('active', 'unsubscribed') DEFAULT 'active',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_email (email)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
    
    $pdo->exec($sql);
    
    echo "<p style='color:green;'><strong>SUCESSO!</strong></p>";
    echo "<p>Tabela <strong>newsletter_subscribers</strong> criada/verificada com sucesso.</p>";
    echo "<hr>";
    echo "<p style='color:red;'><strong>IMPORTANTE: Delete este arquivo agora!</strong></p>";
    echo "<p>Caminho: /home/curr6441/inforagro.com.br/public/setup_newsletter.php</p>";
    
} catch (PDOException $e) {
    echo "<h3 style='color:red;'>ERRO:</h3>";
    echo "<pre>" . $e->getMessage() . "</pre>";
}
?>
