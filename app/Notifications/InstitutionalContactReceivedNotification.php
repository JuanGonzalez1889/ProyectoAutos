<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InstitutionalContactReceivedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private readonly string $name,
        private readonly string $email,
        private readonly string $message,
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
            ->subject('Nuevo contacto institucional')
            ->greeting('Nuevo mensaje desde autowebpro.com.ar')
            ->line("Nombre: {$this->name}")
            ->line("Email: {$this->email}")
            ->line("Mensaje: {$this->message}")
            ->line('IP: ' . ($this->ipAddress ?: 'N/D'))
            ->line('Origen: ' . ($this->origin ?: 'N/D'));
    }
}
