<?php

namespace Tests\Feature\Controllers\Shop;

use App\Models\Shop\Category;
use App\Models\Shop\Product;
use Tests\TestCase;

class CatalogControllerTest extends TestCase
{

    public function test_catalog_404()
    {
        $response = $this->get('/catalog/not_exist/not_exist/not_exist/not_exist');
        $response->assertStatus(404);
    }

    public function test_index()
    {
        $this->withCategories()
            ->withProducts();

        $response = $this->get('/catalog');
        $response->assertStatus(200);
    }

    public function test_list()
    {
        $this->withCategories()
            ->withProducts();

        $category = Category::find(rand(2, 99));
        $response = $this->get($category->url);
        $response->assertStatus(200);
    }

    public function test_detail()
    {
        $this->withCategories()
            ->withProducts()
            ->withProperties();

        $product = Product::find(1);
        $response = $this->get($product->url);
        $response->assertStatus(200);
    }

    public function test_detail_404()
    {
        $this->withCategories();

        $category = Category::find(rand(2, 99));
        $response = $this->get($category->url . '/detail-product/prod-not-exist');
        $response->assertStatus(404);
    }

}
