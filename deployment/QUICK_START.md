# 🚀 QUICK START - DEPLOYMENT A PRODUCCIÓN

## 📋 Checklist Rápido

### ✅ Antes de Empezar
- [ ] Servidor Linux (Ubuntu 20.04+ o similar)
- [ ] Acceso SSH con privilegios sudo
- [ ] Dominio configurado apuntando al servidor
- [ ] Credenciales de producción (Stripe, MercadoPago, etc.)

---

## 🛠️ INSTALACIÓN RÁPIDA (30 minutos)

### 1️⃣ Instalar Software Base
```bash
# Actualizar sistema
sudo apt update && sudo apt upgrade -y

# Instalar dependencias
sudo apt install -y nginx mysql-server redis-server php8.2-fpm php8.2-mysql \
    php8.2-redis php8.2-xml php8.2-mbstring php8.2-curl php8.2-zip \
    git composer supervisor certbot python3-certbot-nginx
```

### 2️⃣ Configurar Base de Datos
```bash
# Crear base de datos
sudo mysql -u root -p
```
```sql
CREATE DATABASE proyecto_autos_prod CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'autoweb_user'@'localhost' IDENTIFIED BY 'PASSWORD_SEGURO_AQUI';
GRANT ALL PRIVILEGES ON proyecto_autos_prod.* TO 'autoweb_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### 3️⃣ Clonar Proyecto
```bash
cd /var/www
sudo git clone https://github.com/tu-usuario/autoweb-pro.git
cd autoweb-pro
```

### 4️⃣ Configurar .env
```bash
cp .env.production.example .env
nano .env  # Editar con tus credenciales
php artisan key:generate
```

### 5️⃣ Instalar y Configurar
```bash
# Composer
composer install --no-dev --optimize-autoloader

# NPM
npm ci
npm run build

# Migraciones
php artisan migrate --force --seed

# Permisos
sudo chown -R www-data:www-data /var/www/autoweb-pro
sudo chmod -R 775 storage bootstrap/cache

# Optimizaciones
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link
```

### 6️⃣ Configurar Nginx
```bash
sudo cp deployment/configs/nginx.conf /etc/nginx/sites-available/autoweb-pro
sudo ln -s /etc/nginx/sites-available/autoweb-pro /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

### 7️⃣ Configurar SSL (Let's Encrypt)
```bash
sudo certbot --nginx -d tudominio.com -d www.tudominio.com
```

### 8️⃣ Configurar Queue Workers
```bash
sudo cp deployment/configs/supervisor.conf /etc/supervisor/conf.d/laravel-worker.conf
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start laravel-worker:*
```

### 9️⃣ Configurar Cron
```bash
sudo crontab -e -u www-data
# Pegar contenido de deployment/configs/crontab
```

### 🔟 Verificar Health Check
```bash
chmod +x health-check.sh
./health-check.sh
```

---

## 📦 DEPLOYMENTS SUBSECUENTES

```bash
# Hacer ejecutables los scripts (solo primera vez)
chmod +x deploy.sh rollback.sh health-check.sh

# Deploy
./deploy.sh

# Si algo falla, rollback
./rollback.sh
```

---

## 🔧 COMANDOS ÚTILES

### Ver Logs
```bash
tail -f storage/logs/laravel.log
tail -f /var/log/nginx/autoweb-error.log
sudo supervisorctl tail -f laravel-worker:laravel-worker_00
```

### Reiniciar Servicios
```bash
sudo systemctl restart nginx
sudo systemctl restart php8.2-fpm
sudo supervisorctl restart laravel-worker:*
```

### Limpiar Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Monitorear Queue
```bash
php artisan queue:monitor
php artisan queue:work --once  # Procesar un job
```

---

## 🆘 SOLUCIÓN DE PROBLEMAS

### Error 500 - Internal Server Error
```bash
# 1. Revisar logs
tail -50 storage/logs/laravel.log

# 2. Verificar permisos
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache

# 3. Limpiar cache
php artisan config:clear
```

### Queue no procesa jobs
```bash
# Verificar workers
sudo supervisorctl status

# Reiniciar workers
sudo supervisorctl restart laravel-worker:*

# Ver logs de workers
sudo supervisorctl tail -f laravel-worker:laravel-worker_00
```

### Nginx no inicia
```bash
# Testear configuración
sudo nginx -t

# Ver errores
sudo systemctl status nginx
sudo tail -50 /var/log/nginx/error.log
```

---

## 📞 SOPORTE

Para más detalles, consultar:
- **PRODUCTION_READINESS_ANALYSIS.md** - Análisis completo de seguridad y performance
- **deployment/configs/** - Archivos de configuración completos

---

**¡Listo para producción! 🎉**
