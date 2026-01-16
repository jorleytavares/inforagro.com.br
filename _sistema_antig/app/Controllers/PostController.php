<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Post;
use App\Models\Category;

/**
 * Controlador de Posts/Artigos
 */
class PostController extends Controller
{
    /**
     * Exibir artigo individual
     */
    public function show(string $category, string $slug): void
    {
        try {
            $post = Post::findBySlug($slug);
        } catch (\Exception $e) {
            $post = null;
        }
        
        if (!$post) {
            // Post não encontrado - exibir 404
            http_response_code(404);
            $this->view('errors.404', [
                'pageTitle' => 'Página não encontrada | InforAgro',
                'pageDescription' => 'O artigo que você está procurando não existe.',
            ]);
            return;
        }
        
        // Cache: 1h Browser, 7 dias CDN (Cloudflare)
        // Isso reduz carga no servidor, mas requer contador de views via JS (AJAX)
        if (getenv('APP_ENV') !== 'development') {
            header('Cache-Control: public, max-age=3600, s-maxage=604800, stale-while-revalidate=86400');
            header('Vary: Accept-Encoding');
        }

        // Incremento Síncrono REMOVIDO em favor do AJAX para permitir cache de página HTML
        // Veja método registerView() abaixo
        
        // Obter tags do post
        $tags = [];
        try {
            $tags = Post::getTags($post['id']);
        } catch (\Exception $e) {}
        
        // Posts relacionados
        $relatedPosts = [];
        if (isset($post['category_id'])) {
            try {
                $relatedPosts = Post::getRelated($post['id'], $post['category_id'], 4);
            } catch (\Exception $e) {}
        }
        
        // Breadcrumb
        $breadcrumbs = [
            ['name' => 'Início', 'url' => '/'],
            ['name' => $post['category_name'], 'url' => '/' . $post['category_slug']],
            ['name' => $post['title'], 'url' => '/' . $post['category_slug'] . '/' . $post['slug']],
        ];
        
        // Schema JSON-LD para artigo
        $articleSchema = $this->generateArticleSchema($post);
        
        // Append Manual Schema if present
        if (!empty($post['custom_schema'])) {
            $articleSchema .= "\n" . $post['custom_schema'];
        }
        
        $this->view('post.show', [
            'pageTitle' => ($post['meta_title'] ?? $post['title']) . ' | InforAgro',
            'pageDescription' => $post['meta_description'] ?? $post['excerpt'] ?? '',
            'canonical' => 'https://www.inforagro.com.br/' . $post['category_slug'] . '/' . $post['slug'],
            'ogType' => 'article',
            'ogImage' => $post['og_image'] ?? $post['featured_image'] ?? null,
            'post' => $post,
            'tags' => $tags,
            'relatedPosts' => $relatedPosts,
            'breadcrumbs' => $breadcrumbs,
            'additionalSchemas' => $articleSchema,
        ]);
    }

    /**
     * Registrar visualização via AJAX
     * (Is para não quebrar o cache de página estática)
     */
    public function registerView(): void
    {
        // Headers para permitir AJAX de qualquer origem se necessário, ou restrito
        header('Content-Type: application/json');
        
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (!empty($data['post_id'])) {
            try {
                Post::incrementViews((int)$data['post_id']);
                echo json_encode(['success' => true]);
            } catch (\Exception $e) {
                http_response_code(500);
                echo json_encode(['error' => 'Erro interno']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'ID ausente']);
        }
        exit;
    }
    
    /**
     * Gerar schema JSON-LD do artigo
     * Este método cria automaticamente o markup estruturado para Google (NewsArticle)
     */
    private function generateArticleSchema(array $post): string
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'NewsArticle',
            'headline' => $post['title'],
            'description' => $post['excerpt'] ?? '',
            'image' => $post['featured_image'] ?? 'https://www.inforagro.com.br/assets/images/og-default.jpg',
            'datePublished' => $post['published_at'] ?? date('c'),
            'dateModified' => $post['updated_at'] ?? date('c'),
            'author' => [
                '@type' => 'Person',
                'name' => $post['author_name'] ?? 'Equipe InforAgro',
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => 'InforAgro',
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => 'https://www.inforagro.com.br/assets/images/logo.png'
                ]
            ],
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => 'https://www.inforagro.com.br/' . $post['category_slug'] . '/' . $post['slug']
            ],
            'articleSection' => $post['category_name'] ?? ''
        ];
        
        return '<script type="application/ld+json">' . 
               json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . 
               '</script>';
    }
}

