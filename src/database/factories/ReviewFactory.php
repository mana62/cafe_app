<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Cafe;

class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = \Faker\Factory::create('ja_JP');

        return [
            'user_id' => User::factory(),
            'cafe_id' => Cafe::factory(),
            'rating' => $this->faker->numberBetween(1, 5),
            'comment' => $this->faker->sentence(),
        ];
    }
}
