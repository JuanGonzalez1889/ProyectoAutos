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
            // Línea eliminada: setRuntimeEnvironment no existe en dx-php
        }
    }

    /**
     * Create a preference for subscription
     */
    /**
     * Crear preferencia simple para Checkout Pro (solo suscripción manual, email test)
     */
    public function createPreference($plan, $price, $userEmail)
    {
       
        // Log de entrada
        Log::info('MP_DEBUG_CREATE_PREF', [
            'access_token' => config('services.mercadopago.access_token'),
            'plan' => $plan,
            'price' => $price,
            'user_email' => $userEmail,
        ]);
        try {
            $client = new \MercadoPago\Client\Preference\PreferenceClient();
            $payload = [
                "items" => [
                    [
                        "id" => "PLAN-" . time(),
                        "title" => "Suscripcion " . $plan,
                        "description" => "Suscripcion mensual al plan " . $plan,
                        "quantity" => 1,
                        "unit_price" => (float) $price,
                        "currency_id" => "ARS",
                    ]
                ],
                "payer" => [
                    "email" => $userEmail,
                ],
                "back_urls" => [
                    "success" => config('app.url') . '/subscriptions/success',
                    "failure" => config('app.url') . '/subscriptions/failure',
                ],
                "notification_url" => config('app.url') . '/webhooks/mercadopago',
                "external_reference" => json_encode([
                    'tenant_id' => auth()->user()->tenant_id ?? null,
                    'plan' => $plan
                ]),
                "auto_return" => "approved",
            ];
            Log::info('MP_DEBUG_PAYLOAD', $payload);
            $preference = $client->create($payload);
            Log::info('MP_DEBUG_PREF_RESPONSE', [
                'preference' => $preference,
                'init_point' => $preference->init_point ?? null,
                'sandbox_init_point' => $preference->sandbox_init_point ?? null,
                'status' => $preference->status ?? null,
                'error' => $preference->error ?? null,
                'message' => $preference->message ?? null,
                'details' => $preference->details ?? null,
            ]);
            if (isset($preference->status) && $preference->status !== 'active') {
                Log::warning('MP_DEBUG_PREF_STATUS', [
                    'status' => $preference->status,
                    'error' => $preference->error ?? null,
                    'message' => $preference->message ?? null,
                    'details' => $preference->details ?? null,
                ]);
            }
            // Preferimos el init_point real
            if (isset($preference->init_point)) {
                return [
                    'init_point' => $preference->init_point,
                    'sandbox_init_point' => $preference->sandbox_init_point ?? null,
                ];
            } else {
                Log::error('MP_DEBUG_NO_INIT_POINT', [
                    'preference' => $preference
                ]);
                return null;
            }
        } catch (\Exception $e) {
            Log::error('MP_DEBUG_EXCEPTION', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'exception_class' => get_class($e),
            ]);
            try {
                if (method_exists($e, 'getApiResponse')) {
                    Log::error('MP_DEBUG_API_RESPONSE', [
                        'api_response' => json_encode($e->getApiResponse()->getContent())
                    ]);
                }
            } catch (\Throwable $t) {
                Log::error('MP_DEBUG_API_RESPONSE_FAIL', [
                    'message' => $t->getMessage(),
                    'trace' => $t->getTraceAsString(),
                ]);
            }
            return null;
        }
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
        Log::info('MP_DEBUG_WEBHOOK_APPROVED_START', [
            'payment_id' => $payment->id,
            'tenant_id' => $tenant->id,
            'plan' => $plan,
            'payment_status' => $payment->status,
            'transaction_amount' => $payment->transaction_amount,
        ]);

        $planDetails = $this->getPlanDetails($plan);

        try {
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
            Log::info('MP_DEBUG_WEBHOOK_SUBSCRIPTION', [
                'subscription_id' => $subscription->id ?? null,
                'tenant_id' => $tenant->id,
                'mercadopago_id' => $payment->id,
            ]);

            $invoice = Invoice::create([
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
            Log::info('MP_DEBUG_WEBHOOK_INVOICE', [
                'invoice_id' => $invoice->id ?? null,
                'tenant_id' => $tenant->id,
                'subscription_id' => $subscription->id,
            ]);

            $tenant->update([
                'plan' => $plan,
                'subscription_ends_at' => now()->addMonth(),
            ]);
            Log::info('MP_DEBUG_WEBHOOK_TENANT_UPDATED', [
                'tenant_id' => $tenant->id,
                'plan' => $plan,
                'subscription_ends_at' => $tenant->subscription_ends_at,
            ]);
        } catch (\Exception $e) {
            Log::error('MP_DEBUG_WEBHOOK_ERROR', [
                'error' => $e->getMessage(),
                'payment_id' => $payment->id,
                'tenant_id' => $tenant->id,
            ]);
        }
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
    public function getPlanDetails(string $plan): array
    {
        $plans = [
            'basico' => [
                'name' => 'Plan Básico',
                'price' => 50000,
                'features' => ['Sitio web básico', '15 autos máx', 'Soporte WhatsApp'],
            ],
            'profesional' => [
                'name' => 'Plan Profesional',
                'price' => 150000,
                'features' => ['Integración CRM básica', '30 autos máx', 'Herramientas SEO'],
            ],
            'premium' => [
                'name' => 'Plan Premium',
                'price' => 300000,
                'features' => ['Publicación ilimitada', 'Soporte 24/7', 'Analítica avanzada'],
            ],
            'premium_plus' => [
                'name' => 'Plan Premium +',
                'price' => 500000,
                'features' => ['Manejo de Redes Sociales', 'Gestión de marketing completa'],
            ],
            'test100' => [
                'name' => 'Plan Test $100',
                'price' => 100,
                'features' => ['Prueba real de pago', 'Soporte limitado'],
            ],
        ];

        return $plans[strtolower($plan)] ?? $plans['basico'];
    }
}
