<?php

namespace Database\Seeders;

use App\Helpers\DataRefactor;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Factory::create();

        DB::table('categories')->insert([
            'title' => 'Коренева директорія',
            'slug' => '_',
            'url' => '_'
        ]);

        for ($num = 1; $num < 100; $num++) {

            if($num <= 10){
                $parent_id = 1;
            }elseif ($num > 10 && $num <= 30){
                $parent_id = rand(2, 11);
            }else{
                $parent_id = rand(12, 30);
            }

            $title = $faker->unique()->lastName();
            DB::table('categories')->insert([
                'title' => $title,
                'slug' => Str::slug($title),
                'url' => Str::slug($title),
                'category_id' => $parent_id
            ]);
        }

        DataRefactor::refreshCategoriesUrl();

    }
}
