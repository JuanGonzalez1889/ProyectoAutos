<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Subscription;
use App\Models\Invoice;

class SubscriptionConfirmedEmail extends Notification implements ShouldQueue
{
    use Queueable;

    private $subscription;
    private $invoice;

    /**
     * Create a new notification instance.
     */
    public function __construct(Subscription $subscription, Invoice $invoice)
    {
        $this->subscription = $subscription;
        $this->invoice = $invoice;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('¡Suscripción Activada! 🎉')
                    ->view('emails.subscription-confirmed', [
                        'user' => $notifiable,
                        'subscription' => $this->subscription,
                        'invoice' => $this->invoice,
                        'dashboardUrl' => route('admin.dashboard'),
                        'billingUrl' => route('subscriptions.billing'),
                    ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
