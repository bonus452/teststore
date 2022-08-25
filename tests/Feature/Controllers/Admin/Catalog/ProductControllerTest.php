<?php

namespace Tests\Feature\Controllers\Admin\Catalog;

use App\Models\Shop\Product;
use App\Models\User;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{

    public function test_create_form()
    {
        $this->withUsers()->withCategories();

        $admin = User::find(1);
        $response = $this->actingAs($admin)->get(route('admin.catalog.product.create_form'));
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
            'active' => '1',
            'name' => $new_title,
            'category_id' => 5,
            'slug' => $new_slug,
            'image' => '',
            'properties' => [
                1 => 'prop prod value',
                2 => 'prop prod value',
                3 => 'prop prod value3',
            ],
            'offers' => [
                [
                    'article' => 'test-article',
                    'price' => 25.50,
                    'amount' =>30,
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
        $this->assertInstanceOf(Product::class, $new_product);
    }

    public function test_create_without_offers()
    {

        $this->withUsers()
            ->withCategories();

        $admin = User::find(1);
        $new_title = "Test Title";
        $new_slug = 'test-title';
        $send_data = [
            'active' => '1',
            'name' => $new_title,
            'category_id' => 5,
            'slug' => $new_slug,
            'image' => '',
        ];
        $this->actingAs($admin)->post(route('admin.catalog.product.create'), $send_data);
        $new_product = Product::where('slug', $new_slug)->first();
        $this->assertNotInstanceOf(Product::class, $new_product);
    }

    public function test_update_form()
    {
        $this->withUsers()
            ->withCategories()
            ->withProducts(1)
            ->withProperties();
        $product = Product::find(1);
        $admin = User::find(1);
        $response = $this->actingAs($admin)->get(route('admin.catalog.product.edit_form', $product));
        $response->assertStatus(200);
    }

    public function test_update_without_offers()
    {

        $this->withUsers()
            ->withCategories()
            ->withProducts(1)
            ->withProperties();

        $product = Product::find(1);

        $admin = User::find(1);
        $new_title = "Test Title";
        $new_slug = 'test-title';
        $send_data = [
            'active' => '1',
            'name' => $new_title,
            'category_id' => 5,
            'slug' => $new_slug,
            'image' => '',
        ];
        $this->actingAs($admin)->patch(route('admin.catalog.product.update', $product), $send_data);
        $new_product = Product::where('slug', $new_slug)->first();
        $this->assertNotInstanceOf(Product::class, $new_product);
    }

    public function test_update_with_offers_ok()
    {

        $this->withUsers()
            ->withCategories()
            ->withProducts(1)
            ->withProperties();

        $product = Product::find(1);

        $admin = User::find(1);
        $new_title = "Test Title";
        $new_slug = 'test-title';
        $send_data = [
            'active' => '1',
            'name' => $new_title,
            'category_id' => 5,
            'slug' => $new_slug,
            'image' => '',
            'properties' => [
                1 => 'prop prod value',
                2 => 'prop prod value',
                3 => 'prop prod value3',
            ],
            'offers' => [
                [
                    'article' => 'test-article',
                    'price' => 25.50,
                    'amount' =>30,
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
        $response = $this->actingAs($admin)->patch(route('admin.catalog.product.update', $product), $send_data);
        $new_product = Product::where('slug', $new_slug)->first();
        $this->assertInstanceOf(Product::class, $new_product);
    }

}
