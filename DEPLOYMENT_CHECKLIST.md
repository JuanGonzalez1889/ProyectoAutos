# 🚀 Checklist de Deployment - AutoWeb Pro

## ✅ PRE-DEPLOYMENT

### 1. Preparación del Código
- [ ] Todos los tests pasan: `php artisan test`
- [ ] No hay errores de linting: `composer check-style`
- [ ] Assets compilados para producción: `npm run build`
- [ ] Dependencias actualizadas: `composer update --no-dev`
- [ ] `.env.example` actualizado con todas las variables necesarias
- [ ] Archivo `.env.production.example` creado y documentado

### 2. Configuración del Repositorio
- [ ] Código pusheado a repositorio Git (GitHub/GitLab/Bitbucket)
- [ ] `.gitignore` incluye: `.env`, `node_modules`, `vendor`, `storage`, `public/storage`
- [ ] Branch `main` o `production` creado
- [ ] Tags versionados creados: `git tag v1.0.0`

### 3. Base de Datos
- [ ] Backup de base de datos de desarrollo creado
- [ ] Migraciones revisadas y probadas
- [ ] Seeders de producción preparados (si aplican)
- [ ] Índices de base de datos optimizados
- [ ] Verificar que no hay migraciones con `DB::statement()` que puedan fallar

## 🖥️ CONFIGURACIÓN DEL SERVIDOR

### 4. Servidor Web (VPS/Cloud)
**Opción A: Laravel Forge (Recomendado)**
- [ ] Cuenta de Laravel Forge creada
- [ ] Servidor provisionado (DigitalOcean/Linode/AWS)
- [ ] PHP 8.2+ instalado
- [ ] MySQL 8.0+ / PostgreSQL instalado
- [ ] Redis instalado
- [ ] Composer instalado
- [ ] Node.js 18+ y NPM instalados

**Opción B: Configuración Manual**
- [ ] Nginx/Apache configurado
- [ ] PHP-FPM configurado
- [ ] Extensiones PHP instaladas: `bcmath`, `ctype`, `fileinfo`, `json`, `mbstring`, `openssl`, `pdo`, `tokenizer`, `xml`, `curl`, `gd`, `zip`
- [ ] Límites PHP ajustados: `upload_max_filesize=20M`, `post_max_size=20M`, `memory_limit=256M`

### 5. SSL/HTTPS
- [ ] Certificado SSL instalado (Let's Encrypt recomendado)
- [ ] Renovación automática configurada: `certbot renew --dry-run`
- [ ] Redirección HTTP → HTTPS configurada en Nginx/Apache
- [ ] HSTS habilitado en configuración web
- [ ] Verificar SSL con: https://www.ssllabs.com/ssltest/

### 6. Nginx Configuration (Ejemplo)
```nginx
server {
    listen 80;
    listen [::]:80;
    server_name autowebpro.com www.autowebpro.com;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    listen [::]:443 ssl http2;
    server_name autowebpro.com www.autowebpro.com;

    root /var/www/autowebpro/public;
    index index.php index.html;

    ssl_certificate /etc/letsencrypt/live/autowebpro.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/autowebpro.com/privkey.pem;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

## 🔧 DEPLOYMENT DEL CÓDIGO

### 7. Clonar Repositorio
```bash
cd /var/www
git clone https://github.com/tu-usuario/autowebpro.git
cd autowebpro
```

### 8. Configurar Variables de Entorno
```bash
cp .env.production.example .env
nano .env  # Editar con valores reales
php artisan key:generate
```

### 9. Instalar Dependencias
```bash
composer install --optimize-autoloader --no-dev
npm install
npm run build
```

### 10. Configurar Permisos
```bash
sudo chown -R www-data:www-data /var/www/autowebpro
sudo chmod -R 755 /var/www/autowebpro
sudo chmod -R 775 storage bootstrap/cache
```

### 11. Ejecutar Migraciones
```bash
php artisan migrate --force
php artisan db:seed --class=ProductionSeeder  # Si aplica
```

### 12. Optimizar Aplicación
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

### 13. Storage Link
```bash
php artisan storage:link
```

## ⚙️ CONFIGURACIÓN DE SERVICIOS

### 14. Queue Workers (Supervisor)
Crear: `/etc/supervisor/conf.d/autowebpro-worker.conf`
```ini
[program:autowebpro-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/autowebpro/artisan queue:work redis --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/autowebpro/storage/logs/worker.log
stopwaitsecs=3600
```

Activar:
```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start autowebpro-worker:*
```

### 15. Cron Jobs
Editar: `sudo crontab -e -u www-data`
```cron
# Laravel Scheduler
* * * * * cd /var/www/autowebpro && php artisan schedule:run >> /dev/null 2>&1

# Backups diarios a las 2 AM
0 2 * * * cd /var/www/autowebpro && php artisan backup:run --only-db
0 3 * * 0 cd /var/www/autowebpro && php artisan backup:run  # Backup completo semanal

# Limpiar backups antiguos
0 4 * * * cd /var/www/autowebpro && php artisan backup:clean

# Generar sitemap diario
0 5 * * * cd /var/www/autowebpro && php artisan sitemap:generate
```

### 16. Log Rotation
Crear: `/etc/logrotate.d/autowebpro`
```
/var/www/autowebpro/storage/logs/*.log {
    daily
    missingok
    rotate 14
    compress
    delaycompress
    notifempty
    create 0644 www-data www-data
    sharedscripts
}
```

## 🔐 SEGURIDAD

### 17. Firewall
```bash
sudo ufw allow 22/tcp    # SSH
sudo ufw allow 80/tcp    # HTTP
sudo ufw allow 443/tcp   # HTTPS
sudo ufw enable
```

### 18. Fail2ban (Opcional)
```bash
sudo apt install fail2ban
sudo systemctl enable fail2ban
sudo systemctl start fail2ban
```

### 19. Seguridad de Base de Datos
- [ ] Usuario de BD con permisos mínimos (no root)
- [ ] Contraseña fuerte generada
- [ ] Acceso remoto restringido (solo desde servidor web)
- [ ] Backups automáticos configurados

## 📊 MONITORING & LOGGING

### 20. Monitoring de Uptime
- [ ] UptimeRobot configurado: https://uptimerobot.com
- [ ] Pingdom configurado (alternativa): https://www.pingdom.com
- [ ] Alertas por email/SMS configuradas

### 21. Error Tracking
**Sentry (Recomendado)**
```bash
composer require sentry/sentry-laravel
php artisan vendor:publish --provider="Sentry\Laravel\ServiceProvider"
```

Agregar a `.env`:
```
SENTRY_LARAVEL_DSN=https://xxxxx@sentry.io/xxxxx
```

### 22. Application Performance Monitoring
- [ ] New Relic configurado (opcional)
- [ ] Laravel Telescope instalado en staging (NO en producción)

### 23. Log Aggregation
- [ ] Papertrail configurado para logs centralizados
- [ ] Loggly configurado (alternativa)

## 💳 PAYMENT GATEWAYS

### 24. Stripe
- [ ] Cuenta de Stripe en modo LIVE
- [ ] Claves LIVE copiadas a `.env`
- [ ] Webhook endpoint configurado: `https://autowebpro.com/webhooks/stripe`
- [ ] Eventos de webhook seleccionados: `checkout.session.completed`, `invoice.payment_failed`, `customer.subscription.deleted`
- [ ] Webhook secret copiado a `STRIPE_WEBHOOK_SECRET`
- [ ] Test de pago con tarjeta real en modo live

### 25. MercadoPago
- [ ] Cuenta de MercadoPago en modo PRODUCCIÓN
- [ ] Credenciales PROD copiadas a `.env`
- [ ] Webhook configurado: `https://autowebpro.com/webhooks/mercadopago`
- [ ] URL de retorno configurada
- [ ] Test de pago con cuenta real en producción

## 🌐 DNS & DOMAINS

### 26. Configuración de DNS
- [ ] Dominio principal apuntando a IP del servidor
  - Tipo: A Record
  - Host: @
  - Value: IP_DEL_SERVIDOR
  - TTL: 3600

- [ ] Subdominio www configurado
  - Tipo: CNAME
  - Host: www
  - Value: autowebpro.com
  - TTL: 3600

- [ ] Wildcard para subdominios de tenants (opcional)
  - Tipo: A Record
  - Host: *
  - Value: IP_DEL_SERVIDOR
  - TTL: 3600

### 27. Email DNS (SPF, DKIM, DMARC)
- [ ] SPF record configurado
  - Tipo: TXT
  - Host: @
  - Value: `v=spf1 include:_spf.sendgrid.net ~all`

- [ ] DKIM configurado (desde SendGrid/Mailgun)
- [ ] DMARC configurado
  - Tipo: TXT
  - Host: _dmarc
  - Value: `v=DMARC1; p=quarantine; rua=mailto:admin@autowebpro.com`

## 🧪 POST-DEPLOYMENT TESTING

### 28. Tests Funcionales
- [ ] Registro de usuario funciona
- [ ] Login funciona
- [ ] Creación de tenant funciona
- [ ] Subida de imágenes a S3 funciona
- [ ] Emails se envían correctamente
- [ ] Google OAuth funciona
- [ ] reCAPTCHA valida correctamente

### 29. Tests de Pagos
- [ ] Checkout con Stripe funciona (tarjeta real)
- [ ] Checkout con MercadoPago funciona (cuenta real)
- [ ] Webhooks de Stripe se reciben
- [ ] Webhooks de MercadoPago se reciben
- [ ] Subscripciones se activan correctamente
- [ ] Emails de confirmación se envían

### 30. Tests de Performance
- [ ] Tiempo de carga < 3 segundos
- [ ] PageSpeed Insights > 80
- [ ] GTmetrix Grade A
- [ ] Lighthouse Performance > 80

## 📝 DOCUMENTACIÓN

### 31. Documentación Interna
- [ ] README.md actualizado con instrucciones de deployment
- [ ] Changelog creado: `CHANGELOG.md`
- [ ] Guía de usuario creada
- [ ] API documentation generada (si aplica)

### 32. Credenciales Seguras
- [ ] Todas las credenciales guardadas en 1Password/LastPass
- [ ] Accesos SSH documentados
- [ ] Credenciales de base de datos documentadas
- [ ] API keys de servicios externos documentadas

## 🎯 GO LIVE

### 33. Launch
- [ ] DNS propagado (verificar con: https://www.whatsmydns.net)
- [ ] Sitio accesible desde múltiples ubicaciones
- [ ] Todos los tests pasando
- [ ] Backups automáticos funcionando
- [ ] Monitoring activo

### 34. Marketing Launch
- [ ] Landing page lista
- [ ] Google Analytics activo
- [ ] Pixels de Facebook/LinkedIn instalados (si aplica)
- [ ] Email de lanzamiento enviado
- [ ] Redes sociales anunciadas

## 📞 SOPORTE POST-LAUNCH

### 35. Primeras 24 Horas
- [ ] Monitorear logs cada 2 horas
- [ ] Verificar queue workers funcionando
- [ ] Revisar emails enviados exitosamente
- [ ] Verificar transacciones de pago
- [ ] Responder a usuarios reportando issues

### 36. Primera Semana
- [ ] Revisar analytics diariamente
- [ ] Optimizar performance basado en métricas
- [ ] Corregir bugs críticos inmediatamente
- [ ] Actualizar documentación según feedback

## ✅ CHECKLIST COMPLETADO

**Fecha de Deployment:** _______________

**Deployed by:** _______________

**Versión:** v1.0.0

**Status:** [ ] Dev [ ] Staging [ ] Production

---

## 🆘 ROLLBACK PLAN

En caso de problemas críticos:

```bash
# 1. Volver a versión anterior
cd /var/www/autowebpro
git checkout tags/v1.0.0-previous

# 2. Reinstalar dependencias
composer install --no-dev
npm install && npm run build

# 3. Limpiar cachés
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# 4. Re-optimizar
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 5. Restaurar base de datos (si necesario)
php artisan backup:restore --backup=nombre-del-backup.zip

# 6. Reiniciar servicios
sudo supervisorctl restart autowebpro-worker:*
sudo systemctl restart nginx
sudo systemctl restart php8.2-fpm
```

## 📚 RECURSOS ADICIONALES

- Laravel Deployment: https://laravel.com/docs/deployment
- Laravel Forge: https://forge.laravel.com
- Server Configuration: https://serversforhackers.com
- Stripe Testing: https://stripe.com/docs/testing
- SSL Setup: https://certbot.eff.org
