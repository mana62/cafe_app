<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Reservation;

class PaymentFactory extends Factory
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
            'reservation_id' => Reservation::factory(),
            'payment_intent_id' => $this->faker->uuid(),
            'amount' => $this->faker->numberBetween(500, 5000),
            'status' => $this->faker->randomElement(['pending', 'succeeded', 'failed']),
            'payment_method' => 'card',
        ];
    }
}
