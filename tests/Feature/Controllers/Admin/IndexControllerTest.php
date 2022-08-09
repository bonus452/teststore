<?php

namespace Tests\Feature\Controllers\Admin;

use App\Models\User;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Tests\TestCase;

class IndexControllerTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(UserSeeder::class);
        $this->seed(RoleSeeder::class);
    }

    public function test_redirect()
    {
        $response = $this->get('/admin');
        $response->assertRedirect('login');
    }
    public function test_index()
    {
        $admin = User::find(1);
        $response = $this->actingAs($admin)->get('/admin');
        $response->assertStatus(200);
    }
}
