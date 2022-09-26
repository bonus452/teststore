<?php

namespace Database\Factories\Catalog;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $name = $this->faker->unique()->name();
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'active' => true,
            'description' => $this->faker->text(),
            'category_id' => rand(2, 99)
        ];
    }
}
