<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;

/**
 * Controller de Health Check e Métricas
 * Endpoint: /api/health
 */
class HealthController extends Controller
{
    /**
     * Health check completo
     */
    public function index(): void
    {
        header('Content-Type: application/json');
        header('Cache-Control: no-cache, no-store, must-revalidate');
        
        $checks = [
            'status' => 'healthy',
            'timestamp' => date('c'),
            'version' => '1.0.0',
            'checks' => [],
        ];
        
        // Check Database
        $checks['checks']['database'] = $this->checkDatabase();
        
        // Check Disk Space
        $checks['checks']['disk'] = $this->checkDiskSpace();
        
        // Check Cache Directory
        $checks['checks']['cache'] = $this->checkCacheDirectory();
        
        // Check Uploads Directory
        $checks['checks']['uploads'] = $this->checkUploadsDirectory();
        
        // Determinar status geral
        foreach ($checks['checks'] as $check) {
            if ($check['status'] !== 'ok') {
                $checks['status'] = 'degraded';
                break;
            }
        }
        
        $httpCode = $checks['status'] === 'healthy' ? 200 : 503;
        http_response_code($httpCode);
        
        echo json_encode($checks, JSON_PRETTY_PRINT);
    }
    
    /**
     * Health check simples (para load balancer)
     */
    public function ping(): void
    {
        header('Content-Type: text/plain');
        echo 'pong';
    }
    
    /**
     * Métricas do sistema
     */
    public function metrics(): void
    {
        header('Content-Type: application/json');
        
        // Verificar autenticação (apenas admin pode ver métricas)
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['admin_logged_in'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            return;
        }
        
        try {
            $metrics = [
                'timestamp' => date('c'),
                'posts' => [
                    'total' => Database::fetch("SELECT COUNT(*) as c FROM posts")['c'] ?? 0,
                    'published' => Database::fetch("SELECT COUNT(*) as c FROM posts WHERE status='published'")['c'] ?? 0,
                    'draft' => Database::fetch("SELECT COUNT(*) as c FROM posts WHERE status='draft'")['c'] ?? 0,
                ],
                'categories' => Database::fetch("SELECT COUNT(*) as c FROM categories")['c'] ?? 0,
                'users' => Database::fetch("SELECT COUNT(*) as c FROM users")['c'] ?? 0,
                'authors' => Database::fetch("SELECT COUNT(*) as c FROM authors")['c'] ?? 0,
                'searches' => [
                    'today' => Database::fetch("SELECT COUNT(*) as c FROM search_logs WHERE DATE(created_at) = CURDATE()")['c'] ?? 0,
                    'week' => Database::fetch("SELECT COUNT(*) as c FROM search_logs WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)")['c'] ?? 0,
                ],
                'views' => [
                    'total' => Database::fetch("SELECT SUM(views) as v FROM posts")['v'] ?? 0,
                ],
                'storage' => [
                    'uploads_size' => $this->getDirectorySize(ROOT_PATH . '/public/uploads'),
                    'cache_size' => $this->getDirectorySize(ROOT_PATH . '/storage/cache'),
                ],
            ];
            
            echo json_encode($metrics, JSON_PRETTY_PRINT);
            
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to fetch metrics']);
        }
    }
    
    /**
     * Verificar conexão com banco
     */
    private function checkDatabase(): array
    {
        try {
            $result = Database::fetch("SELECT 1 as check_value");
            return [
                'status' => 'ok',
                'message' => 'Database connection successful',
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Database connection failed',
            ];
        }
    }
    
    /**
     * Verificar espaço em disco
     */
    private function checkDiskSpace(): array
    {
        $freeSpace = disk_free_space(ROOT_PATH);
        $totalSpace = disk_total_space(ROOT_PATH);
        $usedPercent = round((1 - ($freeSpace / $totalSpace)) * 100, 2);
        
        $status = 'ok';
        if ($usedPercent > 90) {
            $status = 'warning';
        }
        if ($usedPercent > 95) {
            $status = 'error';
        }
        
        return [
            'status' => $status,
            'free_gb' => round($freeSpace / 1024 / 1024 / 1024, 2),
            'used_percent' => $usedPercent,
        ];
    }
    
    /**
     * Verificar diretório de cache
     */
    private function checkCacheDirectory(): array
    {
        $cacheDir = ROOT_PATH . '/storage/cache';
        
        if (!is_dir($cacheDir)) {
            return [
                'status' => 'warning',
                'message' => 'Cache directory does not exist',
            ];
        }
        
        if (!is_writable($cacheDir)) {
            return [
                'status' => 'error',
                'message' => 'Cache directory is not writable',
            ];
        }
        
        return [
            'status' => 'ok',
            'writable' => true,
        ];
    }
    
    /**
     * Verificar diretório de uploads
     */
    private function checkUploadsDirectory(): array
    {
        $uploadsDir = ROOT_PATH . '/public/uploads';
        
        if (!is_dir($uploadsDir)) {
            return [
                'status' => 'error',
                'message' => 'Uploads directory does not exist',
            ];
        }
        
        if (!is_writable($uploadsDir)) {
            return [
                'status' => 'error',
                'message' => 'Uploads directory is not writable',
            ];
        }
        
        return [
            'status' => 'ok',
            'writable' => true,
        ];
    }
    
    /**
     * Calcular tamanho de diretório
     */
    private function getDirectorySize(string $path): string
    {
        if (!is_dir($path)) {
            return '0 MB';
        }
        
        $size = 0;
        
        try {
            foreach (new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path, \RecursiveDirectoryIterator::SKIP_DOTS)) as $file) {
                $size += $file->getSize();
            }
        } catch (\Exception $e) {
            return 'N/A';
        }
        
        return round($size / 1024 / 1024, 2) . ' MB';
    }
}
