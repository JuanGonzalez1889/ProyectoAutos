<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Subscription;

class PaymentFailedEmail extends Notification implements ShouldQueue
{
    use Queueable;

    private $subscription;
    private $errorMessage;

    /**
     * Create a new notification instance.
     */
    public function __construct(Subscription $subscription, string $errorMessage = '')
    {
        $this->subscription = $subscription;
        $this->errorMessage = $errorMessage;
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
                    ->subject('⚠️ Problema con tu Pago')
                    ->view('emails.payment-failed', [
                        'user' => $notifiable,
                        'subscription' => $this->subscription,
                        'errorMessage' => $this->errorMessage,
                        'billingUrl' => route('subscriptions.billing'),
                        'updatePaymentUrl' => route('subscriptions.index'),
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
