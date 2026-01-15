<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Models\Tag;

/**
 * Controlador de Tags (Público)
 */
class TagController extends Controller
{
    /**
     * Exibir página de tag
     */
    public function show(string $slug): void
    {
        $tag = null;
        $posts = [];
        $page = (int) ($_GET['page'] ?? 1);
        $perPage = 12;
        
        try {
            $tag = Tag::findBySlug($slug);
            
            if ($tag) {
                $offset = ($page - 1) * $perPage;
                $posts = Tag::getPosts($tag['id'], $perPage, $offset);
            }
        } catch (\Exception $e) {
            // Fallback
        }
        
        if (!$tag) {
            http_response_code(404);
            $this->view('errors.404', ['pageTitle' => 'Tag não encontrada | InfoRagro']);
            return;
        }
        
        $this->view('tag.show', [
            'pageTitle' => $tag['name'] . ' | InforAgro',
            'pageDescription' => !empty($tag['description']) ? $tag['description'] : 'Confira as últimas notícias e artigos sobre ' . $tag['name'] . ' no portal InforAgro.',
            'tag' => $tag,
            'posts' => $posts,
            'currentPage' => $page,
            'breadcrumbs' => [
                ['name' => 'Início', 'url' => '/'],
                ['name' => $tag['name'], 'url' => '/tag/' . $slug],
            ],
        ]);
    }
}
