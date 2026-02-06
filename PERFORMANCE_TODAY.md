# ✅ Performance (Medio)

## 1) Cache & Optimización Laravel
- [ ] `php artisan config:cache`
- [ ] `php artisan route:cache`
- [ ] `php artisan view:cache`
- [ ] `php artisan event:cache`
- [ ] `composer install --optimize-autoloader --no-dev`

## 2) Assets
- [ ] `npm run build` (Vite)
- [ ] Verificar `public/build/manifest.json`

## 3) Nginx
- [ ] gzip ON
- [ ] Cache headers para assets (1 año)

## 4) Base de datos (índices recomendados)
- [ ] Índices compuestos en vehicles/leads/users

## 5) CDN (opcional)
- [ ] Cloudflare/otro CDN configurado

---

### Referencias
- Nginx: deployment/configs/nginx.conf
