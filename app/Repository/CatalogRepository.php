<?php

namespace App\Repository;

use App\Filters\QueryFilter;
use App\Models\Shop\Category;
use App\Models\Shop\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Collection as ElCollection;

class CatalogRepository
{

    private ProductRepository $productRepository;
    private CategoryRepository $categoryRepository;

    public function __construct()
    {
        $this->productRepository = new ProductRepository();
        $this->categoryRepository = new CategoryRepository();
    }

    public function getCategoriesWithCountProducts(Category $parent): ElCollection
    {
        $child_categories = $parent->child()->get();
        $this->setCountProductsToCategories($child_categories);
        return $child_categories;
    }

    private function setCountProductsToCategories(Collection &$categories): void
    {
        $all_categories = Category::all();
        $categories->transform(function (Category $item) use ($all_categories) {
            $children = $this->categoryRepository->getAllChildrenId($item->id, $all_categories);
            $count_products = $this->productRepository->getCountFromCategories($children);
            return $item->setCustomProp('count_products', $count_products);
        });
    }

    public function getFilteredPaginateSublevelProducts(QueryFilter $filter, $category_id = false): object
    {
        $products = Product::active()
            ->filter($filter)
            ->with('category', 'firstOffer', 'firstImage');
        if ($category_id) {
            $categories = $this->categoryRepository->getAllChildrenId($category_id);
            $products->whereIn('category_id', $categories);
        }
        $url_params = request()->except('page');
        $products = $products
            ->paginate(12)
            ->appends($url_params);
        $result = $this->prepareProductResultPagination($products);
        return $result;
    }

    private function prepareProductResultPagination(LengthAwarePaginator $paginator): object
    {
        $result = (object)[
            'products' => $paginator,
            'info' => "Showing "
                . (($paginator->currentPage() - 1) * $paginator->perPage() + 1)
                . " - " . $paginator->currentPage() * $paginator->perPage()
                . " of " . $paginator->total() . " results "
        ];
        return $result;
    }

    public function getPaginateWithCategories(Category $parent = null): LengthAwarePaginator
    {
        $parent = $parent ?? $this->categoryRepository->getRootCategory();

        $categories = $parent->child()
            ->selectRaw("id, category_id, title, slug, created_at, updated_at, url, 'category' as `type`");
        $result = Product::where('category_id', $parent->id)
            ->selectRaw("id, category_id, name as title, slug, created_at, updated_at, 'url' as `url`, 'product' as `type`")
            ->with('category')
            ->union($categories)
            ->orderBy('type', 'asc')
            ->paginate(12);

        $this->prepareMixResultPagination($result);

        return $result;
    }

    private function prepareMixResultPagination(&$pagination): void
    {
        $pagination->getCollection()
            ->transform(function ($value) {
                if ($value->type == 'category') {
                    return (new Category())->setRawAttributes($value->getAttributes());
                } else {
                    return $value;
                }
            });
    }

}
