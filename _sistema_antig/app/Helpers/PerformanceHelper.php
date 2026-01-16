<?php

namespace App\Helpers;

/**
 * Helper de Performance e Otimização
 */
class PerformanceHelper
{
    /**
     * Gerar tag de imagem com lazy loading e srcset
     */
    public static function lazyImage(
        string $src, 
        string $alt, 
        array $options = []
    ): string {
        $width = $options['width'] ?? '';
        $height = $options['height'] ?? '';
        $class = $options['class'] ?? '';
        $loading = $options['loading'] ?? 'lazy';
        $decoding = $options['decoding'] ?? 'async';
        
        $attrs = [
            'src' => htmlspecialchars($src),
            'alt' => htmlspecialchars($alt),
            'loading' => $loading,
            'decoding' => $decoding,
        ];
        
        if ($width) $attrs['width'] = $width;
        if ($height) $attrs['height'] = $height;
        if ($class) $attrs['class'] = $class;
        
        // Adicionar srcset para imagens responsivas se for local
        if (strpos($src, '/uploads/') !== false) {
            $attrs['srcset'] = self::generateSrcset($src);
        }
        
        $attrString = '';
        foreach ($attrs as $key => $value) {
            if ($value) {
                $attrString .= " {$key}=\"{$value}\"";
            }
        }
        
        return "<img{$attrString}>";
    }
    
    /**
     * Gerar srcset para imagens responsivas
     */
    private static function generateSrcset(string $src): string
    {
        // Por enquanto, retorna apenas a imagem original
        // Em produção, poderia gerar múltiplos tamanhos
        return htmlspecialchars($src);
    }
    
    /**
     * Gerar link preload para recurso crítico
     */
    public static function preload(string $href, string $as, array $options = []): string
    {
        $type = $options['type'] ?? '';
        $crossorigin = $options['crossorigin'] ?? false;
        
        $attrs = "href=\"" . htmlspecialchars($href) . "\" as=\"{$as}\"";
        if ($type) $attrs .= " type=\"{$type}\"";
        if ($crossorigin) $attrs .= " crossorigin";
        
        return "<link rel=\"preload\" {$attrs}>";
    }
    
    /**
     * Gerar script defer/async
     */
    public static function script(string $src, array $options = []): string
    {
        $defer = $options['defer'] ?? true;
        $async = $options['async'] ?? false;
        $module = $options['module'] ?? false;
        
        $attrs = 'src="' . htmlspecialchars($src) . '"';
        if ($defer) $attrs .= ' defer';
        if ($async) $attrs .= ' async';
        if ($module) $attrs .= ' type="module"';
        
        return "<script {$attrs}></script>";
    }
    
    /**
     * Gerar breadcrumb Schema.org JSON-LD
     */
    public static function breadcrumbSchema(array $items): string
    {
        $listItems = [];
        foreach ($items as $index => $item) {
            $listItems[] = [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'name' => $item['name'],
                'item' => $item['url'] ?? null,
            ];
        }
        
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $listItems,
        ];
        
        return '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>';
    }
    
    /**
     * Gerar Article Schema.org JSON-LD
     */
    public static function articleSchema(array $post): string
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $post['title'] ?? '',
            'description' => $post['excerpt'] ?? '',
            'image' => $post['featured_image'] ?? '',
            'datePublished' => $post['published_at'] ?? '',
            'dateModified' => $post['updated_at'] ?? $post['published_at'] ?? '',
            'author' => [
                '@type' => 'Person',
                'name' => $post['author_name'] ?? 'InforAgro',
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => 'InforAgro',
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => 'https://www.inforagro.com.br/assets/images/logo.png',
                ],
            ],
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => 'https://www.inforagro.com.br/' . ($post['category_slug'] ?? '') . '/' . ($post['slug'] ?? ''),
            ],
        ];
        
        return '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>';
    }
    
    /**
     * Gerar FAQ Schema.org JSON-LD
     */
    public static function faqSchema(array $faqs): string
    {
        $items = [];
        foreach ($faqs as $faq) {
            $items[] = [
                '@type' => 'Question',
                'name' => $faq['question'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $faq['answer'],
                ],
            ];
        }
        
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => $items,
        ];
        
        return '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>';
    }
    
    /**
     * Calcular tempo de leitura estimado
     */
    public static function readingTime(string $content): int
    {
        $wordCount = str_word_count(strip_tags($content));
        $readingSpeed = 200; // palavras por minuto
        
        return max(1, ceil($wordCount / $readingSpeed));
    }
    
    /**
     * Gerar meta tags para página de categoria
     */
    public static function categoryMeta(array $category): array
    {
        return [
            'title' => ($category['meta_title'] ?? $category['name']) . ' | InforAgro',
            'description' => $category['meta_description'] ?? "Últimas notícias e artigos sobre {$category['name']} no agronegócio brasileiro.",
            'canonical' => "https://www.inforagro.com.br/{$category['slug']}",
        ];
    }
    
    /**
     * Gerar meta tags para post
     */
    public static function postMeta(array $post): array
    {
        return [
            'title' => ($post['meta_title'] ?? $post['title']) . ' | InforAgro',
            'description' => $post['meta_description'] ?? $post['excerpt'] ?? '',
            'canonical' => "https://www.inforagro.com.br/{$post['category_slug']}/{$post['slug']}",
            'ogImage' => $post['featured_image'] ?? '/assets/images/og-default.jpg',
            'ogType' => 'article',
        ];
    }
}
