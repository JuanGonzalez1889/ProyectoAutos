<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Subscription;

class PaymentReminderEmail extends Notification implements ShouldQueue
{
    use Queueable;

    private $subscription;
    private $daysRemaining;

    /**
     * Create a new notification instance.
     */
    public function __construct(Subscription $subscription, int $daysRemaining = 3)
    {
        $this->subscription = $subscription;
        $this->daysRemaining = $daysRemaining;
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
                    ->subject('Recordatorio: Tu suscripción se renueva pronto 📅')
                    ->view('emails.payment-reminder', [
                        'user' => $notifiable,
                        'subscription' => $this->subscription,
                        'daysRemaining' => $this->daysRemaining,
                        'billingUrl' => route('subscriptions.billing'),
                        'plansUrl' => route('subscriptions.index'),
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
