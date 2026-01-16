<?php

namespace App\Helpers;

/**
 * SEO Helper
 * 
 * Gera meta tags, Open Graph, Twitter Cards e Structured Data
 */
class SeoHelper
{
    private static string $siteName = 'InfoRagro';
    private static string $siteUrl = 'https://www.inforagro.com.br';
    private static string $defaultImage = '/assets/images/og-default.jpg';
    private static string $twitterHandle = '@InfoRagro';
    
    /**
     * Gerar meta tags básicas
     */
    public static function metaTags(array $data): string
    {
        $title = $data['title'] ?? self::$siteName;
        $description = $data['description'] ?? '';
        $canonical = $data['canonical'] ?? '';
        $robots = $data['robots'] ?? 'index, follow';
        
        $html = '';
        
        // Meta básicas
        $html .= '<meta name="description" content="' . self::escape($description) . '">' . "\n";
        $html .= '<meta name="robots" content="' . $robots . '">' . "\n";
        
        if ($canonical) {
            $html .= '<link rel="canonical" href="' . self::escape($canonical) . '">' . "\n";
        }
        
        // Idioma
        $html .= '<meta name="language" content="pt-BR">' . "\n";
        $html .= '<meta name="geo.region" content="BR">' . "\n";
        
        return $html;
    }
    
    /**
     * Gerar Open Graph tags
     */
    public static function openGraph(array $data): string
    {
        $title = $data['title'] ?? self::$siteName;
        $description = $data['description'] ?? '';
        $url = $data['url'] ?? self::$siteUrl;
        $image = $data['image'] ?? self::$siteUrl . self::$defaultImage;
        $type = $data['type'] ?? 'website';
        
        $html = '';
        $html .= '<meta property="og:type" content="' . $type . '">' . "\n";
        $html .= '<meta property="og:site_name" content="' . self::$siteName . '">' . "\n";
        $html .= '<meta property="og:title" content="' . self::escape($title) . '">' . "\n";
        $html .= '<meta property="og:description" content="' . self::escape($description) . '">' . "\n";
        $html .= '<meta property="og:url" content="' . self::escape($url) . '">' . "\n";
        $html .= '<meta property="og:image" content="' . self::escape($image) . '">' . "\n";
        $html .= '<meta property="og:image:width" content="1200">' . "\n";
        $html .= '<meta property="og:image:height" content="630">' . "\n";
        $html .= '<meta property="og:locale" content="pt_BR">' . "\n";
        
        // Específico para artigos
        if ($type === 'article' && isset($data['published_at'])) {
            $html .= '<meta property="article:published_time" content="' . $data['published_at'] . '">' . "\n";
            if (isset($data['updated_at'])) {
                $html .= '<meta property="article:modified_time" content="' . $data['updated_at'] . '">' . "\n";
            }
            if (isset($data['author'])) {
                $html .= '<meta property="article:author" content="' . self::escape($data['author']) . '">' . "\n";
            }
            if (isset($data['category'])) {
                $html .= '<meta property="article:section" content="' . self::escape($data['category']) . '">' . "\n";
            }
        }
        
        return $html;
    }
    
    /**
     * Gerar Twitter Cards
     */
    public static function twitterCards(array $data): string
    {
        $title = $data['title'] ?? self::$siteName;
        $description = $data['description'] ?? '';
        $image = $data['image'] ?? self::$siteUrl . self::$defaultImage;
        
        $html = '';
        $html .= '<meta name="twitter:card" content="summary_large_image">' . "\n";
        $html .= '<meta name="twitter:site" content="' . self::$twitterHandle . '">' . "\n";
        $html .= '<meta name="twitter:title" content="' . self::escape($title) . '">' . "\n";
        $html .= '<meta name="twitter:description" content="' . self::escape($description) . '">' . "\n";
        $html .= '<meta name="twitter:image" content="' . self::escape($image) . '">' . "\n";
        
        return $html;
    }
    
    /**
     * Schema JSON-LD: Organization
     */
    public static function organizationSchema(): string
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => 'InfoRagro',
            'url' => self::$siteUrl,
            'logo' => self::$siteUrl . '/assets/images/logo.png',
            'description' => 'Portal de notícias e referências sobre o agronegócio brasileiro',
            'foundingDate' => '2026',
            'address' => [
                '@type' => 'PostalAddress',
                'addressCountry' => 'BR'
            ],
            'sameAs' => []
        ];
        
        return self::schemaScript($schema);
    }
    
    /**
     * Schema JSON-LD: WebSite
     */
    public static function websiteSchema(): string
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => 'InfoRagro',
            'url' => self::$siteUrl,
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => self::$siteUrl . '/buscar?q={search_term_string}',
                'query-input' => 'required name=search_term_string'
            ]
        ];
        
        return self::schemaScript($schema);
    }
    
    /**
     * Schema JSON-LD: NewsArticle
     */
    public static function articleSchema(array $article): string
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'NewsArticle',
            'headline' => $article['title'],
            'description' => $article['excerpt'] ?? '',
            'image' => $article['image'] ?? self::$siteUrl . self::$defaultImage,
            'datePublished' => $article['published_at'] ?? date('c'),
            'dateModified' => $article['updated_at'] ?? date('c'),
            'author' => [
                '@type' => 'Person',
                'name' => $article['author_name'] ?? 'Equipe InfoRagro',
                'url' => self::$siteUrl . '/autor/' . ($article['author_slug'] ?? 'equipe-InfoRagro')
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => 'InfoRagro',
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => self::$siteUrl . '/assets/images/logo.png'
                ]
            ],
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => $article['url'] ?? self::$siteUrl
            ],
            'wordCount' => $article['word_count'] ?? 0,
            'articleSection' => $article['category'] ?? ''
        ];
        
        return self::schemaScript($schema);
    }
    
    /**
     * Schema JSON-LD: BreadcrumbList
     */
    public static function breadcrumbSchema(array $items): string
    {
        $listItems = [];
        foreach ($items as $position => $item) {
            $listItems[] = [
                '@type' => 'ListItem',
                'position' => $position + 1,
                'name' => $item['name'],
                'item' => $item['url']
            ];
        }
        
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $listItems
        ];
        
        return self::schemaScript($schema);
    }
    
    /**
     * Schema JSON-LD: FAQPage
     */
    public static function faqSchema(array $faqs): string
    {
        $questions = [];
        foreach ($faqs as $faq) {
            $questions[] = [
                '@type' => 'Question',
                'name' => $faq['question'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $faq['answer']
                ]
            ];
        }
        
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => $questions
        ];
        
        return self::schemaScript($schema);
    }
    
    /**
     * Gerar script tag com schema
     */
    private static function schemaScript(array $schema): string
    {
        return '<script type="application/ld+json">' . 
               json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . 
               '</script>' . "\n";
    }
    
    /**
     * Escapar HTML
     */
    private static function escape(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
    
    /**
     * Gerar título SEO
     */
    public static function title(string $pageTitle, bool $includeSiteName = true): string
    {
        if ($includeSiteName && $pageTitle !== self::$siteName) {
            return $pageTitle . ' | ' . self::$siteName;
        }
        return $pageTitle;
    }
    
    /**
     * Limitar descrição para SEO
     */
    public static function limitDescription(string $text, int $maxLength = 160): string
    {
        $text = strip_tags($text);
        $text = preg_replace('/\s+/', ' ', $text);
        $text = trim($text);
        
        if (mb_strlen($text) <= $maxLength) {
            return $text;
        }
        
        return mb_substr($text, 0, $maxLength - 3) . '...';
    }
}
