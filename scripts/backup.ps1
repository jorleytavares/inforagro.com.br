# =====================================================
# InforAgro - Script de Backup (Windows)
# =====================================================

# Configurações
$BACKUP_DIR = ".\backups"
$DATE = Get-Date -Format "yyyy-MM-dd_HHmmss"
$DB_CONTAINER = "inforagro_db"
$DB_USER = "inforagro_user"
$DB_PASS = "inforagro_secret"
$DB_NAME = "inforagro"

Write-Host "========================================" -ForegroundColor Green
Write-Host "   InforAgro - Backup Automatizado" -ForegroundColor Green
Write-Host "========================================" -ForegroundColor Green
Write-Host ""

# Criar diretório de backup
if (-not (Test-Path $BACKUP_DIR)) {
    New-Item -ItemType Directory -Path $BACKUP_DIR | Out-Null
}

# 1. Backup do Banco de Dados
Write-Host "[1/3] Fazendo backup do banco de dados..." -ForegroundColor Yellow
docker exec $DB_CONTAINER mysqldump -u $DB_USER -p$DB_PASS --single-transaction $DB_NAME > "$BACKUP_DIR\db_backup_$DATE.sql"

if ($LASTEXITCODE -eq 0) {
    Write-Host "✓ Banco de dados salvo: db_backup_$DATE.sql" -ForegroundColor Green
} else {
    Write-Host "✗ Erro ao fazer backup do banco" -ForegroundColor Red
}

# 2. Backup dos Uploads
Write-Host "[2/3] Fazendo backup dos uploads..." -ForegroundColor Yellow
if (Test-Path "public\uploads") {
    Compress-Archive -Path "public\uploads\*" -DestinationPath "$BACKUP_DIR\uploads_backup_$DATE.zip" -Force
    Write-Host "✓ Uploads salvos: uploads_backup_$DATE.zip" -ForegroundColor Green
} else {
    Write-Host "! Diretório de uploads não encontrado" -ForegroundColor Yellow
}

# 3. Backup das Configurações
Write-Host "[3/3] Fazendo backup das configurações..." -ForegroundColor Yellow
$configFiles = @("app\Core\Config.php")
if (Test-Path ".env") { $configFiles += ".env" }
Compress-Archive -Path $configFiles -DestinationPath "$BACKUP_DIR\config_backup_$DATE.zip" -Force
Write-Host "✓ Configurações salvas: config_backup_$DATE.zip" -ForegroundColor Green

# Limpar backups antigos (mais de 30 dias)
Write-Host ""
Write-Host "Limpando backups antigos (>30 dias)..." -ForegroundColor Yellow
$cutoffDate = (Get-Date).AddDays(-30)
Get-ChildItem $BACKUP_DIR -File | Where-Object { $_.LastWriteTime -lt $cutoffDate } | Remove-Item -Force
Write-Host "✓ Limpeza concluída" -ForegroundColor Green

# Resumo
Write-Host ""
Write-Host "========================================" -ForegroundColor Green
Write-Host "   Backup Concluído!" -ForegroundColor Green
Write-Host "========================================" -ForegroundColor Green
Write-Host "Arquivos salvos em: $BACKUP_DIR"
Get-ChildItem "$BACKUP_DIR\*$DATE*" | Format-Table Name, Length
