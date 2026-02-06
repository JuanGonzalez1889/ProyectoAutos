#!/bin/bash
# ===================================================================
# SCRIPT DE DEPLOYMENT PARA PRODUCCIÓN
# ===================================================================
# Automatiza el proceso de deployment incluyendo:
# - Actualización de código
# - Instalación de dependencias
# - Compilación de assets
# - Migraciones
# - Optimizaciones
# ===================================================================

set -euo pipefail # Exit on error and undefined vars

echo "🚀 Starting AutoWeb Pro deployment..."

# === 0. BASIC CHECKS ===
if [ ! -f ".env" ]; then
    echo "❌ .env not found. Aborting deploy."
    exit 1
fi

# === 1. PULL LATEST CODE ===
echo "📦 Pulling latest code from repository..."
git pull origin main

# === 2. COMPOSER DEPENDENCIES ===
echo "📚 Installing Composer dependencies (production mode)..."
composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# === 3. NPM DEPENDENCIES ===
echo "📦 Installing NPM dependencies..."
npm ci --omit=dev

# === 4. BUILD ASSETS ===
echo "🎨 Building production assets with Vite..."
npm run build

# === 5. MIGRATIONS ===
echo "🗄️  Running database migrations..."
echo "🛑 Enabling maintenance mode..."
php artisan down --retry=60 --render="errors::503" || true
php artisan migrate --force

# === 6. CLEAR OLD CACHE ===
echo "🧹 Clearing old cache..."
php artisan optimize:clear

# === 7. OPTIMIZE APPLICATION ===
echo "⚡ Optimizing application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# === 8. OPTIMIZE COMPOSER AUTOLOADER ===
echo "📚 Optimizing Composer autoloader..."
composer dump-autoload --optimize

# === 9. STORAGE LINK ===
echo "🔗 Creating storage link..."
php artisan storage:link

# === 10. PERMISSIONS ===
echo "🔐 Setting correct permissions..."
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# === 11. RESTART SERVICES ===
echo "🔄 Restarting services..."

# Restart queue workers
php artisan queue:restart

# Restart supervisor workers
if command -v supervisorctl &> /dev/null; then
    sudo supervisorctl restart laravel-worker:*
    echo "✅ Supervisor workers restarted"
fi

# Reload PHP-FPM
if command -v systemctl &> /dev/null; then
    sudo systemctl reload php8.2-fpm
    echo "✅ PHP-FPM reloaded"
fi

# Reload Nginx
if command -v nginx &> /dev/null; then
    sudo nginx -t && sudo systemctl reload nginx
    echo "✅ Nginx reloaded"
fi

echo "🟢 Disabling maintenance mode..."
php artisan up || true

# === 12. CLEANUP ===
echo "🧹 Cleaning up temporary files..."
rm -rf node_modules/.cache

echo ""
echo "✅ ================================="
echo "✅ DEPLOYMENT COMPLETED SUCCESSFULLY!"
echo "✅ ================================="
echo ""
echo "📊 Deployment Summary:"
echo "   - Code updated from Git"
echo "   - Dependencies installed"
echo "   - Assets compiled"
echo "   - Database migrated"
echo "   - Cache optimized"
echo "   - Services restarted"
echo ""
echo "🌐 Application URL: ${APP_URL:-https://tudominio.com}"
echo "📅 Deployed at: $(date '+%Y-%m-%d %H:%M:%S')"
echo ""
echo "💡 Next steps:"
echo "   1. Verify application is running: curl -I ${APP_URL:-https://tudominio.com}"
echo "   2. Check logs: tail -f storage/logs/laravel.log"
echo "   3. Monitor queue workers: php artisan queue:monitor"
echo ""
