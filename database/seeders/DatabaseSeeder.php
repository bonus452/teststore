<?php

namespace Database\Seeders;

use App\Models\Shop\Offer;
use App\Models\Shop\Product;
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
            CategorySeeder::class,
            UserSeeder::class,
            RoleSeeder::class
        ]);
        Product::factory(500)->create();
        Offer::factory(2500)->create();
        $this->call([
            PropertySeeder::class
        ]);
    }
}
