<?php

namespace Database\Factories\Shop;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OfferFactory extends Factory
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
            'article' => $this->faker->unique()->text(20),
            'price' => rand(3, 500000) / rand(3, 10),
            'description' => $this->faker->text(),
            'product_id' => rand(1,500)
        ];
    }
}
