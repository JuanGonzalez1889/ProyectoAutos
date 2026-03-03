<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\Subscription;
use App\Models\Tenant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\Client\PreApproval\PreApprovalClient;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Exceptions\MPApiException;
use MercadoPago\MercadoPagoConfig;

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
     * Crear suscripción mensual automática con Mercado Pago PreApproval
     */
    public function createPreference($plan, $price, $userEmail)
    {
        $traceId = (string) Str::uuid();
        $planDetails = $this->getPlanDetails((string) $plan);
        $tenantId = Auth::user()?->tenant_id;
        $transactionAmount = (float) ($price ?: $planDetails['price']);
        $resolvedPayerEmail = $this->resolvePayerEmail((string) $userEmail);
        $checkoutBaseUrl = $this->resolveCheckoutBaseUrl();
        $webhookBaseUrl = $this->resolveWebhookBaseUrl($checkoutBaseUrl);

        Log::info('MP_DEBUG_CREATE_PREF', [
            'trace_id' => $traceId,
            'access_token_masked' => $this->maskSecret((string) config('services.mercadopago.access_token')),
            'plan' => $plan,
            'price' => $price,
            'user_email' => $userEmail,
            'resolved_payer_email' => $resolvedPayerEmail,
            'tenant_id' => $tenantId,
            'checkout_base_url' => $checkoutBaseUrl,
            'webhook_base_url' => $webhookBaseUrl,
            'app_env' => config('app.env'),
        ]);

        try {
            $client = new PreApprovalClient();
            $payload = [
                'reason' => 'Suscripción mensual ' . $planDetails['name'],
                'payer_email' => $resolvedPayerEmail,
                'back_url' => $checkoutBaseUrl . '/subscriptions/success',
                'status' => 'pending',
                'auto_recurring' => [
                    'frequency' => 1,
                    'frequency_type' => 'months',
                    'transaction_amount' => $transactionAmount,
                    'currency_id' => 'ARS',
                ],
                'external_reference' => json_encode([
                    'tenant_id' => $tenantId,
                    'plan' => $plan,
                ]),
                'notification_url' => $webhookBaseUrl . '/webhooks/mercadopago',
            ];

            Log::info('MP_DEBUG_PAYLOAD', [
                'trace_id' => $traceId,
                'provider' => 'preapproval',
                'payload' => $this->sanitizePayloadForLogs($payload),
            ]);

            try {
                $preapproval = $client->create($payload);
            } catch (MPApiException $firstException) {
                $apiResponse = $firstException->getApiResponse();
                $responseContent = $apiResponse ? $apiResponse->getContent() : null;
                $apiMessage = is_array($responseContent)
                    ? ($responseContent['message'] ?? null)
                    : (is_object($responseContent) ? ($responseContent->message ?? null) : null);

                $shouldRetryWithoutPayerEmail = !empty($payload['payer_email'])
                    && is_string($apiMessage)
                    && stripos($apiMessage, 'internal server error') !== false;

                if (!$shouldRetryWithoutPayerEmail) {
                    Log::error('MP_PREAPPROVAL_PRIMARY_FAILED', array_merge([
                        'trace_id' => $traceId,
                        'tenant_id' => $tenantId,
                        'plan' => $plan,
                        'retry_without_payer_email' => false,
                    ], $this->extractApiExceptionDiagnostics($firstException)));
                    throw $firstException;
                }

                $retryPayload = $payload;
                unset($retryPayload['payer_email']);

                Log::warning('MP_PREAPPROVAL_RETRY_WITHOUT_PAYER_EMAIL', [
                    'trace_id' => $traceId,
                    'tenant_id' => $tenantId,
                    'plan' => $plan,
                    'first_error' => $apiMessage,
                    'retry_payload' => $this->sanitizePayloadForLogs($retryPayload),
                ]);

                try {
                    $preapproval = $client->create($retryPayload);
                } catch (MPApiException $retryException) {
                    Log::error('MP_PREAPPROVAL_RETRY_FAILED', array_merge([
                        'trace_id' => $traceId,
                        'tenant_id' => $tenantId,
                        'plan' => $plan,
                    ], $this->extractApiExceptionDiagnostics($retryException)));

                    throw $retryException;
                }
            }

            Log::info('MP_DEBUG_PREF_RESPONSE', [
                'trace_id' => $traceId,
                'preapproval' => $preapproval,
                'preapproval_id' => $preapproval->id ?? null,
                'init_point' => $preapproval->init_point ?? null,
                'status' => $preapproval->status ?? null,
            ]);

            if (isset($preapproval->status) && !in_array($preapproval->status, ['authorized', 'pending'], true)) {
                Log::warning('MP_DEBUG_PREF_STATUS', [
                    'trace_id' => $traceId,
                    'status' => $preapproval->status,
                ]);
            }

            if (isset($preapproval->init_point)) {
                return [
                    'init_point' => $preapproval->init_point,
                ];
            }

            Log::error('MP_DEBUG_NO_INIT_POINT', [
                'trace_id' => $traceId,
                'preapproval' => $preapproval,
            ]);

            return [
                'error' => 'Mercado Pago no devolvió init_point para iniciar el checkout de suscripción.',
            ];
        } catch (\Exception $e) {
            $fallbackPreference = $this->createCheckoutProFallback(
                $planDetails,
                $transactionAmount,
                $resolvedPayerEmail,
                $checkoutBaseUrl,
                $webhookBaseUrl,
                $tenantId,
                (string) $plan,
                $e,
                $traceId
            );

            if (isset($fallbackPreference['init_point'])) {
                return $fallbackPreference;
            }

            $friendlyError = 'No se pudo iniciar la suscripción automática en Mercado Pago.';

            Log::error('MP_DEBUG_EXCEPTION', [
                'trace_id' => $traceId,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'exception_class' => get_class($e),
            ]);

            try {
                if (method_exists($e, 'getApiResponse')) {
                    $apiResponse = call_user_func([$e, 'getApiResponse']);
                    $responseContent = $apiResponse ? $apiResponse->getContent() : null;
                    $apiMessage = null;

                    if (is_array($responseContent)) {
                        $apiMessage = $responseContent['message'] ?? null;
                    } elseif (is_object($responseContent)) {
                        $apiMessage = $responseContent->message ?? null;
                    }

                    if (!empty($apiMessage)) {
                        $friendlyError = 'Mercado Pago: ' . $apiMessage;

                        if (stripos($apiMessage, 'internal server error') !== false) {
                            $friendlyError .= ' (error temporal de Mercado Pago, reintentá en unos segundos).';
                        }

                        if (stripos($apiMessage, 'different countries') !== false) {
                            $friendlyError .= ' (usa un usuario comprador del mismo país que tu cuenta de Mercado Pago; en local podés setear MERCADOPAGO_TEST_PAYER_EMAIL).';
                        }
                    }

                    Log::error('MP_DEBUG_API_RESPONSE', [
                        'trace_id' => $traceId,
                        'diagnostics' => $this->extractApiExceptionDiagnostics($e),
                        'api_response' => $apiResponse ? json_encode($responseContent) : null,
                    ]);
                }
            } catch (\Throwable $t) {
                Log::error('MP_DEBUG_API_RESPONSE_FAIL', [
                    'trace_id' => $traceId,
                    'message' => $t->getMessage(),
                    'trace' => $t->getTraceAsString(),
                ]);
            }

            return [
                'error' => $friendlyError,
            ];
        }
    }

    private function createCheckoutProFallback(
        array $planDetails,
        float $transactionAmount,
        string $resolvedPayerEmail,
        string $checkoutBaseUrl,
        string $webhookBaseUrl,
        ?string $tenantId,
        string $plan,
        \Exception $originalException,
        string $traceId
    ): array {
        try {
            $client = new PreferenceClient();

            $payload = [
                'items' => [
                    [
                        'title' => 'Suscripción mensual ' . ($planDetails['name'] ?? 'Plan'),
                        'quantity' => 1,
                        'unit_price' => $transactionAmount,
                        'currency_id' => 'ARS',
                    ],
                ],
                'payer' => [
                    'email' => $resolvedPayerEmail,
                ],
                'back_urls' => [
                    'success' => $checkoutBaseUrl . '/subscriptions/success',
                    'failure' => $checkoutBaseUrl . '/subscriptions/failure',
                    'pending' => $checkoutBaseUrl . '/subscriptions/pending',
                ],
                'notification_url' => $webhookBaseUrl . '/webhooks/mercadopago',
                'external_reference' => json_encode([
                    'tenant_id' => $tenantId,
                    'plan' => $plan,
                ]),
                'auto_return' => 'approved',
            ];

            Log::warning('MP_PREAPPROVAL_FAILED_USING_CHECKOUT_PRO_FALLBACK', [
                'trace_id' => $traceId,
                'tenant_id' => $tenantId,
                'plan' => $plan,
                'original_exception' => get_class($originalException),
                'original_message' => $originalException->getMessage(),
                'fallback_payload' => $this->sanitizePayloadForLogs($payload),
            ]);

            $preference = $client->create($payload);

            if (!isset($preference->init_point)) {
                return [];
            }

            return [
                'init_point' => $preference->init_point,
                'sandbox_init_point' => $preference->sandbox_init_point ?? null,
                'fallback_mode' => 'checkout_pro',
            ];
        } catch (\Throwable $fallbackException) {
            $diagnostics = $fallbackException instanceof MPApiException
                ? $this->extractApiExceptionDiagnostics($fallbackException)
                : [];

            Log::error('MP_CHECKOUT_PRO_FALLBACK_FAILED', array_merge([
                'trace_id' => $traceId,
                'tenant_id' => $tenantId,
                'plan' => $plan,
                'error' => $fallbackException->getMessage(),
            ], $diagnostics));

            return [];
        }
    }

    private function extractApiExceptionDiagnostics(\Throwable $exception): array
    {
        $data = [
            'exception_class' => get_class($exception),
            'exception_message' => $exception->getMessage(),
        ];

        if (!method_exists($exception, 'getApiResponse')) {
            return $data;
        }

        try {
            $apiResponse = call_user_func([$exception, 'getApiResponse']);

            if (!$apiResponse) {
                return $data;
            }

            $statusCode = null;
            if (method_exists($apiResponse, 'getStatusCode')) {
                $statusCode = $apiResponse->getStatusCode();
            } elseif (property_exists($apiResponse, 'statusCode')) {
                $statusCode = $apiResponse->statusCode;
            }

            $content = null;
            if (method_exists($apiResponse, 'getContent')) {
                $content = $apiResponse->getContent();
            }

            $headers = null;
            if (method_exists($apiResponse, 'getHeaders')) {
                $headers = $apiResponse->getHeaders();
            } elseif (property_exists($apiResponse, 'headers')) {
                $headers = $apiResponse->headers;
            }

            $data['api_status_code'] = $statusCode;
            $data['api_content'] = is_string($content) ? $content : json_encode($content);
            $data['api_headers'] = $headers;
        } catch (\Throwable $parseError) {
            $data['api_parse_error'] = $parseError->getMessage();
        }

        return $data;
    }

    private function sanitizePayloadForLogs(array $payload): array
    {
        $sanitized = $payload;

        if (isset($sanitized['payer_email'])) {
            $sanitized['payer_email'] = $this->maskEmail((string) $sanitized['payer_email']);
        }

        if (isset($sanitized['payer']['email'])) {
            $sanitized['payer']['email'] = $this->maskEmail((string) $sanitized['payer']['email']);
        }

        return $sanitized;
    }

    private function maskEmail(string $email): string
    {
        $parts = explode('@', $email);
        if (count($parts) !== 2) {
            return '***';
        }

        $local = $parts[0];
        $domain = $parts[1];
        $maskedLocal = strlen($local) <= 2
            ? str_repeat('*', strlen($local))
            : substr($local, 0, 2) . str_repeat('*', max(strlen($local) - 2, 1));

        return $maskedLocal . '@' . $domain;
    }

    private function maskSecret(string $secret): string
    {
        if ($secret === '') {
            return '';
        }

        $length = strlen($secret);
        if ($length <= 8) {
            return str_repeat('*', $length);
        }

        return substr($secret, 0, 4) . str_repeat('*', $length - 8) . substr($secret, -4);
    }

    private function resolvePayerEmail(string $defaultEmail): string
    {
        $sandboxEmail = env('MERCADOPAGO_TEST_PAYER_EMAIL');

        if (!empty($sandboxEmail) && !app()->environment('production')) {
            $normalizedSandboxEmail = trim((string) $sandboxEmail);

            if (preg_match('/^testuser(\d+)$/i', $normalizedSandboxEmail, $matches)) {
                return 'test_user_' . $matches[1] . '@testuser.com';
            }

            if (!str_contains($normalizedSandboxEmail, '@')) {
                return strtolower($normalizedSandboxEmail) . '@testuser.com';
            }

            return strtolower($normalizedSandboxEmail);
        }

        return $defaultEmail;
    }

    private function resolveCheckoutBaseUrl(): string
    {
        $request = request();

        if ($request && $request->getHost()) {
            $scheme = $request->isSecure() ? 'https' : 'http';

            if (app()->environment('local')) {
                $scheme = 'http';
            }

            return $scheme . '://' . $request->getHttpHost();
        }

        return rtrim((string) config('app.url'), '/');
    }

    private function resolveWebhookBaseUrl(string $checkoutBaseUrl): string
    {
        if (app()->environment('local')) {
            return rtrim($checkoutBaseUrl, '/');
        }

        return rtrim((string) config('app.url'), '/');
    }

    public function syncFromCheckoutReturn(Request $request): void
    {
        $preapprovalId = $request->query('preapproval_id')
            ?? $request->query('subscription_id')
            ?? $request->query('id');

        if (!empty($preapprovalId) && preg_match('/^[a-z0-9]+$/i', (string) $preapprovalId)) {
            $this->handlePreapproval((string) $preapprovalId);
        }

        $paymentId = $request->query('collection_id')
            ?? $request->query('payment_id')
            ?? $request->query('data_id');

        if (!empty($paymentId) && is_numeric($paymentId)) {
            $this->handlePayment((string) $paymentId);
        }
    }

    public function handleWebhook(array $data): void
    {
        try {
            $type = $data['type'] ?? $data['topic'] ?? null;
            $dataId = $data['data']['id'] ?? null;

            if (!$type || !$dataId) {
                Log::warning('Invalid MercadoPago webhook data', $data);
                return;
            }

            switch ($type) {
                case 'payment':
                    $this->handlePayment($dataId);
                    break;
                case 'preapproval':
                case 'subscription_preapproval':
                    $this->handlePreapproval($dataId);
                    break;
                default:
                    Log::info('Unhandled MercadoPago webhook type', ['type' => $type]);
            }
        } catch (\Exception $e) {
            Log::error('MercadoPago webhook error', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

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

    private function handlePayment(string $paymentId): void
    {
        try {
            $paymentClient = new PaymentClient();
            $payment = $paymentClient->get((int) $paymentId);

            if (!$payment) {
                Log::error('Payment not found', ['payment_id' => $paymentId]);
                return;
            }

            $externalReference = $this->decodeExternalReference($payment->external_reference ?? null);
            $tenantId = $externalReference['tenant_id'] ?? null;
            $plan = $externalReference['plan'] ?? 'basico';

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

    private function handleApprovedPayment($payment, Tenant $tenant, string $plan): void
    {
        Log::info('MP_DEBUG_WEBHOOK_APPROVED_START', [
            'payment_id' => $payment->id,
            'tenant_id' => $tenant->id,
            'plan' => $plan,
            'payment_status' => $payment->status,
            'transaction_amount' => $payment->transaction_amount,
        ]);

        $this->applyApprovedRenewal(
            $tenant,
            $plan,
            (string) ($payment->id ?? ('mp-payment-' . Str::random(8))),
            (float) ($payment->transaction_amount ?? 0),
            (string) ($payment->currency_id ?? 'ARS')
        );
    }

    public function applyApprovedRenewal(
        Tenant $tenant,
        string $plan,
        string $referenceId,
        float $transactionAmount,
        string $currency = 'ARS'
    ): Subscription {
        $existingInvoice = Invoice::where('mercadopago_invoice_id', $referenceId)->first();
        if ($existingInvoice) {
            $existingSubscription = Subscription::where('tenant_id', $tenant->id)
                ->where('payment_method', 'mercadopago')
                ->latest('current_period_end')
                ->first();

            if ($existingSubscription) {
                Log::warning('MP_APPROVED_RENEWAL_DUPLICATE_REFERENCE', [
                    'tenant_id' => $tenant->id,
                    'reference_id' => $referenceId,
                    'subscription_id' => $existingSubscription->id,
                ]);

                return $existingSubscription;
            }
        }

        $planDetails = $this->getPlanDetails($plan);
        $currentPeriodStart = now();
        $currentPeriodEnd = now()->addMonth();

        $subscription = Subscription::where('tenant_id', $tenant->id)
            ->where('payment_method', 'mercadopago')
            ->latest('current_period_end')
            ->first();

        if ($subscription && $subscription->current_period_end && $subscription->current_period_end->isFuture()) {
            $currentPeriodStart = $subscription->current_period_end->copy();
            $currentPeriodEnd = $subscription->current_period_end->copy()->addMonth();
        }

        if (!$subscription) {
            $subscription = new Subscription([
                'tenant_id' => $tenant->id,
                'payment_method' => 'mercadopago',
            ]);
        }

        if (!$subscription->mercadopago_id) {
            $subscription->mercadopago_id = $referenceId;
        }

        $amount = $transactionAmount > 0 ? $transactionAmount : (float) $planDetails['price'];

        $subscription->fill([
            'mercadopago_status' => 'approved',
            'plan' => $plan,
            'status' => 'active',
            'amount' => $amount,
            'currency' => strtoupper($currency ?: 'ARS'),
            'current_period_start' => $currentPeriodStart,
            'current_period_end' => $currentPeriodEnd,
            'canceled_at' => null,
        ]);
        $subscription->save();

        Invoice::firstOrCreate(
            [
                'mercadopago_invoice_id' => $referenceId,
            ],
            [
                'tenant_id' => $tenant->id,
                'subscription_id' => $subscription->id,
                'invoice_number' => Invoice::generateInvoiceNumber(),
                'amount' => $amount,
                'currency' => strtoupper($currency ?: 'ARS'),
                'tax' => 0,
                'total' => $amount,
                'status' => 'paid',
                'payment_method' => 'mercadopago',
                'paid_at' => now(),
                'notes' => 'Renovación aprobada: ' . $referenceId,
            ]
        );

        $tenant->update([
            'plan' => $plan,
            'subscription_ends_at' => $subscription->current_period_end,
        ]);

        Log::info('MP_APPROVED_RENEWAL_APPLIED', [
            'tenant_id' => $tenant->id,
            'subscription_id' => $subscription->id,
            'reference_id' => $referenceId,
            'current_period_end' => $subscription->current_period_end,
        ]);

        return $subscription;
    }

    private function handleRejectedPayment($payment, Tenant $tenant): void
    {
        $reason = $this->buildRejectionReason(
            (string) ($payment->status_detail ?? ''),
            (string) ($payment->status ?? 'rejected')
        );

        $referenceId = (string) ($payment->id ?? ('mp-rejected-' . Str::random(8)));

        Log::warning('MercadoPago payment rejected', [
            'tenant_id' => $tenant->id,
            'payment_id' => $referenceId,
            'status_detail' => $payment->status_detail ?? null,
            'reason' => $reason,
        ]);

        $this->applyRejectedRenewal($tenant, $reason, $referenceId);
    }

    public function applyRejectedRenewal(Tenant $tenant, string $reason, string $referenceId): ?Subscription
    {
        $subscription = Subscription::where('tenant_id', $tenant->id)
            ->where('payment_method', 'mercadopago')
            ->latest('updated_at')
            ->first();

        if (!$subscription) {
            Log::warning('MP_REJECTED_WITHOUT_SUBSCRIPTION', [
                'tenant_id' => $tenant->id,
                'reference_id' => $referenceId,
            ]);
            return null;
        }

        $subscription->update([
            'status' => 'pending',
            'mercadopago_status' => 'paused:' . $reason,
            'canceled_at' => null,
        ]);

        Invoice::firstOrCreate(
            [
                'mercadopago_invoice_id' => $referenceId,
            ],
            [
                'tenant_id' => $tenant->id,
                'subscription_id' => $subscription->id,
                'invoice_number' => Invoice::generateInvoiceNumber(),
                'amount' => (float) $subscription->amount,
                'currency' => strtoupper((string) ($subscription->currency ?? 'ARS')),
                'tax' => 0,
                'total' => (float) $subscription->amount,
                'status' => 'failed',
                'payment_method' => 'mercadopago',
                'notes' => 'Pago rechazado: ' . $reason,
            ]
        );

        $tenant->update([
            'subscription_ends_at' => $subscription->current_period_end,
        ]);

        Log::warning('MP_REJECTED_RENEWAL_APPLIED', [
            'tenant_id' => $tenant->id,
            'subscription_id' => $subscription->id,
            'reference_id' => $referenceId,
            'reason' => $reason,
        ]);

        return $subscription;
    }

    private function handlePreapproval(string $preapprovalId): void
    {
        try {
            $client = new PreApprovalClient();
            $preapproval = $client->get($preapprovalId);

            $externalReference = $this->decodeExternalReference($preapproval->external_reference ?? null);
            $tenantId = $externalReference['tenant_id'] ?? null;
            $plan = $externalReference['plan'] ?? 'basico';

            if (!$tenantId) {
                Log::warning('Preapproval without tenant_id', ['preapproval_id' => $preapprovalId]);
                return;
            }

            $tenant = Tenant::find($tenantId);
            if (!$tenant) {
                Log::warning('Preapproval tenant not found', ['tenant_id' => $tenantId, 'preapproval_id' => $preapprovalId]);
                return;
            }

            $planDetails = $this->getPlanDetails($plan);
            $autoRecurring = is_array($preapproval->auto_recurring)
                ? $preapproval->auto_recurring
                : (array) $preapproval->auto_recurring;
            $nextPaymentDate = !empty($preapproval->next_payment_date)
                ? Carbon::parse($preapproval->next_payment_date)
                : now()->addMonth();

            $status = $this->mapPreapprovalStatus((string) ($preapproval->status ?? 'pending'));

            $subscription = Subscription::where('tenant_id', $tenant->id)
                ->where('payment_method', 'mercadopago')
                ->whereIn('status', ['active', 'pending'])
                ->latest('updated_at')
                ->first();

            if (!$subscription) {
                $subscription = new Subscription([
                    'tenant_id' => $tenant->id,
                    'payment_method' => 'mercadopago',
                ]);
            }

            $subscription->fill([
                'mercadopago_id' => (string) $preapproval->id,
                'mercadopago_status' => $preapproval->status,
                'plan' => $plan,
                'status' => $status,
                'amount' => (float) ($autoRecurring['transaction_amount'] ?? $planDetails['price']),
                'currency' => strtoupper((string) ($autoRecurring['currency_id'] ?? 'ARS')),
                'current_period_start' => now(),
                'current_period_end' => $nextPaymentDate,
                'canceled_at' => in_array($status, ['canceled', 'expired'], true) ? now() : null,
            ]);
            $subscription->save();

            if ($status === 'active') {
                $tenant->update([
                    'plan' => $plan,
                    'subscription_ends_at' => $nextPaymentDate,
                ]);
            }

            Log::info('MP_DEBUG_PREAPPROVAL_PROCESSED', [
                'preapproval_id' => $preapproval->id,
                'tenant_id' => $tenant->id,
                'status' => $preapproval->status,
                'mapped_status' => $status,
                'subscription_id' => $subscription->id,
                'next_payment_date' => $nextPaymentDate,
            ]);
        } catch (\Exception $e) {
            Log::error('Error processing MercadoPago preapproval', [
                'error' => $e->getMessage(),
                'preapproval_id' => $preapprovalId,
            ]);
        }
    }

    public function cancelSubscription(Subscription $subscription): void
    {
        if ($subscription->payment_method !== 'mercadopago') {
            throw new \Exception('This subscription is not managed by Mercado Pago');
        }

        if (empty($subscription->mercadopago_id)) {
            $subscription->cancel();
            return;
        }

        if (is_numeric($subscription->mercadopago_id)) {
            Log::warning('Legacy MercadoPago subscription id detected, canceling locally', [
                'subscription_id' => $subscription->id,
                'mercadopago_id' => $subscription->mercadopago_id,
            ]);

            $subscription->cancel();
            return;
        }

        try {
            $client = new PreApprovalClient();
            $client->update((string) $subscription->mercadopago_id, [
                'status' => 'cancelled',
            ]);

            $subscription->update([
                'mercadopago_status' => 'cancelled',
                'status' => 'canceled',
                'canceled_at' => now(),
            ]);
        } catch (\Exception $e) {
            Log::error('Error canceling MercadoPago subscription', [
                'subscription_id' => $subscription->id,
                'mercadopago_id' => $subscription->mercadopago_id,
                'error' => $e->getMessage(),
            ]);

            $subscription->cancel();
        }
    }

    /**
     * Reconciliar una suscripción local con el estado remoto en Mercado Pago
     */
    public function reconcileSubscriptionFromRemote(Subscription $subscription, bool $applyChanges = true): array
    {
        if ($subscription->payment_method !== 'mercadopago') {
            return [
                'subscription_id' => $subscription->id,
                'result' => 'skipped',
                'reason' => 'payment_method_not_mercadopago',
            ];
        }

        if (empty($subscription->mercadopago_id) || is_numeric($subscription->mercadopago_id)) {
            return [
                'subscription_id' => $subscription->id,
                'result' => 'skipped',
                'reason' => 'invalid_or_legacy_mercadopago_id',
            ];
        }

        $client = new PreApprovalClient();
        $preapproval = $client->get((string) $subscription->mercadopago_id);

        $remoteStatus = strtolower((string) ($preapproval->status ?? 'pending'));
        $mappedStatus = $this->mapPreapprovalStatus($remoteStatus);
        $externalReference = $this->decodeExternalReference($preapproval->external_reference ?? null);
        $plan = (string) ($externalReference['plan'] ?? $subscription->plan);
        $autoRecurring = is_array($preapproval->auto_recurring)
            ? $preapproval->auto_recurring
            : (array) $preapproval->auto_recurring;

        $nextPaymentDate = !empty($preapproval->next_payment_date)
            ? Carbon::parse($preapproval->next_payment_date)
            : $subscription->current_period_end;

        $mercadopagoStatus = (string) ($preapproval->status ?? $subscription->mercadopago_status);
        if ($remoteStatus === 'paused' && !str_starts_with($mercadopagoStatus, 'paused:')) {
            $mercadopagoStatus = 'paused:Pago pendiente de reintento en Mercado Pago.';
        }

        $payload = [
            'status' => $mappedStatus,
            'mercadopago_status' => $mercadopagoStatus,
            'plan' => $plan,
            'amount' => (float) ($autoRecurring['transaction_amount'] ?? $subscription->amount),
            'currency' => strtoupper((string) ($autoRecurring['currency_id'] ?? $subscription->currency ?? 'ARS')),
        ];

        if ($mappedStatus === 'active') {
            $normalizedPeriodEnd = $nextPaymentDate ?? $subscription->current_period_end ?? now()->addMonth();
            $normalizedPeriodStart = $subscription->current_period_start;

            if (!$normalizedPeriodStart || $normalizedPeriodStart->gt($normalizedPeriodEnd)) {
                $normalizedPeriodStart = $normalizedPeriodEnd->copy()->subMonth();
            }

            $payload['current_period_start'] = $normalizedPeriodStart;
            $payload['current_period_end'] = $normalizedPeriodEnd;
            $payload['canceled_at'] = null;
        }

        if ($mappedStatus === 'canceled') {
            $payload['canceled_at'] = now();
        }

        if ($mappedStatus === 'pending') {
            $payload['canceled_at'] = null;
        }

        if ($applyChanges) {
            $subscription->update($payload);

            if ($subscription->tenant) {
                if ($mappedStatus === 'active') {
                    $subscription->tenant->update([
                        'plan' => $plan,
                        'subscription_ends_at' => $payload['current_period_end'] ?? $subscription->current_period_end,
                    ]);
                } elseif ($mappedStatus === 'canceled') {
                    $subscription->tenant->update([
                        'subscription_ends_at' => now(),
                    ]);
                }
            }
        }

        return [
            'subscription_id' => $subscription->id,
            'result' => 'ok',
            'remote_status' => $remoteStatus,
            'local_status' => $mappedStatus,
            'mercadopago_status' => $mercadopagoStatus,
            'applied' => $applyChanges,
        ];
    }

    private function decodeExternalReference(?string $externalReference): array
    {
        if (empty($externalReference)) {
            return [];
        }

        $decoded = json_decode($externalReference, true);

        return is_array($decoded) ? $decoded : [];
    }

    private function mapPreapprovalStatus(string $status): string
    {
        return match (strtolower($status)) {
            'authorized' => 'active',
            'paused' => 'pending',
            'cancelled', 'cancelled_by_user' => 'canceled',
            default => 'pending',
        };
    }

    private function buildRejectionReason(string $statusDetail, string $status): string
    {
        $statusDetail = strtolower(trim($statusDetail));

        if ($statusDetail === '') {
            return 'Pago rechazado por Mercado Pago.';
        }

        $map = [
            'cc_rejected_insufficient_amount' => 'Fondos insuficientes.',
            'cc_rejected_bad_filled_date' => 'Fecha de vencimiento inválida.',
            'cc_rejected_bad_filled_security_code' => 'Código de seguridad inválido.',
            'cc_rejected_bad_filled_other' => 'Datos de tarjeta inválidos.',
            'cc_rejected_call_for_authorize' => 'Debes autorizar el pago con tu banco.',
            'cc_rejected_card_disabled' => 'La tarjeta está deshabilitada.',
            'cc_rejected_card_error' => 'Error con la tarjeta.',
            'cc_rejected_duplicated_payment' => 'Ya se intentó un pago similar.',
            'cc_rejected_high_risk' => 'Pago rechazado por seguridad.',
            'cc_rejected_max_attempts' => 'Se superó el máximo de intentos.',
            'cc_rejected_other_reason' => 'Tu banco rechazó el pago.',
        ];

        return $map[$statusDetail] ?? ('Pago rechazado (' . ($status ?: 'rejected') . ': ' . $statusDetail . ').');
    }

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
