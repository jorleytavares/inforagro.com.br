# 🚀 Guia de Deploy - InforAgro no cPanel

## Informações do Servidor

- **Hospedagem:** Napoleon (napoleon.com.br)
- **Usuário cPanel:** curr6441
- **IP:** 186.209.113.112
- **Domínio:** inforagro.com.br

## Credenciais do Banco

- **Banco:** curr6441_inforagro01
- **Usuário:** curr6441_hostinfor01
- **Senha:** (ver .env.production)

---

## 📋 CHECKLIST DE DEPLOY

### 1. ✅ Configurar Domínio no cPanel

1. Acessar cPanel → **Domínios** ou **Addon Domains**
2. Adicionar: `inforagro.com.br`
3. Document Root: `/home/curr6441/inforagro.com.br`

### 2. ✅ Clonar Repositório via Git

1. cPanel → **Git Version Control** → **Criar**
2. Clone URL: `https://github.com/jorleytavares/inforagro.com.br.git`
3. Repository Path: `/home/curr6441/inforagro.com.br`
4. Clicar em **Create**

### 3. ✅ Configurar Banco de Dados

1. cPanel → **Bancos de Dados MySQL**
2. Banco já criado: `curr6441_inforagro01`
3. Usuário já criado: `curr6441_hostinfor01`
4. **Importante:** Usuário precisa ter TODAS as permissões no banco

### 4. ✅ Importar Dados no Banco

1. cPanel → **phpMyAdmin**
2. Selecionar banco: `curr6441_inforagro01`
3. Aba **Importar** → Upload do arquivo `database/full_backup.sql`

### 5. ✅ Configurar Arquivo .env

1. No gerenciador de arquivos ou via SSH:
2. Renomear `.env.production` para `.env`
3. Ou criar o arquivo `.env` com o conteúdo de `.env.production`

```bash
# Via SSH (se disponível):
cd /home/curr6441/inforagro.com.br
cp .env.production .env
```

### 6. ✅ Configurar .htaccess na Raiz

1. Renomear `.htaccess.cpanel` para `.htaccess` na raiz do domínio
2. Isso redireciona tudo para a pasta `/public`

### 7. ✅ Ajustar Permissões

```bash
# Via SSH:
chmod 755 /home/curr6441/inforagro.com.br
chmod -R 755 /home/curr6441/inforagro.com.br/public
chmod -R 777 /home/curr6441/inforagro.com.br/storage
chmod -R 777 /home/curr6441/inforagro.com.br/public/uploads
```

### 8. ✅ Verificar o Site

1. Acessar: https://inforagro.com.br
2. Testar login admin: https://inforagro.com.br/admin/login
3. Verificar health: https://inforagro.com.br/api/health

---

## 🔧 SOLUÇÃO DE PROBLEMAS

### Erro 500:
- Verificar logs em: `/home/curr6441/logs/error.log`
- Verificar permissões do storage/
- Verificar conexão com banco (credenciais)

### Página em branco:
- Verificar se .htaccess está correto
- Verificar se mod_rewrite está habilitado

### Erro de banco:
- Verificar se usuário tem permissões
- Testar conexão via phpMyAdmin

---

## 📞 SUPORTE

- **Documentação:** DOCUMENTATION.md
- **Segurança:** SECURITY-AUDIT.md

---

*Deploy Guide v1.0 - InforAgro*
