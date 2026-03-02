# Producción Windows: Scheduler Laravel (sin popups)

## Opción recomendada: Task Scheduler como SYSTEM

1. Abrir PowerShell **como Administrador**.
2. Ejecutar:

```powershell
Set-Location C:\Proyectos\ProyectoAutos
powershell -ExecutionPolicy Bypass -File .\scripts\install_windows_scheduler_task.ps1
```

Esto crea la tarea `ProyectoAutos-Laravel-Scheduler` cada 1 minuto, ejecutando en modo no interactivo.

## Opción enterprise: servicio Windows con NSSM (`schedule:work`)

1. Descargar NSSM y ubicarlo, por ejemplo, en `C:\Tools\nssm\win64\nssm.exe`.
2. Abrir PowerShell **como Administrador**.
3. Ejecutar:

```powershell
Set-Location C:\Proyectos\ProyectoAutos
powershell -ExecutionPolicy Bypass -File .\scripts\install_windows_scheduler_service_nssm.ps1 -NssmPath "C:\Tools\nssm\win64\nssm.exe" -PhpPath "php"
```

## Verificación rápida

```powershell
schtasks /Query /TN "ProyectoAutos-Laravel-Scheduler" /V /FO LIST
Get-Content .\storage\logs\scheduler.log -Tail 20
```

Si usás NSSM:

```powershell
sc query ProyectoAutosScheduler
Get-Content .\storage\logs\scheduler-service.log -Tail 20
```

## Notas

- Para producción, preferí ejecución como `SYSTEM` o servicio NSSM.
- Evitá modo interactivo para no mostrar ventanas al usuario.
- Ya existe reconciliación de suscripciones Mercado Pago cada 10 minutos en `routes/console.php`.
