<?php

/**
 * Configurações de Produção - cPanel Napoleon
 * 
 * ATENÇÃO: Este arquivo contém credenciais sensíveis.
 * NÃO comitar no Git - adicionar ao .gitignore
 */

// =====================================================
// BANCO DE DADOS
// =====================================================
define('DB_HOST', 'localhost');
define('DB_NAME', 'curr6441_inforagro01');
define('DB_USER', 'curr6441_hostinfor01');
define('DB_PASS', 'BYY3*)D,77E$yZ#f');
define('DB_CHARSET', 'utf8mb4');

// =====================================================
// APLICAÇÃO
// =====================================================
define('APP_ENV', 'production');
define('APP_DEBUG', false);
define('APP_URL', 'https://inforagro.com.br');

// =====================================================
// SEGURANÇA
// =====================================================
define('SESSION_LIFETIME', 1800); // 30 minutos
define('CSRF_ENABLED', true);

// =====================================================
// E-MAIL (SMTP)
// =====================================================
define('MAIL_HOST', 'mail.inforagro.com.br');
define('MAIL_PORT', 587);
define('MAIL_USERNAME', ''); // Configurar depois
define('MAIL_PASSWORD', ''); // Configurar depois
define('MAIL_FROM', 'contato@inforagro.com.br');
define('MAIL_FROM_NAME', 'InforAgro');

// =====================================================
// PATHS
// =====================================================
define('ROOT_PATH', dirname(__DIR__));
define('APP_PATH', ROOT_PATH . '/app');
define('PUBLIC_PATH', ROOT_PATH . '/public');
define('STORAGE_PATH', ROOT_PATH . '/storage');
define('CACHE_PATH', STORAGE_PATH . '/cache');
define('LOGS_PATH', STORAGE_PATH . '/logs');
