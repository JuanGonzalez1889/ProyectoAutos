<?php

namespace Database\Factories;

use App\Models\Domain;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

class DomainFactory extends Factory
{
    protected $model = Domain::class;

    public function definition(): array
    {
        return [
            'tenant_id' => Tenant::factory(),
            'domain' => $this->faker->unique()->domainName(),
            'type' => 'new',
        ];
    }
}
