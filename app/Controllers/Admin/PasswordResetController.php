<?php

namespace App\Controllers\Admin;

use App\Core\Database;
use App\Helpers\Csrf;

/**
 * Controlador de Recuperação de Senha
 */
class PasswordResetController
{
    /**
     * Página de solicitação de reset
     */
    public function showRequest(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $this->render('auth.forgot', [
            'pageTitle' => 'Recuperar Senha | Admin InforAgro',
            'csrfToken' => Csrf::token(),
            'success' => $_GET['success'] ?? null,
            'error' => $_GET['error'] ?? null,
        ]);
    }
    
    /**
     * Processar solicitação de reset
     */
    public function sendReset(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!Csrf::verify()) {
            header('Location: /admin/forgot-password?error=' . urlencode('Token inválido'));
            exit;
        }
        
        $email = trim($_POST['email'] ?? '');
        
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header('Location: /admin/forgot-password?error=' . urlencode('E-mail inválido'));
            exit;
        }
        
        try {
            // Verificar se usuário existe
            $user = Database::fetch("SELECT id, name FROM users WHERE email = ?", [$email]);
            
            if ($user) {
                // Gerar token único
                $token = bin2hex(random_bytes(32));
                $expiresAt = date('Y-m-d H:i:s', strtotime('+1 hour'));
                
                // Salvar token no banco
                // Primeiro remover tokens antigos
                Database::query("DELETE FROM password_resets WHERE email = ?", [$email]);
                
                Database::query(
                    "INSERT INTO password_resets (email, token, expires_at, created_at) VALUES (?, ?, ?, NOW())",
                    [$email, hash('sha256', $token), $expiresAt]
                );
                
                // Em produção: enviar e-mail com link
                // Por enquanto, logamos o token (remover em produção!)
                error_log("Password reset token for {$email}: {$token}");
                
                // Mail::send($email, 'Recuperar Senha', "Seu link: /admin/reset-password?token={$token}");
            }
            
            // Sempre mostrar sucesso (evita enumeration)
            header('Location: /admin/forgot-password?success=1');
            
        } catch (\Exception $e) {
            header('Location: /admin/forgot-password?error=' . urlencode('Erro ao processar'));
        }
        exit;
    }
    
    /**
     * Página de reset de senha
     */
    public function showReset(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $token = $_GET['token'] ?? '';
        
        if (empty($token)) {
            header('Location: /admin/login?error=' . urlencode('Token inválido'));
            exit;
        }
        
        // Verificar se token é válido
        $reset = Database::fetch(
            "SELECT * FROM password_resets WHERE token = ? AND expires_at > NOW()",
            [hash('sha256', $token)]
        );
        
        if (!$reset) {
            header('Location: /admin/login?error=' . urlencode('Token expirado ou inválido'));
            exit;
        }
        
        $this->render('auth.reset', [
            'pageTitle' => 'Nova Senha | Admin InforAgro',
            'csrfToken' => Csrf::token(),
            'token' => $token,
            'error' => $_GET['error'] ?? null,
        ]);
    }
    
    /**
     * Processar nova senha
     */
    public function doReset(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!Csrf::verify()) {
            header('Location: /admin/login?error=' . urlencode('Token inválido'));
            exit;
        }
        
        $token = $_POST['token'] ?? '';
        $password = $_POST['password'] ?? '';
        $passwordConfirm = $_POST['password_confirm'] ?? '';
        
        // Validações
        if (empty($token) || empty($password)) {
            header('Location: /admin/reset-password?token=' . urlencode($token) . '&error=' . urlencode('Preencha todos os campos'));
            exit;
        }
        
        if ($password !== $passwordConfirm) {
            header('Location: /admin/reset-password?token=' . urlencode($token) . '&error=' . urlencode('As senhas não conferem'));
            exit;
        }
        
        if (strlen($password) < 8) {
            header('Location: /admin/reset-password?token=' . urlencode($token) . '&error=' . urlencode('Senha deve ter no mínimo 8 caracteres'));
            exit;
        }
        
        try {
            // Verificar token
            $reset = Database::fetch(
                "SELECT * FROM password_resets WHERE token = ? AND expires_at > NOW()",
                [hash('sha256', $token)]
            );
            
            if (!$reset) {
                header('Location: /admin/login?error=' . urlencode('Token expirado'));
                exit;
            }
            
            // Atualizar senha
            Database::query(
                "UPDATE users SET password = ? WHERE email = ?",
                [password_hash($password, PASSWORD_DEFAULT), $reset['email']]
            );
            
            // Remover token usado
            Database::query("DELETE FROM password_resets WHERE email = ?", [$reset['email']]);
            
            // Log de auditoria
            \App\Helpers\AuditLog::log('password_reset', 'user', null, ['email' => $reset['email']]);
            
            header('Location: /admin/login?success=' . urlencode('Senha alterada com sucesso!'));
            
        } catch (\Exception $e) {
            header('Location: /admin/login?error=' . urlencode('Erro ao atualizar senha'));
        }
        exit;
    }
    
    /**
     * Renderizar view
     */
    private function render(string $view, array $data = []): void
    {
        extract($data);
        
        $viewPath = ROOT_PATH . '/app/Views/admin/' . str_replace('.', '/', $view) . '.php';
        
        if (file_exists($viewPath)) {
            require $viewPath;
        }
    }
}
