# ✅ Observabilidad - Checklist (HOY)

## 1) Error Tracking (Sentry/Bugsnag)
- [ ] Crear proyecto en Sentry (o Bugsnag/Rollbar).
- [ ] Copiar DSN en `.env`:
  - `SENTRY_LARAVEL_DSN=...`
- [ ] (Si se usa Sentry) instalar paquete:
  - `composer require sentry/sentry-laravel`
  - `php artisan sentry:publish`

## 2) Uptime Monitoring
- [ ] Configurar UptimeRobot/Pingdom con URL pública.
- [ ] Alertas email/SMS activas.

## 3) Log Rotation
- [ ] Instalar configuración de logrotate del repo:
  - `deployment/configs/logrotate.conf` → `/etc/logrotate.d/autoweb-pro`
- [ ] Verificar rotación con `logrotate -f`.

## 4) Log Level en producción
- [ ] `LOG_CHANNEL=daily`
- [ ] `LOG_LEVEL=warning`

---

### Archivos de referencia
- Config logging: config/logging.php
- Logrotate: deployment/configs/logrotate.conf
