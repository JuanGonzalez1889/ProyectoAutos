<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;

class PlanSeeder extends Seeder
{
    public function run()
    {
        Plan::create([
            'nombre' => 'Plan Básico',
            'slug' => 'basico',
            'price' => 0,
            'features' => json_encode(['feature1', 'feature2']),
            'activo' => true,
        ]);
        Plan::create([
            'nombre' => 'Plan Profesional',
            'slug' => 'profesional',
            'price' => 100,
            'features' => json_encode(['feature1', 'feature2', 'feature3']),
            'activo' => true,
        ]);
        Plan::create([
            'nombre' => 'Plan Premium',
            'slug' => 'premium',
            'price' => 200,
            'features' => json_encode(['feature1', 'feature2', 'feature3', 'feature4']),
            'activo' => true,
        ]);
        // Agrega más planes según tu necesidad
    }
}
