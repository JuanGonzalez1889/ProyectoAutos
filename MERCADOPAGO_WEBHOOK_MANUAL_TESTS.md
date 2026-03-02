# Pruebas manuales de webhook firmado (PowerShell)

Script: [scripts/test_mp_webhook_signature.ps1](scripts/test_mp_webhook_signature.ps1)

## 1) Prueba válida (esperado 200)

```powershell
powershell -ExecutionPolicy Bypass -File .\scripts\test_mp_webhook_signature.ps1 `
  -Url "http://127.0.0.1:8000/webhooks/mercadopago" `
  -Secret "TU_MERCADOPAGO_WEBHOOK_SECRET" `
  -Type "payment" `
  -DataId "123456789" `
  -RequestId "req-valid-001"
```

## 2) Prueba inválida (esperado 401 en producción)

```powershell
powershell -ExecutionPolicy Bypass -File .\scripts\test_mp_webhook_signature.ps1 `
  -Url "https://TU_DOMINIO/webhooks/mercadopago" `
  -Secret "TU_MERCADOPAGO_WEBHOOK_SECRET" `
  -Type "payment" `
  -DataId "123456789" `
  -RequestId "req-invalid-001" `
  -InvalidSignature
```

## 3) Evento de suscripción automática (preapproval)

```powershell
powershell -ExecutionPolicy Bypass -File .\scripts\test_mp_webhook_signature.ps1 `
  -Url "http://127.0.0.1:8000/webhooks/mercadopago" `
  -Secret "TU_MERCADOPAGO_WEBHOOK_SECRET" `
  -Type "preapproval" `
  -DataId "2c9380847e9b451c017ea1bd70ba0219" `
  -RequestId "req-preapproval-001"
```

## 4) Si Mercado Pago envía `topic` en vez de `type`

```powershell
powershell -ExecutionPolicy Bypass -File .\scripts\test_mp_webhook_signature.ps1 `
  -Url "http://127.0.0.1:8000/webhooks/mercadopago" `
  -Secret "TU_MERCADOPAGO_WEBHOOK_SECRET" `
  -Type "payment" `
  -DataId "123456789" `
  -RequestId "req-topic-001" `
  -UseTopic
```

## Resultado esperado

- Ambiente local/no producción: puede procesar aunque falle firma (según configuración actual del backend).
- Producción: firma inválida debe devolver 401.
- Firma válida: debe devolver 200 y ejecutar lógica de webhook.

## 5) Verificar impacto en base por tenant

```powershell
php .\scripts\verify_mp_state.php TU_TENANT_ID
```

Salida esperada:
- Bloque `TENANT` con `plan` y `subscription_ends_at` actualizado.
- Bloque `SUSCRIPCIÓN MP` con `mercadopago_id` (preapproval) y estado.
- Bloque `FACTURAS MP` con los últimos cobros de Mercado Pago.
