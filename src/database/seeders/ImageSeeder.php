<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Image;
use App\Models\Cafe;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cafes = Cafe::all();

        foreach ($cafes as $cafe) {
            Image::factory(3)->create(['cafe_id' => $cafe->id]);
        }
    }
}
