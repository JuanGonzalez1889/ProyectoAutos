# Documentación - Sistema SaaS Multi-Tenant ProyectoAutos

## 🏗️ Arquitectura

Sistema de **Single Database Multi-Tenancy** donde:
- Una sola base de datos MySQL para todos los tenants (agencias)
- Campo `tenant_id` en todas las tablas de negocio
- Identificación automática del tenant por dominio
- Scoping automático de queries

## 🚀 Configuración de Tenancy

### 1. Archivo de Configuración Principal
`config/tenancy.php` - Configuración de stancl/tenancy

**Dominios Centrales** (sin tenant):
```php
'central_domains' => [
    'localhost',
    '127.0.0.1',
    'proyectoautos.local',  // Tu dominio raíz
],
```

### 2. Tablas de Base de Datos

**Tablas de Tenants (centrales)**:
- `tenants` - Información de cada agencia
  - `id` (UUID): Identificador único
  - `name`: Nombre de la agencia
  - `email`: Email principal
  - `phone`, `address`: Contacto
  - `plan`: basic, premium, enterprise
  - `is_active`: Estado
  - `trial_ends_at`: Fin de prueba
  - `subscription_ends_at`: Fin de suscripción

- `domains` - Dominios asociados a cada tenant
  - `id`: Identificador
  - `domain`: URL del tenant (ej: miagencia.misaas.com)
  - `tenant_id`: Referencia a tenant

**Tablas de Negocio** (con `tenant_id`):
- `users` - Usuarios de cada agencia
- `agencias` - Agencias (redundante con tenants pero mantiene estructura)
- `vehicles` - Vehículos del inventario
- `tasks` - Tareas asignadas
- `events` - Eventos/calendario
- `leads` - Prospectos

## 📝 Registro de Nueva Agencia (Onboarding)

### Flujo de Registro

1. **Usuario accede a**: `https://proyectoautos.local/tenants/register`
2. **Formulario solicita**:
   - Nombre de la agencia
   - Nombre completo del administrador
   - Email del administrador
   - Contraseña
   - Dominio deseado (ej: "miagencia" → miagencia.misaas.com)
   - Teléfono (opcional)
   - Dirección (opcional)

3. **En la base de datos se crea**:
   - Registro en tabla `tenants`
   - Registro en tabla `domains` (vinculando dominio a tenant)
   - Usuario ADMIN para ese tenant
   - Agencia (opcional, mantiene estructura)

4. **Usuario es redirigido** a login para iniciar sesión

### Transacción Atómica
Toda la creación usa `DB::beginTransaction()` - si falla algo, se revierte todo.

```php
// En TenantController@register
DB::beginTransaction();
// 1. Crear Tenant
// 2. Crear Domain
// 3. Crear Agencia
// 4. Crear User Admin
// 5. Asignar rol ADMIN
DB::commit();
```

## 🔐 Identificación de Tenant

### Middleware `IdentifyTenant`

Ejecuta en **TODAS** las requests:
1. Obtiene el dominio del request (`$request->getHost()`)
2. Si es dominio central (localhost, etc), permite acceso
3. Busca `Domain::where('domain', $host)` en BD
4. Si encuentra, obtiene el `Tenant` asociado
5. Verifica que el tenant esté activo
6. Si usuario está logged, verifica que pertenezca al tenant
7. Si no coincide, logout y error 403

```
https://miagencia.misaas.com/admin/dashboard
    ↓
middleware IdentifyTenant
    ↓
busca Domain donde domain = 'miagencia.misaas.com'
    ↓
obtiene tenant_id asociado
    ↓
verifica que usuario pertenezca a ese tenant
    ↓
app('tenant') = Tenant::find(...)
```

## 🎯 Scoping Automático de Queries

### Trait `BelongsToTenant`

Usado en modelos: `Task`, `Event`, `Lead`, `Vehicle`

**Características**:
- Global scope: Filtra automáticamente por `tenant_id` del usuario logueado
- Creación automática: Cuando se crea un modelo, asigna `tenant_id` automáticamente
- Transparente: No necesitas pensar en `tenant_id` en queries

```php
// Automáticamente filtra por tenant_id del usuario logueado
$tasks = Task::all(); // Solo tareas del tenant del usuario

// O explícitamente
$tasks = Task::forTenant($tenantId)->get();

// Crear automáticamente asigna tenant_id
$task = Task::create([
    'title' => 'Tarea',
    // tenant_id se asigna automáticamente
]);
```

## 👥 Roles y Permisos por Tenant

Usando **Spatie Permission**:

**Roles disponibles**:
- `ADMIN` - Administrador de la agencia
- `AGENCIERO` - Gerente de la agencia
- `COLABORADOR` - Empleado

**Asignación en registro**:
```php
$admin->assignRole('ADMIN');
```

**Protección de rutas**:
```php
Route::middleware('role:ADMIN')->group(function () {
    // Solo ADMINs pueden acceder
    Route::get('/tenants', [TenantController::class, 'index']);
});
```

## 🌐 Rutas por Dominio

### Dominios Centrales
`localhost`, `127.0.0.1`, `proyectoautos.local`

Rutas accesibles:
- `GET /` → Redirige a login
- `GET /login`
- `POST /login`
- `GET /tenants/register` ← Nueva agencia
- `POST /tenants/register`
- `GET /auth/google`

### Dominios de Tenants
`*.misaas.com` (ej: miagencia.misaas.com)

Rutas accesibles (después de login):
- `GET /admin/dashboard`
- `GET /admin/tasks`
- `GET /admin/events`
- `GET /admin/leads`
- `GET /admin/vehicles`
- etc...

## 💾 Base de Datos - Single DB Strategy

**Ventajas**:
✅ Una sola BD, más simple de mantener
✅ Backups centralizados
✅ Reportes consolidados entre agencias
✅ Menor costo de infraestructura

**Seguridad**:
✅ Global scope automático en modelos
✅ Middleware verifica tenant por dominio
✅ Usuario solo ve datos de su tenant

## 🔧 Configuración de Dominios

### Desarrollo Local

En tu `hosts` file (`C:\Windows\System32\drivers\etc\hosts`):
```
127.0.0.1 localhost
127.0.0.1 proyectoautos.local
127.0.0.1 miagencia.misaas.local
127.0.0.1 otraagencia.misaas.local
```

En `.env`:
```env
APP_URL=http://proyectoautos.local
CENTRAL_DOMAIN=proyectoautos.local
```

### Producción

En tu hosting, configura:
- Dominio raíz: `misaas.com`
- Wildcard DNS: `*.misaas.com` → Tu servidor

En `.env` de producción:
```env
APP_URL=https://misaas.com
CENTRAL_DOMAIN=misaas.com
```

## 📊 Panel de Administración SaaS

**Ruta**: `/admin/tenants` (solo ADMIN con rol ADMIN)

Funcionalidades:
- 📋 Listar todas las agencias
- 👁️ Ver detalles de cada agencia
- ✏️ Editar configuración (plan, estado, etc)
- ⚫⚪ Activar/Desactivar agencias
- 🗑️ Eliminar agencia (borra todo asociado)

**Estadísticas en el panel**:
- Total de agencias
- Agencias activas
- Agencias en período de prueba
- Agencias inactivas

## 🧪 Testing

### Crear agencia de prueba

1. Accede a `http://proyectoautos.local/tenants/register`
2. Llena el formulario:
   - Agencia: "Test Agency"
   - Admin: "Juan Admin"
   - Email: "juan@test.com"
   - Password: "password123"
   - Dominio: "testagency"
3. Se crea `testagency.misaas.local`
4. Login con `juan@test.com` / `password123`
5. Accede a `http://testagency.misaas.local/admin/dashboard`

### Verificar scoping

1. Login como admin del primer tenant
2. Crea una tarea
3. Verifica que la tarea tenga `tenant_id` correcto
4. Login como admin de otro tenant
5. Verifica que NO ve la tarea del primer tenant

## 📚 Archivos Clave

```
app/
├── Http/
│   ├── Controllers/
│   │   └── TenantController.php      ← Lógica de tenants
│   └── Middleware/
│       └── IdentifyTenant.php        ← Identificar tenant por dominio
├── Models/
│   ├── Tenant.php                    ← Modelo de agencia
│   ├── Domain.php                    ← Modelo de dominio
│   └── [Otros modelos con BelongsToTenant trait]
├── Traits/
│   └── BelongsToTenant.php           ← Scoping automático
│
bootstrap/
└── app.php                           ← Middleware global

config/
└── tenancy.php                       ← Configuración de tenancy

database/
└── migrations/
    ├── 2019_09_15_000010_create_tenants_table.php
    ├── 2019_09_15_000020_create_domains_table.php
    └── 2026_01_05_220002_add_tenant_id_to_existing_tables.php

resources/
└── views/
    ├── tenants/
    │   ├── register.blade.php         ← Formulario de registro
    │   └── index.blade.php            ← Panel de admin de tenants
    └── layouts/
        └── admin.blade.php            ← Menú con acceso a tenants
```

## 🎁 Próximas Mejoras

- [ ] Stripe/Mercado Pago integration para suscripciones
- [ ] Email notifications para pruebas/suscripciones
- [ ] Analytics dashboard (uso por agencia)
- [ ] API para terceros
- [ ] Custom branding por tenant
- [ ] Exportación de datos por agencia
- [ ] Auditoría de acciones por tenant

---

**¡Tu SaaS Multi-Tenant está listo!** 🎉
