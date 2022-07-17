<?php

namespace App\Repository;

use App\Models\Shop\Category as Model;
use Illuminate\Support\Collection;


class CategoryRepository extends CatalogRepository
{

    function getModelClass(): string
    {
        return Model::class;
    }

    protected function getInstance(): Model
    {
        return clone $this->instance;
    }

    public function getFromUrl($href)
    {
        $curent_slug = collect(explode('/', $href))->last();
        $result = Model::where('slug', $curent_slug)->first();
        return $result;
    }

    public function getParents(Model $category): Collection
    {
        $result[] = $category;
        while ($category = $category->parent) {
            $result[] = $category;
        }
        return collect(array_reverse($result));
    }

    public function getBreadcrumb(Model $category)
    {
        $result = $this->breadcrumbRepository->getBreadcrumb($category);
        return $result;
    }

    public function getCategoriesTree($pid = 1): Collection
    {
        $categories = $this->getInstance()->all();
        return $this->buildTree($categories, $pid);
    }

    public function getForCombobox($selectedCategory): Collection
    {
        $categories = $this->getCategoriesTree(1);
        $result = $this->getRootCategory();
        $result->setCustomProp('sub_categories', $categories);
        $result = collect([$result]);

        $selectedCategoryId = $selectedCategory ? $selectedCategory->id : 0;
        $result = $this->markSelectedCategory($result, $selectedCategoryId);

        return $result;
    }

    private function markSelectedCategory(Collection $categories, $selectedCategoryId)
    {


        $categories->transform(function ($category) use ($selectedCategoryId) {
            /** @var \App\Models\Shop\Category $category */

            $check_category = old('category_id') ?? $selectedCategoryId;
            if ($category->id == $check_category) {
                $category->setCustomProp('selected', 'selected');
            }
            $sub_categories = $category->getCustomProp('sub_categories');
            if ($sub_categories->isNotEmpty()) {
                $category->setCustomProp('sub_categories',
                    $this->markSelectedCategory($sub_categories, $selectedCategoryId)
                );
            }
            return $category;
        });
        return $categories;
    }

    public function getChildrenWithCount(Model $parent)
    {
        $result = $parent->child()->get();
        $all_categories = $this->getInstance()->all();
        $result->transform(function (Model $item) use ($all_categories) {
            $children = $this->getAllChildsList($item->id, $all_categories);
            $count_products = $this->getCountByCategories($children);
            return $item->setCustomProp('count_products', $count_products);
        });
        return $result;
    }

    private function buildTree(Collection $categories, $pid)
    {
        /** @var \App\Models\Shop\Category $cat */

        $found = $categories->where('category_id', $pid);
        foreach ($found as &$cat) {
            $cat->setCustomProp('sub_categories', $this->buildTree($categories, $cat->id));
        }
        return $found;
    }

    public function getWithPaginate(Model $category = null)
    {

        return $this->getInstance()->paginate(12);
    }

}
