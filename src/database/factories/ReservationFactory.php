<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Cafe;

class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'cafe_id' => Cafe::factory(),
            'reservation_time' => $this->faker->dateTimeBetween('now', '+1 month'),
            'guest_count' => $this->faker->numberBetween(1, 10),
            'status' => $this->faker->randomElement(['confirmed', 'done', 'canceled']),
        ];
    }
}
