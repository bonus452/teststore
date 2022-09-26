<?php

namespace Tests;

use App\Models\Catalog\Offer;
use App\Models\Catalog\Product;
use App\Models\Catalog\PropertyName;
use App\Models\Catalog\PropertyValue;
use Database\Seeders\CategorySeeder;
use Database\Seeders\PropertySeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations;

    protected function withUsers(){
        $this->seed(UserSeeder::class);
        $this->seed(RoleSeeder::class);
        return $this;
    }

    protected function withCategories(){
        $this->seed(CategorySeeder::class);
        return $this;
    }

    protected function withProducts($num = 3){
        Product::factory($num)
            ->hasOffers(5)
            ->create();
        return $this;
    }

    protected function withProperties(){

        $faker = Factory::create();
        PropertyName::factory(3)
            ->state(new Sequence(
                ['name' => 'Class'],
                ['name' => 'Color'],
                ['name' => 'Model']
            ))
            ->has(
                PropertyValue::factory(5)
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

        $this->seed(PropertySeeder::class);
        return $this;
    }

}
