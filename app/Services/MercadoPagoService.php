<?php

namespace App\Services;

use App\Models\Subscription;
use App\Models\Invoice;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Client\Payment\PaymentClient;

class MercadoPagoService
{
    public function __construct()
    {
        $token = config('services.mercadopago.access_token');
        if ($token) {
            MercadoPagoConfig::setAccessToken($token);
        }
    }

    /**
     * Create a preference for subscription
     */
    public function createPreference(Tenant $tenant, string $plan, string $successUrl, string $failureUrl, string $pendingUrl): string
    {
        $planDetails = $this->getPlanDetails($plan);

        $client = new PreferenceClient();

        $preference = $client->create([
            'items' => [
                [
                    'title' => $planDetails['name'],
                    'description' => implode(', ', $planDetails['features']),
                    'quantity' => 1,
                    'unit_price' => (float) $planDetails['price'],
                    'currency_id' => 'ARS',
                ],
            ],
            'payer' => [
                'name' => $tenant->name,
                'email' => $tenant->email,
            ],
            'back_urls' => [
                'success' => $successUrl,
                'failure' => $failureUrl,
                'pending' => $pendingUrl,
            ],
            'auto_return' => 'approved',
            'external_reference' => json_encode([
                'tenant_id' => $tenant->id,
                'plan' => $plan,
            ]),
            'notification_url' => route('webhooks.mercadopago'),
        ]);

        return $preference->init_point ?? $preference->sandbox_init_point;
    }

    /**
     * Handle webhook from MercadoPago
     */
    public function handleWebhook(array $data): void
    {
        try {
            $type = $data['type'] ?? null;
            $dataId = $data['data']['id'] ?? null;

            if (!$type || !$dataId) {
                Log::warning('Invalid MercadoPago webhook data', $data);
                return;
            }

            switch ($type) {
                case 'payment':
                    $this->handlePayment($dataId);
                    break;

                default:
                    Log::info('Unhandled MercadoPago webhook type', ['type' => $type]);
            }
        } catch (\Exception $e) {
            Log::error('MercadoPago webhook error', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * Verify MercadoPago webhook signature
     */
    public function verifyWebhookSignature(Request $request): bool
    {
        $secret = config('services.mercadopago.webhook_secret');

        if (!$secret) {
            Log::warning('MercadoPago webhook secret not configured');
            return app()->environment('local');
        }

        $signatureHeader = $request->header('X-Signature');
        $requestId = $request->header('X-Request-Id');

        if (!$signatureHeader || !$requestId) {
            Log::warning('MercadoPago webhook missing signature headers', [
                'has_signature' => (bool) $signatureHeader,
                'has_request_id' => (bool) $requestId,
            ]);
            return false;
        }

        $parts = [];
        foreach (explode(',', $signatureHeader) as $pair) {
            $pieces = array_map('trim', explode('=', $pair, 2));
            if (count($pieces) !== 2) {
                continue;
            }

            [$key, $value] = $pieces;
            if ($key && $value) {
                $parts[$key] = $value;
            }
        }

        $timestamp = $parts['ts'] ?? null;
        $signature = $parts['v1'] ?? null;

        if (!$timestamp || !$signature) {
            Log::warning('MercadoPago webhook invalid signature format', [
                'signature_header' => $signatureHeader,
            ]);
            return false;
        }

        $dataId = $request->input('data.id') ?? $request->input('id') ?? $request->input('data');

        if (!$dataId) {
            Log::warning('MercadoPago webhook missing data id');
            return false;
        }

        $manifest = "id:$dataId;request-id:$requestId;ts:$timestamp;";
        $expectedSignature = hash_hmac('sha256', $manifest, $secret);

        return hash_equals($expectedSignature, $signature);
    }

    /**
     * Handle payment notification
     */
    private function handlePayment(string $paymentId): void
    {
        try {
            $paymentClient = new PaymentClient();
            $payment = $paymentClient->get((int) $paymentId);

            if (!$payment) {
                Log::error('Payment not found', ['payment_id' => $paymentId]);
                return;
            }

            $externalReference = json_decode($payment->external_reference, true);
            $tenantId = $externalReference['tenant_id'] ?? null;
            $plan = $externalReference['plan'] ?? 'basic';

            if (!$tenantId) {
                Log::error('Payment without tenant_id', ['payment_id' => $paymentId]);
                return;
            }

            $tenant = Tenant::find($tenantId);
            if (!$tenant) {
                Log::error('Tenant not found', ['tenant_id' => $tenantId]);
                return;
            }

            if ($payment->status === 'approved') {
                $this->handleApprovedPayment($payment, $tenant, $plan);
            } elseif ($payment->status === 'rejected') {
                $this->handleRejectedPayment($payment, $tenant);
            }
        } catch (\Exception $e) {
            Log::error('Error processing MercadoPago payment', [
                'error' => $e->getMessage(),
                'payment_id' => $paymentId,
            ]);
        }
    }

    /**
     * Handle approved payment
     */
    private function handleApprovedPayment($payment, Tenant $tenant, string $plan): void
    {
        $planDetails = $this->getPlanDetails($plan);

        // Create or update subscription
        $subscription = Subscription::updateOrCreate(
            [
                'tenant_id' => $tenant->id,
                'mercadopago_id' => $payment->id,
            ],
            [
                'mercadopago_status' => $payment->status,
                'plan' => $plan,
                'payment_method' => 'mercadopago',
                'status' => 'active',
                'amount' => $planDetails['price'],
                'currency' => 'ARS',
                'current_period_start' => now(),
                'current_period_end' => now()->addMonth(),
            ]
        );

        // Create invoice
        Invoice::create([
            'tenant_id' => $tenant->id,
            'subscription_id' => $subscription->id,
            'invoice_number' => Invoice::generateInvoiceNumber(),
            'mercadopago_invoice_id' => $payment->id,
            'amount' => $payment->transaction_amount,
            'currency' => 'ARS',
            'total' => $payment->transaction_amount,
            'status' => 'paid',
            'payment_method' => 'mercadopago',
            'paid_at' => now(),
        ]);

        // Update tenant
        $tenant->update([
            'plan' => $plan,
            'subscription_ends_at' => now()->addMonth(),
        ]);

        Log::info('MercadoPago subscription created successfully', [
            'tenant_id' => $tenant->id,
            'plan' => $plan,
        ]);
    }

    /**
     * Handle rejected payment
     */
    private function handleRejectedPayment($payment, Tenant $tenant): void
    {
        Log::warning('MercadoPago payment rejected', [
            'tenant_id' => $tenant->id,
            'payment_id' => $payment->id,
            'status_detail' => $payment->status_detail,
        ]);

        // TODO: Send notification email
    }

    /**
     * Get plan details
     */
    private function getPlanDetails(string $plan): array
    {
        $plans = [
            'basic' => [
                'name' => 'Plan Básico',
                'price' => 29000, // ARS
                'features' => ['10 vehículos', 'Plantilla básica', 'Soporte email'],
            ],
            'premium' => [
                'name' => 'Plan Premium',
                'price' => 79000,
                'features' => ['50 vehículos', '4 plantillas', 'Soporte prioritario', 'Analytics'],
            ],
            'enterprise' => [
                'name' => 'Plan Enterprise',
                'price' => 199000,
                'features' => ['Vehículos ilimitados', 'Plantillas custom', 'Soporte 24/7', 'API access'],
            ],
        ];

        return $plans[$plan] ?? $plans['basic'];
    }
}
