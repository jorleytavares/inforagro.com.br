<?php
/**
 * Script para criar tabela de newsletter
 */

require_once __DIR__ . '/../app/Core/Config.php';
require_once __DIR__ . '/../app/Core/Database.php';

use App\Core\Database;

// Carregar config manualmente se necessário
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

echo "<h2>Criando Tabela Newsletter</h2>";

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
    
    echo "<p style='color:green;'>Tabela <strong>newsletter_subscribers</strong> criada com sucesso!</p>";
    echo "<p style='color:red;'>Delete este arquivo após o uso!</p>";
    
} catch (PDOException $e) {
    echo "<p style='color:red;'>Erro: " . $e->getMessage() . "</p>";
}
?>
