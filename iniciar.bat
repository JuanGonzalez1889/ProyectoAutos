@echo off
echo ====================================
echo PROYECTO AUTOS - INSTALACION FINAL
echo ====================================
echo.

echo [1/3] Creando base de datos...
mysql -u root -p -e "CREATE DATABASE IF NOT EXISTS proyecto_autos CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

if %ERRORLEVEL% NEQ 0 (
    echo.
    echo ERROR: No se pudo crear la base de datos.
    echo Asegurate de tener MySQL corriendo y las credenciales correctas.
    pause
    exit /b 1
)

echo [OK] Base de datos creada
echo.

echo [2/3] Ejecutando migraciones y seeders...
php artisan migrate --seed

if %ERRORLEVEL% NEQ 0 (
    echo.
    echo ERROR: No se pudieron ejecutar las migraciones.
    pause
    exit /b 1
)

echo [OK] Migraciones ejecutadas
echo.

echo [3/3] Iniciando servidor...
echo.
echo ====================================
echo    PROYECTO LISTO!
echo ====================================
echo.
echo Accede a: http://localhost:8000
echo.
echo Para detener el servidor presiona Ctrl+C
echo.

php artisan serve

pause
