Set shell = CreateObject("WScript.Shell")
command = "powershell -NoProfile -NonInteractive -ExecutionPolicy Bypass -File ""C:\Proyectos\ProyectoAutos\scripts\run_scheduler.ps1"""
shell.Run command, 0, True
