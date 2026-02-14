# Checklist para pasar MercadoPago a producción

## 1. Variables de entorno (.env)
- [ ] Cambiar `APP_URL` al dominio real de producción (ej: https://tudominio.com)
- [ ] Cambiar `APP_ENV=production`
- [ ] Cambiar `APP_DEBUG=false`
- [ ] Usar claves reales de producción:
    - [ ] `MERCADOPAGO_PUBLIC_KEY=APP_USR-...`
    - [ ] `MERCADOPAGO_ACCESS_TOKEN=APP_USR-...`
    - [ ] `MERCADOPAGO_WEBHOOK_SECRET=...` (si aplica)

## 2. Código fuente
- [ ] Quitar emails de test en los controladores y servicios, usar el email real del usuario:
    - [ ] En `MercadoPagoController` y `MercadoPagoService`, reemplazar `TESTUSER...` por el email real del usuario.
- [ ] Verificar que la URL de notificación apunte a `/webhooks/mercadopago` en el dominio real.

## 3. Webhooks
- [ ] Configurar el webhook en el panel de MercadoPago:
    - [ ] URL: `https://tudominio.com/webhooks/mercadopago`
    - [ ] Verificar que el secreto (si se usa) coincida con el de `.env`
- [ ] Probar que MercadoPago pueda acceder al webhook (sin errores 403/500)

## 4. Seguridad y logs
- [ ] Revisar que los logs no expongan datos sensibles en producción.
- [ ] Revisar permisos de archivos y carpetas.

## 5. Pruebas
- [ ] Realizar pagos reales con montos bajos.
- [ ] Verificar que los pagos se acrediten y los webhooks funcionen.
- [ ] Verificar emails/notificaciones al usuario.

## 6. Limpieza y optimización
- [ ] Limpiar cachés:
    - [ ] `php artisan config:clear`
    - [ ] `php artisan cache:clear`
    - [ ] `php artisan route:clear`
    - [ ] `php artisan view:clear`
    - [ ] `composer dump-autoload`
- [ ] Optimizar:
    - [ ] `php artisan config:cache`
    - [ ] `php artisan route:cache`
    - [ ] `php artisan view:cache`
    - [ ] `php artisan optimize`

## 7. Otros
- [ ] Documentar el proceso para el equipo.
- [ ] Hacer backup antes del deploy.

---

**Notas:**
- No olvides revisar la documentación oficial de MercadoPago para cambios recientes.
- Si usas Docker o CI/CD, asegúrate de que las variables de entorno estén correctamente seteadas en el entorno de producción.
