<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Post;
use App\Models\Category;

/**
 * Controlador da Página Inicial
 */
class HomeController extends Controller
{
    /**
     * Exibir página inicial
     */
    public function index(): void
    {
        // Obter categorias principais (silos)
        $categories = Category::getMainCategories();
        
        // Tentar obter posts do banco
        try {
            $featuredPosts = Post::getFeatured(6);
            $latestPosts = Post::getPublished(6);
        } catch (\Exception $e) {
            $featuredPosts = [];
            $latestPosts = [];
        }
        
        $this->view('home.index', [
            'pageTitle' => 'InforAgro - Portal de Notícias do Agronegócio Brasileiro',
            'pageDescription' => 'Portal de notícias, análises e referências sobre o agronegócio brasileiro. Agricultura, pecuária, mercado agro, sustentabilidade e mundo pet.',
            'canonical' => 'https://www.inforagro.com.br',
            'ogType' => 'website',
            'featuredPosts' => $featuredPosts,
            'latestPosts' => $latestPosts,
            'categories' => $categories,
        ]);
    }
}
