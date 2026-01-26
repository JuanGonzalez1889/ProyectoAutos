#!/usr/bin/env php
<?php

/*
|--------------------------------------------------------------------------
| Laravel Kernel Bootstrap
|--------------------------------------------------------------------------
*/

$app = require_once __DIR__.'/bootstrap/app.php';

// Crear un kernel manual simplificado para evitar el error de "files"
try {
    $kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
} catch (\Exception $e) {
    // Si hay error, ignorar
    error_log("Error al hacer bootstrap: " . $e->getMessage());
}

return $app;
