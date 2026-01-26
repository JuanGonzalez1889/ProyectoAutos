# ⚡ QUICK START - 5 MINUTOS

## Paso 1: Inicia el servidor (1 minuto)

```powershell
.\START.ps1
```

Espera hasta ver: `Server running on [http://127.0.0.1:8000]`

## Paso 2: Registra una agencia (1 minuto)

Abre: **http://localhost:8000/tenants/register**

Llena el formulario:
```
Agencia: Mi Agencia
Admin Nombre: Juan Pérez  
Admin Email: juan@test.com
Contraseña: Password123!
Confirmar: Password123!
Dominio: miagensia
Teléfono: +34900123456
Dirección: Calle Principal 123
```

Click: **"Registrar Agencia"**

## Paso 3: Login (1 minuto)

Abre: **http://localhost:8000/login**

```
Email: juan@test.com
Contraseña: Password123!
```

Click: **"Iniciar Sesión"**

## Paso 4: Explora el panel (1 minuto)

En el menú izquierdo, busca: **"🔧 Multi-Tenancy"**

Click para ver todas las agencias registradas

## Paso 5: Haz clic en tu agencia (1 minuto)

- Verás detalles completos
- Puedes editar información
- Puedes activar/desactivar
- Puedes ver usuarios

---

## 🎉 ¡Listo!

Tu sistema SaaS multi-tenant está funcionando.

### Próximos pasos:

1. **Leer documentación**: Lee `SAAS_DOCUMENTATION.md`
2. **Testing completo**: Sigue pasos en `TESTING.md`
3. **Entender arquitectura**: Lee `RESUMEN.md`

---

## 🆘 Problemas comunes

**Error: "Connection refused"**
→ Asegúrate MySQL está corriendo

**Error: "Class not found"**
→ Ejecuta: `composer install` (si lo eliminaste)

**Error: "Base de datos no existe"**
→ Crea: `CREATE DATABASE proyecto_autos;` en MySQL

**Botón "Multi-Tenancy" no aparece**
→ Debes ser ADMIN (registra agencia primero)

---

## 📞 Comandos útiles

```bash
# Limpiar cache
php artisan cache:clear

# Ver logs
php artisan tinker
> App\Models\Tenant::all()

# Migraciones
php artisan migrate:status
```

---

**¡Haz clic en `.\START.ps1` ahora!** 🚀
