<?php

namespace Database\Factories;

use App\Models\Tenant;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleFactory extends Factory
{
    protected $model = Vehicle::class;

    public function definition(): array
    {
        return [
            'tenant_id' => Tenant::factory(),
            'title' => $this->faker->words(3, true),
            'brand' => $this->faker->randomElement(['Toyota', 'Ford', 'Chevrolet', 'Volkswagen']),
            'model' => $this->faker->word(),
            'year' => $this->faker->numberBetween(2005, now()->year),
            'price' => $this->faker->numberBetween(5000, 50000),
            'price_original' => null,
            'description' => $this->faker->paragraph(),
            'fuel_type' => $this->faker->randomElement(['Gasolina', 'Diesel', 'Eléctrico', 'Híbrido']),
            'transmission' => $this->faker->randomElement(['Manual', 'Automático']),
            'kilometers' => $this->faker->numberBetween(0, 200000),
            'color' => $this->faker->safeColorName(),
            'plate' => strtoupper($this->faker->bothify('???###')),
            'features' => ['Aire acondicionado', 'ABS'],
            'images' => [],
            'contact_name' => $this->faker->name(),
            'contact_phone' => $this->faker->phoneNumber(),
            'contact_email' => $this->faker->safeEmail(),
            'status' => 'published',
            'featured' => false,
            'user_id' => User::factory(),
            'agencia_id' => null,
        ];
    }
}
