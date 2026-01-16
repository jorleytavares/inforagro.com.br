<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdnjs.cloudflare.com; style-src 'self' 'unsafe-inline' https://cdnjs.cloudflare.com https://fonts.googleapis.com; font-src 'self' https://fonts.gstatic.com; img-src 'self' data: https:; connect-src 'self';">
    <title><?= htmlspecialchars($pageTitle ?? 'Admin | InforAgro') ?></title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Favicon & App Icons -->
    <link rel="icon" type="image/png" href="/assets/images/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="/assets/images/favicon.svg" />
    <link rel="shortcut icon" href="/assets/images/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/images/apple-touch-icon.png" />
    <meta name="apple-mobile-web-app-title" content="InforAgro" />
    <link rel="manifest" href="/assets/images/site.webmanifest" />
    <meta name="theme-color" content="#ffffff">
    
    <style>
        :root {
            --admin-primary: #5F7D4E;
            --admin-primary-hover: #4a633d;
            --admin-secondary: #64748b;
            
            --glass-bg: rgba(255, 255, 255, 0.75);
            --glass-border: 1px solid rgba(255, 255, 255, 0.6);
            --glass-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.05);
            --glass-blur: blur(12px);
            
            --admin-text: #334155;
            --admin-text-muted: #64748b;
            --admin-danger: #ef4444;
            --sidebar-width: 270px;
        }
        
        * { box-sizing: border-box; margin: 0; padding: 0; }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f2f5;
            background-image: 
                radial-gradient(at 0% 0%, hsla(108, 47%, 95%, 1) 0px, transparent 50%),
                radial-gradient(at 50% 100%, hsla(192, 63%, 94%, 1) 0px, transparent 50%),
                radial-gradient(at 80% 0%, hsla(38, 100%, 96%, 1) 0px, transparent 50%);
            background-attachment: fixed;
            color: var(--admin-text);
            min-height: 100vh;
        }
        
        .admin-layout {
            display: flex;
            min-height: 100vh;
        }
        
        /* Glass Components */
        .glass-panel {
            background: var(--glass-bg);
            backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
            border: var(--glass-border);
            box-shadow: var(--glass-shadow);
        }
        
        /* Sidebar */
        .admin-sidebar {
            width: var(--sidebar-width);
            background: rgba(255, 255, 255, 0.85); /* Mais opaco para contraste */
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255, 255, 255, 0.5);
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 100;
        }
        
        .sidebar-header {
            padding: 2rem 1.5rem;
            display: flex;
            align-items: center;
        }
        
        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            color: #1e293b;
            font-weight: 800;
            font-size: 1.5rem;
            letter-spacing: -0.5px;
        }
        
        .sidebar-nav { padding: 1rem 0; }
        
        .nav-section { padding: 1rem 1.5rem 0.5rem; }
        .nav-section-title {
            font-size: 0.75rem;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.5rem;
        }
        
        .nav-link {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.85rem 1.5rem;
            color: #475569;
            text-decoration: none;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            border-left: 3px solid transparent;
            font-weight: 500;
        }
        .nav-link:hover {
            background: rgba(255, 255, 255, 0.6);
            color: var(--admin-primary);
        }
        .nav-link.active {
            background: linear-gradient(90deg, rgba(95, 125, 78, 0.15) 0%, rgba(95, 125, 78, 0) 100%);
            color: var(--admin-primary);
            border-left-color: var(--admin-primary);
        }
        .nav-link-icon { font-size: 1.1rem; width: 24px; text-align: center; }
        
        /* Main Content */
        .admin-main {
            flex: 1;
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        .admin-header {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.4);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 50;
        }
        
        .header-title { font-size: 1.35rem; font-weight: 700; color: #1e293b; letter-spacing: -0.5px; }
        
        .header-user {
            background: rgba(255, 255, 255, 0.5);
            padding: 0.5rem 1rem;
            border-radius: 99px;
            border: 1px solid rgba(255, 255, 255, 0.5);
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .btn-logout {
            background: #fff;
            border: 1px solid #e2e8f0;
            padding: 0.4rem 1rem;
            border-radius: 20px;
            cursor: pointer;
            font-size: 0.8rem;
            color: var(--admin-text-muted);
            font-weight: 600;
            transition: all 0.2s;
        }
        .btn-logout:hover {
            background: #ffe4e6;
            color: #ef4444;
            border-color: #fecaca;
        }
        
        .admin-content { padding: 2.5rem; }
        
        /* Cards */
        .card {
            background: rgba(255, 255, 255, 0.85); /* Glassy White */
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.8);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
            overflow: hidden;
            margin-bottom: 1.5rem;
        }
        
        .card-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(255, 255, 255, 0.4);
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        .card-title { font-weight: 700; color: #0f172a; }
        
        /* Tables */
        .table { width: 100%; border-collapse: separate; border-spacing: 0; }
        
        .table th {
            padding: 1rem 1.5rem;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            color: #64748b;
            background: rgba(248, 250, 252, 0.5);
            border-bottom: 1px solid rgba(0,0,0,0.05);
            text-align: left;
        }
        
        .table td {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid rgba(0,0,0,0.03);
            color: #334155;
            vertical-align: middle;
        }
        
        .table tr:last-child td { border-bottom: none; }
        .table tr:hover td { background: rgba(255, 255, 255, 0.6); }
        
        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.625rem 1.25rem;
            border-radius: 12px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            border: none;
            transition: all 0.2s;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        }
        
        .btn-primary {
            background: var(--admin-primary);
            color: white;
            box-shadow: 0 4px 12px rgba(95, 125, 78, 0.3);
        }
        .btn-primary:hover {
            background: var(--admin-primary-hover);
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(95, 125, 78, 0.4);
        }
        
        .btn-secondary {
            background: #fff;
            color: #475569;
            border: 1px solid #e2e8f0;
        }
        .btn-secondary:hover { background: #f8fafc; border-color: #cbd5e1; }
        
        .btn-danger { background: #ef4444; color: white; }
        .btn-danger:hover { background: #dc2626; }
        
        .btn-sm { padding: 0.4rem 0.8rem; font-size: 0.8rem; border-radius: 8px; }
        
        /* Form Controls */
        .form-group { margin-bottom: 1.5rem; }
        .form-label { display: block; font-size: 0.9rem; font-weight: 600; margin-bottom: 0.5rem; color: #1e293b; }
        
        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            background: rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(203, 213, 225, 0.6);
            border-radius: 10px;
            font-size: 1rem;
            font-family: inherit;
            color: #0f172a;
            transition: all 0.2s;
        }
        .form-control:focus {
            outline: none;
            background: #fff;
            border-color: var(--admin-primary);
            box-shadow: 0 0 0 4px rgba(95, 125, 78, 0.1);
        }
        
        textarea.form-control { min-height: 120px; }
        
        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        .stat-card {
            background: rgba(255, 255, 255, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 16px;
            padding: 1.5rem;
            backdrop-filter: blur(10px);
        }
        .stat-value { font-size: 2.5rem; font-weight: 800; color: var(--admin-primary); letter-spacing: -1px; }
        .stat-label { color: #64748b; font-weight: 500; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.5px; }

        .alert { padding: 1rem; border-radius: 12px; margin-bottom: 1rem; font-weight: 500;}
        .alert-success { background: rgba(220, 252, 231, 0.8); color: #14532d; border: 1px solid #bbf7d0; }
        .alert-error { background: rgba(254, 226, 226, 0.8); color: #7f1d1d; border: 1px solid #fecaca; }

        .empty-state {
            padding: 4rem 2rem;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: var(--admin-text-muted);
        }

        @media (max-width: 768px) {
            .admin-sidebar { display: none; }
            .admin-main { margin-left: 0; }
        }
    </style>
</head>
<body>
    <div class="admin-layout">
        <!-- Sidebar -->
        <?php if(empty($isPicker)): ?>
        <aside class="admin-sidebar">
            <div class="sidebar-header">
                <a href="/admin" class="sidebar-logo">
                    <span>🌿</span>
                    <span>InforAgro</span>
                </a>
            </div>
            
            <nav class="sidebar-nav">
                <div class="nav-section">
                    <div class="nav-section-title">Principal</div>
                </div>
                <a href="/admin" class="nav-link <?= $_SERVER['REQUEST_URI'] === '/admin' ? 'active' : '' ?>">
                    <span class="nav-link-icon">📊</span>
                    Dashboard
                </a>
                
                <div class="nav-section">
                    <div class="nav-section-title">Conteúdo</div>
                </div>
                <a href="/admin/posts" class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/admin/posts') !== false ? 'active' : '' ?>">
                    <span class="nav-link-icon">📝</span>
                    Posts
                </a>
                <a href="/admin/categories" class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/admin/categories') !== false ? 'active' : '' ?>">
                    <span class="nav-link-icon">📁</span>
                    Categorias
                </a>
                <a href="/admin/tags" class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/admin/tags') !== false ? 'active' : '' ?>">
                    <span class="nav-link-icon">🏷️</span>
                    Tags
                </a>
                <a href="/admin/authors" class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/admin/authors') !== false ? 'active' : '' ?>">
                    <span class="nav-link-icon">👤</span>
                    Autores
                </a>
                <a href="/admin/media" class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/admin/media') !== false ? 'active' : '' ?>">
                    <span class="nav-link-icon">🖼️</span>
                    Mídia
                </a>
                <a href="/admin/search-terms" class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/admin/search-terms') !== false ? 'active' : '' ?>">
                    <span class="nav-link-icon">🔍</span>
                    Monitor de Buscas
                </a>
                <a href="/admin/newsletter" class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/admin/newsletter') !== false ? 'active' : '' ?>">
                    <span class="nav-link-icon">📧</span>
                    Newsletter
                </a>
                
                <div class="nav-section">
                    <div class="nav-section-title">Sistema</div>
                </div>
                <a href="/admin/settings" class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/admin/settings') !== false ? 'active' : '' ?>">
                    <span class="nav-link-icon">⚙️</span>
                    Configurações
                </a>
                <a href="/admin/users" class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/admin/users') !== false ? 'active' : '' ?>">
                    <span class="nav-link-icon">👥</span>
                    Usuários
                </a>
                <a href="/" class="nav-link" target="_blank">
                    <span class="nav-link-icon">🌐</span>
                    Ver Site
                </a>
                <a href="/admin/logout" class="nav-link">
                    <span class="nav-link-icon">🚪</span>
                    Sair
                </a>
            </nav>
        </aside>
        <?php endif; ?>
        
        <!-- Main Content -->
        <main class="admin-main" style="<?= !empty($isPicker) ? 'margin-left:0' : '' ?>">
            <?php if(empty($isPicker)): ?>
            <header class="admin-header">
                <h1 class="header-title"><?= $pageTitle ?? 'Dashboard' ?></h1>
                <div class="header-user">
                    <span>Olá, <?= htmlspecialchars($_SESSION['admin_username'] ?? 'Admin') ?></span>
                    <a href="/admin/logout" class="btn-logout">Sair</a>
                </div>
            </header>
            <?php endif; ?>
            
            <div class="admin-content">
                <?= $content ?>
            </div>
        </main>
    </div>
</body>
</html>
