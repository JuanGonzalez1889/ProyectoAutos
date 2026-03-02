# Checklist Sandbox: Suscripción Mensual Automática (Mercado Pago)

Fecha: 2026-03-02

## 1) Pre-requisitos

- [ ] Tener configuradas estas variables en `.env`:
  - `MERCADOPAGO_ACCESS_TOKEN`
  - `MERCADOPAGO_PUBLIC_KEY`
  - `MERCADOPAGO_WEBHOOK_SECRET` (obligatoria en producción)
  - `APP_URL` apuntando a URL pública (si usás webhook desde internet)
- [ ] Tener un usuario autenticado con `tenant_id` válido.
- [ ] Tener al menos un plan disponible (`basico`, `profesional`, `premium`, `premium_plus`, `test100`).

## 2) Configurar webhook en Mercado Pago

- [ ] URL webhook: `https://TU_DOMINIO/webhooks/mercadopago`
- [ ] Tópicos/eventos activos:
  - `payment`
  - `preapproval` (o equivalente de suscripciones en tu panel)

## 3) Alta de suscripción automática

- [ ] Ir a `/subscriptions` y elegir plan.
- [ ] Confirmar que redirige a checkout de suscripción (preapproval/init_point).
- [ ] Completar autorización en sandbox.

Resultado esperado:
- [ ] Se crea/actualiza registro en `subscriptions` con:
  - `payment_method = mercadopago`
  - `mercadopago_id` con ID de preapproval
  - `status = active` (cuando quede autorizada)
  - `current_period_end` con próxima renovación
- [ ] En `tenants` se actualiza:
  - `plan`
  - `subscription_ends_at`

## 4) Verificar cobro y factura

- [ ] Recibir webhook `payment` aprobado.
- [ ] Se genera factura en `invoices` con:
  - `mercadopago_invoice_id` (id del pago)
  - `status = paid`
  - `payment_method = mercadopago`

## 5) Verificar renovación automática

- [ ] Esperar siguiente ciclo mensual real en sandbox.
- [ ] Confirmar nuevo webhook `payment` aprobado.
- [ ] Validar que:
  - Se crea nueva factura (sin duplicar `mercadopago_invoice_id`)
  - `current_period_end` avanza +1 mes
  - `tenant.subscription_ends_at` se extiende al nuevo período

## 6) Cancelación desde tu panel

- [ ] En `/subscriptions/billing`, ejecutar “cancelar suscripción”.

Resultado esperado:
- [ ] Se envía cancelación a Mercado Pago (`preapproval` -> `cancelled`).
- [ ] En BD queda:
  - `status = canceled`
  - `mercadopago_status = cancelled`
  - `canceled_at` con fecha/hora

## 7) Logs útiles para diagnóstico

Buscar en logs:
- `MP_DEBUG_CREATE_PREF`
- `MP_DEBUG_PAYLOAD`
- `MP_DEBUG_PREF_RESPONSE`
- `MP_DEBUG_PREAPPROVAL_PROCESSED`
- `MP_DEBUG_WEBHOOK_APPROVED_START`
- `MP_DEBUG_WEBHOOK_SUBSCRIPTION`
- `MP_DEBUG_WEBHOOK_INVOICE`

## 8) Casos de error a probar

- [ ] Webhook con firma inválida en producción (debe rechazar con 401).
- [ ] Pago rechazado (`status = rejected`) y verificar log de rechazo.
- [ ] `external_reference` inválido/sin `tenant_id` (debe loguear warning/error y no romper).

## 9) SQL de verificación rápida

```sql
-- Suscripción activa o última del tenant
SELECT id, tenant_id, mercadopago_id, mercadopago_status, plan, status, current_period_start, current_period_end, canceled_at
FROM subscriptions
WHERE tenant_id = 'TU_TENANT_ID'
ORDER BY id DESC;

-- Facturas del tenant
SELECT id, tenant_id, subscription_id, mercadopago_invoice_id, total, status, paid_at, created_at
FROM invoices
WHERE tenant_id = 'TU_TENANT_ID'
ORDER BY id DESC;

-- Estado resumido del tenant
SELECT id, plan, subscription_ends_at
FROM tenants
WHERE id = 'TU_TENANT_ID';
```

## 10) Suite de casos negativos (go-live)

Objetivo: validar resiliencia sin cambiar código del flujo actual.

### Caso N1: firma webhook inválida (solo producción)

- [ ] Ejecutar (contra URL productiva):

```powershell
powershell -ExecutionPolicy Bypass -File .\scripts\test_mp_webhook_signature.ps1 `
  -Url "https://TU_DOMINIO/webhooks/mercadopago" `
  -Secret "TU_MERCADOPAGO_WEBHOOK_SECRET" `
  -Type "payment" `
  -DataId "123456789" `
  -RequestId "neg-signature-001" `
  -InvalidSignature
```

Esperado:
- [ ] HTTP 401
- [ ] Log de firma inválida
- [ ] Sin cambios en `subscriptions`, `tenants`, `invoices`

### Caso N2: webhook duplicado del mismo pago

- [ ] Enviar dos veces el mismo webhook `payment` con mismo `DataId`.

Esperado:
- [ ] No duplicar factura con mismo `mercadopago_invoice_id`
- [ ] No adelantar dos veces `current_period_end`
- [ ] Mantener consistencia del tenant

### Caso N3: evento fuera de orden

- [ ] Enviar `payment` antes de `preapproval` para el mismo tenant.

Esperado:
- [ ] No romper flujo (sin excepción fatal)
- [ ] Al llegar `preapproval`, reconciliación deja estado consistente
- [ ] Sin tenant incorrecto afectado

### Caso N4: `external_reference` inválido o sin `tenant_id`

- [ ] Probar webhook/evento con `external_reference` vacío o JSON inválido.

Esperado:
- [ ] Warning/Error en logs
- [ ] Sin cambios destructivos en datos de otro tenant

### Caso N5: pago rechazado y reintento

- [ ] Simular rechazo (`status=rejected`) y luego ejecutar reintento desde UI.

Esperado:
- [ ] Suscripción queda en estado pausado/pending tras rechazo
- [ ] Se crea factura fallida
- [ ] Reintento exitoso vuelve a `active` y extiende período

### Caso N6: API Mercado Pago intermitente (500/timeout)

- [ ] Forzar situación de error temporal (sandbox) y luego correr reconciliación.

Comando:

```powershell
php artisan subscriptions:reconcile-mercadopago --tenantId=TU_TENANT_ID
```

Esperado:
- [ ] Sin corrupción de estado local
- [ ] Recuperación al próximo ciclo cuando MP responde
- [ ] Logs con error controlado + posterior normalización

### Criterio de aprobación de negativos

- [ ] Ningún caso rompe checkout ni webhook
- [ ] No hay duplicados de facturas por mismo `mercadopago_invoice_id`
- [ ] No hay extensión duplicada de período por un solo evento
- [ ] Todos los errores quedan logueados y recuperables por reconciliación
