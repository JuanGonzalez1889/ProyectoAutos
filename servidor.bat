@echo off
chcp 65001 >nul
cd /d "%~dp0"
echo.
echo ========================================
echo   SERVIDOR PHP - PROYECTO AUTOS
echo ========================================
echo.
echo El proyecto estara disponible en:
echo   http://localhost:8000
echo.
echo Limpiando cache...
REM Limpiar cache
powershell -Command "Remove-Item -Path 'bootstrap/cache/*' -Force -Recurse -ErrorAction SilentlyContinue; Remove-Item -Path 'storage/framework/cache/*' -Force -Recurse -ErrorAction SilentlyContinue; Remove-Item -Path 'storage/framework/views/*' -Force -Recurse -ErrorAction SilentlyContinue"

echo [OK] Cache limpiado
echo.
echo Iniciando servidor...
echo.
echo Para detener el servidor presiona Ctrl+C
echo.
timeout /t 2 /nobreak
php -S localhost:8000 -t public -r server.php
pause
