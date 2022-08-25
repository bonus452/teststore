<?php

namespace Tests\Feature\Controllers;

use Database\Seeders\CategorySeeder;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(CategorySeeder::class);
    }

    public function test_index()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test404()
    {
        $response = $this->get('/not_exist/not_exist/not_exist/not_exist/not_exist');
        $response->assertStatus(404);
    }
}
