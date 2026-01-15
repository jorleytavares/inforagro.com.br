<?php

namespace App\Helpers;

/**
 * Helper de Strings e Formatação
 */
class StringHelper
{
    /**
     * Gerar slug a partir de texto
     */
    public static function slugify(string $text): string
    {
        $text = mb_strtolower($text);
        
        // Substituir caracteres acentuados
        $replacements = [
            '/[áàãâä]/u' => 'a',
            '/[éèêë]/u' => 'e',
            '/[íìîï]/u' => 'i',
            '/[óòõôö]/u' => 'o',
            '/[úùûü]/u' => 'u',
            '/[ç]/u' => 'c',
            '/[ñ]/u' => 'n',
        ];
        
        foreach ($replacements as $pattern => $replacement) {
            $text = preg_replace($pattern, $replacement, $text);
        }
        
        // Remover caracteres especiais
        $text = preg_replace('/[^a-z0-9]+/', '-', $text);
        
        return trim($text, '-');
    }
    
    /**
     * Truncar texto
     */
    public static function truncate(string $text, int $length = 160, string $suffix = '...'): string
    {
        if (mb_strlen($text) <= $length) {
            return $text;
        }
        
        $text = mb_substr($text, 0, $length);
        $lastSpace = mb_strrpos($text, ' ');
        
        if ($lastSpace !== false) {
            $text = mb_substr($text, 0, $lastSpace);
        }
        
        return $text . $suffix;
    }
    
    /**
     * Formatar data em português
     */
    public static function formatDate(?string $date, string $format = 'long'): string
    {
        if (empty($date)) {
            return '';
        }
        
        $timestamp = strtotime($date);
        
        $months = [
            1 => 'janeiro', 2 => 'fevereiro', 3 => 'março', 4 => 'abril',
            5 => 'maio', 6 => 'junho', 7 => 'julho', 8 => 'agosto',
            9 => 'setembro', 10 => 'outubro', 11 => 'novembro', 12 => 'dezembro'
        ];
        
        $day = date('j', $timestamp);
        $month = $months[(int) date('n', $timestamp)];
        $year = date('Y', $timestamp);
        
        if ($format === 'long') {
            return "{$day} de {$month} de {$year}";
        } elseif ($format === 'short') {
            return date('d/m/Y', $timestamp);
        } elseif ($format === 'relative') {
            return self::relativeTime($timestamp);
        }
        
        return date($format, $timestamp);
    }
    
    /**
     * Tempo relativo
     */
    public static function relativeTime(int $timestamp): string
    {
        $diff = time() - $timestamp;
        
        if ($diff < 60) {
            return 'agora mesmo';
        } elseif ($diff < 3600) {
            $mins = floor($diff / 60);
            return "há {$mins} " . ($mins === 1 ? 'minuto' : 'minutos');
        } elseif ($diff < 86400) {
            $hours = floor($diff / 3600);
            return "há {$hours} " . ($hours === 1 ? 'hora' : 'horas');
        } elseif ($diff < 604800) {
            $days = floor($diff / 86400);
            return "há {$days} " . ($days === 1 ? 'dia' : 'dias');
        } elseif ($diff < 2592000) {
            $weeks = floor($diff / 604800);
            return "há {$weeks} " . ($weeks === 1 ? 'semana' : 'semanas');
        } elseif ($diff < 31536000) {
            $months = floor($diff / 2592000);
            return "há {$months} " . ($months === 1 ? 'mês' : 'meses');
        } else {
            $years = floor($diff / 31536000);
            return "há {$years} " . ($years === 1 ? 'ano' : 'anos');
        }
    }
    
    /**
     * Calcular tempo de leitura
     */
    public static function readingTime(string $content): int
    {
        $wordCount = str_word_count(strip_tags($content));
        $readTime = ceil($wordCount / 200); // 200 palavras por minuto
        return max(1, $readTime);
    }
    
    /**
     * Extrair primeiro parágrafo
     */
    public static function extractExcerpt(string $content, int $maxLength = 160): string
    {
        // Remover tags HTML
        $text = strip_tags($content);
        
        // Pegar primeiro parágrafo
        $paragraphs = preg_split('/\n\n|\r\n\r\n/', $text);
        $firstParagraph = trim($paragraphs[0] ?? '');
        
        return self::truncate($firstParagraph, $maxLength);
    }
    
    /**
     * Destacar termo de busca
     */
    public static function highlight(string $text, string $term): string
    {
        if (empty($term)) {
            return $text;
        }
        
        $escapedTerm = preg_quote($term, '/');
        return preg_replace(
            "/({$escapedTerm})/i",
            '<mark>$1</mark>',
            $text
        );
    }
}
