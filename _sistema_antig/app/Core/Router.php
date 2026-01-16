<?php

namespace App\Core;

/**
 * Roteador Simples
 * 
 * Gerencia as rotas da aplicação e direciona para os controladores
 */
class Router
{
    private array $routes = [];
    
    /**
     * Registrar rota GET
     */
    public function get(string $path, string $controller, string $method): void
    {
        $this->addRoute('GET', $path, $controller, $method);
    }
    
    /**
     * Registrar rota POST
     */
    public function post(string $path, string $controller, string $method): void
    {
        $this->addRoute('POST', $path, $controller, $method);
    }
    
    /**
     * Adicionar rota ao registro
     */
    private function addRoute(string $httpMethod, string $path, string $controller, string $method): void
    {
        // Converter parâmetros de rota {param} para regex
        $pattern = preg_replace('/\{([a-zA-Z_]+)\}/', '(?P<$1>[^/]+)', $path);
        $pattern = '#^' . $pattern . '$#';
        
        $this->routes[] = [
            'httpMethod' => $httpMethod,
            'pattern' => $pattern,
            'path' => $path,
            'controller' => $controller,
            'method' => $method,
        ];
    }
    
    /**
     * Despachar a requisição para o controlador apropriado
     */
    public function dispatch(): void
    {
        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        // Remover trailing slash
        $uri = rtrim($uri, '/') ?: '/';
        
        foreach ($this->routes as $route) {
            if ($route['httpMethod'] !== $httpMethod) {
                continue;
            }
            
            if (preg_match($route['pattern'], $uri, $matches)) {
                // Filtrar apenas parâmetros nomeados
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                
                // Instanciar controlador e chamar método
                $controllerClass = "App\\Controllers\\{$route['controller']}";
                
                if (!class_exists($controllerClass)) {
                    $this->notFound("Controller não encontrado: {$controllerClass}");
                    return;
                }
                
                $controller = new $controllerClass();
                $method = $route['method'];
                
                if (!method_exists($controller, $method)) {
                    $this->notFound("Método não encontrado: {$method}");
                    return;
                }
                
                // Chamar o método com os parâmetros (array_values para compatibilidade PHP 8+)
                call_user_func_array([$controller, $method], array_values($params));
                return;
            }
        }
        
        // Nenhuma rota encontrada
        $this->notFound();
    }
    
    /**
     * Renderizar página 404
     */
    private function notFound(string $message = 'Página não encontrada'): void
    {
        http_response_code(404);
        
        if (Config::isDebug()) {
            echo "<h1>404 - Não Encontrado</h1><p>{$message}</p>";
        } else {
            // Renderizar view 404 personalizada
            if (file_exists(ROOT_PATH . '/app/Views/errors/404.php')) {
                require ROOT_PATH . '/app/Views/errors/404.php';
            } else {
                echo '<h1>Página não encontrada</h1>';
            }
        }
    }
}
