<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Post;
use App\Models\SearchLog;

/**
 * Controlador de Busca
 */
class SearchController extends Controller
{
    /**
     * Página de busca
     */
    public function index(): void
    {
        $query = trim($this->query('q', ''));
        $posts = [];
        
        if (strlen($query) >= 3) {
            try {
                $posts = Post::search($query, 20);
            } catch (\Exception $e) {
                // Banco não disponível
            }
        }
        
        
        // Log da busca (para monitoramento)
        if (!empty($query)) {
            SearchLog::log($query, count($posts));
        }

        $this->view('search.index', [
            'pageTitle' => $query ? 'Busca: ' . $query . ' | InforAgro' : 'Buscar | InforAgro',
            'pageDescription' => 'Busque por notícias e artigos sobre agronegócio no portal InforAgro.',
            'robots' => 'noindex, follow',
            'query' => $query,
            'posts' => $posts,
            'totalResults' => count($posts),
        ]);
    }
}
