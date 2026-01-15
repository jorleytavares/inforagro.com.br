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
}
