<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => fn () => User::factory(),
            'service_id' => fn () => Service::factory(),
            'customer_name' => fake()->name(),
            'phone' => fake()->numerify('08##########'),
            'vehicle_type' => fake()->randomElement(['motor', 'mobil']),
            'plate_number' => 'B '.fake()->randomNumber(4, true).' '.fake()->randomLetter().fake()->randomLetter().fake()->randomLetter(),
            'preferred_date' => fake()->dateTimeBetween('+1 day', '+14 days')->format('Y-m-d'),
            'notes' => fake()->sentence(),
            'status' => 'pending',
        ];
    }
}
