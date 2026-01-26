# Guía de Testing - Sistema SaaS Multi-Tenant

## ✅ Estado Actual

Todo el sistema está **100% implementado y listo para testing**:

✅ Instalación de stancl/tenancy v3.9.1
✅ Migraciones ejecutadas (tenants, domains, tenant_id en todas las tablas)
✅ Modelos actualizados con tenant_id
✅ Middleware de identificación de tenant (IdentifyTenant)
✅ Rutas completas (registro, admin, CRUD)
✅ Vistas de registro, listado, detalles, edición
✅ Integración con Spatie Permission
✅ Scoping automático con trait BelongsToTenant

---

## 🚀 Pasos para Testear

### PASO 1: Iniciar el Servidor

```bash
cd "C:\Users\Juan Gonzalez\Desktop\JuanMauro\ProyectoAutos"

# Opción A: Con artisan (recomendado)
php artisan serve

# Opción B: Con Vite (para frontend)
npm run dev

# En otra terminal
php artisan serve
```

El servidor estará en: `http://localhost:8000`

### PASO 2: Registrar la Primera Agencia (SIN estar logueado)

1. Accede a: `http://localhost:8000/tenants/register`

2. Llena el formulario:
   - **Agencia**: "Mi Primera Agencia"
   - **Admin Nombre**: "Juan Pérez"
   - **Admin Email**: "juan@miagencia.com"
   - **Contraseña**: "Password123!"
   - **Confirmar**: "Password123!"
   - **Dominio**: "miagencia" (se convierte a `miagencia.misaas.com`)
   - **Teléfono**: "+34 900 123 456" (opcional)
   - **Dirección**: "Calle Principal 123, Madrid" (opcional)

3. Click en **"Registrar Agencia"**

**Resultado esperado**:
- ✅ Se crea `Tenant` (agencia)
- ✅ Se crea `Domain` (miagencia.misaas.com)
- ✅ Se crea `Agencia`
- ✅ Se crea `User` (admin)
- ✅ Se asigna rol `ADMIN` al usuario
- ✅ Redirige a login con mensaje de éxito

### PASO 3: Login con la Cuenta del Admin

1. Accede a: `http://localhost:8000/login`

2. Credenciales:
   - Email: `juan@miagencia.com`
   - Contraseña: `Password123!`

3. Click en **"Iniciar Sesión"**

**Resultado esperado**:
- ✅ Login exitoso
- ✅ Redirige al dashboard
- ✅ Muestra "juan colaborador" como usuario logueado

### PASO 4: Verificar que es ADMIN

1. En el dashboard, busca el menú izquierdo

2. Verifica que aparece: **"🔧 Multi-Tenancy"**
   - Esta opción **SOLO aparece para ADMINs**

3. Click en **"Multi-Tenancy"**

**Resultado esperado**:
- ✅ Muestra página `/admin/tenants`
- ✅ Muestra estadísticas de agencias
- ✅ Muestra tabla con la agencia creada

### PASO 5: Ver Detalles de la Agencia

1. En la página de Multi-Tenancy, busca tu agencia "Mi Primera Agencia"

2. Click en el ícono **👁️** (Ver detalles)

**Resultado esperado**:
- ✅ Muestra página `/admin/tenants/{id}`
- ✅ Información básica: nombre, email, teléfono, dirección
- ✅ Dominio: miagencia.misaas.com
- ✅ Usuario: Juan Pérez (ADMIN)
- ✅ Estado: Activa
- ✅ Plan: basic
- ✅ En período de prueba (30 días)

### PASO 6: Editar Configuración de la Agencia

1. En la página de detalles, click en **"✏️ Editar Información"**

2. Modifica:
   - Nombre: "Mi Primera Agencia - Editada"
   - Plan: Cambia de "basic" a "premium"

3. Click en **"💾 Guardar Cambios"**

**Resultado esperado**:
- ✅ Redirige a la página de detalles
- ✅ Muestra mensaje: "Configuración actualizada exitosamente"
- ✅ Los datos están actualizados

### PASO 7: Activar/Desactivar Agencia

1. Vuelve a los detalles de la agencia

2. En el sidebar, click en **"⏹️ Desactivar Agencia"**

3. Verifica el cambio:
   - Estado cambia de "Activo" a "Inactivo"
   - Click en **"▶️ Activar Agencia"** para volver a activar

**Resultado esperado**:
- ✅ El estado cambia correctamente
- ✅ Aparece mensaje de confirmación

### PASO 8: Registrar Segunda Agencia

Repite los pasos 1-3 pero con:
- **Agencia**: "Segunda Agencia SRL"
- **Admin Email**: "maria@segunda.com"
- **Contraseña**: "Password123!"
- **Dominio**: "segunda"

### PASO 9: Verificar Scoping de Datos

1. Login con **juan@miagencia.com** (primera agencia)

2. Crea una **Tarea**:
   - Título: "Tarea 1 - Primera Agencia"
   - Descripción: "Solo visible en primera agencia"

3. En el sidebar, verifica conteo: **1 Tarea Pendiente** ✅

4. Login con **maria@segunda.com** (segunda agencia)

5. Verifica en el sidebar: **0 Tareas Pendientes** ✅

**Resultado esperado**:
- ✅ Cada tenant ve SOLO sus datos
- ✅ No hay cross-contamination de datos
- ✅ El scoping automático funciona

### PASO 10: Testing del Dominio (Avanzado)

Si quieres testear con dominios diferentes:

1. Edita tu archivo **hosts**:
   ```
   C:\Windows\System32\drivers\etc\hosts
   ```

2. Agrega al final:
   ```
   127.0.0.1 miagencia.misaas.local
   127.0.0.1 segunda.misaas.local
   127.0.0.1 proyectoautos.local
   ```

3. Accede a:
   - `http://proyectoautos.local:8000/` → Dominio central (sin tenant)
   - `http://miagencia.misaas.local:8000/` → Tenant 1
   - `http://segunda.misaas.local:8000/` → Tenant 2

**Resultado esperado**:
- ✅ El middleware identifica correctamente el tenant por dominio
- ✅ Cada dominio muestra datos del tenant correcto
- ✅ Dominio central permite acceso sin tenant específico

---

## 🧪 Pruebas Adicionales

### Test: Crear Datos en Diferentes Roles

1. Login como ADMIN (juan@miagencia.com)

2. Crea:
   - 1 Tarea
   - 1 Evento
   - 1 Lead
   - 1 Vehículo

3. Verifica que aparecen en los badges del sidebar

4. Cambia a otra agencia y verifica que no aparecen

### Test: Validación de Email Único

1. Intenta registrar otra agencia con **juan@miagencia.com**

**Resultado esperado**:
- ❌ Error: "El email ya existe"

### Test: Validación de Dominio Único

1. Intenta registrar agencia con dominio **"miagencia"**

**Resultado esperado**:
- ❌ Error: "El dominio ya está registrado"

### Test: Eliminación de Agencia

1. En `/admin/tenants/{id}`, click en **"🗑️ Eliminar Agencia"**

2. Confirma en el popup

**Resultado esperado**:
- ✅ Se elimina completamente la agencia
- ✅ Se eliminan todos sus datos (usuarios, dominios, tareas, etc)
- ✅ Redirige a listado de tenants

---

## 🔍 Verificación en Base de Datos

Si quieres verificar la BD directamente:

```bash
# Abre la terminal y conéctate a MySQL
mysql -u root -p

# Selecciona la BD
USE proyecto_autos;

# Verifica tablas de tenancy
SELECT * FROM tenants;
SELECT * FROM domains;

# Verifica que tenant_id está en todos lados
SELECT id, tenant_id, name FROM users;
SELECT id, tenant_id, title FROM tasks;
SELECT id, tenant_id, title FROM events;
SELECT id, tenant_id, first_name FROM leads;
SELECT id, tenant_id, model FROM vehicles;
```

---

## ✅ Checklist de Validación

- [ ] Registro de agencia funciona
- [ ] Login funciona
- [ ] Dashboard muestra datos correctos
- [ ] Aparece menú "Multi-Tenancy" solo para ADMIN
- [ ] Lista de tenants muestra las agencias
- [ ] Detalles de tenant muestran toda la información
- [ ] Edición de tenant funciona
- [ ] Activar/desactivar funciona
- [ ] Scoping de datos funciona (cada tenant ve solo sus datos)
- [ ] Los contadores de tareas/eventos son correctos
- [ ] Crear datos nuevos en una agencia no afecta a otras
- [ ] El middleware identifica correctamente el tenant

---

## 🎯 Próximos Pasos (Después del Testing)

1. **Stripe/Mercado Pago Integration**: Implementar pagos para suscripciones
2. **Email Notifications**: Notificaciones para fin de trial/suscripción
3. **Analytics Dashboard**: Ver uso por agencia
4. **API REST**: Para que terceros se conecten
5. **Custom Branding**: Cada agencia con su logo/colores
6. **Data Export**: Exportar datos por agencia

---

## 📞 Soporte

Si encuentras errores durante el testing:

1. Revisa `storage/logs/laravel.log` para ver logs de errores
2. Verifica que MySQL está corriendo
3. Verifica que las migraciones se ejecutaron (`php artisan migrate:status`)
4. Limpia cache: `php artisan cache:clear`

**¡Listo para testear! 🚀**
