<?php

namespace App\Controllers\Admin;

use App\Core\Database;
use App\Models\Category;

/**
 * Controlador de Categorias (Admin)
 */
class CategoryController extends DashboardController
{
    /**
     * Listar todas as categorias (Hierárquico)
     */
    public function index(): void
    {
        $orderedCategories = [];
        try {
            // Buscar todas as categorias
            $allCategories = Database::fetchAll(
                "SELECT c.*, p.name as parent_name,
                 (SELECT COUNT(*) FROM posts WHERE category_id = c.id) as post_count
                 FROM categories c 
                 LEFT JOIN categories p ON c.parent_id = p.id 
                 ORDER BY c.sort_order, c.name"
            );
            
            // Separar pais e filhos
            $parents = [];
            $children = [];
            
            foreach ($allCategories as $cat) {
                if (empty($cat['parent_id'])) {
                    $parents[] = $cat;
                } else {
                    $children[$cat['parent_id']][] = $cat;
                }
            }
            
            // Construir lista ordenada
            foreach ($parents as $parent) {
                $orderedCategories[] = $parent;
                if (isset($children[$parent['id']])) {
                    foreach ($children[$parent['id']] as $child) {
                        $child['name'] = '— ' . $child['name']; // Indentação visual
                        $child['is_child'] = true;
                        $orderedCategories[] = $child;
                    }
                }
            }
            
            // Adicionar órfãos (se houver, por segurança)
            foreach ($allCategories as $cat) {
                $found = false;
                foreach ($orderedCategories as $oc) {
                    if ($oc['id'] == $cat['id']) {
                        $found = true;
                        break;
                    }
                }
                if (!$found) {
                    $orderedCategories[] = $cat;
                }
            }
            
        } catch (\Exception $e) {}
        
        $this->adminView('categories.index', [
            'pageTitle' => 'Categorias | Admin InforAgro',
            'categories' => $orderedCategories,
        ]);
    }
    
    /**
     * Formulário de nova categoria
     */
    public function create(): void
    {
        $parentCategories = [];
        try {
            $parentCategories = Database::fetchAll(
                "SELECT * FROM categories WHERE parent_id IS NULL ORDER BY name"
            );
        } catch (\Exception $e) {}
        
        $this->adminView('categories.form', [
            'pageTitle' => 'Nova Categoria | Admin InforAgro',
            'category' => null,
            'parentCategories' => $parentCategories,
            'isEdit' => false,
        ]);
    }
    
    /**
     * Salvar nova categoria
     */
    public function store(): void
    {
        $this->verifyCsrf();
        
        $data = [
            'name' => $_POST['name'] ?? '',
            'slug' => $_POST['slug'] ?? $this->generateSlug($_POST['name'] ?? ''),
            'description' => $_POST['description'] ?? '',
            'parent_id' => !empty($_POST['parent_id']) ? (int) $_POST['parent_id'] : null,
            'meta_title' => $_POST['meta_title'] ?? '',
            'meta_description' => $_POST['meta_description'] ?? '',
            'icon' => $_POST['icon'] ?? '',
            'color' => $_POST['color'] ?? '#5F7D4E',
            'sort_order' => (int) ($_POST['sort_order'] ?? 0),
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ];
        
        try {
            // Regra: Bloquear se existe tag com mesmo slug
            $conflict = Database::fetch("SELECT id FROM tags WHERE slug = ?", [$data['slug']]);
            if ($conflict) {
                throw new \Exception("Conflito: Já existe uma Tag com o slug '{$data['slug']}'. Regra de SEO: Tag e Categoria não podem ter o mesmo nome.");
            }

            Category::create($data);
            header('Location: /admin/categories?success=created');
        } catch (\Exception $e) {
            header('Location: /admin/categories/create?error=' . urlencode($e->getMessage()));
        }
        exit;
    }
    
    /**
     * Formulário de edição
     */
    public function edit(int $id): void
    {
        $category = null;
        $parentCategories = [];
        
        try {
            $category = Category::find($id);
            $parentCategories = Database::fetchAll(
                "SELECT * FROM categories WHERE parent_id IS NULL AND id != ? ORDER BY name",
                [$id]
            );
        } catch (\Exception $e) {}
        
        if (!$category) {
            header('Location: /admin/categories?error=notfound');
            exit;
        }
        
        $this->adminView('categories.form', [
            'pageTitle' => 'Editar Categoria | Admin InforAgro',
            'category' => $category,
            'parentCategories' => $parentCategories,
            'isEdit' => true,
        ]);
    }
    
    /**
     * Atualizar categoria
     */
    public function update(int $id): void
    {
        $this->verifyCsrf();
        
        $data = [
            'name' => $_POST['name'] ?? '',
            'slug' => $_POST['slug'] ?? '',
            'description' => $_POST['description'] ?? '',
            'parent_id' => !empty($_POST['parent_id']) ? (int) $_POST['parent_id'] : null,
            'meta_title' => $_POST['meta_title'] ?? '',
            'meta_description' => $_POST['meta_description'] ?? '',
            'icon' => $_POST['icon'] ?? '',
            'color' => $_POST['color'] ?? '#5F7D4E',
            'sort_order' => (int) ($_POST['sort_order'] ?? 0),
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ];
        
        try {
             // Regra: Bloquear se existe tag com mesmo slug
            $conflict = Database::fetch("SELECT id FROM tags WHERE slug = ?", [$data['slug']]);
            if ($conflict) {
                throw new \Exception("Conflito: Já existe uma Tag com o slug '{$data['slug']}'.");
            }

            Category::update($id, $data);
            header('Location: /admin/categories?success=updated');
        } catch (\Exception $e) {
            header('Location: /admin/categories/' . $id . '/edit?error=' . urlencode($e->getMessage()));
        }
        exit;
    }
    
    /**
     * Otimizar categorias: Converter subcategorias em Tags
     */
    public function optimize(): void
    {
        try {
            // 1. Buscar Subcategorias
            $subCategories = Database::fetchAll("SELECT * FROM categories WHERE parent_id IS NOT NULL");
            
            if (empty($subCategories)) {
                header('Location: /admin/categories?error=' . urlencode('Nenhuma subcategoria para otimizar.'));
                exit;
            }

            $pdo = Database::getInstance();
            $pdo->beginTransaction();

            foreach ($subCategories as $sub) {
                // 2. Garantir que existe Tag
                $tagSlug = $sub['slug'];
                $existingTag = Database::fetch("SELECT id FROM tags WHERE slug = ?", [$tagSlug]);
                
                if ($existingTag) {
                    $tagId = $existingTag['id'];
                } else {
                    Database::query("INSERT INTO tags (name, slug) VALUES (?, ?)", [$sub['name'], $tagSlug]);
                    $tagId = $pdo->lastInsertId();
                }
                
                // 3. Buscar Posts desta subcategoria
                $posts = Database::fetchAll("SELECT id FROM posts WHERE category_id = ?", [$sub['id']]);
                
                foreach ($posts as $post) {
                    // Mover para categoria pai
                    Database::query(
                        "UPDATE posts SET category_id = ? WHERE id = ?", 
                        [$sub['parent_id'], $post['id']]
                    );
                    
                    // Associar Tag (Verifica se já tem)
                    $hasTag = Database::fetch(
                        "SELECT * FROM post_tags WHERE post_id = ? AND tag_id = ?", 
                        [$post['id'], $tagId]
                    );
                    
                    if (!$hasTag) {
                        Database::query(
                            "INSERT INTO post_tags (post_id, tag_id) VALUES (?, ?)", 
                            [$post['id'], $tagId]
                        );
                    }
                }
                
                // 4. Deletar Subcategoria
                Database::query("DELETE FROM categories WHERE id = ?", [$sub['id']]);
            }

            $pdo->commit();
            header('Location: /admin/categories?success=' . urlencode('Categorias otimizadas! Subcategorias convertidas em Tags.'));

        } catch (\Exception $e) {
            if (isset($pdo)) $pdo->rollBack();
            header('Location: /admin/categories?error=' . urlencode('Erro ao otimizar: ' . $e->getMessage()));
        }
        exit;
    }
    
    /**
     * Gerar slug
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
        return trim($slug, '-');
    }
}
