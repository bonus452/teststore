<?php

namespace Tests\Feature\Controllers\Admin;

use App\Models\User;
use Tests\TestCase;

class IndexControllerTest extends TestCase
{

    public function test_redirect()
    {
        $response = $this->get('/admin');
        $response->assertRedirect('login');
    }
    public function test_index()
    {
        $this->withUsers();

        $admin = User::find(1);
        $response = $this->actingAs($admin)->get('/admin');
        $response->assertStatus(200);
    }
}
