# inforagro.com.br

🌿 Blog especializado em agricultura, pecuária e agronegócio brasileiro.

## Requisitos

- Docker Desktop
- Git

## Instalação

1. Clone o repositório:
```bash
git clone https://github.com/seu-usuario/inforagro.com.br.git
cd inforagro.com.br
```

2. Inicie os containers:
```bash
docker-compose up -d
```

3. Acesse a aplicação:
- **Site:** http://localhost:8080
- **phpMyAdmin:** http://localhost:8081

## Estrutura do Projeto

```
inforagro.com.br/
├── app/
│   ├── Controllers/     # Controladores da aplicação
│   ├── Core/            # Classes base (Router, Database, etc)
│   ├── Models/          # Models de dados
│   └── Views/           # Templates PHP
├── database/
│   └── init/            # Scripts SQL de inicialização
├── public/              # Arquivos públicos (DocumentRoot)
│   ├── assets/          # CSS, JS, imagens
│   └── index.php        # Front controller
├── docker-compose.yml
├── Dockerfile
└── DESIGN-SYSTEM.md     # Especificações de design
```

## Tecnologias

- PHP 8.2 (Apache)
- MySQL 8.0
- Docker
- CSS Custom Properties (Design Tokens)

## Comandos Úteis

```bash
# Iniciar containers
docker-compose up -d

# Parar containers
docker-compose down

# Ver logs
docker-compose logs -f app

# Acessar container PHP
docker exec -it inforagro_app bash

# Acessar MySQL
docker exec -it inforagro_db mysql -u inforagro_user -p
```
