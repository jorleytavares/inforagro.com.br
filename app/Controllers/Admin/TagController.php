<?php

namespace App\Controllers\Admin;

use App\Core\Database;

/**
 * Controlador de Tags (Admin)
 */
class TagController extends DashboardController
{
    /**
     * Listar tags
     */
    public function index(): void
    {
        $tags = [];
        try {
            $tags = Database::fetchAll(
                "SELECT t.*, 
                 (SELECT COUNT(*) FROM post_tags WHERE tag_id = t.id) as post_count
                 FROM tags t ORDER BY t.name"
            );
        } catch (\Exception $e) {}
        
        $this->adminView('tags.index', [
            'pageTitle' => 'Tags | Admin InforAgro',
            'tags' => $tags,
        ]);
    }
    
    /**
     * Nova tag
     */
    public function create(): void
    {
        $this->adminView('tags.form', [
            'pageTitle' => 'Nova Tag | Admin InforAgro',
            'tag' => null,
            'isEdit' => false,
        ]);
    }
    
    /**
     * Salvar tag
     */
    public function store(): void
    {
        $this->verifyCsrf();
        
        $name = $_POST['name'] ?? '';
        $slug = $_POST['slug'] ?? $this->slugify($name);
        
        try {
            // Regra: Bloquear se existe categoria com mesmo slug
            $conflict = Database::fetch("SELECT id FROM categories WHERE slug = ?", [$slug]);
            if ($conflict) {
                throw new \Exception("Conflito: Já existe uma categoria com o slug '$slug'. Regra de SEO: Tag e Categoria não podem ter o mesmo nome.");
            }

            Database::query(
                "INSERT INTO tags (name, slug) VALUES (?, ?)",
                [$name, $slug]
            );
            header('Location: /admin/tags?success=created');
        } catch (\Exception $e) {
            header('Location: /admin/tags/create?error=' . urlencode($e->getMessage()));
        }
        exit;
    }
    
    /**
     * Editar tag
     */
    public function edit(int $id): void
    {
        $tag = Database::fetch("SELECT * FROM tags WHERE id = ?", [$id]);
        
        if (!$tag) {
            header('Location: /admin/tags?error=notfound');
            exit;
        }
        
        $this->adminView('tags.form', [
            'pageTitle' => 'Editar Tag | Admin InforAgro',
            'tag' => $tag,
            'isEdit' => true,
        ]);
    }
    
    /**
     * Atualizar tag
     */
    public function update(int $id): void
    {
        $this->verifyCsrf();
        
        $name = $_POST['name'] ?? '';
        $slug = $_POST['slug'] ?? '';
        
        try {
            // Regra: Bloquear se existe categoria com mesmo slug
            $conflict = Database::fetch("SELECT id FROM categories WHERE slug = ?", [$slug]);
            if ($conflict) {
                throw new \Exception("Conflito: Já existe uma categoria com o slug '$slug'.");
            }

            Database::query(
                "UPDATE tags SET name = ?, slug = ? WHERE id = ?",
                [$name, $slug, $id]
            );
            header('Location: /admin/tags?success=updated');
        } catch (\Exception $e) {
            header('Location: /admin/tags/' . $id . '/edit?error=' . urlencode($e->getMessage()));
        }
        exit;
    }
    
    /**
     * Deletar tag
     */
    public function destroy(int $id): void
    {
        $this->verifyCsrf();
        
        try {
            Database::query("DELETE FROM post_tags WHERE tag_id = ?", [$id]);
            Database::query("DELETE FROM tags WHERE id = ?", [$id]);
            header('Location: /admin/tags?success=deleted');
        } catch (\Exception $e) {
            header('Location: /admin/tags?error=' . urlencode($e->getMessage()));
        }
        exit;
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
