<?php

namespace Tests;

use App\Models\Shop\Offer;
use App\Models\Shop\Product;
use Database\Seeders\CategorySeeder;
use Database\Seeders\PropertySeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations;


//    public function setUp(): void
//    {
//        parent::setUp();
////        Artisan::call('migrate:refresh');
//    }

}
