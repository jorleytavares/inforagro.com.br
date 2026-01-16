<?php

/**
 * Autoloader PSR-4 Simples
 * 
 * Carrega automaticamente as classes baseado no namespace
 */

spl_autoload_register(function ($class) {
    // Prefixo do namespace base
    $prefix = 'App\\';
    
    // Diretório base para o namespace
    $baseDir = ROOT_PATH . '/app/';
    
    // Verificar se a classe usa o prefixo do namespace
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    
    // Obter o nome relativo da classe
    $relativeClass = substr($class, $len);
    
    // Substituir o separador de namespace pelo separador de diretório
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';
    
    // Se o arquivo existir, carregá-lo
    if (file_exists($file)) {
        require $file;
    }
});
