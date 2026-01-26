# Script de instalación final para Proyecto Autos

Write-Host "====================================" -ForegroundColor Cyan
Write-Host "PROYECTO AUTOS - INSTALACION FINAL" -ForegroundColor Cyan
Write-Host "====================================" -ForegroundColor Cyan
Write-Host ""

# Verificar si MySQL está corriendo
$mysqlRunning = Get-Process mysql -ErrorAction SilentlyContinue
if (-not $mysqlRunning) {
    Write-Host "[!] ADVERTENCIA: MySQL no parece estar corriendo" -ForegroundColor Yellow
    Write-Host "Asegurate de iniciar MySQL antes de continuar" -ForegroundColor Yellow
    Write-Host ""
    $continue = Read-Host "¿Deseas continuar de todas formas? (s/n)"
    if ($continue -ne "s") {
        exit
    }
}

Write-Host "[1/3] Creando base de datos..." -ForegroundColor White

# Solicitar credenciales de MySQL si no están configuradas
$dbUser = "root"
Write-Host "Usuario MySQL (default: root): " -NoNewline -ForegroundColor Gray
$inputUser = Read-Host
if ($inputUser) { $dbUser = $inputUser }

Write-Host "Contraseña MySQL: " -NoNewline -ForegroundColor Gray
$dbPassword = Read-Host -AsSecureString
$dbPasswordPlain = [Runtime.InteropServices.Marshal]::PtrToStringAuto([Runtime.InteropServices.Marshal]::SecureStringToBSTR($dbPassword))

# Actualizar .env con las credenciales
(Get-Content .env) -replace 'DB_USERNAME=root', "DB_USERNAME=$dbUser" | Set-Content .env
(Get-Content .env) -replace 'DB_PASSWORD=', "DB_PASSWORD=$dbPasswordPlain" | Set-Content .env

# Crear la base de datos
$createDbCommand = "CREATE DATABASE IF NOT EXISTS proyecto_autos CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
if ($dbPasswordPlain) {
    mysql -u $dbUser -p$dbPasswordPlain -e $createDbCommand 2>$null
} else {
    mysql -u $dbUser -e $createDbCommand 2>$null
}

if ($LASTEXITCODE -eq 0) {
    Write-Host "[OK] Base de datos creada" -ForegroundColor Green
} else {
    Write-Host "[X] ERROR: No se pudo crear la base de datos" -ForegroundColor Red
    Write-Host "Verifica tus credenciales de MySQL" -ForegroundColor Yellow
    pause
    exit 1
}

Write-Host ""
Write-Host "[2/3] Ejecutando migraciones y seeders..." -ForegroundColor White

php artisan migrate --seed --force

if ($LASTEXITCODE -eq 0) {
    Write-Host "[OK] Migraciones ejecutadas" -ForegroundColor Green
} else {
    Write-Host "[X] ERROR: No se pudieron ejecutar las migraciones" -ForegroundColor Red
    pause
    exit 1
}

Write-Host ""
Write-Host "[3/3] Iniciando servidor..." -ForegroundColor White
Write-Host ""
Write-Host "====================================" -ForegroundColor Green
Write-Host "    PROYECTO LISTO!" -ForegroundColor Green
Write-Host "====================================" -ForegroundColor Green
Write-Host ""
Write-Host "Accede a: " -NoNewline -ForegroundColor White
Write-Host "http://localhost:8000" -ForegroundColor Cyan
Write-Host ""
Write-Host "Para detener el servidor presiona Ctrl+C" -ForegroundColor Yellow
Write-Host ""

php artisan serve
