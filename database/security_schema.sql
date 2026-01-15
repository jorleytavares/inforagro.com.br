-- =====================================================
-- InforAgro - Schema do Banco de Dados
-- Tabelas de Segurança e Auditoria
-- =====================================================

-- Tabela de tentativas de login (Rate Limiting)
CREATE TABLE IF NOT EXISTS login_attempts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    attempt_key VARCHAR(255) NOT NULL,
    ip_address VARCHAR(45),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_key (attempt_key),
    INDEX idx_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela de logs de auditoria
CREATE TABLE IF NOT EXISTS audit_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    action VARCHAR(50) NOT NULL,
    entity_type VARCHAR(50),
    entity_id INT,
    old_data JSON,
    new_data JSON,
    ip_address VARCHAR(45),
    user_agent TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_user (user_id),
    INDEX idx_action (action),
    INDEX idx_entity (entity_type, entity_id),
    INDEX idx_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela de recuperação de senha
CREATE TABLE IF NOT EXISTS password_resets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    token VARCHAR(64) NOT NULL,
    expires_at DATETIME NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_token (token),
    INDEX idx_expires (expires_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- Índices de Performance
-- =====================================================

-- Índice composto para posts por status e data
-- ALTER TABLE posts ADD INDEX idx_posts_status_published (status, published_at);

-- Índice para posts por categoria
-- ALTER TABLE posts ADD INDEX idx_posts_category (category_id);

-- Índice para usuários por email
-- ALTER TABLE users ADD INDEX idx_users_email (email);

-- =====================================================
-- Limpeza Automática (Eventos)
-- =====================================================

-- Habilitar event scheduler (executar como root)
-- SET GLOBAL event_scheduler = ON;

-- Evento para limpar login_attempts antigos (24h)
DELIMITER //
CREATE EVENT IF NOT EXISTS cleanup_login_attempts
ON SCHEDULE EVERY 1 HOUR
DO
BEGIN
    DELETE FROM login_attempts WHERE created_at < DATE_SUB(NOW(), INTERVAL 24 HOUR);
END//
DELIMITER ;

-- Evento para limpar password_resets expirados
DELIMITER //
CREATE EVENT IF NOT EXISTS cleanup_password_resets
ON SCHEDULE EVERY 1 HOUR
DO
BEGIN
    DELETE FROM password_resets WHERE expires_at < NOW();
END//
DELIMITER ;

-- Evento para limpar audit_logs antigos (90 dias)
DELIMITER //
CREATE EVENT IF NOT EXISTS cleanup_audit_logs
ON SCHEDULE EVERY 1 DAY
DO
BEGIN
    DELETE FROM audit_logs WHERE created_at < DATE_SUB(NOW(), INTERVAL 90 DAY);
END//
DELIMITER ;
