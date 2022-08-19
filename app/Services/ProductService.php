<?php

namespace App\Services;

use App\Models\Shop\Product;

class ProductService
{
    protected $propertyService;

    public function __construct()
    {
        $this->propertyService = new PropertyService();
    }

    public function store(array $fields) : Product
    {
        if (empty($fields['slug'])){
            $fields['slug'] = \Str::slug($fields['name']);
        }
        $product = Product::create($fields);

        if (isset($fields['properties'])){
            $property_values = $this->propertyService->findOrCreateValues($fields['properties']);
            $product->properties()->sync($property_values);
        }

        return $product;
    }

    public function update(Product &$product, array $fields)
    {
        if (empty($fields['slug'])){
            $fields['slug'] = \Str::slug($fields['name']);
        }
        $result = $product->update($fields);
        if (isset($fields['properties'])){
            $property_values = $this->propertyService->findOrCreateValues($fields['properties']);
            $product->properties()->sync($property_values);
        }

        return $result;
    }
}
