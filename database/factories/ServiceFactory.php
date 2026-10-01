<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement([
                'Tune Up Motor',
                'Service Mobil',
                'Detailing Interior',
                'Pengecekan Rem',
            ]),
            'slug' => fake()->unique()->slug(),
            'category' => fake()->randomElement(['motor', 'mobil', 'detailing']),
            'description' => fake()->sentence(10),
            'price' => fake()->numberBetween(150000, 1500000),
            'duration_minutes' => fake()->numberBetween(30, 180),
            'is_active' => true,
        ];
    }
}
