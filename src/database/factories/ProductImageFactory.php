<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;

class ProductImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_id' => function () {
                return Product::inRandomOrder()->first()->id ?? Product::factory()->create()->id;
            },
            'image_path' => $this->faker->imageUrl(640, 480, 'food'),
        ];
    }
}
