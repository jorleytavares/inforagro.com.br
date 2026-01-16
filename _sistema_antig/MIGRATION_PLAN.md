# Plano de Migração: Legado -> Laravel

## 1. Pré-requisitos (Bloqueio Atual)
- [ ] Instalação do Framework Laravel via Composer.
  - *Status:* Aguardando execução do comando `composer create-project` pelo usuário (CLI indisponível para o agente).

## 2. Estrutura de Banco de Dados
- [ ] Configurar `.env` com credenciais do banco atual.
- [ ] Criar Models Eloquent para tabelas existentes:
  - `User`
  - `Post`
  - `Category`
  - `Tag`
  - `Media`? (Ou usar Spatie MediaLibrary)
- [ ] Criar Migrations de "snapshot" do schema atual.

## 3. Painel Administrativo (FilamentPHP)
- [ ] Instalar `filament/filament`.
- [ ] Criar Resources:
  - `PostResource` (Editor rico, upload, SEO fields).
  - `CategoryResource`.
  - `UserResource`.
  - `TagResource`.
- [ ] Configurar Tema e Dashboard.

## 4. Frontend (Blade Components)
- [ ] Migrar Layout Principal (`main.blade.php`).
- [ ] Migrar Página Inicial (`HomeController`).
- [ ] Migrar Listagem de Posts e Single Post.
- [ ] Implementar Rotas limpas.

## 5. Migração de Dados/Assets
- [ ] Mover pasta `uploads` para `storage/app/public`.
- [ ] Rodar `php artisan storage:link`.
