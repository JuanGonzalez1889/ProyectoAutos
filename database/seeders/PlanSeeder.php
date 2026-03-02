<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;

class PlanSeeder extends Seeder
{
    public function run()
    {
        $plans = [
            [
                'nombre' => 'Plan Básico',
                'slug' => 'basico',
                'price' => 50000,
                'features' => ['Sitio web básico', '15 autos máx', 'Soporte WhatsApp'],
                'activo' => true,
            ],
            [
                'nombre' => 'Plan Profesional',
                'slug' => 'profesional',
                'price' => 150000,
                'features' => ['Integración CRM básica', '30 autos máx', 'Herramientas SEO'],
                'activo' => true,
            ],
            [
                'nombre' => 'Plan Premium',
                'slug' => 'premium',
                'price' => 300000,
                'features' => ['Publicación ilimitada', 'Soporte 24/7', 'Analítica avanzada'],
                'activo' => true,
            ],
            [
                'nombre' => 'Plan Premium +',
                'slug' => 'premium_plus',
                'price' => 500000,
                'features' => ['Manejo de Redes Sociales', 'Gestión de marketing completa'],
                'activo' => true,
            ],
            [
                'nombre' => 'Plan Test $100',
                'slug' => 'test100',
                'price' => 100,
                'features' => ['Prueba real de pago', 'Soporte limitado'],
                'activo' => true,
            ],
        ];

        foreach ($plans as $plan) {
            Plan::updateOrCreate(
                ['slug' => $plan['slug']],
                [
                    'nombre' => $plan['nombre'],
                    'price' => $plan['price'],
                    'features' => json_encode($plan['features']),
                    'activo' => $plan['activo'],
                ]
            );
        }

        Plan::whereNotIn('slug', collect($plans)->pluck('slug'))->update(['activo' => false]);
    }
}
