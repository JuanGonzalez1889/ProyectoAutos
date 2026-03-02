param(
    [string]$ProjectPath = "C:\Proyectos\ProyectoAutos",
    [string]$TaskName = "ProyectoAutos-Laravel-Scheduler",
    [switch]$AsSystem = $true
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

$runnerScript = Join-Path $ProjectPath "scripts\run_scheduler.ps1"
if (-not (Test-Path $runnerScript)) {
    Write-Error "No existe el script: $runnerScript"
    exit 1
}

$taskCommand = "powershell -NoProfile -NonInteractive -ExecutionPolicy Bypass -File $runnerScript"

try {
    schtasks /Delete /TN $TaskName /F | Out-Null
} catch {
}

if ($AsSystem) {
    schtasks /Create /SC MINUTE /MO 1 /TN $TaskName /TR $taskCommand /RU "SYSTEM" /RL HIGHEST /F | Out-Null
} else {
    schtasks /Create /SC MINUTE /MO 1 /TN $TaskName /TR $taskCommand /F | Out-Null
}

schtasks /Run /TN $TaskName | Out-Null

Write-Host "Tarea '$TaskName' creada correctamente."
Write-Host "Comando: $taskCommand"
Write-Host "Modo: " ($(if ($AsSystem) { "SYSTEM (recomendado producción)" } else { "usuario actual" }))
