# ✅ Post‑Deploy Tests (Bloqueante)

> Ejecutar en producción/staging apenas se despliega.

## 1) Smoke test básico
- [ ] Home pública carga (dominio principal)
- [ ] `/up` responde 200
- [ ] Login / Logout funcionan

## 2) Registro y Tenancy
- [ ] Registro de agencia OK
- [ ] Dominio generado OK
- [ ] Admin creado con rol ADMIN
- [ ] Panel admin accesible

## 3) Storage y uploads
- [ ] Subida de imágenes (S3) OK
- [ ] Imágenes visibles desde CDN/S3

## 4) Emails
- [ ] Email de bienvenida OK
- [ ] Email de confirmación de suscripción OK

## 5) OAuth / reCAPTCHA
- [ ] Google OAuth login OK
- [ ] reCAPTCHA valida OK (registro/contacto)

## 6) Pagos
- [ ] Stripe checkout live OK
- [ ] MercadoPago pago live OK
- [ ] Webhooks Stripe recibidos OK
- [ ] Webhooks MercadoPago recibidos OK

## 7) Scoping
- [ ] Tenant A no ve datos de Tenant B

---

### Referencias
- Guía general: TESTING.md
- Health check: health-check.sh
