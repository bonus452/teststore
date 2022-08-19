<?php

namespace App\Services;

use App\Models\Shop\Product;

class ImageService
{

    public function syncImages(Product $product, $new_images, $remaining_images = null)
    {
        if (isset($remaining_images)){
            $product->images()
                ->whereNotIn('id', $remaining_images)
                ->get()
                ->each
                ->delete();

        }

        foreach ($new_images as $new_image){
            $product->images()->create(['src' => $new_image]);
        }
    }

}
