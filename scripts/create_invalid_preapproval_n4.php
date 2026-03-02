<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$token = config('services.mercadopago.access_token');
if (!$token) {
    fwrite(STDERR, "Falta MERCADOPAGO_ACCESS_TOKEN\n");
    exit(1);
}

\MercadoPago\MercadoPagoConfig::setAccessToken($token);
$client = new \MercadoPago\Client\PreApproval\PreApprovalClient();

$payerEmail = env('MERCADOPAGO_TEST_PAYER_EMAIL', 'test_user_2401476329094061594@testuser.com');
if (!str_contains($payerEmail, '@')) {
    $payerEmail = strtolower($payerEmail) . '@testuser.com';
}

$baseUrl = rtrim((string) config('app.url'), '/');
if ($baseUrl === '') {
    $baseUrl = 'http://127.0.0.1:8000';
}

try {
    $preapproval = $client->create([
        'reason' => 'N4 invalid external reference',
        'payer_email' => strtolower($payerEmail),
        'back_url' => $baseUrl . '/subscriptions/success',
        'status' => 'pending',
        'auto_recurring' => [
            'frequency' => 1,
            'frequency_type' => 'months',
            'transaction_amount' => 100,
            'currency_id' => 'ARS',
        ],
        'external_reference' => 'invalid-n4-reference',
        'notification_url' => $baseUrl . '/webhooks/mercadopago',
    ]);

    echo ($preapproval->id ?? '') . PHP_EOL;
} catch (Throwable $e) {
    fwrite(STDERR, $e->getMessage() . PHP_EOL);

    if (method_exists($e, 'getApiResponse')) {
        $apiResponse = $e->getApiResponse();
        $content = $apiResponse ? $apiResponse->getContent() : null;
        fwrite(STDERR, 'API_RESPONSE=' . json_encode($content, JSON_UNESCAPED_UNICODE) . PHP_EOL);
    }

    exit(1);
}
