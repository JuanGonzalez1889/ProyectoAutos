<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tenants = \App\Models\Tenant::all();

        foreach ($tenants as $tenant) {
            // Si el tenant no tiene suscripción, crear una free con prueba de 30 días
            if (!$tenant->subscriptions()->exists()) {
                $tenant->subscriptions()->create([
                    'plan' => 'free',
                    'status' => 'active',
                    'payment_method' => 'none',
                    'amount' => 0,
                    'currency' => 'USD',
                    'current_period_start' => now(),
                    'current_period_end' => now()->addDays(30),
                    'trial_ends_at' => now()->addDays(30),
                ]);
            }
        }
    }
}
