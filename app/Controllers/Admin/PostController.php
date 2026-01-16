<?php

namespace App\Controllers\Admin;

use App\Core\Database;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Author;
use App\Helpers\JwtHelper;
use App\Helpers\AuditLog;

/**
 * Controlador de Posts (Admin)
 */
class PostController extends DashboardController
{
    /**
     * Listar todos os posts
     */
    public function index(): void
    {
        $posts = [];
        $categories = [];
        
        // Filtros
        $where = [];
        $params = [];
        $filterStatus = $_GET['status'] ?? '';
        $filterCategory = $_GET['category'] ?? '';
        $filterSearch = $_GET['search'] ?? '';
        
        $sql = "SELECT p.*, c.name as category_name, a.name as author_name 
                FROM posts p 
                LEFT JOIN categories c ON p.category_id = c.id 
                LEFT JOIN authors a ON p.author_id = a.id";
        
        if (!empty($filterStatus)) {
            $where[] = "p.status = ?";
            $params[] = $filterStatus;
        }
        if (!empty($filterCategory)) {
            $where[] = "p.category_id = ?";
            $params[] = $filterCategory;
        }
        if (!empty($filterSearch)) {
            $where[] = "(p.title LIKE ? OR p.slug LIKE ?)";
            $params[] = "%$filterSearch%";
            $params[] = "%$filterSearch%";
        }
        
        if (!empty($where)) {
            $sql .= " WHERE " . implode(' AND ', $where);
        }
        
        $sql .= " ORDER BY p.created_at DESC";
        
        try {
            $posts = Database::fetchAll($sql, $params);
            $categories = Database::fetchAll("SELECT * FROM categories ORDER BY name");
        } catch (\Exception $e) {}
        
        $this->adminView('posts.index', [
            'pageTitle' => 'Posts | Admin InforAgro',
            'posts' => $posts,
            'categories' => $categories,
            'filters' => [
                'status' => $filterStatus,
                'category' => $filterCategory,
                'search' => $filterSearch
            ]
        ]);
    }
    
    /**
     * Formulário de novo post
     */
    public function create(): void
    {
        $categories = [];
        $authors = [];
        
        try {
            $categories = Database::fetchAll("SELECT * FROM categories ORDER BY name");
            $authors = Database::fetchAll("SELECT * FROM authors WHERE is_active = 1");
            $allTags = Database::fetchAll("SELECT name FROM tags ORDER BY name");
        } catch (\Exception $e) {}
        
        $this->adminView('posts.form', [
            'pageTitle' => 'Novo Post | Admin InforAgro',
            'post' => null,
            'categories' => $categories,
            'authors' => $authors,
            'isEdit' => false,
            'tinymceToken' => JwtHelper::generateToken(['name' => $_SESSION['admin_name'] ?? 'Admin']),
            'allTags' => array_column($allTags ?? [], 'name'),
        ]);
    }
    
    /**
     * Salvar novo post
     */
    public function store(): void
    {
        $this->verifyCsrf();
        $data = $this->getPostData();
        
        try {
            $id = Post::create($data);
            
            // Sync Tags
            if (isset($_POST['tags'])) {
                $this->syncTags((int)$id, $_POST['tags']);
            }
            
            header('Location: /admin/posts?success=created');
        } catch (\Exception $e) {
            header('Location: /admin/posts/create?error=' . urlencode($e->getMessage()));
        }
        exit;
    }
    
    /**
     * Formulário de edição
     */
    public function edit(int $id): void
    {
        $post = null;
        $categories = [];
        $authors = [];
        
        try {
            $post = Post::find($id);
            $categories = Database::fetchAll("SELECT * FROM categories ORDER BY name");
            $authors = Database::fetchAll("SELECT * FROM authors WHERE is_active = 1");
            $allTags = Database::fetchAll("SELECT name FROM tags ORDER BY name");
            $postTags = Database::fetchAll("SELECT t.name FROM tags t JOIN post_tags pt ON t.id = pt.tag_id WHERE pt.post_id = ?", [$id]);
        } catch (\Exception $e) {}
        
        if (!$post) {
            header('Location: /admin/posts?error=notfound');
            exit;
        }
        
        $this->adminView('posts.form', [
            'pageTitle' => 'Editar Post | Admin InforAgro',
            'post' => $post,
            'categories' => $categories,
            'authors' => $authors,
            'isEdit' => true,
            'tinymceToken' => JwtHelper::generateToken(['name' => $_SESSION['admin_name'] ?? 'Admin']),
            'allTags' => array_column($allTags ?? [], 'name'),
            'currentTags' => array_column($postTags ?? [], 'name'),
        ]);
    }
    
    /**
     * Atualizar post
     */
    public function update(int $id): void
    {
        $this->verifyCsrf();
        $data = $this->getPostData();
        
        try {
            Post::update($id, $data);
            
            // Sync Tags
            if (isset($_POST['tags'])) {
                $this->syncTags($id, $_POST['tags']);
            }
            
            header('Location: /admin/posts?success=updated');
        } catch (\Exception $e) {
            header('Location: /admin/posts/' . $id . '/edit?error=' . urlencode($e->getMessage()));
        }
        exit;
    }
    
    /**
     * Deletar post
     */
    public function destroy(int $id): void
    {
        $this->verifyCsrf();
        $this->requireRole('editor');
        
        try {
            AuditLog::deleted('post', $id, ['id' => $id]);
            Post::delete($id);
            header('Location: /admin/posts?success=deleted');
        } catch (\Exception $e) {
            header('Location: /admin/posts?error=' . urlencode($e->getMessage()));
        }
        exit;
    }
    
    /**
     * Obter dados do formulário
     */
    private function getPostData(): array
    {
        $title = $_POST['title'] ?? '';
        $slug = $_POST['slug'] ?? $this->generateSlug($title);
        
        return [
            'title' => $title,
            'subtitle' => $_POST['subtitle'] ?? '',
            'slug' => $slug,
            'excerpt' => $this->generateExcerpt($_POST['content'] ?? ''),
            'content' => $_POST['content'] ?? '',
            'category_id' => (int) ($_POST['category_id'] ?? 1),
            'author_id' => (int) ($_POST['author_id'] ?? 1),
            'status' => $_POST['status'] ?? 'draft',
            'content_type' => $_POST['content_type'] ?? 'article',
            'meta_title' => $_POST['meta_title'] ?? '',
            'meta_description' => $_POST['meta_description'] ?? '',
            'focus_keyword' => $_POST['focus_keyword'] ?? '',
            'featured_image' => $_POST['featured_image'] ?? '',
            'featured_image_caption' => $_POST['featured_image_caption'] ?? '',
            'custom_schema' => $_POST['custom_schema'] ?? '',
            'read_time' => $this->calculateReadTime($_POST['content'] ?? ''),
            'word_count' => str_word_count(strip_tags($_POST['content'] ?? '')),
            'published_at' => $_POST['status'] === 'published' ? date('Y-m-d H:i:s') : null,
        ];
    }
    
    /**
     * Gerar slug a partir do título
     */
    private function generateSlug(string $title): string
    {
        $slug = mb_strtolower($title);
        $slug = preg_replace('/[áàãâä]/u', 'a', $slug);
        $slug = preg_replace('/[éèêë]/u', 'e', $slug);
        $slug = preg_replace('/[íìîï]/u', 'i', $slug);
        $slug = preg_replace('/[óòõôö]/u', 'o', $slug);
        $slug = preg_replace('/[úùûü]/u', 'u', $slug);
        $slug = preg_replace('/[ç]/u', 'c', $slug);
        $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
        $slug = trim($slug, '-');
        return $slug;
    }
    
    /**
     * Calcular tempo de leitura
     */
    private function calculateReadTime(string $content): int
    {
        $wordCount = str_word_count(strip_tags($content));
        $readTime = ceil($wordCount / 200); // 200 palavras por minuto
        return max(1, $readTime);
    }
    /**
     * Sincronizar Tags
     */
    private function syncTags(int $postId, string $tagsInput): void
    {
        // Limpar relação anterior
        Database::query("DELETE FROM post_tags WHERE post_id = ?", [$postId]);
        
        if (empty(trim($tagsInput))) return;
        
        $tagNames = array_filter(array_map('trim', explode(',', $tagsInput)));
        
        foreach ($tagNames as $tagName) {
            if (empty($tagName)) continue;
            
            $slug = $this->generateSlug($tagName);
            
            // Verificar Conflito com Categorias
            $catConflict = Database::fetch("SELECT id FROM categories WHERE slug = ?", [$slug]);
            if ($catConflict) {
                continue;
            }
            
            // Buscar ou Criar Tag
            $tag = Database::fetch("SELECT id FROM tags WHERE slug = ?", [$slug]);
            
            if ($tag) {
                $tagId = $tag['id'];
            } else {
                Database::query("INSERT INTO tags (name, slug) VALUES (?, ?)", [$tagName, $slug]);
                $tagId = Database::lastInsertId();
            }
            
            // Associar
            try {
                Database::query("INSERT INTO post_tags (post_id, tag_id) VALUES (?, ?)", [$postId, $tagId]);
            } catch (\Exception $e) {}
        }
    }

    /**
     * Gerar resumo automático a partir do conteúdo
     */
    private function generateExcerpt(string $content, int $length = 160): string
    {
        $text = strip_tags($content);
        // Limpar espaços extras
        $text = trim(preg_replace('/\s+/', ' ', $text));
        
        if (mb_strlen($text) <= $length) {
            return $text;
        }
        
        $excerpt = mb_substr($text, 0, $length);
        // Cortar no último espaço para não quebrar palavras
        $lastSpace = mb_strrpos($excerpt, ' ');
        if ($lastSpace !== false) {
            $excerpt = mb_substr($excerpt, 0, $lastSpace);
        }
        
        return $excerpt . '...';
    }
}
