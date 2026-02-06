# ✅ DNS Completo (Bloqueante)

> Completar en el proveedor DNS del dominio.

## 1) Registros A / CNAME
- [ ] A @ → IP del servidor
- [ ] CNAME www → dominio raíz
- [ ] A * → IP del servidor (wildcard para tenants)

## 2) Email DNS
### SPF
- [ ] TXT @ → `v=spf1 include:_spf.sendgrid.net ~all` (o proveedor real)

### DKIM
- [ ] TXT `s1._domainkey` → clave del proveedor (SendGrid/Mailgun/Postmark)

### DMARC
- [ ] TXT _dmarc → `v=DMARC1; p=quarantine; rua=mailto:admin@tudominio.com`

## 3) Verificación
- [ ] Propagación DNS OK (whatsmydns.net)
- [ ] SSL emite para root + wildcard

---

### Datos necesarios
- IP pública del servidor
- Dominio final
- Proveedor de email (para SPF/DKIM reales)
