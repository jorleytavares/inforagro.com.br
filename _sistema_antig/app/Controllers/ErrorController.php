<?php

namespace App\Controllers;

use App\Core\Controller;

/**
 * Controller para páginas de erro
 */
class ErrorController extends Controller
{
    /**
     * Página 404 - Não Encontrado
     */
    public function notFound(): void
    {
        http_response_code(404);
        
        $this->render('errors.404', [
            'pageTitle' => 'Página não encontrada | InforAgro',
            'pageDescription' => 'A página que você procura não foi encontrada.',
            'robots' => 'noindex, nofollow',
        ]);
    }
    
    /**
     * Página 500 - Erro Interno
     */
    public function serverError(): void
    {
        http_response_code(500);
        
        $this->render('errors.500', [
            'pageTitle' => 'Erro no servidor | InforAgro',
            'pageDescription' => 'Ocorreu um erro interno no servidor.',
            'robots' => 'noindex, nofollow',
        ]);
    }
    
    /**
     * Página 503 - Manutenção
     */
    public function maintenance(): void
    {
        http_response_code(503);
        header('Retry-After: 3600');
        
        $this->render('errors.503', [
            'pageTitle' => 'Em manutenção | InforAgro',
            'pageDescription' => 'Estamos em manutenção. Voltamos em breve!',
            'robots' => 'noindex, nofollow',
        ]);
    }
}
