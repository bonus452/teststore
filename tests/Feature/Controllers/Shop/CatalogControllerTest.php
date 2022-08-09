<?php

namespace Tests\Feature\Controllers\Shop;

use App\Models\Shop\Category;
use App\Models\Shop\Product;
use App\Models\Shop\PropertyName;
use App\Models\Shop\PropertyValue;
use Database\Seeders\CategorySeeder;
use Database\Seeders\PropertySeeder;
use Faker\Factory;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Tests\TestCase;

class CatalogControllerTest extends TestCase
{

    public function setUp(): void
    {
        $faker = Factory::create();

        parent::setUp();

        $this->seed(CategorySeeder::class);
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

        Product::factory(5)
            ->hasOffers(5)
            ->create();

        $this->seed(PropertySeeder::class);
    }

    public function testCatalog404()
    {
        $response = $this->get('/catalog/not_exist/not_exist/not_exist/not_exist');
        $response->assertStatus(404);
    }

    public function testindex()
    {
        $response = $this->get('/catalog');
        $response->assertStatus(200);
    }

    public function testlist()
    {
        $category = Category::find(rand(2, 99));
        $response = $this->get($category->url);
        $response->assertStatus(200);
    }

    public function testdetail()
    {
        $category = Category::find(rand(2, 99));
        $response = $this->get($category->url);
        $response->assertStatus(200);
    }

}
