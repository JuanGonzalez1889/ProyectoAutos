param(
    [string]$ProjectPath = "C:\Proyectos\ProyectoAutos",
    [string]$ServiceName = "ProyectoAutosScheduler",
    [string]$NssmPath = "C:\Tools\nssm\win64\nssm.exe",
    [string]$PhpPath = "php"
)

$ErrorActionPreference = 'Stop'

function Test-IsAdmin {
    $identity = [Security.Principal.WindowsIdentity]::GetCurrent()
    $principal = New-Object Security.Principal.WindowsPrincipal($identity)
    return $principal.IsInRole([Security.Principal.WindowsBuiltInRole]::Administrator)
}

if (-not (Test-IsAdmin)) {
    Write-Error "Este script requiere PowerShell en modo Administrador."
    exit 1
}

if (-not (Test-Path $NssmPath)) {
    Write-Error "No se encontró NSSM en: $NssmPath"
    exit 1
}

$stdoutLog = Join-Path $ProjectPath "storage\logs\scheduler-service.log"
$stderrLog = Join-Path $ProjectPath "storage\logs\scheduler-service-error.log"

& $NssmPath stop $ServiceName | Out-Null
& $NssmPath remove $ServiceName confirm | Out-Null

& $NssmPath install $ServiceName $PhpPath "artisan" "schedule:work"
& $NssmPath set $ServiceName AppDirectory $ProjectPath
& $NssmPath set $ServiceName AppStdout $stdoutLog
& $NssmPath set $ServiceName AppStderr $stderrLog
& $NssmPath set $ServiceName AppRotateFiles 1
& $NssmPath set $ServiceName AppRotateOnline 1
& $NssmPath set $ServiceName AppRotateBytes 10485760
& $NssmPath set $ServiceName Start SERVICE_AUTO_START

& $NssmPath start $ServiceName

Write-Host "Servicio '$ServiceName' instalado e iniciado correctamente."
Write-Host "Comando: $PhpPath artisan schedule:work"
