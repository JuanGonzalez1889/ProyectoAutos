<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeEmail extends Notification implements ShouldQueue
{
    use Queueable;

    private $password;
    private $tenant;

    /**
     * Create a new notification instance.
     */
    public function __construct($password, $tenant)
    {
        $this->password = $password;
        $this->tenant = $tenant;
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
                    ->subject('¡Bienvenido a AutoWeb Pro! 🚗')
                    ->view('emails.welcome', [
                        'user' => $notifiable,
                        'password' => $this->password,
                        'tenant' => $this->tenant,
                        'loginUrl' => route('login'),
                        'dashboardUrl' => route('admin.dashboard'),
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
