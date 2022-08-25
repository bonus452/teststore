<?php

namespace Controllers\Admin\Catalog;

use App\Models\Shop\PropertyName;
use App\Models\User;
use Tests\TestCase;

class PropertyControllerTest extends TestCase
{

    public function test_get_property_form(){
        $this->withUsers()->withProperties();
        $user = User::find(1);
        $responce = $this
            ->actingAs($user)
            ->get(route('admin.catalog.property.get_properties'));
        $responce->assertStatus(200);
    }

    public function test_create_property_name(){
        $this->withUsers();
        $user = User::find(1);
        $responce = $this
            ->actingAs($user)
            ->post(route('admin.catalog.property.create_property_name'), ['property_name' => 'Test']);

        $property = PropertyName::find(1);
        $this->assertInstanceOf(PropertyName::class, $property);
    }

}
