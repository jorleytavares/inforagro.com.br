# 📚 Documentação - InforAgro

**Portal de Notícias do Agronegócio Brasileiro**

---

## 📋 Índice

1. [Visão Geral](#visão-geral)
2. [Requisitos](#requisitos)
3. [Instalação](#instalação)
4. [Estrutura do Projeto](#estrutura-do-projeto)
5. [Configuração](#configuração)
6. [Segurança](#segurança)
7. [API Endpoints](#api-endpoints)
8. [Administração](#administração)
9. [Manutenção](#manutenção)
10. [Troubleshooting](#troubleshooting)

---

## 🌾 Visão Geral

InforAgro é um portal de notícias focado no agronegócio brasileiro, desenvolvido em PHP 8 com arquitetura MVC, MySQL e Docker.

### Funcionalidades Principais
- ✅ Sistema de posts com categorias e tags
- ✅ Painel administrativo completo
- ✅ Sistema de autores
- ✅ Busca full-text
- ✅ Newsletter
- ✅ Sitemap XML automático
- ✅ SEO otimizado (Schema.org, Open Graph)
- ✅ API REST
- ✅ Sistema de segurança robusto

---

## 💻 Requisitos

- PHP 8.0+
- MySQL 8.0+
- Docker & Docker Compose
- Composer (para dependências)

---

## 🚀 Instalação

### Com Docker

```bash
# Clonar repositório
git clone <repo-url> inforagro.com.br
cd inforagro.com.br

# Iniciar containers
docker-compose up -d

# Configurar banco de dados
docker exec -i inforagro_db mysql -u inforagro_user -pinforagro_secret inforagro < database/schema.sql
```

### Acessos
- **Site**: http://localhost:8080
- **Admin**: http://localhost:8080/admin/login
- **PHPMyAdmin**: http://localhost:8081

---

## 📁 Estrutura do Projeto

```
inforagro.com.br/
├── app/
│   ├── Controllers/       # Controllers MVC
│   │   └── Admin/        # Controllers do painel admin
│   ├── Core/             # Classes base (Router, Database, Controller)
│   ├── Helpers/          # Classes auxiliares
│   ├── Models/           # Models do banco de dados
│   └── Views/            # Templates PHP
│       ├── admin/        # Views do painel
│       ├── errors/       # Páginas de erro
│       └── layouts/      # Layouts base
├── public/               # Arquivos públicos (DocumentRoot)
│   ├── assets/           # CSS, JS, imagens
│   ├── uploads/          # Arquivos enviados
│   └── index.php         # Front controller
├── storage/
│   ├── cache/            # Cache de dados
│   └── logs/             # Logs da aplicação
├── docker/               # Configurações Docker
├── database/             # Scripts SQL
└── SECURITY-AUDIT.md     # Relatório de segurança
```

---

## ⚙️ Configuração

### Variáveis de Ambiente (.env)

```env
DB_HOST=inforagro_db
DB_NAME=inforagro
DB_USER=inforagro_user
DB_PASS=inforagro_secret
DB_PORT=3306

APP_ENV=production
APP_DEBUG=false
APP_URL=https://www.inforagro.com.br

MAIL_HOST=smtp.example.com
MAIL_PORT=587
MAIL_USER=
MAIL_PASS=
```

---

## 🔐 Segurança

### Recursos Implementados

| Recurso | Descrição |
|---------|-----------|
| **CSRF Protection** | Token em todos os formulários |
| **Rate Limiting** | 5 tentativas de login / 15 min |
| **Session Security** | Expiração 30 min, regeneração de ID |
| **Password Reset** | Token SHA-256, expira em 1 hora |
| **RBAC** | Roles: author, editor, admin |
| **Audit Logs** | Registro de ações críticas |
| **HTTP Headers** | CSP, X-Frame-Options, etc |

### Hierarquia de Roles

| Role | Nível | Acesso |
|------|-------|--------|
| `author` | 1 | Criar posts |
| `editor` | 2 | Criar + editar + deletar posts |
| `admin` | 3 | Acesso total |

### Helpers de Segurança

```php
// CSRF
use App\Helpers\Csrf;
Csrf::token();       // Obter token
Csrf::field();       // Campo input hidden
Csrf::verify();      // Verificar POST

// Rate Limiting
use App\Helpers\RateLimiter;
RateLimiter::check('login_' . $email);   // Verificar
RateLimiter::hit('login_' . $email);     // Registrar tentativa
RateLimiter::clear('login_' . $email);   // Limpar

// Audit Log
use App\Helpers\AuditLog;
AuditLog::log('action', 'entity_type', $entityId, $data);

// Session Security
use App\Helpers\SessionSecurity;
SessionSecurity::init();
SessionSecurity::isLoggedIn();
SessionSecurity::getUser();
```

---

## 🔌 API Endpoints

### Públicos

| Método | Endpoint | Descrição |
|--------|----------|-----------|
| GET | `/api/posts` | Lista de posts |
| GET | `/api/posts/{id}` | Detalhes de um post |
| GET | `/api/categories` | Lista de categorias |
| GET | `/api/health` | Health check |
| GET | `/api/ping` | Ping simples |

### Autenticados (Admin)

| Método | Endpoint | Descrição |
|--------|----------|-----------|
| GET | `/api/metrics` | Métricas do sistema |

### Exemplo de Response

```json
// GET /api/health
{
  "status": "healthy",
  "timestamp": "2026-01-15T03:45:00-04:00",
  "version": "1.0.0",
  "checks": {
    "database": { "status": "ok" },
    "disk": { "status": "ok", "free_gb": 50.25, "used_percent": 45.5 },
    "cache": { "status": "ok", "writable": true },
    "uploads": { "status": "ok", "writable": true }
  }
}
```

---

## 🎛️ Administração

### Acesso
- URL: `/admin/login`
- Recuperação: `/admin/forgot-password`

### Seções do Painel

| Seção | URL | Descrição |
|-------|-----|-----------|
| Dashboard | `/admin` | Estatísticas gerais |
| Posts | `/admin/posts` | Gerenciar posts |
| Categorias | `/admin/categories` | Gerenciar categorias |
| Tags | `/admin/tags` | Gerenciar tags |
| Autores | `/admin/authors` | Gerenciar autores |
| Usuários | `/admin/users` | Gerenciar usuários (admin) |
| Mídia | `/admin/media` | Upload de imagens |
| Configurações | `/admin/settings` | Configurações do site (admin) |

---

## 🔧 Manutenção

### Limpeza de Cache

```bash
# Via admin
GET /admin/settings/clear-cache

# Via CLI
rm -rf storage/cache/*.cache
```

### Backup do Banco

```bash
docker exec inforagro_db mysqldump -u inforagro_user -pinforagro_secret --single-transaction inforagro > backup_$(date +%Y%m%d).sql
```

### Otimização do Banco

```sql
ANALYZE TABLE posts, categories, users, tags;
OPTIMIZE TABLE posts, categories, users, tags;
```

### Limpeza de Logs

```sql
-- Login attempts (mais de 24h)
DELETE FROM login_attempts WHERE created_at < DATE_SUB(NOW(), INTERVAL 24 HOUR);

-- Audit logs (mais de 90 dias)
DELETE FROM audit_logs WHERE created_at < DATE_SUB(NOW(), INTERVAL 90 DAY);

-- Password resets expirados
DELETE FROM password_resets WHERE expires_at < NOW();
```

---

## 🐛 Troubleshooting

### Erro 500

1. Verificar logs: `docker logs inforagro_php`
2. Verificar permissões do storage/
3. Verificar conexão com banco

### Sessão Expirando

- Sessão expira após 30 minutos de inatividade
- Mensagem: "Sessão expirada. Faça login novamente."

### Bloqueio de Login

- Limite: 5 tentativas em 15 minutos
- Mensagem: "Muitas tentativas. Aguarde X minutos."
- Limpar manualmente: `DELETE FROM login_attempts WHERE attempt_key LIKE '%email%';`

### Erro de CSRF

- Recarregar página e tentar novamente
- Limpar cookies do navegador

---

## 📞 Suporte

- **Documentação**: Este arquivo
- **Segurança**: SECURITY-AUDIT.md
- **Logs**: storage/logs/

---

*Documentação v1.0 - InforAgro*
*Última atualização: 15/01/2026*
