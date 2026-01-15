<?php

namespace App\Helpers;

/**
 * Helper para geração de JWT (JSON Web Tokens) com assinatura RS256
 */
class JwtHelper
{
    /**
     * Gera um token JWT assinado com chave privada RSA
     * 
     * @param array $payload Dados a serem incluídos no token
     * @param int $expiration Tempo de expiração em segundos (padrão 10 minutos)
     * @return string Token JWT
     */
    public static function generateToken(array $payload = [], int $expiration = 600): string
    {
        // Cabeçalho
        $header = [
            'typ' => 'JWT',
            'alg' => 'RS256'
        ];

        // Payload padrão
        $defaultPayload = [
            'iat' => time(),
            'exp' => time() + $expiration,
            'sub' => 'tinymce_user', // Identificador genérico ou ID do usuário logado
            'name' => 'Admin User'
        ];
        
        $payload = array_merge($defaultPayload, $payload);

        // Codificar Header e Payload
        $base64Header = self::base64UrlEncode(json_encode($header));
        $base64Payload = self::base64UrlEncode(json_encode($payload));

        // Assinar
        $signature = self::sign($base64Header . "." . $base64Payload);
        $base64Signature = self::base64UrlEncode($signature);

        return $base64Header . "." . $base64Payload . "." . $base64Signature;
    }

    /**
     * Assina a mensagem usando a chave privada RSA
     */
    private static function sign(string $message): string
    {
        $privateKeyPath = __DIR__ . '/../Config/keys/tinymce_private.key'; // Caminho relativo fixo
        
        if (!file_exists($privateKeyPath)) {
            throw new \Exception("Chave privada não encontrada em: " . $privateKeyPath);
        }

        $privateKey = file_get_contents($privateKeyPath);
        $binarySignature = '';

        if (!openssl_sign($message, $binarySignature, $privateKey, OPENSSL_ALGO_SHA256)) {
            throw new \Exception("Erro ao assinar JWT");
        }

        return $binarySignature;
    }

    /**
     * Codificação Base64 URL Safe (sem padding)
     */
    private static function base64UrlEncode(string $data): string
    {
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($data));
    }
}
