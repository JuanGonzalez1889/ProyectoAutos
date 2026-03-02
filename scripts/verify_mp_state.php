<?php

use App\Models\Invoice;
use App\Models\Subscription;
use App\Models\Tenant;

require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$tenantId = $argv[1] ?? null;

if (!$tenantId) {
    fwrite(STDERR, "Uso: php scripts/verify_mp_state.php <tenant_id>\n");
    exit(1);
}

$tenant = Tenant::find($tenantId);

if (!$tenant) {
    fwrite(STDERR, "Tenant no encontrado: {$tenantId}\n");
    exit(1);
}

$subscription = Subscription::where('tenant_id', $tenantId)
    ->where('payment_method', 'mercadopago')
    ->latest('updated_at')
    ->first();

$invoices = Invoice::where('tenant_id', $tenantId)
    ->where('payment_method', 'mercadopago')
    ->latest('created_at')
    ->limit(5)
    ->get();

echo "=== TENANT ===\n";
echo json_encode([
    'id' => $tenant->id,
    'plan' => $tenant->plan,
    'subscription_ends_at' => optional($tenant->subscription_ends_at)?->toDateTimeString(),
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n\n";

echo "=== SUSCRIPCIÓN MP (última) ===\n";
echo json_encode($subscription ? [
    'id' => $subscription->id,
    'mercadopago_id' => $subscription->mercadopago_id,
    'mercadopago_status' => $subscription->mercadopago_status,
    'status' => $subscription->status,
    'plan' => $subscription->plan,
    'amount' => $subscription->amount,
    'currency' => $subscription->currency,
    'current_period_start' => optional($subscription->current_period_start)?->toDateTimeString(),
    'current_period_end' => optional($subscription->current_period_end)?->toDateTimeString(),
    'canceled_at' => optional($subscription->canceled_at)?->toDateTimeString(),
] : null, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n\n";

echo "=== FACTURAS MP (últimas 5) ===\n";
echo json_encode($invoices->map(function (Invoice $invoice) {
    return [
        'id' => $invoice->id,
        'invoice_number' => $invoice->invoice_number,
        'mercadopago_invoice_id' => $invoice->mercadopago_invoice_id,
        'total' => $invoice->total,
        'status' => $invoice->status,
        'paid_at' => optional($invoice->paid_at)?->toDateTimeString(),
        'created_at' => optional($invoice->created_at)?->toDateTimeString(),
    ];
})->values(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";
