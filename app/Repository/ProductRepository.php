<?php

namespace App\Repository;

use App\Models\Shop\Category;
use App\Models\Shop\Product as Model;
use Illuminate\Support\Collection;




class ProductRepository extends CatalogRepository
{

    function getModelClass(): string
    {
        return Model::class;
    }

    protected function getInstance(): Model
    {
        return clone $this->instance;
    }

    public function getPaginateWithSublevelsProducts($category_id = false): object
    {

        $products = $this->getInstance()->active()->with(['offers', 'category']);
        if ($category_id) {
            $categories = $this->getAllChildsList($category_id);
            $products = $products->whereIn('category_id', $categories);
        }
        $products = $products->paginate(12);

        $result = (object)[
            'products' => $products,
            'info' => "Showing "
                . (($products->currentPage() - 1) * $products->perPage() + 1)
                . " - " . $products->currentPage() * $products->perPage()
                . " of " . $products->total() . " results "
        ];
        return $result;
    }

    public function getPaginateWithCategories(Category $parent = null)
    {

        $parent = $parent ?? $this->getRootCategory();
        $categories = $parent->child()
            ->selectRaw("id, category_id, title, slug, created_at, updated_at, url, 'category' as `type`");
        $result = $this->getInstance()
            ->where('category_id', $parent->id)
            ->selectRaw("id, category_id, name as title, slug, created_at, updated_at, 'url' as `url`, 'product' as `type`")
            ->with('category')
            ->union($categories)
            ->orderBy('type', 'asc')
            ->paginate(12);

        $result->getCollection()
            ->transform(function ($value) {
                if ($value->type == 'category') {
                    return (new Category())->setRawAttributes($value->getAttributes());
                } else {
                    return $value;
                }
            });

        return $result;
    }


    public function getForDetailPage($product)
    {
        $product = $this->getInstance()->where('slug', $product)->active()
            ->with(['offers' => function($query){
                $query->with(['properties' => function($query){
                    $query->with('property_name');
                }]);
            }])
            ->with(['properties' => function($query){
                $query->with('property_name');
            }])
            ->first();

        return $product;
    }

}
