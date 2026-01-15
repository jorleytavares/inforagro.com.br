<?php

namespace App\Controllers;

use App\Core\Controller;

/**
 * Controlador de Newsletter
 */
class NewsletterController extends Controller
{
    /**
     * Inscrever na newsletter
     */
    public function subscribe(): void
    {
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        
        if (!$email) {
            if ($this->isAjax()) {
                $this->json(['success' => false, 'message' => 'E-mail inválido']);
                return;
            }
            $this->redirect('/?newsletter=error');
            return;
        }
        
        // Salvar email (arquivo simples por enquanto)
        $newsletterFile = ROOT_PATH . '/storage/newsletter.txt';
        $storageDir = ROOT_PATH . '/storage';
        
        if (!is_dir($storageDir)) {
            mkdir($storageDir, 0755, true);
        }
        
        // Verificar se já existe
        $existingEmails = file_exists($newsletterFile) ? file($newsletterFile, FILE_IGNORE_NEW_LINES) : [];
        
        if (in_array($email, $existingEmails)) {
            if ($this->isAjax()) {
                $this->json(['success' => true, 'message' => 'Você já está inscrito!']);
                return;
            }
            $this->redirect('/?newsletter=exists');
            return;
        }
        
        // Adicionar email
        file_put_contents($newsletterFile, $email . "\n", FILE_APPEND);
        
        // Log
        $logEntry = date('Y-m-d H:i:s') . " - " . $email . " - " . $_SERVER['REMOTE_ADDR'] . "\n";
        file_put_contents(ROOT_PATH . '/storage/newsletter-log.txt', $logEntry, FILE_APPEND);
        
        if ($this->isAjax()) {
            $this->json(['success' => true, 'message' => 'Inscrição realizada com sucesso!']);
            return;
        }
        
        $this->redirect('/?newsletter=success');
    }
    
    /**
     * Verificar se é requisição AJAX
     */
    private function isAjax(): bool
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }
}
