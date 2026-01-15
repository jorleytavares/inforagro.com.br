<?php

namespace App\Controllers\Admin;

/**
 * Controlador de Upload de Mídia
 */
class MediaController extends DashboardController
{
    private array $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    private int $maxSize = 5 * 1024 * 1024; // 5MB
    
    /**
     * Página de mídia
     */
    public function index(): void
    {
        $media = [];
        
        // Listar arquivos do diretório uploads (Recursivo)
        $uploadDir = ROOT_PATH . '/public/uploads';
        if (is_dir($uploadDir)) {
            try {
                $iterator = new \RecursiveIteratorIterator(
                    new \RecursiveDirectoryIterator($uploadDir, \RecursiveDirectoryIterator::SKIP_DOTS),
                    \RecursiveIteratorIterator::SELF_FIRST
                );
                
                foreach ($iterator as $file) {
                    if ($file->isFile()) {
                        $ext = strtolower($file->getExtension());
                        if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                            // URL pública
                            $urlPath = str_replace([ROOT_PATH . '/public', '\\'], ['', '/'], $file->getPathname());
                            
                            // Path relativo para exclusão (ex: 2026-01/imagem.jpg)
                            $deletePath = str_replace([ROOT_PATH . '/public/uploads/', '\\'], ['', '/'], $file->getPathname());
                            $deletePath = ltrim($deletePath, '/');
                            
                            $media[] = [
                                'name' => $file->getFilename(),
                                'url' => $urlPath,
                                'path' => $deletePath, // Caminho para exclusão
                                'size' => $file->getSize(),
                                'date' => date('Y-m-d H:i:s', $file->getMTime()),
                            ];
                        }
                    }
                }
            } catch (\Exception $e) {
                // Erro ao ler diretório (permissão, etc)
            }
        }
        
        // Ordenar por data decrescente
        usort($media, fn($a, $b) => strtotime($b['date']) - strtotime($a['date']));
        
        $this->adminView('media.index', [
            'pageTitle' => 'Mídia | Admin InfoRagro',
            'media' => $media,
            'isPicker' => isset($_GET['picker']),
        ]);
    }
    
    /**
     * Upload de arquivo
     */
    public function upload(): void
    {
        header('Content-Type: application/json');
        
        // Verificar CSRF via header
        $csrfToken = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? $_POST['_csrf'] ?? '';
        if (empty($csrfToken) || !hash_equals($_SESSION['csrf_token'] ?? '', $csrfToken)) {
            echo json_encode(['success' => false, 'error' => 'Token de segurança inválido']);
            return;
        }
        
        if (!isset($_FILES['file'])) {
            echo json_encode(['success' => false, 'error' => 'Nenhum arquivo enviado']);
            return;
        }
        
        $file = $_FILES['file'];
        
        // Validar tipo
        if (!in_array($file['type'], $this->allowedTypes)) {
            echo json_encode(['success' => false, 'error' => 'Tipo de arquivo não permitido']);
            return;
        }
        
        // Validar tamanho
        if ($file['size'] > $this->maxSize) {
            echo json_encode(['success' => false, 'error' => 'Arquivo muito grande (máx 5MB)']);
            return;
        }
        
        // Gerar nome único
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = date('Y-m') . '/' . uniqid() . '-' . $this->slugify(pathinfo($file['name'], PATHINFO_FILENAME)) . '.' . $extension;
        
        // Criar diretório se não existir
        $uploadDir = ROOT_PATH . '/public/uploads/' . date('Y-m');
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $destination = ROOT_PATH . '/public/uploads/' . $filename;
        
        if (move_uploaded_file($file['tmp_name'], $destination)) {
            // Otimizar imagem se for JPEG ou PNG
            $this->optimizeImage($destination, $file['type']);
            
            echo json_encode([
                'success' => true,
                'url' => '/uploads/' . $filename,
                'filename' => basename($filename),
            ]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Erro ao salvar arquivo']);
        }
    }
    
    /**
     * Upload via TinyMCE
     */
    public function tinymceUpload(): void
    {
        header('Content-Type: application/json');
        
        // TinyMCE envia JWT no header Authorization
        // Verificar se usuário está logado
        if (!isset($_SESSION['admin_logged_in'])) {
            echo json_encode(['error' => ['message' => 'Não autorizado']]);
            return;
        }
        
        if (!isset($_FILES['file'])) {
            echo json_encode(['error' => ['message' => 'Nenhum arquivo enviado']]);
            return;
        }
        
        $file = $_FILES['file'];
        
        if (!in_array($file['type'], $this->allowedTypes)) {
            echo json_encode(['error' => ['message' => 'Tipo não permitido']]);
            return;
        }
        
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = date('Y-m') . '/' . uniqid() . '.' . $extension;
        
        $uploadDir = ROOT_PATH . '/public/uploads/' . date('Y-m');
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $destination = ROOT_PATH . '/public/uploads/' . $filename;
        
        if (move_uploaded_file($file['tmp_name'], $destination)) {
            echo json_encode(['location' => '/uploads/' . $filename]);
        } else {
            echo json_encode(['error' => ['message' => 'Erro ao salvar']]);
        }
    }
    
    /**
     * Deletar arquivo
     */
    public function delete(): void
    {
        $this->verifyCsrf();
        
        $filename = $_POST['filename'] ?? '';
        
        if (empty($filename)) {
            header('Location: /admin/media?error=nofile');
            exit;
        }
        
        // Proteção contra path traversal
        $filename = basename(str_replace(['..', '\\'], '', $filename));
        if (strpos($_POST['filename'] ?? '', '/') !== false) {
            // Permite subdiretórios como 2026-01/file.jpg
            $parts = explode('/', $_POST['filename']);
            $safeParts = array_map(fn($p) => basename(str_replace(['..', '\\'], '', $p)), $parts);
            $filename = implode('/', $safeParts);
        }
        
        $filepath = ROOT_PATH . '/public/uploads/' . $filename;
        
        // Verificar se está dentro do diretório de uploads (double check)
        $realUploadDir = realpath(ROOT_PATH . '/public/uploads');
        $realFilePath = realpath($filepath);
        
        if ($realFilePath && strpos($realFilePath, $realUploadDir) === 0 && is_file($realFilePath)) {
            unlink($realFilePath);
            \App\Helpers\AuditLog::log('delete_media', 'media', null, ['filename' => $filename]);
            header('Location: /admin/media?success=deleted');
        } else {
            header('Location: /admin/media?error=notfound');
        }
        exit;
    }
    
    /**
     * Otimizar imagem
     */
    private function optimizeImage(string $path, string $type): void
    {
        if (!extension_loaded('gd')) return;
        
        $image = null;
        
        switch ($type) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($path);
                if ($image) {
                    imagejpeg($image, $path, 85);
                }
                break;
            case 'image/png':
                $image = imagecreatefrompng($path);
                if ($image) {
                    imagepng($image, $path, 8);
                }
                break;
        }
        
        if ($image) {
            imagedestroy($image);
        }
    }
    
    /**
     * Gerar slug seguro para nome de arquivo
     */
    private function slugify(string $text): string
    {
        $text = mb_strtolower($text);
        $text = preg_replace('/[áàãâä]/u', 'a', $text);
        $text = preg_replace('/[éèêë]/u', 'e', $text);
        $text = preg_replace('/[íìîï]/u', 'i', $text);
        $text = preg_replace('/[óòõôö]/u', 'o', $text);
        $text = preg_replace('/[úùûü]/u', 'u', $text);
        $text = preg_replace('/[ç]/u', 'c', $text);
        $text = preg_replace('/[^a-z0-9]+/', '-', $text);
        return trim($text, '-');
    }
}
