#!/bin/bash
# =====================================================
# InforAgro - Script de Backup
# =====================================================

# Configurações
BACKUP_DIR="./backups"
DATE=$(date +%Y-%m-%d_%H%M%S)
DB_CONTAINER="inforagro_db"
DB_USER="inforagro_user"
DB_PASS="inforagro_secret"
DB_NAME="inforagro"

# Cores
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

echo -e "${GREEN}========================================${NC}"
echo -e "${GREEN}   InforAgro - Backup Automatizado${NC}"
echo -e "${GREEN}========================================${NC}"
echo ""

# Criar diretório de backup
mkdir -p "$BACKUP_DIR"

# 1. Backup do Banco de Dados
echo -e "${YELLOW}[1/3] Fazendo backup do banco de dados...${NC}"
docker exec $DB_CONTAINER mysqldump -u $DB_USER -p$DB_PASS --single-transaction $DB_NAME > "$BACKUP_DIR/db_backup_$DATE.sql"

if [ $? -eq 0 ]; then
    echo -e "${GREEN}✓ Banco de dados salvo: db_backup_$DATE.sql${NC}"
else
    echo -e "${RED}✗ Erro ao fazer backup do banco${NC}"
fi

# 2. Backup dos Uploads
echo -e "${YELLOW}[2/3] Fazendo backup dos uploads...${NC}"
if [ -d "public/uploads" ]; then
    tar -czf "$BACKUP_DIR/uploads_backup_$DATE.tar.gz" -C public uploads
    echo -e "${GREEN}✓ Uploads salvos: uploads_backup_$DATE.tar.gz${NC}"
else
    echo -e "${YELLOW}! Diretório de uploads não encontrado${NC}"
fi

# 3. Backup das Configurações
echo -e "${YELLOW}[3/3] Fazendo backup das configurações...${NC}"
tar -czf "$BACKUP_DIR/config_backup_$DATE.tar.gz" \
    --exclude='*.cache' \
    --exclude='*.log' \
    app/Core/Config.php \
    .env 2>/dev/null

echo -e "${GREEN}✓ Configurações salvas: config_backup_$DATE.tar.gz${NC}"

# Limpar backups antigos (mais de 30 dias)
echo ""
echo -e "${YELLOW}Limpando backups antigos (>30 dias)...${NC}"
find "$BACKUP_DIR" -type f -mtime +30 -delete
echo -e "${GREEN}✓ Limpeza concluída${NC}"

# Resumo
echo ""
echo -e "${GREEN}========================================${NC}"
echo -e "${GREEN}   Backup Concluído!${NC}"
echo -e "${GREEN}========================================${NC}"
echo "Arquivos salvos em: $BACKUP_DIR"
ls -lh "$BACKUP_DIR"/*_$DATE* 2>/dev/null
echo ""
