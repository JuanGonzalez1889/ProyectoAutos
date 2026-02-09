@echo off
setlocal
cd /d "%~dp0"
start "Laravel" cmd /c "php -S 127.0.0.1:8000 -t public"
start "Vite" cmd /c "npm run dev"
echo Servidores iniciados: http://127.0.0.1:8000
endlocal
