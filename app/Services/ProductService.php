<?php

namespace App\Services;

use App\Models\Shop\Product;

class ProductService
{
    public function store(array $fields) : Product
    {
        if (empty($fields['slug'])){
            $fields['slug'] = \Str::slug($fields['name']);
        }
        return Product::create($fields);
    }

    public function update(Product &$product, array $product_fields)
    {
        return $product->update($product_fields);
    }
}
