<?php

namespace App\Repository;

use App\Models\Shop\Category;
use App\Models\Shop\Product;
use App\Models\Shop\Product as Model;


class ProductRepository
{

    protected function getInstance()
    {
        return new Model();
    }

    public function getCountFromCategories(array $categories): int
    {
        $result = Product::active()
            ->whereIn('category_id', $categories)
            ->count();
        return $result;
    }

    public function getForDetailPage($product)
    {
        $product = $this->getInstance()->where('slug', $product)->active()
            ->with(['offers' => function ($query) {
                $query->with(['properties' => function ($query) {
                    $query->with('property_name');
                }]);
            }])
            ->with(['properties' => function ($query) {
                $query->with('property_name');
            }])
            ->first();

        return $product;
    }

}
