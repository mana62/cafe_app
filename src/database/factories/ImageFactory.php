<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Cafe;

class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'cafe_id' => function () {
                return Cafe::inRandomOrder()->first()->id ?? Cafe::factory()->create()->id;
            },
            'image_path' => $this->faker->imageUrl(640, 480, 'food'),
        ];
    }
}
