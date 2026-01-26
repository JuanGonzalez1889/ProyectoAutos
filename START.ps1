# Script para iniciar el servidor SaaS Multi-Tenant ProyectoAutos
# Uso: .\START.ps1

Write-Host "╔════════════════════════════════════════════════════════════════╗" -ForegroundColor Cyan
Write-Host "║  🚀 INICIANDO SERVIDOR SAAS MULTI-TENANT PROYECTOAUTOS         ║" -ForegroundColor Cyan
Write-Host "║  Fecha: $(Get-Date -Format 'dd/MM/yyyy HH:mm:ss')                          ║" -ForegroundColor Cyan
Write-Host "╚════════════════════════════════════════════════════════════════╝" -ForegroundColor Cyan
Write-Host ""

# Verificar que estamos en el directorio correcto
if (-not (Test-Path "artisan")) {
    Write-Host "❌ Error: Debes ejecutar este script desde la raíz del proyecto" -ForegroundColor Red
    exit 1
}

Write-Host "📋 Verificando estado de las migraciones..." -ForegroundColor Yellow
php artisan migrate:status

Write-Host ""
Write-Host "🔧 Limpiando cache..." -ForegroundColor Yellow
php artisan cache:clear
php artisan config:cache

Write-Host ""
Write-Host "✅ SERVIDOR LISTO!" -ForegroundColor Green
Write-Host ""
Write-Host "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" -ForegroundColor Cyan
Write-Host "🌐 ACCEDE A:" -ForegroundColor Cyan
Write-Host "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" -ForegroundColor Cyan
Write-Host "  👤 Login:              http://localhost:8000/login" -ForegroundColor Green
Write-Host "  📝 Registro Agencia:   http://localhost:8000/tenants/register" -ForegroundColor Green
Write-Host "  🏢 Admin Tenants:      http://localhost:8000/admin/tenants (ADMIN only)" -ForegroundColor Green
Write-Host "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" -ForegroundColor Cyan
Write-Host ""
Write-Host "📚 DOCUMENTACIÓN:" -ForegroundColor Yellow
Write-Host "  - RESUMEN.md:           Resumen completo de implementación" -ForegroundColor White
Write-Host "  - SAAS_DOCUMENTATION.md: Documentación del sistema SaaS" -ForegroundColor White
Write-Host "  - TESTING.md:           Guía paso a paso para testing" -ForegroundColor White
Write-Host ""
Write-Host "🚀 Iniciando servidor Laravel..." -ForegroundColor Cyan
Write-Host ""

php artisan serve
