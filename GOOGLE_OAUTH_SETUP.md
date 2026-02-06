# 🔐 Configuración Google OAuth - Guía Completa

## Objetivo
Permitir que los usuarios se registren e inicien sesión usando sus cuentas de Google, con soporte para vincular cuentas existentes.

---

## 📋 Requisitos Previos

1. Cuenta de Google (Gmail)
2. Acceso a [Google Cloud Console](https://console.cloud.google.com/)
3. Proyecto creado en Google Cloud

---

## 🚀 Pasos de Configuración

### 1. Crear Proyecto en Google Cloud Console

1. Ve a https://console.cloud.google.com/
2. Click en el selector de proyecto (arriba a la izquierda)
3. Click en "Nuevo Proyecto"
4. Nombre: `Proyecto Autos` (o tu nombre)
5. Click "Crear"

### 2. Habilitar Google+ API

1. En el menú izquierdo, ve a "APIs y servicios" → "Biblioteca"
2. Busca "Google+ API"
3. Click en ella y luego "Habilitar"

### 3. Crear Credenciales OAuth

1. Ve a "APIs y servicios" → "Credenciales"
2. Click en "Crear credenciales" → "ID de cliente de OAuth"
3. Si te pide crear una pantalla de consentimiento:
   - Click "Crear pantalla de consentimiento"
   - Selecciona "Externo"
   - Completa el formulario:
     - Nombre de aplicación: `Proyecto Autos`
     - Email de soporte: tu email
     - Email de desarrollador: tu email
   - Click "Guardar y continuar"
   - En "Permisos", no necesitas agregar nada. Click "Guardar y continuar"
   - Vuelve a "Credenciales"

4. Click "Crear credenciales" → "ID de cliente de OAuth"
5. Tipo de aplicación: **Aplicación web**
6. Nombre: `Proyecto Autos Web`
7. En "URIs de redireccionamiento autorizados", agrega:
   ```
   http://localhost:8000/auth/google/callback
   ```
   (Para producción: `https://tudominio.com/auth/google/callback`)

8. Click "Crear"
9. Se abrirá un popup con tus credenciales - **COPIA ESTOS VALORES**

### 4. Configurar Variables de Entorno

En tu archivo `.env`:

```env
GOOGLE_CLIENT_ID=your-client-id-here.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=your-client-secret-here
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

**Para Producción:**
```env
GOOGLE_CLIENT_ID=your-prod-client-id.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=your-prod-secret
GOOGLE_REDIRECT_URI=https://tudominio.com/auth/google/callback
```

---

## 🔄 Flujo de Autenticación

### Caso 1: Nuevo Usuario

```
Google Login → Crear Tenant + Usuario → Asignar Rol AGENCIERO → Redirect Dashboard
```

### Caso 2: Usuario Existente (por Google ID)

```
Google Login → Encontrar Usuario → Login → Redirect Dashboard
```

### Caso 3: Email Existe (Usuario Antiguo)

```
Google Login → Email encontrado → Vincular Google ID → Login → Redirect Dashboard
```

### Caso 4: Usuario Autenticado Quiere Vincular Google

```
Autenticado → Click "Vincular Google" → Redirect Google → Confirmar → Actualizar google_id
```

---

## 📱 Endpoints

| Método | Ruta | Descripción |
|--------|------|-------------|
| GET | `/auth/google` | Redirige a Google |
| GET | `/auth/google/callback` | Callback de Google |
| POST | `/auth/google/confirm-link` | Confirmar vinculación |

---

## 🧪 Testing

### Test de Flujo Completo

```bash
php vendor/bin/phpunit tests/Feature/GoogleOAuthTest.php
```

### Casos de Prueba Incluidos

- ✅ Redirección a Google
- ✅ Crear nuevo usuario desde Google
- ✅ Autenticar usuario existente
- ✅ Vincular Google a usuario existente
- ✅ Manejo de errores

---

## 🛡️ Seguridad

- ✅ **State Validation**: Laravel Socialite maneja automáticamente
- ✅ **CSRF Protection**: Verifica el estado de la sesión
- ✅ **Email Verification**: Se marca como verificado automáticamente
- ✅ **Avatar Storage**: Se descarga y almacena el avatar
- ✅ **Error Handling**: Manejo de excepciones y errores

---

## 🐛 Troubleshooting

### Error: "redirect_uri_mismatch"

**Causa**: La URI en el navegador no coincide con la registrada en Google Cloud

**Solución**: 
- Verifica que `GOOGLE_REDIRECT_URI` en `.env` sea exacta
- Las URIs deben coincidir exactamente (incluyendo https/http)
- Recarga las credenciales en Google Cloud si cambias algo

### Error: "Access Denied"

**Causa**: Pantalla de consentimiento no configurada

**Solución**:
- Ve a Google Cloud Console
- APIs y servicios → Pantalla de consentimiento
- Agrégates como usuario de prueba
- Espera 5-10 minutos

### Usuario No Recibe Avatar

**Causa**: Problema con descargas de imágenes

**Solución**:
- Verifica que `FILESYSTEM_DISK=public` en `.env`
- Ejecuta: `php artisan storage:link`
- Revisa permisos de la carpeta `storage/app/public`

---

## 📚 Modelos Afectados

### Usuario Nuevo
```php
User::create([
    'tenant_id' => $tenant->id,
    'name' => 'John Doe',
    'email' => 'john@gmail.com',
    'google_id' => 'google-unique-id',
    'avatar' => 'https://...',
    'email_verified_at' => now(),
    'is_active' => true,
]);
```

### Tenant Nuevo (Automático)
```php
Tenant::create([
    'id' => (string) Str::uuid(),
    'name' => 'John Doe',
    'email' => 'john@gmail.com',
    'is_active' => true,
]);
```

---

## 🎯 Casos de Uso

### Registro Rápido
1. Usuario ve botón "Continuar con Google"
2. Click → Redirección a Google
3. Inicia sesión o da consentimiento
4. Vuelve y crea su cuenta automáticamente

### Vincular Cuenta Existente
1. Usuario inicia sesión normalmente
2. Ve opción "Vincular Google" en perfil
3. Click → Redirección a Google
4. Vuelve y su cuenta está vinculada
5. Próximo login puede usar Google directamente

### Multi-Login
Usuario puede usar:
- Email + Contraseña
- Google OAuth
- Ambos (la cuenta es la misma)

---

## 📊 Base de Datos

### Columnas en `users`
```
- google_id (nullable)
- avatar (nullable)
- email_verified_at
```

---

## ✅ Checklist de Verificación

- [ ] Google Cloud Project creado
- [ ] Google+ API habilitada
- [ ] OAuth Credentials creadas
- [ ] `.env` configurado con credenciales
- [ ] `GOOGLE_REDIRECT_URI` es correcto
- [ ] Tests pasando (`PermissionSystemTest.php`)
- [ ] Pantalla de consentimiento configurada
- [ ] Usuario de prueba agregado a pantalla de consentimiento (en desarrollo)
- [ ] Avatar descargándose correctamente
- [ ] Login y registro funcionando

---

## 🚀 Producción

Para llevar a producción:

1. **Crear nuevas credenciales en Google Cloud** (sin localhost)
2. **Actualizar `.env`** con credenciales de producción
3. **Cambiar pantalla de consentimiento a "Producción"**
4. **Agregar dominio** a URIs autorizadas
5. **Validar SSL/HTTPS**
6. **Probar flujo completo** en staging

---

**Última actualización**: 4 de febrero de 2026
**Versión Laravel**: 11.47.0
**Librería Socialite**: ^5.0
