<?php

namespace App\Services;

use App\Models\Lead;
use App\Models\Tenant;
use App\Models\User;
use App\Notifications\NewLeadReceivedNotification;
use App\Notifications\NewsletterSubscriptionReceivedNotification;
use Illuminate\Support\Facades\Notification;

class FormEmailNotificationService
{
    public function notifyNewLead(Lead $lead): void
    {
        $tenant = Tenant::find($lead->tenant_id);
        $recipients = $this->resolveRecipients($tenant);

        if (empty($recipients)) {
            return;
        }

        Notification::route('mail', $recipients)
            ->notify(new NewLeadReceivedNotification($lead, $tenant));
    }

    public function notifyNewsletterSubscription(string $email, ?string $ipAddress = null, ?string $origin = null): void
    {
        $recipients = $this->resolveRecipients();

        if (empty($recipients)) {
            return;
        }

        Notification::route('mail', $recipients)
            ->notify(new NewsletterSubscriptionReceivedNotification($email, $ipAddress, $origin));
    }

    private function resolveRecipients(?Tenant $tenant = null): array
    {
        $emails = [];

        $globalRecipients = env('CONTACT_NOTIFICATIONS_TO');
        if (is_string($globalRecipients) && trim($globalRecipients) !== '') {
            $emails = array_merge($emails, array_map('trim', explode(',', $globalRecipients)));
        }

        $fromAddress = config('mail.from.address');
        if (is_string($fromAddress) && trim($fromAddress) !== '') {
            $emails[] = $fromAddress;
        }

        if ($tenant) {
            if (!empty($tenant->email)) {
                $emails[] = $tenant->email;
            }

            $roleRecipients = User::query()
                ->where('tenant_id', $tenant->id)
                ->where('is_active', true)
                ->role(['ADMIN', 'AGENCIERO'])
                ->pluck('email')
                ->toArray();

            $emails = array_merge($emails, $roleRecipients);
        }

        $emails = array_filter(array_unique($emails), function ($email) {
            return is_string($email) && filter_var($email, FILTER_VALIDATE_EMAIL);
        });

        return array_values($emails);
    }
}
