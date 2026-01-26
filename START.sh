#!/bin/bash
# Script para iniciar el servidor SaaS Multi-Tenant ProyectoAutos

echo "╔════════════════════════════════════════════════════════════════╗"
echo "║  🚀 INICIANDO SERVIDOR SAAS MULTI-TENANT PROYECTOAUTOS         ║"
echo "║  Fecha: $(date +"%d/%m/%Y %H:%M:%S")                          ║"
echo "╚════════════════════════════════════════════════════════════════╝"
echo ""

# Verificar que estamos en el directorio correcto
if [ ! -f "artisan" ]; then
    echo "❌ Error: Debes ejecutar este script desde la raíz del proyecto"
    exit 1
fi

echo "📋 Verificando estado de las migraciones..."
php artisan migrate:status --quiet || echo "⚠️ No se pudieron verificar migraciones"

echo ""
echo "🔧 Limpiando cache..."
php artisan cache:clear
php artisan config:cache

echo ""
echo "✅ SERVIDOR LISTO!"
echo ""
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "🌐 ACCEDE A:"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "  👤 Login:              http://localhost:8000/login"
echo "  📝 Registro Agencia:   http://localhost:8000/tenants/register"
echo "  🏢 Admin Tenants:      http://localhost:8000/admin/tenants (ADMIN only)"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo ""
echo "📚 DOCUMENTACIÓN:"
echo "  - RESUMEN.md:           Resumen completo de implementación"
echo "  - SAAS_DOCUMENTATION.md: Documentación del sistema SaaS"
echo "  - TESTING.md:           Guía paso a paso para testing"
echo ""
echo "🚀 Iniciando servidor Laravel..."
php artisan serve
