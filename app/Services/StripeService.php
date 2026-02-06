<?php

namespace App\Services;

use App\Models\Subscription;
use App\Models\Invoice;
use App\Models\Tenant;
use Stripe\Stripe;
use Stripe\Checkout\Session as CheckoutSession;
use Stripe\Customer;
use Stripe\Subscription as StripeSubscription;
use Stripe\Webhook;
use Illuminate\Support\Facades\Log;

class StripeService
{
        private $hasApiKey = false;

        public function __construct()
        {
            $apiKey = config('services.stripe.secret');
            if ($apiKey) {
                Stripe::setApiKey($apiKey);
                $this->hasApiKey = true;
            }
        }

        public function isConfigured(): bool
        {
            return $this->hasApiKey;
        }

    /**
     * Create a checkout session for subscription
     */
    public function createCheckoutSession(Tenant $tenant, string $plan, string $successUrl, string $cancelUrl): string
    {
        $planDetails = $this->getPlanDetails($plan);

        // Create or get customer
        $customer = $this->getOrCreateCustomer($tenant);

        $session = CheckoutSession::create([
            'customer' => $customer->id,
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'unit_amount' => $planDetails['price'] * 100, // Convert to cents
                    'recurring' => [
                        'interval' => 'month',
                    ],
                    'product_data' => [
                        'name' => $planDetails['name'],
                        'description' => implode(', ', $planDetails['features']),
                    ],
                ],
                'quantity' => 1,
            ]],
            'mode' => 'subscription',
            'success_url' => $successUrl,
            'cancel_url' => $cancelUrl,
            'metadata' => [
                'tenant_id' => $tenant->id,
                'plan' => $plan,
            ],
        ]);

        return $session->url;
    }

    /**
     * Get or create Stripe customer for tenant
     */
    private function getOrCreateCustomer(Tenant $tenant): Customer
    {
        // Check if tenant already has a Stripe customer ID
        $subscription = $tenant->subscriptions()->latest()->first();
        
        if ($subscription && $subscription->stripe_id) {
            try {
                return Customer::retrieve($subscription->stripe_id);
            } catch (\Exception $e) {
                // Customer not found, create new one
            }
        }

        return Customer::create([
            'email' => $tenant->email,
            'name' => $tenant->name,
            'metadata' => [
                'tenant_id' => $tenant->id,
            ],
        ]);
    }

    /**
     * Handle webhook from Stripe
     */
    public function handleWebhook(string $payload, string $signature): void
    {
        try {
            $event = Webhook::constructEvent(
                $payload,
                $signature,
                config('services.stripe.webhook_secret')
            );

            switch ($event->type) {
                case 'checkout.session.completed':
                    $this->handleCheckoutCompleted($event->data->object);
                    break;

                case 'invoice.paid':
                    $this->handleInvoicePaid($event->data->object);
                    break;

                case 'invoice.payment_failed':
                    $this->handleInvoiceFailed($event->data->object);
                    break;

                case 'customer.subscription.updated':
                    $this->handleSubscriptionUpdated($event->data->object);
                    break;

                case 'customer.subscription.deleted':
                    $this->handleSubscriptionCanceled($event->data->object);
                    break;

                default:
                    Log::info('Unhandled Stripe webhook event', ['type' => $event->type]);
            }
        } catch (\Exception $e) {
            Log::error('Stripe webhook error', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * Handle checkout session completed
     */
    private function handleCheckoutCompleted($session): void
    {
        $tenantId = $session->metadata->tenant_id ?? null;
        $plan = $session->metadata->plan ?? 'basic';

        if (!$tenantId) {
            Log::error('Checkout session without tenant_id', ['session' => $session->id]);
            return;
        }

        $tenant = Tenant::find($tenantId);
        if (!$tenant) {
            Log::error('Tenant not found', ['tenant_id' => $tenantId]);
            return;
        }

        // Get subscription from Stripe
        $stripeSubscription = StripeSubscription::retrieve($session->subscription);

        $planDetails = $this->getPlanDetails($plan);

        // Create subscription record
        Subscription::create([
            'tenant_id' => $tenant->id,
            'stripe_id' => $session->customer,
            'stripe_status' => $stripeSubscription->status,
            'stripe_price' => $stripeSubscription->items->data[0]->price->id,
            'plan' => $plan,
            'payment_method' => 'stripe',
            'status' => 'active',
            'amount' => $planDetails['price'],
            'currency' => 'USD',
            'current_period_start' => now(),
            'current_period_end' => now()->addMonth(),
        ]);

        // Update tenant
        $tenant->update([
            'plan' => $plan,
            'subscription_ends_at' => now()->addMonth(),
        ]);

        Log::info('Subscription created successfully', [
            'tenant_id' => $tenant->id,
            'plan' => $plan,
        ]);
    }

    /**
     * Handle invoice paid
     */
    private function handleInvoicePaid($invoice): void
    {
        // Create invoice record
        $tenant = Tenant::whereHas('subscriptions', function ($query) use ($invoice) {
            $query->where('stripe_id', $invoice->customer);
        })->first();

        if (!$tenant) {
            Log::warning('Tenant not found for paid invoice', ['customer' => $invoice->customer]);
            return;
        }

        $subscription = $tenant->subscriptions()
            ->where('stripe_id', $invoice->customer)
            ->latest()
            ->first();

        Invoice::create([
            'tenant_id' => $tenant->id,
            'subscription_id' => $subscription?->id,
            'invoice_number' => Invoice::generateInvoiceNumber(),
            'stripe_invoice_id' => $invoice->id,
            'amount' => $invoice->amount_paid / 100,
            'currency' => strtoupper($invoice->currency),
            'total' => $invoice->total / 100,
            'status' => 'paid',
            'payment_method' => 'stripe',
            'paid_at' => now(),
        ]);

        Log::info('Invoice paid successfully', [
            'tenant_id' => $tenant->id,
            'amount' => $invoice->amount_paid / 100,
        ]);
    }

    /**
     * Handle invoice payment failed
     */
    private function handleInvoiceFailed($invoice): void
    {
        $tenant = Tenant::whereHas('subscriptions', function ($query) use ($invoice) {
            $query->where('stripe_id', $invoice->customer);
        })->first();

        if (!$tenant) {
            return;
        }

        Log::warning('Invoice payment failed', [
            'tenant_id' => $tenant->id,
            'invoice_id' => $invoice->id,
        ]);

        // TODO: Send notification email
    }

    /**
     * Handle subscription updated
     */
    private function handleSubscriptionUpdated($subscription): void
    {
        $tenantSubscription = Subscription::where('stripe_id', $subscription->customer)->latest()->first();

        if ($tenantSubscription) {
            $tenantSubscription->update([
                'stripe_status' => $subscription->status,
                'status' => $subscription->status === 'active' ? 'active' : 'canceled',
                'current_period_end' => \Carbon\Carbon::createFromTimestamp($subscription->current_period_end),
            ]);

            // Update tenant
            $tenantSubscription->tenant->update([
                'subscription_ends_at' => \Carbon\Carbon::createFromTimestamp($subscription->current_period_end),
            ]);
        }
    }

    /**
     * Handle subscription canceled
     */
    private function handleSubscriptionCanceled($subscription): void
    {
        $tenantSubscription = Subscription::where('stripe_id', $subscription->customer)->latest()->first();

        if ($tenantSubscription) {
            $tenantSubscription->cancel();

            Log::info('Subscription canceled', [
                'tenant_id' => $tenantSubscription->tenant_id,
            ]);
        }
    }

    /**
     * Get plan details
     */
    private function getPlanDetails(string $plan): array
    {
        $plans = [
            'basic' => [
                'name' => 'Plan Básico',
                'price' => 29,
                'features' => ['10 vehículos', 'Plantilla básica', 'Soporte email'],
            ],
            'premium' => [
                'name' => 'Plan Premium',
                'price' => 79,
                'features' => ['50 vehículos', '4 plantillas', 'Soporte prioritario', 'Analytics'],
            ],
            'enterprise' => [
                'name' => 'Plan Enterprise',
                'price' => 199,
                'features' => ['Vehículos ilimitados', 'Plantillas custom', 'Soporte 24/7', 'API access'],
            ],
        ];

        return $plans[$plan] ?? $plans['basic'];
    }

    /**
     * Cancel subscription
     */
    public function cancelSubscription(Subscription $subscription): void
    {
        if ($subscription->payment_method !== 'stripe') {
            throw new \Exception('This subscription is not managed by Stripe');
        }

        try {
            $stripeSubscription = StripeSubscription::retrieve($subscription->stripe_price);
            $stripeSubscription->cancel();

            $subscription->cancel();

            Log::info('Subscription canceled via Stripe', [
                'subscription_id' => $subscription->id,
            ]);
        } catch (\Exception $e) {
            Log::error('Error canceling Stripe subscription', [
                'error' => $e->getMessage(),
                'subscription_id' => $subscription->id,
            ]);
            throw $e;
        }
    }
}
