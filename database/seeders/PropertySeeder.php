<?php

namespace Database\Seeders;

use App\Models\Shop\Offer;
use App\Models\Shop\Product;
use App\Models\Shop\PropertyName;
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
