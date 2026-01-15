<?php

/**
 * inforagro.com.br - Ponto de Entrada da Aplicação
 * 
 * Este arquivo é o front controller que recebe todas as requisições
 * e as direciona para o roteador apropriado.
 */

// Definir constantes de caminho
define('ROOT_PATH', dirname(__DIR__));
define('APP_PATH', ROOT_PATH . '/app');
define('PUBLIC_PATH', __DIR__);

// ===== Headers de Segurança =====
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('X-XSS-Protection: 1; mode=block');
header('Referrer-Policy: strict-origin-when-cross-origin');
header('Permissions-Policy: geolocation=(), microphone=(), camera=()');

// Content Security Policy (ajustar conforme necessidade)
$csp = "default-src 'self'; ";
$csp .= "script-src 'self' 'unsafe-inline' 'unsafe-eval' cdn.jsdelivr.net; ";
$csp .= "style-src 'self' 'unsafe-inline' fonts.googleapis.com; ";
$csp .= "font-src 'self' fonts.gstatic.com; ";
$csp .= "img-src 'self' data: https:; ";
$csp .= "connect-src 'self'; ";
$csp .= "frame-ancestors 'self';";
header('Content-Security-Policy: ' . $csp);

// Carregar autoloader e configurações
require_once ROOT_PATH . '/app/Core/Autoloader.php';
require_once ROOT_PATH . '/app/Core/Config.php';

// Inicializar a aplicação
use App\Core\Router;
use App\Core\Database;

// Carregar rotas
$router = new Router();
require_once ROOT_PATH . '/app/routes.php';

// Executar a aplicação
$router->dispatch();

