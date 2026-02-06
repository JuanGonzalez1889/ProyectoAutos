# ✅ Runbooks (Operación)

## 1) Deploy
- Usar `deploy.sh`
- Verificar `/up` y `health-check.sh`

## 2) Rollback
- Usar `rollback.sh`
- Verificar `/up`

## 3) Incidentes
- Revisar `storage/logs/laravel.log`
- Ver Sentry/Bugsnag
- Reiniciar workers: `supervisorctl restart laravel-worker:*`

## 4) Backups
- Verificar últimos backups en S3
- Probar restore mensual
