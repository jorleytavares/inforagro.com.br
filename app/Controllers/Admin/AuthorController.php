<?php

namespace App\Controllers\Admin;

use App\Core\Database;
use App\Models\Author;

/**
 * Controlador de Autores (Admin)
 */
class AuthorController extends DashboardController
{
    private array $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    private int $maxSize = 2 * 1024 * 1024; // 2MB

    /**
     * Listar autores
     */
    public function index(): void
    {
        $authors = [];
        try {
            $authors = Database::fetchAll(
                "SELECT a.*, 
                 (SELECT COUNT(*) FROM posts WHERE author_id = a.id) as post_count
                 FROM authors a ORDER BY a.name"
            );
        } catch (\Exception $e) {}
        
        $this->adminView('authors.index', [
            'pageTitle' => 'Autores | Admin InforAgro',
            'authors' => $authors,
        ]);
    }
    
    /**
     * Novo autor
     */
    public function create(): void
    {
        $this->adminView('authors.form', [
            'pageTitle' => 'Novo Autor | Admin InforAgro',
            'author' => null,
            'isEdit' => false,
        ]);
    }
    
    /**
     * Salvar autor
     */
    public function store(): void
    {
        $this->verifyCsrf();
        $data = $this->getAuthorData();
        
        // Upload do avatar
        $avatar = $this->uploadAvatar();
        if ($avatar) {
            $data['avatar'] = $avatar;
        }
        
        try {
            Author::create($data);
            header('Location: /admin/authors?success=created');
        } catch (\Exception $e) {
            header('Location: /admin/authors/create?error=' . urlencode($e->getMessage()));
        }
        exit;
    }
    
    /**
     * Editar autor
     */
    public function edit(int $id): void
    {
        $author = Author::find($id);
        
        if (!$author) {
            header('Location: /admin/authors?error=notfound');
            exit;
        }
        
        $this->adminView('authors.form', [
            'pageTitle' => 'Editar Autor | Admin InforAgro',
            'author' => $author,
            'isEdit' => true,
        ]);
    }
    
    /**
     * Atualizar autor
     */
    public function update(int $id): void
    {
        $this->verifyCsrf();
        $data = $this->getAuthorData();
        
        // Upload do avatar (ou manter o atual)
        $avatar = $this->uploadAvatar();
        if ($avatar) {
            $data['avatar'] = $avatar;
        } elseif (!empty($_POST['current_avatar'])) {
            $data['avatar'] = $_POST['current_avatar'];
        }
        
        try {
            Author::update($id, $data);
            header('Location: /admin/authors?success=updated');
        } catch (\Exception $e) {
            header('Location: /admin/authors/' . $id . '/edit?error=' . urlencode($e->getMessage()));
        }
        exit;
    }
    
    /**
     * Obter dados do formulário
     */
    private function getAuthorData(): array
    {
        $name = $_POST['name'] ?? '';
        
        return [
            'name' => $name,
            'slug' => $_POST['slug'] ?? $this->slugify($name),
            'email' => $_POST['email'] ?? '',
            'bio' => $_POST['bio'] ?? '',
            'avatar' => '', // Será preenchido pelo upload
            'website' => $_POST['website'] ?? '',
            'twitter' => $_POST['twitter'] ?? '',
            'linkedin' => $_POST['linkedin'] ?? '',
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ];
    }
    
    /**
     * Upload de avatar
     */
    private function uploadAvatar(): ?string
    {
        if (!isset($_FILES['avatar_file']) || $_FILES['avatar_file']['error'] !== UPLOAD_ERR_OK) {
            return null;
        }
        
        $file = $_FILES['avatar_file'];
        
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
        $filename = 'avatars/' . uniqid('author_') . '.' . $extension;
        
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
     * Gerar slug
     */
    private function slugify(string $text): string
    {
        $text = mb_strtolower($text);
        $text = preg_replace('/[áàãâä]/u', 'a', $text);
        $text = preg_replace('/[éèêë]/u', 'e', $text);
        $text = preg_replace('/[íìîï]/u', 'i', $text);
        $text = preg_replace('/[óòõôö]/u', 'o', $text);
        $text = preg_replace('/[úùûü]/u', 'u', $text);
        $text = preg_replace('/[ç]/u', 'c', $text);
        $text = preg_replace('/[^a-z0-9]+/', '-', $text);
        return trim($text, '-');
    }
}
