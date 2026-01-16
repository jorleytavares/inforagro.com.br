<?php

namespace App\Helpers;

/**
 * Helper de Validação e Sanitização
 */
class Validator
{
    /**
     * Validar email
     */
    public static function email(string $value): bool
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }
    
    /**
     * Validar URL
     */
    public static function url(string $value): bool
    {
        return filter_var($value, FILTER_VALIDATE_URL) !== false;
    }
    
    /**
     * Validar slug
     */
    public static function slug(string $value): bool
    {
        return preg_match('/^[a-z0-9\-]+$/', $value) === 1;
    }
    
    /**
     * Validar inteiro positivo
     */
    public static function positiveInt(mixed $value): bool
    {
        return is_numeric($value) && (int)$value > 0;
    }
    
    /**
     * Validar string não vazia
     */
    public static function required(mixed $value): bool
    {
        if (is_string($value)) {
            return trim($value) !== '';
        }
        return $value !== null && $value !== '';
    }
    
    /**
     * Validar tamanho mínimo
     */
    public static function minLength(string $value, int $min): bool
    {
        return mb_strlen($value) >= $min;
    }
    
    /**
     * Validar tamanho máximo
     */
    public static function maxLength(string $value, int $max): bool
    {
        return mb_strlen($value) <= $max;
    }
    
    /**
     * Sanitizar string para HTML
     */
    public static function sanitizeHtml(string $value): string
    {
        return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
    }
    
    /**
     * Sanitizar para texto simples (remove todas as tags)
     */
    public static function sanitizeText(string $value): string
    {
        return strip_tags(trim($value));
    }
    
    /**
     * Gerar slug a partir de texto
     */
    public static function slugify(string $text): string
    {
        $text = mb_strtolower($text, 'UTF-8');
        
        // Mapeamento de caracteres acentuados
        $map = [
            'á' => 'a', 'à' => 'a', 'ã' => 'a', 'â' => 'a', 'ä' => 'a',
            'é' => 'e', 'è' => 'e', 'ê' => 'e', 'ë' => 'e',
            'í' => 'i', 'ì' => 'i', 'î' => 'i', 'ï' => 'i',
            'ó' => 'o', 'ò' => 'o', 'õ' => 'o', 'ô' => 'o', 'ö' => 'o',
            'ú' => 'u', 'ù' => 'u', 'û' => 'u', 'ü' => 'u',
            'ç' => 'c', 'ñ' => 'n',
        ];
        
        $text = strtr($text, $map);
        $text = preg_replace('/[^a-z0-9]+/', '-', $text);
        $text = trim($text, '-');
        
        return $text;
    }
    
    /**
     * Validar força da senha
     */
    public static function strongPassword(string $password): array
    {
        $errors = [];
        
        if (strlen($password) < 8) {
            $errors[] = 'A senha deve ter no mínimo 8 caracteres';
        }
        if (!preg_match('/[A-Z]/', $password)) {
            $errors[] = 'A senha deve conter pelo menos uma letra maiúscula';
        }
        if (!preg_match('/[a-z]/', $password)) {
            $errors[] = 'A senha deve conter pelo menos uma letra minúscula';
        }
        if (!preg_match('/[0-9]/', $password)) {
            $errors[] = 'A senha deve conter pelo menos um número';
        }
        
        return $errors;
    }
    
    /**
     * Validar tipo de arquivo de upload
     */
    public static function allowedMimeType(string $mimeType, array $allowed): bool
    {
        return in_array($mimeType, $allowed);
    }
    
    /**
     * Validar tamanho de arquivo
     */
    public static function maxFileSize(int $size, int $maxBytes): bool
    {
        return $size <= $maxBytes;
    }
    
    /**
     * Validar extensão de arquivo
     */
    public static function allowedExtension(string $filename, array $allowed): bool
    {
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        return in_array($ext, $allowed);
    }
}
