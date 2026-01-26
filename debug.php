<?php

require __DIR__.'/vendor/autoload.php';

echo "=== DEBUG SCRIPT ===" . PHP_EOL;

try {
    $app = require_once __DIR__.'/bootstrap/app.php';
    echo "✓ Bootstrap loaded" . PHP_EOL;
    
    echo "Intentando bootear la aplicación..." . PHP_EOL;
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
    echo "✓ Application booted" . PHP_EOL;
    
    echo "Intentando obtener configuración de sesión..." . PHP_EOL;
    $sessionConfig = config('session');
    
    echo "Session driver: " . ($sessionConfig['driver'] ?? 'NULL') . PHP_EOL;
    echo "Session store: " . ($sessionConfig['store'] ?? 'NULL') . PHP_EOL;
    
} catch (\Exception $e) {
    echo "✗ ERROR: " . $e->getMessage() . PHP_EOL;
    echo "File: " . $e->getFile() . ":" . $e->getLine() . PHP_EOL;
    echo PHP_EOL . "Stack trace:" . PHP_EOL;
    
    $trace = $e->getTrace();
    foreach (array_slice($trace, 0, 10) as $i => $frame) {
        $file = $frame['file'] ?? 'unknown';
        $line = $frame['line'] ?? '?';
        $function = $frame['function'] ?? 'unknown';
        $class = $frame['class'] ?? '';
        
        echo "#$i $class::$function() in $file:$line" . PHP_EOL;
    }
}
