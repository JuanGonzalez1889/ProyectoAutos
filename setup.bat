@echo off
chcp 65001 >nul
echo.
echo ========================================
echo   PROYECTO AUTOS - INSTALACION
echo ========================================
echo.

REM Verificar si MySQL está instalado
echo Buscando MySQL...
set MYSQL_FOUND=0

REM Buscar en ubicaciones comunes
if exist "C:\Program Files\MySQL\MySQL Server 8.0\bin\mysql.exe" (
    set MYSQL_PATH=C:\Program Files\MySQL\MySQL Server 8.0\bin
    set MYSQL_FOUND=1
)
if exist "C:\Program Files\MySQL\MySQL Server 5.7\bin\mysql.exe" (
    set MYSQL_PATH=C:\Program Files\MySQL\MySQL Server 5.7\bin
    set MYSQL_FOUND=1
)
if exist "C:\xampp\mysql\bin\mysql.exe" (
    set MYSQL_PATH=C:\xampp\mysql\bin
    set MYSQL_FOUND=1
)
if exist "C:\wamp64\bin\mysql\mysql8.0.27\bin\mysql.exe" (
    set MYSQL_PATH=C:\wamp64\bin\mysql\mysql8.0.27\bin
    set MYSQL_FOUND=1
)
if exist "C:\laragon\bin\mysql\mysql-8.0.30-winx64\bin\mysql.exe" (
    set MYSQL_PATH=C:\laragon\bin\mysql\mysql-8.0.30-winx64\bin
    set MYSQL_FOUND=1
)

if %MYSQL_FOUND%==0 (
    echo.
    echo [X] MySQL no encontrado automaticamente
    echo.
    echo Por favor, sigue estos pasos MANUALES:
    echo.
    echo 1. Abre tu cliente MySQL ^(phpMyAdmin, MySQL Workbench, etc.^)
    echo 2. Ejecuta este comando SQL:
    echo    CREATE DATABASE proyecto_autos CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
    echo.
    echo 3. Edita el archivo .env y configura:
    echo    DB_USERNAME=tu_usuario
    echo    DB_PASSWORD=tu_contraseña
    echo.
    echo 4. Ejecuta: php artisan migrate --seed
    echo.
    echo 5. Ejecuta: php artisan serve
    echo.
    echo 6. Abre: http://localhost:8000
    echo.
    pause
    exit /b 1
)

echo [OK] MySQL encontrado en: %MYSQL_PATH%
echo.

set /p DB_USER="Usuario MySQL (default: root): "
if "%DB_USER%"=="" set DB_USER=root

set /p DB_PASS="Contraseña MySQL: "

echo.
echo [1/3] Creando base de datos...

"%MYSQL_PATH%\mysql.exe" -u %DB_USER% -p%DB_PASS% -e "CREATE DATABASE IF NOT EXISTS proyecto_autos CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;" 2>nul

if %ERRORLEVEL% NEQ 0 (
    echo [X] Error al crear la base de datos
    echo     Verifica que MySQL este corriendo y las credenciales sean correctas
    echo.
    pause
    exit /b 1
)

echo [OK] Base de datos creada
echo.

REM Actualizar .env con las credenciales
echo Actualizando configuracion...
powershell -Command "(gc .env) -replace 'DB_USERNAME=.*', 'DB_USERNAME=%DB_USER%' | Out-File -encoding ASCII .env"
powershell -Command "(gc .env) -replace 'DB_PASSWORD=.*', 'DB_PASSWORD=%DB_PASS%' | Out-File -encoding ASCII .env"

echo.
echo [2/3] Ejecutando migraciones...
php artisan migrate --seed --force

if %ERRORLEVEL% NEQ 0 (
    echo [X] Error en las migraciones
    pause
    exit /b 1
)

echo [OK] Base de datos configurada
echo.
echo.
echo ========================================
echo         PROYECTO LISTO!
echo ========================================
echo.
echo [OK] Instalacion completada
echo.
echo Accede a: http://localhost:8000
echo.
echo Presiona cualquier tecla para iniciar el servidor...
pause >nul

echo.
echo Iniciando servidor...
echo Para detener presiona Ctrl+C
echo.

php artisan serve
