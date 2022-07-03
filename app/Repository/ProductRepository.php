<?php

namespace App\Repository;

use App\Models\Shop\Product;
use App\Models\Shop\Product as Model;
use Illuminate\Support\Collection;

class ProductRepository
{

    private static $instance;

    private static function getInstance() : Model
    {
        return static::$instance ?? (static::$instance = new Model());
    }

    public static function getForListPage($category_id)
    {

        $products = self::getInstance()->with(['offers', 'category'])
            ->paginate(12);

        $result = (object)[
            'products' => $products,
            'info' => "Showing "
                . (($products->currentPage() -1) * $products->perPage() + 1)
                . " - " . $products->currentPage() * $products->perPage()
                . " of " . $products->total() . " results "
        ];
        return $result;
    }

    public static function getForDetailPage($product) : Product
    {
        $product = self::getInstance()->where('slug', $product)->first();
        return $product;
    }

    public static function getBreadcrumb(Model $product) : Collection
    {
        $result = CategoryRepository::getBreadcrumb($product->category);
        $result->add((object)[
            'title' => $product->name,
            'url' => $product->category->url . '/detail-product/' . $product->slug
        ]);
        return $result;
    }
}
