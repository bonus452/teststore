<?php

namespace Database\Seeders;

use App\Models\Shop\Offer;
use App\Models\Shop\Product;
use App\Models\Shop\PropertyName;
use App\Models\Shop\PropertyValue;
use Faker\Factory;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return Collection
     */

    public function run()
    {
        $this->call([
            CategorySeeder::class,
            UserSeeder::class,
            RoleSeeder::class
        ]);

        $faker = Factory::create();

        PropertyName::factory(3)
            ->state(new Sequence(
                ['name' => 'Class'],
                ['name' => 'Color'],
                ['name' => 'Model']
            ))
            ->has(
                PropertyValue::factory(20)
                    ->state(function (array $attributes, PropertyName $prop) use($faker){
                            if ($prop->id == 1){
                                return ['value' => $faker->unique()->word];
                            }elseif ($prop->id == 2){
                                return ['value' => $faker->unique()->colorName];
                            }elseif ($prop->id == 3){
                                return ['value' => $faker->unique()->userName];
                            }
                    })
            )
            ->create();

        Product::factory(500)
            ->hasOffers(5)
            ->create();

        $this->call([
            PropertySeeder::class
        ]);

    }
}
