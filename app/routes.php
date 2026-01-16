<?php

/**
 * Arquivo de Rotas da Aplicação
 * inforagro.com.br - Portal de Notícias do Agronegócio
 * 
 * IMPORTANTE: Ordem das rotas importa! Rotas específicas devem vir ANTES das genéricas.
 */

// ==========================================
// ADMIN - PAINEL ADMINISTRATIVO
// ==========================================
$router->get('/admin/login', 'Admin\DashboardController', 'login');
$router->post('/admin/login', 'Admin\DashboardController', 'doLogin');
$router->get('/admin/logout', 'Admin\DashboardController', 'logout');

// Admin - Recuperação de Senha
$router->get('/admin/forgot-password', 'Admin\PasswordResetController', 'showRequest');
$router->post('/admin/forgot-password', 'Admin\PasswordResetController', 'sendReset');
$router->get('/admin/reset-password', 'Admin\PasswordResetController', 'showReset');
$router->post('/admin/reset-password', 'Admin\PasswordResetController', 'doReset');

$router->get('/admin', 'Admin\DashboardController', 'index');
$router->get('/admin/search-terms', 'Admin\SearchTermsController', 'index');
$router->post('/admin/search-terms/clear', 'Admin\SearchTermsController', 'clear');

// Admin - Newsletter
$router->get('/admin/newsletter', 'Admin\NewsletterAdminController', 'index');
$router->get('/admin/newsletter/export', 'Admin\NewsletterAdminController', 'export');

// Admin - Posts
$router->get('/admin/posts', 'Admin\PostController', 'index');
$router->get('/admin/posts/create', 'Admin\PostController', 'create');
$router->post('/admin/posts/store', 'Admin\PostController', 'store');
$router->get('/admin/posts/{id}/edit', 'Admin\PostController', 'edit');
$router->post('/admin/posts/{id}/update', 'Admin\PostController', 'update');
$router->post('/admin/posts/{id}/delete', 'Admin\PostController', 'destroy');

// Admin - Categorias
$router->get('/admin/categories', 'Admin\CategoryController', 'index');
$router->get('/admin/categories/create', 'Admin\CategoryController', 'create');
$router->post('/admin/categories/store', 'Admin\CategoryController', 'store');
$router->get('/admin/categories/{id}/edit', 'Admin\CategoryController', 'edit');
$router->post('/admin/categories/{id}/update', 'Admin\CategoryController', 'update');
$router->post('/admin/categories/optimize', 'Admin\CategoryController', 'optimize');

// Admin - Autores
$router->get('/admin/authors', 'Admin\AuthorController', 'index');
$router->get('/admin/authors/create', 'Admin\AuthorController', 'create');
$router->post('/admin/authors/store', 'Admin\AuthorController', 'store');
$router->get('/admin/authors/{id}/edit', 'Admin\AuthorController', 'edit');
$router->post('/admin/authors/{id}/update', 'Admin\AuthorController', 'update');

// Admin - Tags
$router->get('/admin/tags', 'Admin\TagController', 'index');
$router->get('/admin/tags/create', 'Admin\TagController', 'create');
$router->post('/admin/tags/store', 'Admin\TagController', 'store');
$router->get('/admin/tags/{id}/edit', 'Admin\TagController', 'edit');
$router->post('/admin/tags/{id}/update', 'Admin\TagController', 'update');
$router->post('/admin/tags/{id}/delete', 'Admin\TagController', 'destroy');

// Admin - Mídia
$router->get('/admin/media', 'Admin\MediaController', 'index');
$router->post('/admin/media/upload', 'Admin\MediaController', 'upload');

$router->post('/admin/media/delete', 'Admin\MediaController', 'delete');

// Admin - Configurações
$router->get('/admin/settings', 'Admin\SettingsController', 'index');
$router->post('/admin/settings/update', 'Admin\SettingsController', 'update');
$router->get('/admin/settings/clear-cache', 'Admin\SettingsController', 'clearCache');
$router->get('/admin/settings/purge-cloudflare', 'Admin\SettingsController', 'purgeCloudflare');

// Admin - Usuários
$router->get('/admin/users', 'Admin\UserController', 'index');
$router->get('/admin/users/create', 'Admin\UserController', 'create');
$router->post('/admin/users/store', 'Admin\UserController', 'store');
$router->get('/admin/users/{id}/edit', 'Admin\UserController', 'edit');
$router->post('/admin/users/{id}/update', 'Admin\UserController', 'update');
$router->post('/admin/users/{id}/delete', 'Admin\UserController', 'destroy');

// ==========================================
// PÁGINA INICIAL
// ==========================================
$router->get('/', 'HomeController', 'index');

// ==========================================
// PÁGINAS ESTÁTICAS (DEVEM VIR ANTES DAS GENÉRICAS)
// ==========================================
$router->get('/sobre', 'PageController', 'about');
$router->get('/contato', 'PageController', 'contact');
$router->post('/contato', 'PageController', 'sendContact');
$router->get('/politica-de-privacidade', 'PageController', 'privacy');
$router->get('/termos-de-uso', 'PageController', 'terms');
$router->get('/buscar', 'SearchController', 'index');

// ==========================================
// AUTORES
// ==========================================
$router->get('/autor/{slug}', 'AuthorController', 'show');

// ==========================================
// TAGS
// ==========================================
$router->get('/tag/{slug}', 'TagController', 'show');

// ==========================================
// NEWSLETTER
// ==========================================
$router->post('/newsletter', 'NewsletterController', 'subscribe');

// ==========================================
// SITEMAP
// ==========================================
$router->get('/sitemap.xml', 'SitemapController', 'index');
$router->get('/sitemap-pages.xml', 'SitemapController', 'pages');
$router->get('/sitemap-posts.xml', 'SitemapController', 'posts');
$router->get('/sitemap-categories.xml', 'SitemapController', 'categories');

// ==========================================
// API
// ==========================================
$router->get('/api/posts', 'Api\PostController', 'index');
$router->get('/api/posts/{id}', 'Api\PostController', 'show');
$router->get('/api/categories', 'Api\CategoryController', 'index');
$router->post('/api/view', 'PostController', 'registerView');

// ==========================================
// HEALTH CHECK E MÉTRICAS
// ==========================================
$router->get('/api/health', 'HealthController', 'index');
$router->get('/api/ping', 'HealthController', 'ping');
$router->get('/api/metrics', 'HealthController', 'metrics');

// ==========================================
// CATEGORIAS E POSTS (ROTAS GENÉRICAS - DEVEM VIR POR ÚLTIMO)
// ==========================================
// Categoria/Subcategoria + Post
$router->get('/{category}/{slug}', 'CategoryController', 'showSubcategory');

// Categoria simples
$router->get('/{category}', 'CategoryController', 'show');
