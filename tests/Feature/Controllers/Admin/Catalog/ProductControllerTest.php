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
use Illuminate\Foundation\Testing\RefreshDatabaseState;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{

    public function test_create_form()
    {
        $this->withUsers()->withCategories();

        $admin = User::find(1);
        $response = $this->actingAs($admin)->get(route('admin.catalog.category.create_form'));
        $response->assertStatus(200);
    }

    public function test_create_with_offers_ok()
    {

        $this->withUsers()
            ->withCategories()
            ->withProperties();

        $admin = User::find(1);
        $new_title = "Test Title";
        $new_slug = 'test-title';
        $send_data = [
            'name' => $new_title,
            'category_id' => 5,
            'slug' => $new_slug,
            'image' => '',
            'offers' => [
                [
                    'article' => 'test-article',
                    'price' => 25.50,
                    'properties' => [
                        1 => 'prop value',
                        2 => 'prop value',
                        3 => 'prop value3',
                    ]
                ],
                [
                    'article' => 'test-article2',
                    'price' => 55.50,
                    'properties' => []

                ],
                [
                    'article' => 'test-article3',
                    'price' => 75.50
                ],
            ]
        ];
        $response = $this->actingAs($admin)->post(route('admin.catalog.product.create'), $send_data);
        $new_product = Product::where('slug', $new_slug)->first();
        $this->assertTrue(!is_null($new_product));
    }

    public function test_create_without_offers()
    {

        $this->withUsers()
            ->withCategories()
            ->withProperties();

        $admin = User::find(1);
        $new_title = "Test Title";
        $new_slug = 'test-title';
        $send_data = [
            'name' => $new_title,
            'category_id' => 5,
            'slug' => $new_slug,
            'image' => '',
            'offers' => [
                [
                    'article' => 'test-article',
                    'price' => 25.50,
                    'properties' => [
                        1 => 'prop value',
                        2 => 'prop value',
                        3 => 'prop value3',
                    ]
                ],
                [
                    'article' => 'test-article2',
                    'price' => 55.50,
                    'properties' => []

                ],
                [
                    'article' => 'test-article3',
                    'price' => 75.50
                ],
            ]
        ];
        $this->actingAs($admin)->post(route('admin.catalog.product.create'), $send_data);
        $new_product = Product::where('slug', $new_slug)->first();
        $this->assertTrue(!is_null($new_product));
    }

}
