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
}
