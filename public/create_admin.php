<?php
/**
 * Script para criar/atualizar usuário admin
 * ATENÇÃO: Delete este arquivo após usar!
 */

// Configurações do novo admin
$adminEmail = 'contato@hostamazonas.com.br';
$adminPassword = '#ShellAna1501!';
$adminName = 'Administrador Master';

// Carregar configuração do .env
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

echo "<h2>Criando Usuario Admin</h2>";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Gerar hash da senha
    $hashedPassword = password_hash($adminPassword, PASSWORD_DEFAULT);
    
    echo "<p>Email: $adminEmail</p>";
    echo "<p>Senha: $adminPassword</p>";
    echo "<p>Hash gerado: $hashedPassword</p>";
    
    // Verificar se usuário já existe
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$adminEmail]);
    $existing = $stmt->fetch();
    
    if ($existing) {
        // Atualizar usuário existente
        $stmt = $pdo->prepare("UPDATE users SET password = ?, name = ?, role = 'admin' WHERE email = ?");
        $stmt->execute([$hashedPassword, $adminName, $adminEmail]);
        echo "<p style='color:green;'><strong>Usuario atualizado com sucesso!</strong></p>";
    } else {
        // Criar novo usuário
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'admin')");
        $stmt->execute([$adminName, $adminEmail, $hashedPassword]);
        echo "<p style='color:green;'><strong>Usuario criado com sucesso!</strong></p>";
    }
    
    echo "<hr>";
    echo "<p><strong>Agora voce pode fazer login com:</strong></p>";
    echo "<p>Email: $adminEmail</p>";
    echo "<p>Senha: $adminPassword</p>";
    echo "<hr>";
    echo "<p style='color:red;'><strong>IMPORTANTE: Delete este arquivo agora!</strong></p>";
    echo "<p>Caminho: /home/curr6441/inforagro.com.br/public/create_admin.php</p>";
    
} catch (PDOException $e) {
    echo "<p style='color:red;'>ERRO: " . $e->getMessage() . "</p>";
}
?>
