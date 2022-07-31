<?php

namespace Database\Seeders;

use App\Models\Shop\Offer;
use App\Models\Shop\Product;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropertySeeder extends Seeder
{

    protected $faker;

    public function createProperties(){
        DB::table('property_names')->insert([
            'name' => 'Size',
        ]);
        DB::table('property_names')->insert([
            'name' => 'Color',
        ]);

        DB::table('property_names')->insert([
            'name' => 'Model',
        ]);
    }

    public function createPropertyValues(){
        $faker = Factory::create();
        $size_values = [
            'L', 'XL', 'S', 'XXL', 'M', 'XXXL', 'XS', 'XXS'
        ];
        foreach ($size_values as $value){
            DB::table('property_values')->insert([
                'value' => $value,
                'property_name_id' => 1
            ]);
        }
        for ($i = 1; $i < 50; $i++){
            DB::table('property_values')->insert([
                'value' => $faker->unique()->colorName(),
                'property_name_id' => 2
            ]);
        }
        for ($i = 1; $i < 20; $i++){
            DB::table('property_values')->insert([
                'value' => $faker->unique()->company(),
                'property_name_id' => 3
            ]);
        }
    }

    public function setPropertyToProductItem($type, $item_id, $property_id = null){
        $property_id = $property_id ?? rand(1, 3);
        $values = [
            1 => $this->faker->unique()->numberBetween(1, 7),
            2 => $this->faker->unique()->numberBetween(8, 57),
            3 => $this->faker->unique()->numberBetween(57, 76)
        ];
        $value = $values[$property_id];

        DB::table('propertables')->insert([
            'propertable_id' => $item_id,
            'propertable_type' => $type,
            'property_value_id' => $value
        ]);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $this->faker = Factory::create();

        $this->createProperties();
        $this->createPropertyValues();

        for ($offer_id = 0; $offer_id <= 2500; $offer_id++) {
            $this->faker->unique(true);
            for ($prop_id = 1; $prop_id <= 3; $prop_id++) {
                $this->setPropertyToProductItem(Offer::class, $offer_id, $prop_id);
            }
        }

        for ($product_id = 1; $product_id <= 500; $product_id++) {
            $this->faker->unique(true);
            for ($prop_id = 1; $prop_id <= 3; $prop_id++){
                $this->setPropertyToProductItem(Product::class, $product_id, $prop_id);
            }
        }

    }
}
