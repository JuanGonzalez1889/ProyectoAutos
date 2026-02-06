#!/bin/bash
# ===================================================================
# SCRIPT DE ROLLBACK PARA PRODUCCIÓN
# ===================================================================
# Revierte el deployment a la versión anterior
# ===================================================================

set -euo pipefail

echo "⏪ Starting rollback..."

if [ ! -f ".env" ]; then
    echo "❌ .env not found. Aborting rollback."
    exit 1
fi

# === 1. GIT ROLLBACK ===
echo "📦 Reverting to previous Git commit..."
git reset --hard HEAD~1

# === 2. COMPOSER DEPENDENCIES ===
echo "📚 Reinstalling Composer dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

# === 3. NPM & BUILD ===
echo "📦 Rebuilding assets from previous version..."
npm ci --omit=dev
npm run build

# === 4. DATABASE ROLLBACK ===
echo "🗄️  Rolling back last migration batch..."
php artisan down --retry=60 --render="errors::503" || true
php artisan migrate:rollback --force

# === 5. CLEAR & RECACHE ===
echo "⚡ Clearing and recaching..."
php artisan optimize:clear

php artisan config:cache
php artisan route:cache
php artisan view:cache

# === 6. RESTART SERVICES ===
echo "🔄 Restarting services..."
php artisan queue:restart

if command -v supervisorctl &> /dev/null; then
    sudo supervisorctl restart laravel-worker:*
fi

if command -v systemctl &> /dev/null; then
    sudo systemctl reload php8.2-fpm
    sudo nginx -t && sudo systemctl reload nginx
fi

php artisan up || true

echo ""
echo "✅ ================================="
echo "✅ ROLLBACK COMPLETED"
echo "✅ ================================="
echo ""
echo "⚠️  Application reverted to previous version"
echo "📅 Rolled back at: $(date '+%Y-%m-%d %H:%M:%S')"
echo ""
echo "💡 Verify application status:"
echo "   curl -I ${APP_URL:-https://tudominio.com}"
echo ""
