<?php
// Teste de conexao com banco de dados
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = 'localhost';
$dbname = 'curr6441_inforagro01';
$user = 'curr6441_hostinfor01';
$pass = 'BYY3*)D,77E$yZ#f';

echo "<h2>Teste de Conexao MySQL</h2>";
echo "<p>Host: $host</p>";
echo "<p>Database: $dbname</p>";
echo "<p>User: $user</p>";
echo "<hr>";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<p style='color:green; font-size:20px;'><strong>CONEXAO OK!</strong></p>";
    
    // Testar query
    $result = $pdo->query("SELECT COUNT(*) as total FROM users");
    $row = $result->fetch(PDO::FETCH_ASSOC);
    echo "<p>Usuarios no banco: " . $row['total'] . "</p>";
    
} catch (PDOException $e) {
    echo "<p style='color:red; font-size:20px;'><strong>ERRO:</strong></p>";
    echo "<p>" . $e->getMessage() . "</p>";
}
?>
