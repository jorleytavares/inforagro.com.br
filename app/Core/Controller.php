<?php

namespace App\Core;

/**
 * Controlador Base
 * 
 * Classe base para todos os controladores da aplicação
 */
abstract class Controller
{
    /**
     * Renderizar uma view
     */
    protected function view(string $view, array $data = []): void
    {
        // Extrair dados para variáveis
        extract($data);
        
        // Caminho da view
        $viewPath = ROOT_PATH . '/app/Views/' . str_replace('.', '/', $view) . '.php';
        
        if (!file_exists($viewPath)) {
            throw new \Exception("View não encontrada: {$view}");
        }
        
        // Iniciar buffer de saída
        ob_start();
        require $viewPath;
        $content = ob_get_clean();
        
        // Verificar se deve usar layout
        $layoutPath = ROOT_PATH . '/app/Views/layouts/main.php';
        if (file_exists($layoutPath)) {
            require $layoutPath;
        } else {
            echo $content;
        }
    }
    
    /**
     * Renderizar view sem layout
     */
    protected function partial(string $view, array $data = []): void
    {
        extract($data);
        
        $viewPath = ROOT_PATH . '/app/Views/' . str_replace('.', '/', $view) . '.php';
        
        if (file_exists($viewPath)) {
            require $viewPath;
        }
    }
    
    /**
     * Retornar resposta JSON
     */
    protected function json(array $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }
    
    /**
     * Redirecionar para outra página
     */
    protected function redirect(string $url): void
    {
        header("Location: {$url}");
        exit;
    }
    
    /**
     * Obter dados da requisição POST
     */
    protected function input(string $key, $default = null)
    {
        return $_POST[$key] ?? $default;
    }
    
    /**
     * Obter parâmetro da query string
     */
    protected function query(string $key, $default = null)
    {
        return $_GET[$key] ?? $default;
    }
}
