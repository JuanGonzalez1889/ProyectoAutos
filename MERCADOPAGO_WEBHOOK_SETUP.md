# Configuración de Webhook Mercado Pago (Sandbox y Producción)

Fecha: 2026-03-02

Este proyecto ya procesa webhooks de Mercado Pago en:

- POST /webhooks/mercadopago

Eventos contemplados en backend:

- payment
- preapproval (suscripción automática)

## 1) Variables de entorno obligatorias

Definir en .env:

- MERCADOPAGO_PUBLIC_KEY
- MERCADOPAGO_ACCESS_TOKEN
- MERCADOPAGO_WEBHOOK_SECRET
- APP_URL

Notas:

- En producción, la firma del webhook es obligatoria.
- En entorno local, el backend permite bypass de firma para facilitar pruebas.

## 2) Configuración en panel de Mercado Pago

1. Ir al panel de desarrollador de Mercado Pago.
2. Abrir tu aplicación (sandbox o producción).
3. Configurar notificaciones/webhooks.
4. URL de notificación:

   https://TU_DOMINIO/webhooks/mercadopago

5. Activar eventos:

   - payment
   - preapproval

6. Guardar el secreto de firma y copiarlo a MERCADOPAGO_WEBHOOK_SECRET.

## 3) Checklist rápido de conectividad

- Verificar que tu endpoint responde 200 en eventos válidos.
- Verificar que Mercado Pago marca el envío como exitoso.
- Revisar logs de aplicación al recibir webhooks.

## 4) Cómo valida firma este backend

El backend espera headers:

- X-Signature
- X-Request-Id

Y usa la cadena:

id:{data.id};request-id:{x-request-id};ts:{ts};

con HMAC SHA256 usando MERCADOPAGO_WEBHOOK_SECRET.

Por eso, si falla firma en producción, revisar:

- Que el secreto sea el correcto del mismo ambiente.
- Que la URL configurada corresponda exactamente al endpoint final.
- Que llegue data.id en el payload de Mercado Pago.

## 5) Prueba recomendada sandbox

1. Crear suscripción desde /subscriptions.
2. Autorizar en checkout de Mercado Pago.
3. Confirmar webhook preapproval recibido y suscripción actualizada.
4. Confirmar webhook payment aprobado y factura creada.

## 6) Comportamiento esperado por ambiente

- Local/dev:
  - Firma no bloquea procesamiento si APP_ENV no es production.
- Producción:
  - Firma inválida devuelve 401 y no procesa evento.

## 7) Troubleshooting

Si no impacta la base:

- Verificar APP_URL público y accesible desde internet.
- Confirmar que no hay proxy/firewall bloqueando POST.
- Confirmar que el topic de webhook coincide con payment o preapproval.
- Revisar logs por mensajes MP_DEBUG_ y Mercadopago webhook failed.
