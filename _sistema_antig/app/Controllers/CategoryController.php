<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Category;
use App\Models\Post;

/**
 * Controlador de Categorias
 */
class CategoryController extends Controller
{
    /**
     * Exibir página de categoria
     */
    public function show(string $category): void
    {
        $categoryData = Category::findBySlug($category);
        
        if (!$categoryData) {
            $this->notFound();
            return;
        }
        
        // Obter subcategorias se for categoria principal
        $subcategories = [];
        if ($categoryData['parent_id'] === null) {
            $subcategories = Category::getSubcategories($categoryData['id']);
        }
        
        // Obter posts da categoria
        $page = (int) $this->query('page', 1);
        $perPage = 12;
        $offset = ($page - 1) * $perPage;
        
        try {
            $posts = Post::getByCategory($categoryData['id'], $perPage, $offset);
            $totalPosts = Category::countPosts($categoryData['id']);
        } catch (\Exception $e) {
            $posts = [];
            $totalPosts = 0;
        }
        
        $totalPages = $totalPosts > 0 ? ceil($totalPosts / $perPage) : 0;
        
        // Breadcrumb
        $breadcrumbs = Category::getBreadcrumb($categoryData['id']);
        
        $this->view('category.index', [
            'pageTitle' => $categoryData['meta_title'] ?: $categoryData['name'] . ' | InforAgro',
            'pageDescription' => $categoryData['meta_description'] ?: $categoryData['description'] ?: 'Notícias e artigos sobre ' . $categoryData['name'],
            'canonical' => 'https://www.inforagro.com.br/' . $categoryData['slug'],
            'ogType' => 'website',
            'category' => $categoryData,
            'subcategories' => $subcategories,
            'posts' => $posts,
            'breadcrumbs' => $breadcrumbs,
            'pagination' => [
                'current' => $page,
                'total' => $totalPages,
                'perPage' => $perPage,
                'totalItems' => $totalPosts,
            ],
        ]);
    }
    
    /**
     * Exibir subcategoria OU post
     */
    public function showSubcategory(string $category, string $slug): void
    {
        // Primeiro, verificar se é uma subcategoria válida
        $subcategory = Category::findBySlug($slug);
        if ($subcategory) {
            // É uma subcategoria - exibir como categoria
            $this->show($slug);
            return;
        }
        
        // Não é subcategoria, então é um post
        $postController = new PostController();
        $postController->show($category, $slug);
    }
    
    /**
     * Página não encontrada
     */
    private function notFound(): void
    {
        http_response_code(404);
        $this->view('errors.404', [
            'pageTitle' => 'Página não encontrada | InforAgro',
            'pageDescription' => 'A página que você está procurando não existe.',
        ]);
    }
}

