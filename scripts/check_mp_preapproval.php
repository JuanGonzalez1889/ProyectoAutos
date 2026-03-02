<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$preapprovalId = $argv[1] ?? null;

if (!$preapprovalId) {
    fwrite(STDERR, "Uso: php scripts/check_mp_preapproval.php <preapproval_id>\n");
    exit(1);
}

$token = config('services.mercadopago.access_token');
if (!$token) {
    fwrite(STDERR, "Falta MERCADOPAGO_ACCESS_TOKEN en entorno.\n");
    exit(1);
}

\MercadoPago\MercadoPagoConfig::setAccessToken($token);
$client = new \MercadoPago\Client\PreApproval\PreApprovalClient();

try {
    $preapproval = $client->get($preapprovalId);

    $autoRecurring = is_array($preapproval->auto_recurring)
        ? $preapproval->auto_recurring
        : (array) $preapproval->auto_recurring;

    echo json_encode([
        'id' => $preapproval->id,
        'status' => $preapproval->status,
        'next_payment_date' => $preapproval->next_payment_date,
        'reason' => $preapproval->reason,
        'external_reference' => $preapproval->external_reference,
        'auto_recurring' => [
            'frequency' => $autoRecurring['frequency'] ?? null,
            'frequency_type' => $autoRecurring['frequency_type'] ?? null,
            'transaction_amount' => $autoRecurring['transaction_amount'] ?? null,
            'currency_id' => $autoRecurring['currency_id'] ?? null,
        ],
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . PHP_EOL;
} catch (Throwable $e) {
    fwrite(STDERR, "Error consultando preapproval: " . $e->getMessage() . PHP_EOL);
    exit(1);
}
