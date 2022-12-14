<?php

namespace Tests\Feature\Controllers\Admin\Catalog;

use App\Models\Catalog\Category;
use App\Models\User;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{

    private function setUpData(){
        $this->withCategories()->withUsers();
    }

    public function test_inner_category()
    {
        $this->setUpData();

        $category = Category::find(rand(2, 99));
        $admin = User::find(1);

        $response = $this->actingAs($admin)->get($category->getAdminUrl());
        $response->assertStatus(200);
    }

    public function test_index()
    {
        $this->setUpData();

        $admin = User::find(1);
        $response = $this->actingAs($admin)->get('/admin/catalog');
        $response->assertStatus(200);
    }

    public function test_edit_form()
    {
        $this->setUpData();

        $category = Category::find(rand(2, 99));
        $admin = User::find(1);

        $response = $this->actingAs($admin)->get($category->getEditUrl());
        $response->assertStatus(200);
    }

    public function test_update()
    {
        $this->setUpData();

        $category = Category::find(rand(2, 99));
        $admin = User::find(1);
        $new_title = 'Testing title';
        $send_data = [
            'title' => $new_title,
            'category_id' => $category->category_id,
            'slug' => ''
        ];

        $this->actingAs($admin)->patch($category->getEditUrl(), $send_data);
        $category->refresh();

        $this->assertTrue($new_title == $category->title);
    }

    public function test_create_form()
    {
        $this->setUpData();

        $admin = User::find(1);
        $response = $this->actingAs($admin)->get(route('admin.catalog.category.create_form'));
        $response->assertStatus(200);
    }

    public function test_create()
    {
        $this->setUpData();

        $admin = User::find(1);
        $new_title = "Test Title";
        $new_slug = 'test-title';
        $send_data = [
            'title' => $new_title,
            'category_id' => 5,
            'slug' => $new_slug,
            'image' => ''
        ];
        $this->actingAs($admin)->post(route('admin.catalog.category.create'), $send_data);
        $new_category = Category::where('slug', $new_slug)->first();
        $this->assertTrue(!is_null($new_category));

    }

}
