<?php

namespace App\Models;

use App\Core\Database;

class NewsletterSubscriber
{
    public static function add(string $email, string $ip = null): bool
    {
        $conn = Database::getInstance();
        
        // Verificar se já existe
        $stmt = $conn->prepare("SELECT id FROM newsletter_subscribers WHERE email = ?");
        $stmt->execute([$email]);
        
        if ($stmt->fetch()) {
            return true; // Já existe (consideramos sucesso)
        }
        
        // Inserir
        $stmt = $conn->prepare("INSERT INTO newsletter_subscribers (email, ip_address) VALUES (?, ?)");
        return $stmt->execute([$email, $ip]);
    }
    /**
     * Obter todos os inscritos
     */
    public static function getAll(): array
    {
        $conn = Database::getInstance();
        return $conn->query("SELECT * FROM newsletter_subscribers ORDER BY created_at DESC")->fetchAll(\PDO::FETCH_ASSOC);
    }
}
