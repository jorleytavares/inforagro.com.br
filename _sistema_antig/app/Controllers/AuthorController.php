<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Models\Author;
use App\Helpers\SeoHelper;

/**
 * Controlador de Autores (Público)
 */
class AuthorController extends Controller
{
    /**
     * Exibir página de autor
     */
    public function show(string $slug): void
    {
        $author = null;
        $posts = [];
        $page = (int) ($_GET['page'] ?? 1);
        $perPage = 12;
        
        try {
            $author = Author::findBySlug($slug);
            
            if ($author) {
                $offset = ($page - 1) * $perPage;
                $posts = Author::getPosts($author['id'], $perPage, $offset);
            }
        } catch (\Exception $e) {
            // Fallback
        }
        
        if (!$author) {
            http_response_code(404);
            $this->view('errors.404', ['pageTitle' => 'Autor não encontrado | InfoRagro']);
            return;
        }
        
        $this->view('author.show', [
            'pageTitle' => $author['name'] . ' | InfoRagro',
            'metaDescription' => $author['bio'] ?? 'Artigos de ' . $author['name'] . ' no InfoRagro',
            'author' => $author,
            'posts' => $posts,
            'currentPage' => $page,
            'breadcrumbs' => [
                ['name' => 'Início', 'url' => '/'],
                ['name' => 'Autores', 'url' => '#'],
                ['name' => $author['name'], 'url' => '/autor/' . $slug],
            ],
        ]);
    }
}
