<?php
require __DIR__ . '/../vendor/autoload.php';

try {
    $app = require __DIR__ . '/../bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
    echo "BOOTSTRAP OK\n";
} catch (Throwable $e) {
    echo $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}
