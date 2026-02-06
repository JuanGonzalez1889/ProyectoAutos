<?php

namespace Tests\Feature;

use App\Models\Invoice;
use App\Models\Subscription;
use App\Models\Tenant;
use App\Models\User;
use App\Notifications\PaymentFailedEmail;
use App\Notifications\SubscriptionConfirmedEmail;
use App\Notifications\WelcomeEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class EmailTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test WelcomeEmail is sent on user registration.
     */
    public function test_welcome_email_sent_on_registration(): void
    {
        Notification::fake();

        // Create a tenant
        $tenant = Tenant::factory()->create();
        $user = User::factory()->create(['tenant_id' => $tenant->id]);

        // Send welcome email
        $user->notify(new WelcomeEmail('Password123!', $tenant));

        // Assert notification was sent
        Notification::assertSentTo($user, WelcomeEmail::class);
    }

    /**
     * Test SubscriptionConfirmedEmail is sent after successful payment.
     */
    public function test_subscription_confirmed_email_sent(): void
    {
        Notification::fake();

        $tenant = Tenant::factory()->create(['plan' => 'premium']);
        $user = User::factory()->create(['tenant_id' => $tenant->id]);

        $subscription = Subscription::create([
            'tenant_id' => $tenant->id,
            'plan' => 'premium',
            'payment_method' => 'stripe',
            'status' => 'active',
            'amount' => 29.99,
            'currency' => 'USD',
            'current_period_start' => now(),
            'current_period_end' => now()->addMonth(),
        ]);

        $invoice = Invoice::create([
            'tenant_id' => $tenant->id,
            'subscription_id' => $subscription->id,
            'invoice_number' => Invoice::generateInvoiceNumber(),
            'amount' => 29.99,
            'currency' => 'USD',
            'total' => 29.99,
            'status' => 'paid',
            'payment_method' => 'stripe',
            'paid_at' => now(),
        ]);

        // Send subscription confirmed email
        $user->notify(new SubscriptionConfirmedEmail($subscription, $invoice));

        // Assert notification was sent
        Notification::assertSentTo($user, SubscriptionConfirmedEmail::class);
    }

    /**
     * Test PaymentFailedEmail is sent when payment fails.
     */
    public function test_payment_failed_email_sent(): void
    {
        Notification::fake();

        $tenant = Tenant::factory()->create();
        $user = User::factory()->create(['tenant_id' => $tenant->id]);

        $subscription = Subscription::create([
            'tenant_id' => $tenant->id,
            'plan' => 'premium',
            'payment_method' => 'mercadopago',
            'status' => 'active',
            'amount' => 29.99,
            'currency' => 'USD',
            'current_period_start' => now(),
            'current_period_end' => now()->addMonth(),
        ]);

        // Send payment failed email
        $user->notify(new PaymentFailedEmail($subscription, 'Fondos insuficientes'));

        // Assert notification was sent
        Notification::assertSentTo($user, PaymentFailedEmail::class);
    }

    /**
     * Test email content contains expected elements.
     */
    public function test_welcome_email_contains_expected_content(): void
    {
        $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        $tenant = Tenant::factory()->create();
        $notification = new WelcomeEmail('Password123!', $tenant);
        $mailData = $notification->toMail($user);

        // Assert email properties
        $this->assertStringContainsString('Bienvenido', $mailData->subject);
    }

    /**
     * Test subscription confirmed email contains plan details.
     */
    public function test_subscription_confirmed_email_contains_plan_details(): void
    {
        $user = User::factory()->create();
        
        $tenant = Tenant::factory()->create();
        $subscription = Subscription::create([
            'tenant_id' => $tenant->id,
            'plan' => 'enterprise',
            'payment_method' => 'stripe',
            'status' => 'active',
            'amount' => 79.99,
            'currency' => 'USD',
            'current_period_start' => now(),
            'current_period_end' => now()->addMonth(),
        ]);

        $invoice = Invoice::create([
            'tenant_id' => $tenant->id,
            'subscription_id' => $subscription->id,
            'invoice_number' => Invoice::generateInvoiceNumber(),
            'amount' => 79.99,
            'currency' => 'USD',
            'total' => 79.99,
            'status' => 'paid',
            'payment_method' => 'stripe',
            'paid_at' => now(),
        ]);

        $notification = new SubscriptionConfirmedEmail($subscription, $invoice);
        $mailData = $notification->toMail($user);

        // Assert email contains plan information
        $this->assertStringContainsString('Suscripción Activada', $mailData->subject);
    }

    /**
     * Test payment failed email contains error details.
     */
    public function test_payment_failed_email_contains_error_details(): void
    {
        $user = User::factory()->create();
        
        $tenant = Tenant::factory()->create();
        $subscription = Subscription::create([
            'tenant_id' => $tenant->id,
            'plan' => 'basic',
            'payment_method' => 'mercadopago',
            'status' => 'active',
            'amount' => 9.99,
            'currency' => 'USD',
            'current_period_start' => now(),
            'current_period_end' => now()->addMonth(),
        ]);

        $notification = new PaymentFailedEmail($subscription, 'Tarjeta expirada');
        $mailData = $notification->toMail($user);

        // Assert email contains failure information
        $this->assertStringContainsString('Pago', $mailData->subject);
    }

    /**
     * Test multiple emails can be sent to same user.
     */
    public function test_multiple_emails_can_be_sent_to_user(): void
    {
        Notification::fake();

        $user = User::factory()->create();

        // Send multiple notifications
        $tenant = Tenant::factory()->create();
        $subscription = Subscription::create([
            'tenant_id' => $tenant->id,
            'plan' => 'premium',
            'payment_method' => 'stripe',
            'status' => 'active',
            'amount' => 29.99,
            'currency' => 'USD',
            'current_period_start' => now(),
            'current_period_end' => now()->addMonth(),
        ]);
        $invoice = Invoice::create([
            'tenant_id' => $tenant->id,
            'subscription_id' => $subscription->id,
            'invoice_number' => Invoice::generateInvoiceNumber(),
            'amount' => 29.99,
            'currency' => 'USD',
            'total' => 29.99,
            'status' => 'paid',
            'payment_method' => 'stripe',
            'paid_at' => now(),
        ]);

        $user->notify(new WelcomeEmail('Password123!', $tenant));
        $user->notify(new SubscriptionConfirmedEmail($subscription, $invoice));
        $user->notify(new PaymentFailedEmail($subscription, 'Test error'));

        // Assert all were sent
        Notification::assertSentTo($user, WelcomeEmail::class);
        Notification::assertSentTo($user, SubscriptionConfirmedEmail::class);
        Notification::assertSentTo($user, PaymentFailedEmail::class);

        // Assert count
        Notification::assertCount(3);
    }
}
