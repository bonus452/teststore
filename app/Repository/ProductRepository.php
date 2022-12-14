<?php

namespace App\Repository;

use App\Models\Catalog\Category;
use App\Models\Catalog\Product;
use App\Models\Catalog\Product as Model;


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
        $product = $this->getInstance()
            ->where('slug', $product)
            ->active()
            ->withProperties()
            ->with(['offers' => function ($query) {
                $query->withProperties();
            }])
            ->first();

        return $product;
    }

}
