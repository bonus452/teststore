<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        DB::table('properties')->insert([
            'name' => 'Color',
        ]);
        DB::table('properties')->insert([
            'name' => 'Size',
        ]);

        for ($i = 0; $i < 1000; $i++) {
            DB::table('offer_property')->insert([
                'offer_id' => $faker->unique()->numberBetween(1, 2499),
                'property_id' => rand(1, 2),
                'value' => $faker->colorName()
            ]);
        }
    }
}
