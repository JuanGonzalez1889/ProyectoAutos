# ✅ Infraestructura Base - Checklist Bloqueante (HOY)

## 1) SSL/HTTPS + HSTS
- [ ] Certificado SSL emitido (Let's Encrypt o proveedor).
- [ ] HTTPS activo en dominio raíz + www + wildcard de subdominios.
- [ ] Redirección HTTP → HTTPS activa.
- [ ] HSTS activo (1 año) con subdominios.

## 2) Firewall y SSH
- [ ] UFW (o firewall equivalente) habilitado.
- [ ] Solo puertos 22, 80, 443 abiertos.
- [ ] Acceso SSH root deshabilitado.
- [ ] Usuario no-root con sudo creado y probado.
- [ ] Fail2ban activo (opcional pero recomendado).

## 3) Nginx/Apache + PHP-FPM
- [ ] Nginx configurado con server_name raíz, www y wildcard.
- [ ] PHP-FPM activo y pool optimizado.
- [ ] Client max body size 20M.
- [ ] Compresión gzip activa.
- [ ] Cache headers para assets.

## 4) Supervisor + Cron
- [ ] Supervisor instalado y workers activos (redis).
- [ ] Cron del scheduler activo (cada minuto).

## 5) Verificación final
- [ ] `/up` responde 200 en HTTPS.
- [ ] `health-check.sh` pasa (sin fallas críticas).

---

### Archivos de referencia en el repo
- Nginx: deployment/configs/nginx.conf
- Supervisor: deployment/configs/supervisor.conf
- Deploy: deploy.sh
- Health check: health-check.sh
