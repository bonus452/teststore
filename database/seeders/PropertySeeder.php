<?php

namespace Database\Seeders;

use App\Models\Catalog\Offer;
use App\Models\Catalog\Product;
use App\Models\Catalog\PropertyName;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropertySeeder extends Seeder
{

    protected $faker;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $properties = PropertyName::with('propertyValues')->get();
        $offers = Offer::all();
        foreach ($offers as $offer) {
            foreach ($properties as $property) {
                $offer->properties()->save($property->propertyValues->random());
            }
        }

        $products = Product::all();

        foreach ($products as $product) {
            foreach ($properties as $property) {
                $product->properties()->save($property->propertyValues->random());
            }
        }

    }
}
