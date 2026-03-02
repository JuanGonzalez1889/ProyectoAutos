<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$service = $app->make(App\Services\MercadoPagoService::class);

$ref = new ReflectionClass($service);
$method = $ref->getMethod('decodeExternalReference');
$method->setAccessible(true);

$result = $method->invoke($service, 'invalid-n4-reference');

echo json_encode($result, JSON_UNESCAPED_UNICODE) . PHP_EOL;
