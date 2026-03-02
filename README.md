# Proyecto Autos - Sistema de Gestión de Agencieros

Sistema de administración con Laravel 11 que incluye gestión de usuarios con roles y permisos usando Spatie Laravel Permission, autenticación con Google OAuth, y un panel de administración completo.

## Integración de pagos

Actualmente el sistema soporta **Stripe** y **Mercado Pago** para pagos/suscripciones.

### Variables de entorno Mercado Pago
- MERCADOPAGO_PUBLIC_KEY
- MERCADOPAGO_ACCESS_TOKEN
- MERCADOPAGO_WEBHOOK_SECRET
- MERCADOPAGO_TEST_PAYER_EMAIL (opcional en local/sandbox)

### Variables de entorno Stripe
- STRIPE_KEY
- STRIPE_SECRET
- STRIPE_WEBHOOK_SECRET

### Pruebas de renovación automática (Mercado Pago)
- Ver checklist: `MERCADOPAGO_AUTORENEW_SANDBOX_CHECKLIST.md`

### Configuración webhook Mercado Pago
- Ver guía: `MERCADOPAGO_WEBHOOK_SETUP.md`

### Pruebas manuales webhook firmado
- Ver guía: `MERCADOPAGO_WEBHOOK_MANUAL_TESTS.md`

### Scheduler en producción Windows (sin popups)
- Ver guía: `WINDOWS_PRODUCTION_SCHEDULER.md`
- Script Task Scheduler: `scripts/install_windows_scheduler_task.ps1`
- Script servicio NSSM: `scripts/install_windows_scheduler_service_nssm.ps1`

## Características

 🔐 **Autenticación completa**: Login tradicional y con Google OAuth
- 👥 **Gestión de usuarios**: Crear, editar, eliminar y cambiar estado de usuarios
- 🎭 **Sistema de roles**: ADMIN, AGENCIERO, COLABORADOR
- 🔑 **Permisos granulares**: Control de acceso basado en permisos con Spatie
- 🎨 **Interfaz moderna**: Tailwind CSS para un diseño responsive
- 📊 **Dashboard administrativo**: Estadísticas y gestión centralizada

## Roles del Sistema

1. **ADMIN**: Acceso completo al sistema, puede gestionar todos los usuarios y roles
2. **AGENCIERO**: Puede gestionar colaboradores y acceder al dashboard
3. **COLABORADOR**: Acceso limitado solo al dashboard

## Requisitos

- PHP >= 8.2
- Composer
- MySQL >= 5.7
- Node.js >= 18.x
- NPM o Yarn

## Instalación

### 1. Instalar dependencias de PHP

```bash
composer install
```

### 2. Configurar el archivo de entorno

```bash
cp .env.example .env
```

Edita el archivo `.env` y configura:

- **Base de datos**:
  ```
  DB_DATABASE=proyecto_autos
  DB_USERNAME=root
  DB_PASSWORD=tu_password
  ```

- **Google OAuth** (opcional pero recomendado):
  1. Ve a [Google Cloud Console](https://console.cloud.google.com/)
  2. Crea un nuevo proyecto o selecciona uno existente
  3. Habilita "Google+ API"
  4. Ve a "Credenciales" → "Crear credenciales" → "ID de cliente de OAuth"
  5. Configura las URIs autorizadas:
     - URI de redireccionamiento: `http://localhost:8000/auth/google/callback`
  6. Copia las credenciales al `.env`:
  ```
  GOOGLE_CLIENT_ID=tu_client_id
  GOOGLE_CLIENT_SECRET=tu_client_secret
  ```

### 3. Generar clave de aplicación

```bash
php artisan key:generate
```

### 4. Crear la base de datos

Crea una base de datos llamada `proyecto_autos` en MySQL:

```sql
CREATE DATABASE proyecto_autos CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 5. Ejecutar migraciones y seeders

```bash
php artisan migrate --seed
```

Esto creará:
- Tablas de usuarios
- Tablas de roles y permisos (Spatie)
- Roles iniciales: ADMIN, AGENCIERO, COLABORADOR
- Permisos del sistema

### 6. Instalar dependencias de Node.js

```bash
npm install
```

### 7. Compilar assets

Para desarrollo:
```bash
npm run dev
```

Para producción:
```bash
npm run build
```

### 8. Iniciar el servidor

```bash
php artisan serve
```

La aplicación estará disponible en: `http://localhost:8000`

## Uso

### Primer Registro

1. Ve a `/tenants/register` o haz clic en "Registrar Agencia"
2. El **primer usuario** que se registre será asignado automáticamente como **ADMIN**
3. Los siguientes usuarios se registrarán como **AGENCIERO** por defecto

### Login

- **IMPORTANTE:** El login y acceso al panel deben hacerse desde el subdominio generado, por ejemplo:
  - `https://miagencia.autowebpro.com.ar/login`
  - `https://miagencia.autowebpro.com.ar/admin/dashboard`
- **Email y contraseña**: Usa las credenciales que creaste
- **Google OAuth**: Haz clic en "Continuar con Google"

### Crear Usuarios desde el Panel Admin

1. Inicia sesión como ADMIN (en tu subdominio)
2. Ve a "Usuarios" → "Crear Usuario"
3. Completa el formulario:
  - Nombre completo
  - Email
  - Contraseña
  - Selecciona el rol (ADMIN, AGENCIERO, COLABORADOR)
  - Estado (activo/inactivo)
4. Haz clic en "Crear Usuario"

### Gestionar Usuarios

Desde el panel de usuarios puedes:
- ✏️ **Editar**: Modificar datos del usuario y cambiar su rol
- 🔄 **Activar/Desactivar**: Cambiar el estado de un usuario
- 🗑️ **Eliminar**: Eliminar usuarios (no puedes eliminarte a ti mismo)

## Estructura del Proyecto

```
proyecto-autos/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── Admin/
│   │       │   ├── DashboardController.php
│   │       │   └── UserController.php
│   │       └── Auth/
│   │           ├── AuthController.php
│   │           └── GoogleAuthController.php
│   └── Models/
│       └── User.php
├── config/
│   ├── permission.php (Spatie)
│   └── services.php (Google OAuth)
├── database/
│   ├── migrations/
│   └── seeders/
│       ├── DatabaseSeeder.php
│       └── RoleAndPermissionSeeder.php
├── resources/
│   ├── css/
│   │   └── app.css
│   ├── js/
│   │   ├── app.js
│   │   └── bootstrap.js
│   └── views/
│       ├── admin/
│       │   ├── dashboard.blade.php
│       │   └── users/
│       ├── auth/
│       │   ├── login.blade.php
│       │   └── register.blade.php
│       └── layouts/
│           ├── admin.blade.php
│           └── guest.blade.php
└── routes/
    ├── web.php
    ├── api.php
    └── console.php
```

## Permisos del Sistema

El sistema incluye los siguientes permisos:

**Usuarios**:
- `users.view` - Ver lista de usuarios
- `users.create` - Crear nuevos usuarios
- `users.edit` - Editar usuarios existentes
- `users.delete` - Eliminar usuarios

**Roles**:
- `roles.view` - Ver roles
- `roles.assign` - Asignar roles a usuarios

**Dashboard**:
- `dashboard.access` - Acceder al dashboard
- `dashboard.stats` - Ver estadísticas

**Agencieros**:
- `agencieros.view` - Ver agencieros
- `agencieros.create` - Crear agencieros
- `agencieros.edit` - Editar agencieros
- `agencieros.delete` - Eliminar agencieros

**Colaboradores**:
- `colaboradores.view` - Ver colaboradores
- `colaboradores.create` - Crear colaboradores
- `colaboradores.edit` - Editar colaboradores
- `colaboradores.delete` - Eliminar colaboradores

## Comandos Útiles

```bash
# Limpiar caché
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Reejecutar migraciones (CUIDADO: elimina todos los datos)
php artisan migrate:fresh --seed

# Ver rutas disponibles
php artisan route:list

# Ver permisos y roles
php artisan permission:show
```

## Tecnologías Utilizadas

- **Backend**: Laravel 11
- **Frontend**: Blade Templates + Tailwind CSS
- **Autenticación**: Laravel Sanctum + Laravel Socialite (Google)
- **Roles y Permisos**: Spatie Laravel Permission
- **Base de datos**: MySQL
- **Build Tools**: Vite

## Próximos Pasos

Ahora que tienes el proyecto base configurado, puedes:

1. Personalizar el diseño según tus necesidades
2. Agregar más entidades (autos, ventas, etc.)
3. Implementar funcionalidades específicas para agencieros
4. Crear reportes y estadísticas avanzadas
5. Agregar notificaciones
6. Implementar API REST para aplicaciones móviles

## Soporte

Si encuentras algún problema durante la instalación o uso:

1. Verifica que todos los requisitos estén instalados
2. Revisa el archivo `.env` para configuraciones correctas
3. Consulta los logs en `storage/logs/laravel.log`

## Licencia

MIT License
