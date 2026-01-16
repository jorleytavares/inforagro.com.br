# Plano de Migração: Legado -> Laravel

## 1. Pré-requisitos (Bloqueio Atual)
- [x] Instalação do Framework Laravel via Composer.
- [x] Configuração inicial.

## 2. Estrutura de Banco de Dados
- [x] Configurar `.env` com credenciais do banco atual.
- [x] Criar Models Eloquent para tabelas existentes:
  - [x] `User` (Atualizado com slug/bio/social_links)
  - [x] `Post` (Com escopo published)
  - [x] `Category`
  - [x] `Tag`
  - [x] `SearchLog`
  - [x] `NewsletterSubscriber`
- [ ] Rodar Migrations (PENDENTE DE EXECUÇÃO PELO USUÁRIO)

## 3. Painel Administrativo (FilamentPHP)
- [x] Instalar `filament/filament`.
- [x] Criar Resources:
  - [x] `PostResource`
  - [x] `CategoryResource`
  - [x] `UserResource`
  - [x] `TagResource`

## 4. Frontend (Blade Components)
- [x] Migrar Layout Principal (`main.blade.php` -> `components.layout`).
- [x] Migrar Página Inicial (`HomeController`).
- [x] Migrar Listagem de Posts e Single Post.
- [x] Migrar Páginas Estáticas (Sobre, Contato, Privacidade, Termos).
- [x] Migrar Páginas de Arquivo (Tags, Autores).
- [x] Migrar Busca e Logs de Busca.
- [x] Migrar Newsletter.
- [x] Implementar Rotas limpas.

## 5. Migração de Dados/Assets
- [ ] Mover pasta `uploads` para `storage/app/public`.
- [x] Rota `/fix-storage` criada para linkar storage.
