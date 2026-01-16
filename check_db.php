<?php
require_once 'app/Core/Database.php';
require_once 'app/Config/config.php';

use App\Core\Database;

try {
    echo "Checking 'posts' table schema...\n";
    $columns = Database::fetchAll("DESCRIBE posts");
    foreach ($columns as $col) {
        echo $col['Field'] . " (" . $col['Type'] . ")\n";
    }
    
    echo "\nRows in posts table: ";
    $count = Database::fetch("SELECT COUNT(*) as c FROM posts");
    echo $count['c'] . "\n";
    
    echo "\nLatest 5 posts:\n";
    $posts = Database::fetchAll("SELECT id, title, created_at FROM posts ORDER BY id DESC LIMIT 5");
    foreach ($posts as $p) {
        echo "[{$p['id']}] {$p['title']} ({$p['created_at']})\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
