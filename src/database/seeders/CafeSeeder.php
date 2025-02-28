<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cafe;
use App\Models\Owner;
class CafeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Owner::all()->each(function ($owner) {
            Cafe::factory(2)->create([
                'owner_id' => $owner->id,
            ]);
        });
    }
}
