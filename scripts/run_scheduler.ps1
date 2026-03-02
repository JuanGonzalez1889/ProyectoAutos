Set-Location "C:\Proyectos\ProyectoAutos"
php artisan schedule:run 2>&1 | Out-File -FilePath "C:\Proyectos\ProyectoAutos\storage\logs\scheduler.log" -Append -Encoding utf8
