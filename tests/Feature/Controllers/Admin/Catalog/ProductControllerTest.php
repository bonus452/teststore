<?php

namespace Tests\Feature\Controllers\Admin\Catalog;

use App\Models\Shop\Product;
use App\Models\Shop\PropertyName;
use App\Models\Shop\PropertyValue;
use App\Models\User;
use Database\Seeders\CategorySeeder;
use Database\Seeders\PropertySeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Faker\Factory;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(UserSeeder::class);
        $this->seed(RoleSeeder::class);
        $this->seed(CategorySeeder::class);

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

        Product::factory(3)
            ->hasOffers(5)
            ->create();

        $this->seed(PropertySeeder::class);
    }

    public function test_create_form()
    {
        $admin = User::find(1);
        $response = $this->actingAs($admin)->get(route('admin.catalog.category.create_form'));
        $response->assertStatus(200);
    }
}
