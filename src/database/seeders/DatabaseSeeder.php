<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AdminSeeder::class,
            UserSeeder::class,
            ProductSeeder::class,
            ProductImageSeeder::class,
            FavoriteSeeder::class,
            ReviewSeeder::class,
            OrderSeeder::class,
            PaymentSeeder::class,
            ContactSeeder::class,
            AddressSeeder::class,
            CartSeeder::class,
        ]);
    }
}
