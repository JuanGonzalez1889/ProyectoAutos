<?php

namespace App\Notifications;

use App\Models\Lead;
use App\Models\Tenant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewLeadReceivedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private readonly Lead $lead,
        private readonly ?Tenant $tenant = null
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $tenantName = $this->tenant?->name ?? 'Agencia';
        $leadName = $this->lead->name;
        $leadEmail = $this->lead->email ?? 'Sin email';
        $leadPhone = $this->lead->phone;
        $leadSource = $this->lead->source ?? 'formulario';
        $leadNotes = $this->lead->notes ?: 'Sin mensaje';

        return (new MailMessage)
            ->subject("Nuevo lead recibido - {$tenantName}")
            ->greeting('Nuevo contacto desde formulario')
            ->line("Tenant: {$tenantName}")
            ->line("Nombre: {$leadName}")
            ->line("Email: {$leadEmail}")
            ->line("Teléfono: {$leadPhone}")
            ->line("Origen: {$leadSource}")
            ->line("Mensaje: {$leadNotes}")
            ->action('Ver leads', route('admin.leads.index'));
    }
}
