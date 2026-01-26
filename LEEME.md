# 🚗 Proyecto Autos - Sistema de Gestión de Agencieros

## ✅ Instalación Completada

El proyecto está **99% listo**. Solo faltan estos pasos finales:

### 📋 Pasos Finales (Obligatorios)

#### Opción A: Instalación Automática (Recomendado)

1. **Ejecuta el script de instalación:**
   ```bash
   .\iniciar.ps1
   ```
   O haz doble clic en `iniciar.bat`

2. El script te pedirá:
   - Usuario de MySQL (default: root)
   - Contraseña de MySQL
   
3. ¡Listo! El proyecto se abrirá en `http://localhost:8000`

#### Opción B: Instalación Manual

Si prefieres hacerlo paso a paso:

```bash
# 1. Crear la base de datos en MySQL
mysql -u root -p
CREATE DATABASE proyecto_autos CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
exit;

# 2. Configurar credenciales en .env
# Edita el archivo .env y actualiza:
# DB_USERNAME=tu_usuario
# DB_PASSWORD=tu_contraseña

# 3. Ejecutar migraciones
php artisan migrate --seed

# 4. Iniciar servidor
php artisan serve
```

### 🎯 Primer Uso

1. Abre tu navegador en: `http://localhost:8000`

2. Haz clic en **"Registrarse"** o **"Continuar con Google"**

3. El **primer usuario** que se registre será **ADMIN** automáticamente

4. Ya puedes acceder al panel de administración

---

## 🔐 Sistema de Roles

- **ADMIN**: Control total del sistema
- **AGENCIERO**: Gestiona colaboradores
- **COLABORADOR**: Acceso limitado

---

## 🛠️ Comandos Útiles

```bash
# Iniciar servidor
php artisan serve

# Limpiar caché
php artisan cache:clear
php artisan config:clear

# Ver rutas
php artisan route:list

# Crear nuevo usuario desde consola
php artisan tinker
>>> $user = User::create(['name' => 'Admin', 'email' => 'admin@example.com', 'password' => bcrypt('password')]);
>>> $user->assignRole('ADMIN');
```

---

## 📦 Lo que ya está instalado:

- ✅ Laravel 11
- ✅ Composer (dependencias PHP)
- ✅ NPM (dependencias JavaScript)
- ✅ Tailwind CSS
- ✅ Vite (assets compilados)
- ✅ Spatie Laravel Permission
- ✅ Laravel Socialite (Google OAuth)
- ✅ APP_KEY generado

---

## 🚀 Funcionalidades Implementadas:

1. **Autenticación**
   - Login con email/contraseña
   - Registro de usuarios
   - Login con Google OAuth
   - Protección de rutas

2. **Panel Admin**
   - Dashboard con estadísticas
   - Gestión de usuarios (CRUD completo)
   - Activar/desactivar usuarios
   - Asignación de roles

3. **Roles y Permisos**
   - Sistema Spatie completamente configurado
   - Permisos granulares
   - Middleware de autorización

---

## 🔧 Configuración de Google OAuth (Opcional)

Para habilitar el login con Google:

1. Ve a [Google Cloud Console](https://console.cloud.google.com/)
2. Crea un proyecto
3. Habilita "Google+ API"
4. Crea credenciales OAuth 2.0
5. Agrega al `.env`:
   ```
   GOOGLE_CLIENT_ID=tu_client_id
   GOOGLE_CLIENT_SECRET=tu_client_secret
   ```

---

## 📞 Soporte

Si tienes problemas:

1. Verifica que MySQL esté corriendo
2. Revisa las credenciales en `.env`
3. Consulta los logs en `storage/logs/laravel.log`

---

## 🎉 ¡Listo para usar!

El proyecto está completamente configurado. Solo ejecuta el script de instalación y comienza a trabajar.
