<?php

namespace App\Repository;

use App\Models\Shop\Category;
use App\Models\Shop\Product;
use App\Repository\Breadcrumbs\CoreBreadcrumb;
use App\Repository\Breadcrumbs\Shop\CategoryBreadcrumb;
use Illuminate\Support\Collection;

abstract class CatalogRepository
{

    protected $instance;
    protected $breadcrumbRepository;

    public function __construct(CoreBreadcrumb $breadcrumb = null){
        $this->breadcrumbRepository = $breadcrumb ?? new CategoryBreadcrumb();
        $this->instance = app($this->getModelClass());
    }

    public abstract function getModelClass() :string;


    public function getCountByCategories(array $categories) :int
    {
        $result = Product::active()->whereIn('category_id', $categories);
        $result = $result->count();
        return $result;
    }

    public function getAllChildsList($parent_id, Collection $categories = null): array
    {
        $categories = $categories ?? (new Category())->all();
        $result = $this->getChilds($categories, [$parent_id]);
        $result->add($parent_id);
        return $result->toArray();
    }

    private function getChilds(Collection $categories, $parents) :Collection
    {
        $childs = $categories->whereIn('category_id', $parents)->pluck('id');
        if($childs->isNotEmpty()){
            $result = $this->getChilds($categories, $childs->toArray());
            $childs = $result->merge($childs);
        }
        return $childs;
    }

    public function getRootCategory() : Category
    {
        $result = (new Category())
            ->withoutGlobalScope('withoutroot')
            ->find(1);
        $result->title = 'Catalog';
        return $result;
    }

}
