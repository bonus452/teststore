<?php

namespace Tests\Feature\Controllers\Shop;

use App\Models\Shop\Category;
use App\Models\Shop\Product;
use Tests\TestCase;

class CatalogControllerTest extends TestCase
{

    public function testCatalog404()
    {
        $response = $this->get('/catalog/not_exist/not_exist/not_exist/not_exist');
        $response->assertStatus(404);
    }

    public function testindex()
    {
        $this->withCategories()
            ->withProducts();

        $response = $this->get('/catalog');
        $response->assertStatus(200);
    }

    public function testlist()
    {
        $this->withCategories()
            ->withProducts();

        $category = Category::find(rand(2, 99));
        $response = $this->get($category->url);
        $response->assertStatus(200);
    }

    public function testdetail()
    {
        $this->withCategories()
            ->withProducts()
            ->withProperties();

        $product = Product::find(1);
        $response = $this->get($product->url);
        $response->assertStatus(200);
    }

}
