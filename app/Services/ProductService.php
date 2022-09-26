<?php

namespace App\Services;

use App\Models\Catalog\Product;

class ProductService
{
    protected PropertyService $propertyService;
    protected ImageService $imageService;

    public function __construct()
    {
        $this->propertyService = new PropertyService();
        $this->imageService = new ImageService();
    }

    public function store(array $fields): Product
    {
        $product = Product::create($fields);

        if (isset($fields['new_images'])) {
            $this->imageService->syncImages($product, $fields['new_images']);
        }

        if (isset($fields['properties'])) {
            $property_values = $this->propertyService->findOrCreateValues($fields['properties']);
            $product->properties()->sync($property_values);
        }

        return $product;
    }

    public function update(Product &$product, array $fields): bool
    {
        $result = $product->update($fields);
        $this->imageService->syncImages($product, $fields['new_images'], $fields['exists_images']);

        if (isset($fields['properties'])) {
            $property_values = $this->propertyService->findOrCreateValues($fields['properties']);
            $product->properties()->sync($property_values);
        }

        return $result;
    }
}
