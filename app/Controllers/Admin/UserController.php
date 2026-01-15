<?php

namespace App\Controllers\Admin;

use App\Core\Database;
use App\Helpers\AuditLog;

/**
 * Controlador de Usuários (Admin)
 */
class UserController extends DashboardController
{
    private array $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    private int $maxSize = 2 * 1024 * 1024; // 2MB

    /**
     * Listar usuários
     */
    public function index(): void
    {
        $this->requireRole('admin');
        $users = [];
        try {
            $users = Database::fetchAll("SELECT * FROM users ORDER BY created_at DESC");
        } catch (\Exception $e) {}
        
        $this->adminView('users.index', [
            'pageTitle' => 'Usuários | Admin InforAgro',
            'users' => $users,
        ]);
    }
    
    /**
     * Novo usuário
     */
    public function create(): void
    {
        $this->requireRole('admin');
        $this->adminView('users.form', [
            'pageTitle' => 'Novo Usuário | Admin InforAgro',
            'user' => null,
            'isEdit' => false,
            'roles' => $this->getRoles(),
        ]);
    }
    
    /**
     * Salvar usuário
     */
    public function store(): void
    {
        $this->requireRole('admin');
        $this->verifyCsrf();
        
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $role = $_POST['role'] ?? 'editor';
        
        if (empty($password)) {
            header('Location: /admin/users/create?error=' . urlencode('Senha é obrigatória'));
            exit;
        }
        
        try {
            // Verificar email duplicado
            $existing = Database::fetch("SELECT id FROM users WHERE email = ?", [$email]);
            if ($existing) {
                throw new \Exception("E-mail já cadastrado");
            }
            
            // Upload do avatar
            $avatar = $this->uploadAvatar();
            
            Database::query(
                "INSERT INTO users (name, email, password, role, avatar, created_at) VALUES (?, ?, ?, ?, ?, NOW())",
                [$name, $email, password_hash($password, PASSWORD_DEFAULT), $role, $avatar]
            );
            header('Location: /admin/users?success=created');
        } catch (\Exception $e) {
            header('Location: /admin/users/create?error=' . urlencode($e->getMessage()));
        }
        exit;
    }
    
    /**
     * Editar usuário
     */
    public function edit(int $id): void
    {
        $this->requireRole('admin');
        $user = Database::fetch("SELECT * FROM users WHERE id = ?", [$id]);
        
        if (!$user) {
            header('Location: /admin/users?error=notfound');
            exit;
        }
        
        $this->adminView('users.form', [
            'pageTitle' => 'Editar Usuário | Admin InforAgro',
            'user' => $user,
            'isEdit' => true,
            'roles' => $this->getRoles(),
        ]);
    }
    
    /**
     * Atualizar usuário
     */
    public function update(int $id): void
    {
        $this->requireRole('admin');
        $this->verifyCsrf();
        
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $role = $_POST['role'] ?? 'editor';
        
        try {
            // Verificar email duplicado (exceto o próprio)
            $existing = Database::fetch("SELECT id FROM users WHERE email = ? AND id != ?", [$email, $id]);
            if ($existing) {
                throw new \Exception("E-mail já cadastrado por outro usuário");
            }
            
            // Upload do avatar (ou manter o atual)
            $avatar = $this->uploadAvatar();
            if (!$avatar) {
                $avatar = $_POST['current_avatar'] ?? null;
            }
            
            if (!empty($password)) {
                Database::query(
                    "UPDATE users SET name = ?, email = ?, password = ?, role = ?, avatar = ? WHERE id = ?",
                    [$name, $email, password_hash($password, PASSWORD_DEFAULT), $role, $avatar, $id]
                );
            } else {
                Database::query(
                    "UPDATE users SET name = ?, email = ?, role = ?, avatar = ? WHERE id = ?",
                    [$name, $email, $role, $avatar, $id]
                );
            }
            header('Location: /admin/users?success=updated');
        } catch (\Exception $e) {
            header('Location: /admin/users/' . $id . '/edit?error=' . urlencode($e->getMessage()));
        }
        exit;
    }
    
    /**
     * Deletar usuário
     */
    public function destroy(int $id): void
    {
        $this->requireRole('admin');
        $this->verifyCsrf();
        
        // Não permitir deletar o próprio usuário logado
        if (isset($_SESSION['admin_user_id']) && $_SESSION['admin_user_id'] == $id) {
            header('Location: /admin/users?error=' . urlencode('Você não pode excluir seu próprio usuário'));
            exit;
        }
        
        try {
            AuditLog::deleted('user', $id, ['id' => $id]);
            Database::query("DELETE FROM users WHERE id = ?", [$id]);
            header('Location: /admin/users?success=deleted');
        } catch (\Exception $e) {
            header('Location: /admin/users?error=' . urlencode($e->getMessage()));
        }
        exit;
    }
    
    /**
     * Upload de avatar
     */
    private function uploadAvatar(): ?string
    {
        if (!isset($_FILES['avatar']) || $_FILES['avatar']['error'] !== UPLOAD_ERR_OK) {
            return null;
        }
        
        $file = $_FILES['avatar'];
        
        // Validar tipo
        if (!in_array($file['type'], $this->allowedTypes)) {
            return null;
        }
        
        // Validar tamanho
        if ($file['size'] > $this->maxSize) {
            return null;
        }
        
        // Gerar nome único
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'avatars/' . uniqid('avatar_') . '.' . $extension;
        
        // Criar diretório se não existir
        $uploadDir = ROOT_PATH . '/public/uploads/avatars';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $destination = ROOT_PATH . '/public/uploads/' . $filename;
        
        if (move_uploaded_file($file['tmp_name'], $destination)) {
            return '/uploads/' . $filename;
        }
        
        return null;
    }
    
    /**
     * Roles disponíveis
     */
    private function getRoles(): array
    {
        return [
            'admin' => 'Administrador',
            'editor' => 'Editor',
            'author' => 'Autor',
        ];
    }
}
