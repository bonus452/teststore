<?php

namespace App\Observers;

use App\Models\Shop\Product;

class ProductObserver
{
    public function deleting(Product $product)
    {
        $product->properties()->detach();
        $product->offers()
            ->get()
            ->each
            ->delete();
    }

    public function creating(Product $product)
    {
        $product->slug = $product->slug ?: \Str::slug($product->name);
    }

    public function updating(Product $product)
    {
        $product->slug = $product->slug ?: \Str::slug($product->name);
    }
}
