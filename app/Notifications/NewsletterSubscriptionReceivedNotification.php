<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewsletterSubscriptionReceivedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private readonly string $email,
        private readonly ?string $ipAddress = null,
        private readonly ?string $origin = null
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Nueva suscripción al newsletter')
            ->greeting('Nueva suscripción recibida')
            ->line("Email: {$this->email}")
            ->line('IP: ' . ($this->ipAddress ?: 'N/D'))
            ->line('Origen: ' . ($this->origin ?: 'N/D'));
    }
}
