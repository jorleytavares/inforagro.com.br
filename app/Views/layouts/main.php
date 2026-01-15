<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title><?= htmlspecialchars($pageTitle ?? 'InforAgro - Portal do Agronegócio Brasileiro') ?></title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="<?= htmlspecialchars($pageDescription ?? 'Portal de notícias, análises e referências sobre o agronegócio brasileiro. Agricultura, pecuária, mercado agro, sustentabilidade e mundo pet.') ?>">
    <meta name="keywords" content="<?= htmlspecialchars($pageKeywords ?? 'agronegócio, agricultura, pecuária, agro, notícias agro, mercado agrícola, sustentabilidade, mundo pet, fazenda, produtor rural, commodities, safra, grãos, soja, milho, boi, gado') ?>">
    <meta name="author" content="InforAgro - Portal do Agronegócio">
    <meta name="publisher" content="InforAgro">
    <meta name="robots" content="<?= $robots ?? 'index, follow' ?>">
    <meta name="language" content="pt-BR">
    <meta name="geo.region" content="BR">
    <meta name="geo.placename" content="Brasil">
    <meta name="theme-color" content="#5F7D4E">
    <meta name="msapplication-TileColor" content="#5F7D4E">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="format-detection" content="telephone=no">
    <?php if (!empty($canonical)): ?>
    <link rel="canonical" href="<?= htmlspecialchars($canonical) ?>">
    <?php endif; ?>
    
    <!-- Open Graph -->
    <meta property="og:type" content="<?= $ogType ?? 'website' ?>">
    <meta property="og:site_name" content="InforAgro">
    <meta property="og:title" content="<?= htmlspecialchars($pageTitle ?? 'InforAgro') ?>">
    <meta property="og:description" content="<?= htmlspecialchars($pageDescription ?? '') ?>">
    <meta property="og:url" content="<?= htmlspecialchars($pageUrl ?? 'https://www.inforagro.com.br') ?>">
    <meta property="og:image" content="<?= htmlspecialchars($ogImage ?? '/assets/images/og-default.jpg') ?>">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:locale" content="pt_BR">
    
    <!-- Twitter Cards -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@InforAgro">
    <meta name="twitter:title" content="<?= htmlspecialchars($pageTitle ?? 'InforAgro') ?>">
    <meta name="twitter:description" content="<?= htmlspecialchars($pageDescription ?? '') ?>">
    <meta name="twitter:image" content="<?= htmlspecialchars($ogImage ?? '/assets/images/og-default.jpg') ?>">
    
    <!-- Fontes do Design System -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Atkinson+Hyperlegible:ital,wght@0,400;0,700;1,400&family=Lexend:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- CSS Principal -->
    <link rel="stylesheet" href="/assets/css/style.css">
    
    <!-- Favicon e PWA -->
    <link rel="icon" type="image/svg+xml" href="/assets/images/favicon.svg">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/images/favicon-32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/images/favicon-16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/images/apple-touch-icon.png">
    <link rel="manifest" href="/manifest.json">
    
    <!-- Preload críticos -->
    <link rel="preload" as="style" href="/assets/css/style.css">
    
    <!-- JSON-LD Schemas -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "InforAgro",
        "url": "https://www.inforagro.com.br",
        "logo": "https://www.inforagro.com.br/assets/images/logo.png",
        "description": "Portal de notícias e referências sobre o agronegócio brasileiro",
        "sameAs": []
    }
    </script>
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebSite",
        "name": "InforAgro",
        "url": "https://www.inforagro.com.br",
        "potentialAction": {
            "@type": "SearchAction",
            "target": "https://www.inforagro.com.br/buscar?q={search_term_string}",
            "query-input": "required name=search_term_string"
        }
    }
    </script>
    <?= $additionalSchemas ?? '' ?>

    <!-- Google Analytics 4 -->
    <?php $gaId = \App\Helpers\Settings::get('analytics_id'); ?>
    <?php if ($gaId): ?>
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?= htmlspecialchars($gaId) ?>" data-cfasync="false"></script>
    <script data-cfasync="false">
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', '<?= htmlspecialchars($gaId) ?>');
    </script>
    <?php endif; ?>

    <!-- Google AdSense -->
    <?php $adsenseId = \App\Helpers\Settings::get('adsense_client_id'); ?>
    <?php if ($adsenseId): ?>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=<?= htmlspecialchars($adsenseId) ?>"
     crossorigin="anonymous"></script>
    <?php endif; ?>

    <!-- Custom Head Code -->
    <?= \App\Helpers\Settings::get('custom_head') ?>
</head>
<body>
    <!-- Custom Body Start Code -->
    <?= \App\Helpers\Settings::get('custom_body_start') ?>
    <!-- Skip Link para Acessibilidade -->
    <a href="#main-content" class="skip-link">Pular para o conteúdo principal</a>
    
    <!-- Header -->
    <header class="header" id="header">
        <div class="container">
            <nav class="nav" aria-label="Navegação principal">
                <a href="/" class="logo" aria-label="InforAgro - Página inicial">
                    <span class="logo-icon" aria-hidden="true">🌿</span>
                    <span class="logo-text">InforAgro</span>
                </a>
                
                <?php $globalCategories = \App\Models\Category::getMainCategories() ?? []; ?>
                
                <ul class="nav-menu" id="nav-menu" role="menubar">
                    <?php foreach ($globalCategories as $cat): ?>
                    <li role="none">
                        <a href="/<?= htmlspecialchars($cat['slug']) ?>" class="nav-link" role="menuitem"><?= htmlspecialchars($cat['name']) ?></a>
                    </li>
                    <?php endforeach; ?>
                </ul>
                
                <div class="nav-actions">
                    <button class="btn-search" id="btn-search-toggle" aria-label="Abrir busca" title="Buscar">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <circle cx="11" cy="11" r="8"/>
                            <path d="M21 21l-4.35-4.35"/>
                        </svg>
                    </button>
                    <button class="btn-menu" id="btn-menu" aria-label="Abrir menu" aria-expanded="false" aria-controls="nav-menu">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                </div>
            </nav>
        </div>
    </header>
    
    <!-- Search Dropdown (abaixo do header) -->
    <div class="search-dropdown" id="search-dropdown">
        <div class="container">
            <form class="search-dropdown-form" action="/buscar" method="GET">
                <div class="search-dropdown-wrapper">
                    <span class="search-dropdown-icon">🔍</span>
                    <input type="search" name="q" id="search-dropdown-input" 
                           placeholder="O que você procura? Digite aqui..." 
                           autocomplete="off">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                    <button type="button" class="search-dropdown-close" id="btn-search-close" aria-label="Fechar">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M18 6L6 18M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Breadcrumb -->
    <?php if (!empty($breadcrumbs)): ?>
    <nav class="breadcrumb-nav" aria-label="Breadcrumb">
        <div class="container">
            <ol class="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">
                <?php foreach ($breadcrumbs as $i => $crumb): ?>
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <?php if ($i < count($breadcrumbs) - 1): ?>
                    <a itemprop="item" href="<?= htmlspecialchars($crumb['url']) ?>">
                        <span itemprop="name"><?= htmlspecialchars($crumb['name']) ?></span>
                    </a>
                    <?php else: ?>
                    <span itemprop="name"><?= htmlspecialchars($crumb['name']) ?></span>
                    <?php endif; ?>
                    <meta itemprop="position" content="<?= $i + 1 ?>">
                </li>
                <?php endforeach; ?>
            </ol>
        </div>
    </nav>
    <?php endif; ?>
    
    <!-- Conteúdo Principal -->
    <main id="main-content">
        <?= $content ?>
    </main>
    
    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <a href="/" class="logo">
                        <span class="logo-icon">🌿</span>
                        <span class="logo-text">InforAgro</span>
                    </a>
                    <p class="footer-tagline">Portal de notícias e referências sobre o agronegócio brasileiro.</p>
                    <p class="footer-desc">Agricultura, pecuária, mercado agro, sustentabilidade e mundo pet.</p>
                    
                    <!-- Redes Sociais -->
                    <div class="social-links" style="margin-top: 1rem; display: flex; gap: 10px;">
                        <?php if ($fb = \App\Helpers\Settings::get('facebook_url')): ?>
                        <a href="<?= htmlspecialchars($fb) ?>" target="_blank" rel="noopener" aria-label="Facebook">FB</a>
                        <?php endif; ?>
                        <?php if ($tw = \App\Helpers\Settings::get('twitter_url')): ?>
                        <a href="<?= htmlspecialchars($tw) ?>" target="_blank" rel="noopener" aria-label="Twitter">TW</a>
                        <?php endif; ?>
                        <?php if ($ig = \App\Helpers\Settings::get('instagram_url')): ?>
                        <a href="<?= htmlspecialchars($ig) ?>" target="_blank" rel="noopener" aria-label="Instagram">IG</a>
                        <?php endif; ?>
                        <?php if ($yt = \App\Helpers\Settings::get('youtube_url')): ?>
                        <a href="<?= htmlspecialchars($yt) ?>" target="_blank" rel="noopener" aria-label="YouTube">YT</a>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="footer-links">
                    <h3>Categorias</h3>
                    <ul>
                        <?php if (!empty($globalCategories)): ?>
                            <?php foreach ($globalCategories as $cat): ?>
                            <li><a href="/<?= htmlspecialchars($cat['slug']) ?>"><?= htmlspecialchars($cat['name']) ?></a></li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li><span style="color: rgba(255,255,255,0.5);">Sem categorias</span></li>
                        <?php endif; ?>
                    </ul>
                </div>
                
                <div class="footer-links">
                    <h3>Institucional</h3>
                    <ul>
                        <li><a href="/sobre">Sobre o InforAgro</a></li>
                        <li><a href="/contato">Contato</a></li>
                        <li><a href="/politica-de-privacidade">Política de Privacidade</a></li>
                        <li><a href="/termos-de-uso">Termos de Uso</a></li>
                    </ul>
                </div>
                
                <div class="footer-newsletter">
                    <h3>Newsletter</h3>
                    <p>Receba as últimas notícias do agro no seu e-mail.</p>
                    <form class="newsletter-form" action="/newsletter" method="POST">
                        <input type="email" name="email" placeholder="Seu melhor e-mail" required aria-label="E-mail para newsletter">
                        <button type="submit" class="btn btn-primary">Inscrever</button>
                    </form>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; <?= date('Y') ?> InforAgro. Todos os direitos reservados.</p>
                <p class="footer-legal">CNPJ: XX.XXX.XXX/0001-XX | Desenvolvido no Brasil 🇧🇷</p>
            </div>
        </div>
    </footer>
    
    <!-- Scripts -->
    <script src="/assets/js/main.js" defer></script>
    <?= $additionalScripts ?? '' ?>
    <!-- Custom Footer Code -->
    <?= \App\Helpers\Settings::get('custom_footer') ?>
</body>
</html>
