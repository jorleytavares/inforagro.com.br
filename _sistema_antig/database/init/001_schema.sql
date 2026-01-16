-- inforagro.com.br - Schema Completo do Banco de Dados
-- Portal de Notícias do Agronegócio Brasileiro
-- Versão: 2.0

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- =============================================
-- CATEGORIAS (Silos Principais)
-- =============================================
DROP TABLE IF EXISTS categories;
CREATE TABLE categories (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    parent_id INT UNSIGNED NULL,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    meta_title VARCHAR(160),
    meta_description VARCHAR(320),
    icon VARCHAR(50),
    color VARCHAR(7),
    sort_order INT DEFAULT 0,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (parent_id) REFERENCES categories(id) ON DELETE SET NULL,
    INDEX idx_parent (parent_id),
    INDEX idx_slug (slug),
    INDEX idx_active (is_active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- AUTORES
-- =============================================
DROP TABLE IF EXISTS authors;
CREATE TABLE authors (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(255),
    bio TEXT,
    avatar VARCHAR(255),
    role VARCHAR(50) DEFAULT 'Redator',
    linkedin VARCHAR(255),
    twitter VARCHAR(100),
    expertise JSON,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_slug (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- TAGS
-- =============================================
DROP TABLE IF EXISTS tags;
CREATE TABLE tags (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    slug VARCHAR(50) NOT NULL UNIQUE,
    description VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_slug (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- POSTS (Artigos/Notícias)
-- =============================================
DROP TABLE IF EXISTS posts;
CREATE TABLE posts (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    category_id INT UNSIGNED NOT NULL,
    author_id INT UNSIGNED NOT NULL,
    
    -- Conteúdo
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    excerpt TEXT,
    content LONGTEXT,
    
    -- Imagens
    featured_image VARCHAR(255),
    featured_image_alt VARCHAR(255),
    featured_image_caption VARCHAR(255),
    og_image VARCHAR(255),
    
    -- SEO
    meta_title VARCHAR(160),
    meta_description VARCHAR(320),
    focus_keyword VARCHAR(100),
    canonical_url VARCHAR(255),
    
    -- Tipo de Conteúdo
    content_type ENUM('news', 'article', 'pillar', 'guide', 'review') DEFAULT 'article',
    
    -- Status e Publicação
    status ENUM('draft', 'pending', 'published', 'scheduled', 'archived') DEFAULT 'draft',
    published_at TIMESTAMP NULL,
    scheduled_at TIMESTAMP NULL,
    
    -- Métricas
    views INT UNSIGNED DEFAULT 0,
    read_time INT UNSIGNED DEFAULT 5,
    word_count INT UNSIGNED DEFAULT 0,
    
    -- Estruturados
    faq_schema JSON,
    
    -- Timestamps
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE RESTRICT,
    FOREIGN KEY (author_id) REFERENCES authors(id) ON DELETE RESTRICT,
    
    INDEX idx_slug (slug),
    INDEX idx_status_date (status, published_at),
    INDEX idx_category (category_id),
    INDEX idx_author (author_id),
    INDEX idx_content_type (content_type),
    FULLTEXT idx_search (title, excerpt, content)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- RELACIONAMENTO POST-TAG
-- =============================================
DROP TABLE IF EXISTS post_tags;
CREATE TABLE post_tags (
    post_id INT UNSIGNED NOT NULL,
    tag_id INT UNSIGNED NOT NULL,
    PRIMARY KEY (post_id, tag_id),
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- POSTS RELACIONADOS (Silo Linking)
-- =============================================
DROP TABLE IF EXISTS related_posts;
CREATE TABLE related_posts (
    post_id INT UNSIGNED NOT NULL,
    related_post_id INT UNSIGNED NOT NULL,
    relevance_score DECIMAL(3,2) DEFAULT 1.00,
    PRIMARY KEY (post_id, related_post_id),
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
    FOREIGN KEY (related_post_id) REFERENCES posts(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- MÍDIA/UPLOADS
-- =============================================
DROP TABLE IF EXISTS media;
CREATE TABLE media (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    filename VARCHAR(255) NOT NULL,
    original_name VARCHAR(255),
    mime_type VARCHAR(100),
    size INT UNSIGNED,
    width INT UNSIGNED,
    height INT UNSIGNED,
    alt_text VARCHAR(255),
    caption VARCHAR(500),
    path VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_filename (filename)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- CONFIGURAÇÕES DO SITE
-- =============================================
DROP TABLE IF EXISTS settings;
CREATE TABLE settings (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) NOT NULL UNIQUE,
    setting_value TEXT,
    setting_type ENUM('string', 'number', 'boolean', 'json') DEFAULT 'string',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- DADOS INICIAIS - CATEGORIAS PRINCIPAIS (SILOS)
-- =============================================
INSERT INTO categories (name, slug, description, icon, color, sort_order) VALUES
('Agricultura e Pecuária', 'agricultura-e-pecuaria', 'Notícias sobre culturas agrícolas e criação animal', '🌾', '#5F7D4E', 1),
('Agronegócio', 'agronegocio', 'Mercado, commodities, tecnologia e políticas do setor', '📊', '#3E5232', 2),
('Meio Ambiente e Sustentabilidade', 'meio-ambiente-e-sustentabilidade', 'ESG, clima, legislação ambiental e recuperação de áreas', '🌍', '#2E7D32', 3),
('Mundo Pet', 'mundo-pet', 'Saúde, alimentação e comportamento de animais de estimação', '🐾', '#8D6E63', 4);

-- Subcategorias - Agricultura e Pecuária
INSERT INTO categories (parent_id, name, slug, sort_order) VALUES
(1, 'Agricultura', 'agricultura', 1),
(1, 'Pecuária', 'pecuaria', 2),
(1, 'Soja', 'soja', 3),
(1, 'Milho', 'milho', 4),
(1, 'Café', 'cafe', 5),
(1, 'Cana-de-açúcar', 'cana-de-acucar', 6),
(1, 'Hortifruti', 'hortifruti', 7),
(1, 'Bovinocultura de Corte', 'bovinocultura-de-corte', 8),
(1, 'Bovinocultura de Leite', 'bovinocultura-de-leite', 9),
(1, 'Avicultura', 'avicultura', 10),
(1, 'Suinocultura', 'suinocultura', 11),
(1, 'Sanidade Animal', 'sanidade-animal', 12);

-- Subcategorias - Agronegócio
INSERT INTO categories (parent_id, name, slug, sort_order) VALUES
(2, 'Mercado Agro', 'mercado-agro', 1),
(2, 'Commodities', 'commodities', 2),
(2, 'Exportações', 'exportacoes', 3),
(2, 'Importações', 'importacoes', 4),
(2, 'Tecnologia no Agro', 'tecnologia-no-agro', 5),
(2, 'Máquinas Agrícolas', 'maquinas-agricolas', 6),
(2, 'Crédito Rural', 'credito-rural', 7),
(2, 'Políticas Agrícolas', 'politicas-agricolas', 8);

-- Subcategorias - Meio Ambiente
INSERT INTO categories (parent_id, name, slug, sort_order) VALUES
(3, 'Agricultura Sustentável', 'agricultura-sustentavel', 1),
(3, 'ESG no Agro', 'esg-no-agro', 2),
(3, 'Clima', 'clima', 3),
(3, 'Impactos Ambientais', 'impactos-ambientais', 4),
(3, 'Legislação Ambiental', 'legislacao-ambiental', 5),
(3, 'Créditos de Carbono', 'creditos-de-carbono', 6),
(3, 'Recuperação de Áreas', 'recuperacao-de-areas', 7);

-- Subcategorias - Mundo Pet
INSERT INTO categories (parent_id, name, slug, sort_order) VALUES
(4, 'Cães', 'caes', 1),
(4, 'Gatos', 'gatos', 2),
(4, 'Saúde Pet', 'saude-pet', 3),
(4, 'Alimentação Pet', 'alimentacao-pet', 4),
(4, 'Comportamento Pet', 'comportamento-pet', 5),
(4, 'Curiosidades Pet', 'curiosidades-pet', 6);

-- =============================================
-- AUTOR PADRÃO
-- =============================================
INSERT INTO authors (name, slug, email, bio, role, expertise) VALUES
('Equipe InfoRagro', 'equipe-InfoRagro', 'redacao@inforagro.com.br', 'Equipe de redação do portal InfoRagro, composta por jornalistas e especialistas em agronegócio.', 'Redação', '["Agronegócio", "Agricultura", "Pecuária"]');

-- =============================================
-- TAGS INICIAIS
-- =============================================
INSERT INTO tags (name, slug) VALUES
('Safra 2026', 'safra-2026'),
('Agricultura Familiar', 'agricultura-familiar'),
('Orgânicos', 'organicos'),
('Exportação', 'exportacao'),
('Tecnologia', 'tecnologia'),
('Sustentabilidade', 'sustentabilidade'),
('Mercado', 'mercado'),
('Clima', 'clima'),
('Preços', 'precos'),
('Embrapa', 'embrapa');

-- =============================================
-- CONFIGURAÇÕES INICIAIS
-- =============================================
INSERT INTO settings (setting_key, setting_value, setting_type) VALUES
('site_name', 'InfoRagro', 'string'),
('site_description', 'Portal de notícias e referências sobre o agronegócio brasileiro', 'string'),
('site_url', 'https://www.inforagro.com.br', 'string'),
('posts_per_page', '12', 'number'),
('enable_comments', 'false', 'boolean'),
('adsense_enabled', 'false', 'boolean'),
('adsense_client_id', '', 'string'),
('social_twitter', '@InfoRagro', 'string'),
('social_facebook', '', 'string'),
('social_instagram', '', 'string'),
('analytics_id', '', 'string');

SET FOREIGN_KEY_CHECKS = 1;
