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
        
        try {
            // Tentar salvar no banco
            \App\Models\NewsletterSubscriber::add($email, $_SERVER['REMOTE_ADDR'] ?? null);
            $message = 'Inscrição realizada com sucesso!';
        } catch (\Exception $e) {
            // Fallback para arquivo se banco falhar
            $logEntry = date('Y-m-d H:i:s') . " - " . $email . " - " . ($_SERVER['REMOTE_ADDR']??'') . "\n";
            file_put_contents(ROOT_PATH . '/storage/newsletter.txt', $logEntry, FILE_APPEND);
            $message = 'Inscrição realizada!';
        }
        
        if ($this->isAjax()) {
            $this->json(['success' => true, 'message' => $message]);
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
