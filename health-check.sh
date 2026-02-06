#!/bin/bash
# ===================================================================
# SCRIPT DE HEALTH CHECK PARA PRODUCCIÓN
# ===================================================================
# Verifica que todos los servicios estén funcionando correctamente
# ===================================================================

set -euo pipefail

echo "🏥 Running health checks for AutoWeb Pro..."
echo ""

# === APP URL (from .env if available) ===
APP_URL=""
if [ -f ".env" ]; then
    APP_URL=$(grep -E '^APP_URL=' .env | head -n 1 | cut -d= -f2- | tr -d '"')
fi
APP_URL=${APP_URL:-http://localhost}

# === COLORS ===
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# === COUNTERS ===
PASSED=0
FAILED=0

# === HELPER FUNCTIONS ===
check_pass() {
    echo -e "${GREEN}✓${NC} $1"
    ((PASSED++))
}

check_fail() {
    echo -e "${RED}✗${NC} $1"
    ((FAILED++))
}

# === 1. PHP VERSION ===
echo "1️⃣  Checking PHP version..."
if php -v | grep -q "PHP 8"; then
    PHP_VERSION=$(php -v | head -n 1 | awk '{print $2}')
    check_pass "PHP version: $PHP_VERSION"
else
    check_fail "PHP version incompatible (requires 8.2+)"
fi

# === 2. DATABASE CONNECTION ===
echo "2️⃣  Checking database connection..."
if php artisan db:monitor &> /dev/null; then
    check_pass "Database connection OK"
else
    check_fail "Database connection FAILED"
fi

# === 3. REDIS CONNECTION ===
echo "3️⃣  Checking Redis connection..."
if redis-cli ping 2>/dev/null | grep -q PONG; then
    check_pass "Redis connection OK"
else
    check_fail "Redis connection FAILED"
fi

# === 4. STORAGE WRITABLE ===
echo "4️⃣  Checking storage permissions..."
TEST_FILE="storage/logs/healthcheck_test.txt"
if touch "$TEST_FILE" 2>/dev/null && rm "$TEST_FILE" 2>/dev/null; then
    check_pass "Storage writable"
else
    check_fail "Storage NOT writable"
fi

# === 5. CACHE WRITABLE ===
echo "5️⃣  Checking cache permissions..."
TEST_CACHE="bootstrap/cache/healthcheck_test.txt"
if touch "$TEST_CACHE" 2>/dev/null && rm "$TEST_CACHE" 2>/dev/null; then
    check_pass "Cache writable"
else
    check_fail "Cache NOT writable"
fi

# === 6. HTTP RESPONSE ===
echo "6️⃣  Checking HTTP response..."
HTTP_CODE=$(curl -s -o /dev/null -w "%{http_code}" "${APP_URL}/up")
if [ "$HTTP_CODE" = "200" ]; then
    check_pass "HTTP health endpoint responding (200 OK)"
else
    check_fail "HTTP health endpoint returned $HTTP_CODE"
fi

# === 7. HTTPS (if configured) ===
echo "7️⃣  Checking HTTPS..."
HTTPS_URL=${APP_URL/http:\/\//https:\/\/}
if curl -s -f "$HTTPS_URL" &> /dev/null; then
    check_pass "HTTPS configured and working"
else
    echo -e "${YELLOW}⚠${NC} HTTPS not configured or not accessible"
fi

# === 8. QUEUE WORKERS ===
echo "8️⃣  Checking queue workers..."
if command -v supervisorctl &> /dev/null; then
    RUNNING_WORKERS=$(supervisorctl status | grep -c "RUNNING" || echo "0")
    if [ "$RUNNING_WORKERS" -gt 0 ]; then
        check_pass "Queue workers running ($RUNNING_WORKERS active)"
    else
        check_fail "No queue workers running"
    fi
else
    echo -e "${YELLOW}⚠${NC} Supervisor not installed"
fi

# === 9. DISK SPACE ===
echo "9️⃣  Checking disk space..."
DISK_USAGE=$(df -h / | awk 'NR==2 {print $5}' | sed 's/%//')
if [ "$DISK_USAGE" -lt 80 ]; then
    check_pass "Disk space OK (${DISK_USAGE}% used)"
elif [ "$DISK_USAGE" -lt 90 ]; then
    echo -e "${YELLOW}⚠${NC} Disk space warning (${DISK_USAGE}% used)"
else
    check_fail "Disk space critical (${DISK_USAGE}% used)"
fi

# === 10. LOG FILES ===
echo "🔟 Checking log files..."
if [ -f "storage/logs/laravel.log" ]; then
    LOG_SIZE=$(du -h storage/logs/laravel.log | awk '{print $1}')
    check_pass "Log file exists ($LOG_SIZE)"
else
    check_fail "Log file not found"
fi

# === 11. ENV FILE ===
echo "1️⃣1️⃣  Checking .env configuration..."
if [ -f ".env" ]; then
    if grep -q "APP_ENV=production" .env; then
        check_pass ".env configured for production"
    else
        check_fail ".env NOT configured for production"
    fi
    
    if grep -q "APP_DEBUG=false" .env; then
        check_pass "APP_DEBUG=false (secure)"
    else
        check_fail "APP_DEBUG=true (INSECURE!)"
    fi
else
    check_fail ".env file not found"
fi

# === 12. ARTISAN OPTIMIZE STATUS ===
echo "1️⃣2️⃣  Checking Laravel optimizations..."
if [ -f "bootstrap/cache/config.php" ]; then
    check_pass "Config cached"
else
    check_fail "Config NOT cached (run: php artisan config:cache)"
fi

if [ -f "bootstrap/cache/routes-v7.php" ]; then
    check_pass "Routes cached"
else
    check_fail "Routes NOT cached (run: php artisan route:cache)"
fi

# === SUMMARY ===
echo ""
echo "======================================"
echo "HEALTH CHECK SUMMARY"
echo "======================================"
echo -e "${GREEN}Passed: $PASSED${NC}"
echo -e "${RED}Failed: $FAILED${NC}"
echo ""

if [ $FAILED -eq 0 ]; then
    echo -e "${GREEN}✅ ALL CHECKS PASSED${NC}"
    echo "System is healthy and ready for production!"
    exit 0
else
    echo -e "${RED}❌ SOME CHECKS FAILED${NC}"
    echo "Please review and fix the issues above."
    exit 1
fi
