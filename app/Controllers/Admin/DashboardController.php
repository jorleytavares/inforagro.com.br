<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Database;
use App\Models\Post;
use App\Models\Category;
use App\Helpers\Csrf;
use App\Helpers\RateLimiter;
use App\Helpers\AuditLog;
use App\Helpers\SessionSecurity;

/**
 * Dashboard Administrativo
 */
class DashboardController extends Controller
{
    /**
     * Hierarquia de roles para controle de acesso
     */
    protected array $roleHierarchy = [
        'author' => 1,
        'editor' => 2,
        'admin' => 3,
    ];

    public function __construct()
    {
        $this->initSession();
        $this->checkAuth();
    }
    
    /**
     * Inicializar sessão com configurações seguras
     */
    private function initSession(): void
    {
        SessionSecurity::init();
        
        // Verificar se sessão expirou
        if (SessionSecurity::checkExpiration()) {
            header('Location: /admin/login?error=' . urlencode('Sessão expirada. Faça login novamente.'));
            exit;
        }
    }
    
    /**
     * Verificar autenticação
     */
    private function checkAuth(): void
    {
        // Se não estiver logado e não for a página de login
        if (!isset($_SESSION['admin_logged_in']) && 
            strpos($_SERVER['REQUEST_URI'], '/admin/login') === false) {
            header('Location: /admin/login');
            exit;
        }
    }
    
    /**
     * Verificar permissão por role
     */
    protected function requireRole(string $requiredRole): void
    {
        $userRole = $_SESSION['admin_role'] ?? 'author';
        $userLevel = $this->roleHierarchy[$userRole] ?? 0;
        $requiredLevel = $this->roleHierarchy[$requiredRole] ?? 999;
        
        if ($userLevel < $requiredLevel) {
            http_response_code(403);
            $this->adminView('errors.403', [
                'pageTitle' => 'Acesso Negado | Admin InforAgro',
                'message' => 'Você não tem permissão para acessar esta funcionalidade.',
            ]);
            exit;
        }
    }
    
    /**
     * Verificar CSRF Token
     */
    protected function verifyCsrf(): void
    {
        if (!Csrf::verify()) {
            header('Location: ' . $_SERVER['HTTP_REFERER'] . '?error=' . urlencode('Token de segurança inválido. Tente novamente.'));
            exit;
        }
    }
    
    /**
     * Dashboard principal
     */
    public function index(): void
    {
        $stats = [
            'total_posts' => 0,
            'published_posts' => 0,
            'draft_posts' => 0,
            'total_categories' => 0,
            'total_views' => 0,
        ];
        
        try {
            $stats['total_posts'] = Database::fetch("SELECT COUNT(*) as total FROM posts")['total'] ?? 0;
            $stats['published_posts'] = Database::fetch("SELECT COUNT(*) as total FROM posts WHERE status = 'published'")['total'] ?? 0;
            $stats['draft_posts'] = Database::fetch("SELECT COUNT(*) as total FROM posts WHERE status = 'draft'")['total'] ?? 0;
            $stats['total_categories'] = Database::fetch("SELECT COUNT(*) as total FROM categories")['total'] ?? 0;
            $stats['total_views'] = Database::fetch("SELECT SUM(views) as total FROM posts")['total'] ?? 0;
        } catch (\Exception $e) {}
        
        // Top Termos
        $topTerms = [];
        try {
            $topTerms = Database::fetchAll("SELECT term, count(*) as count FROM search_logs GROUP BY term ORDER BY count DESC LIMIT 5");
        } catch (\Exception $e) {}
        
        // Termos não encontrados
        $missingTerms = [];
        try {
             $missingTerms = \App\Models\SearchLog::getNotFoundTerms(5);
        } catch (\Exception $e) {}

        // Dados para Gráfico
        $chartData = ['labels' => [], 'data' => []];
        try {
            $period = new \DatePeriod(
                new \DateTime('-6 days'),
                new \DateInterval('P1D'),
                new \DateTime('+1 day')
            );
            
            $days = [];
            foreach ($period as $key => $value) {
                $days[$value->format('Y-m-d')] = 0;
            }
            
            $dbData = Database::fetchAll("
                SELECT DATE(created_at) as date, COUNT(*) as count 
                FROM search_logs 
                WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 6 DAY) 
                GROUP BY DATE(created_at) 
            ");
            
            foreach ($dbData as $row) {
                if(isset($days[$row['date']])) {
                    $days[$row['date']] = $row['count'];
                }
            }
            
            foreach ($days as $date => $count) {
                $chartData['labels'][] = date('d/m', strtotime($date));
                $chartData['data'][] = $count;
            }
        } catch (\Exception $e) {}
        
        // Últimos posts
        $recentPosts = [];
        try {
            $recentPosts = Database::fetchAll(
                "SELECT p.*, c.name as category_name FROM posts p 
                 LEFT JOIN categories c ON p.category_id = c.id 
                 ORDER BY p.created_at DESC LIMIT 5"
            );
        } catch (\Exception $e) {}
        
        // Newsletter Stats
        $stats['newsletter_total'] = 0;
        $recentSubscribers = [];
        try {
            $stats['newsletter_total'] = count(\App\Models\NewsletterSubscriber::getAll());
            $recentSubscribers = \App\Models\NewsletterSubscriber::getRecent(5);
        } catch (\Exception $e) {}
        
        $this->adminView('dashboard.index', [
            'pageTitle' => 'Dashboard | Admin InforAgro',
            'stats' => $stats,
            'recentPosts' => $recentPosts,
            'topTerms' => $topTerms,
            'missingTerms' => $missingTerms,
            'chartData' => $chartData,
            'recentSubscribers' => $recentSubscribers
        ]);
    }
    
    /**
     * Página de login
     */
    public function login(): void
    {
        $this->initSession();
        
        if (isset($_SESSION['admin_logged_in'])) {
            header('Location: /admin');
            exit;
        }
        
        $error = null;
        if (isset($_GET['error'])) {
            $error = $_GET['error'] === '1' 
                ? 'E-mail ou senha incorretos.' 
                : urldecode($_GET['error']);
        }
        
        // Verificar se está bloqueado por rate limiting
        $ip = $_SERVER['REMOTE_ADDR'] ?? '';
        if (RateLimiter::tooManyAttempts($ip)) {
            $waitTime = ceil(RateLimiter::availableIn($ip) / 60);
            $error = "Muitas tentativas de login. Tente novamente em {$waitTime} minuto(s).";
        }
        
        $this->adminView('auth.login', [
            'pageTitle' => 'Login | Admin InforAgro',
            'error' => $error,
            'csrfToken' => Csrf::token(),
        ], false);
    }
    
    /**
     * Processar login
     */
    public function doLogin(): void
    {
        $this->initSession();
        
        // Verificar CSRF
        if (!Csrf::verify()) {
            header('Location: /admin/login?error=' . urlencode('Token de segurança inválido.'));
            exit;
        }
        
        $email = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        $ip = $_SERVER['REMOTE_ADDR'] ?? '';
        $rateLimitKey = $ip . ':' . $email;
        
        // Verificar rate limiting
        if (RateLimiter::tooManyAttempts($rateLimitKey)) {
            $waitTime = ceil(RateLimiter::availableIn($rateLimitKey) / 60);
            header('Location: /admin/login?error=' . urlencode("Muitas tentativas. Aguarde {$waitTime} minuto(s)."));
            exit;
        }
        
        // Validar entrada
        if (empty($email) || empty($password)) {
            RateLimiter::hit($rateLimitKey);
            header('Location: /admin/login?error=1');
            exit;
        }
        
        // Autenticação via Banco de Dados
        try {
            $user = Database::fetch("SELECT * FROM users WHERE email = ? LIMIT 1", [$email]);
            
            if ($user && password_verify($password, $user['password'])) {
                // Regenerar ID da sessão (proteção contra session fixation)
                session_regenerate_id(true);
                
                // Limpar tentativas de login
                RateLimiter::clear($rateLimitKey);
                
                // Regenerar CSRF token
                Csrf::regenerate();
                
                // Definir dados da sessão
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_user_id'] = $user['id'];
                $_SESSION['admin_name'] = $user['name'];
                $_SESSION['admin_username'] = $user['name'];
                $_SESSION['admin_email'] = $user['email'];
                $_SESSION['admin_role'] = $user['role'] ?? 'editor';
                $_SESSION['admin_login_time'] = time();
                
                // Registrar log de auditoria
                AuditLog::login($user['id']);
                
                header('Location: /admin');
                exit;
            }
        } catch (\Exception $e) {
            // Log erro se necessário
        }
        
        // Login falhou - registrar tentativa
        RateLimiter::hit($rateLimitKey);
        
        header('Location: /admin/login?error=1');
        exit;
    }
    
    /**
     * Logout
     */
    public function logout(): void
    {
        $this->initSession();
        
        // Registrar log de auditoria
        AuditLog::logout();
        
        // Destruir sessão completamente
        $_SESSION = [];
        
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        
        session_destroy();
        
        header('Location: /admin/login');
        exit;
    }
    
    /**
     * Renderizar view de admin
     */
    protected function adminView(string $view, array $data = [], bool $useLayout = true): void
    {
        // Adicionar token CSRF automaticamente
        $data['csrfField'] = Csrf::field();
        $data['csrfToken'] = Csrf::token();
        
        extract($data);
        
        $viewPath = ROOT_PATH . '/app/Views/admin/' . str_replace('.', '/', $view) . '.php';
        
        if (!file_exists($viewPath)) {
            throw new \Exception("View não encontrada: {$view}");
        }
        
        ob_start();
        require $viewPath;
        $content = ob_get_clean();
        
        if ($useLayout) {
            $layoutPath = ROOT_PATH . '/app/Views/admin/layouts/main.php';
            if (file_exists($layoutPath)) {
                require $layoutPath;
            } else {
                echo $content;
            }
        } else {
            echo $content;
        }
    }
}
