<?php

namespace App\Repository;

use App\Models\Shop\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;


class CategoryRepository extends CatalogRepository
{

    function getModelClass(): string
    {
        return Category::class;
    }

    protected function getInstance(): Category
    {
        return clone $this->instance;
    }

    public function getFromUrl($href)
    {
        $curent_slug = collect(explode('/', $href))->last();
        $result = Category::where('slug', $curent_slug)->first();
        return $result;
    }

    public function getParents(Category $category): Collection
    {
        $result[] = $category;
        while ($category = $category->parent) {
            $result[] = $category;
        }
        return collect(array_reverse($result));
    }

    public function getParentsFromCategoryUrl(Model $category)
    {
        $url = trim($category->getRawOriginal('url'), '/');
        $slugs = explode('/', $url);
        $categories = $this->getInstance()
            ->whereIn('slug', $slugs)
            ->get();
        return collect($slugs)->map(function ($slug) use ($categories) {
            return $categories
                ->where('slug', $slug)
                ->first();
        });
    }

    public function getCategoriesTree($pid = 1): Collection
    {
        $categories = $this->getInstance()->all();
        return $this->buildTree($categories, $pid);
    }

    public function getForCombobox($selectedCategory): Collection
    {
        $result = $this->getCategoriesTree(1);

        $selectedCategoryId = $selectedCategory ? $selectedCategory->id : 0;
        $result = $this->markSelectedCategory($result, $selectedCategoryId);

        return $result;
    }

    public function getForComboboxWithRoot($selectedCategory): Collection
    {
        $categories = $this->getCategoriesTree(1);
        $result = new Collection();
        $root_category = $this->getRootCategory();
        $root_category->setCustomProp('sub_categories', $categories);
        $result = $result->push($root_category);

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

    public function getChildrenWithCountProducts(Category $parent)
    {
        $result = $parent->child()->get();
        $all_categories = $this->getInstance()->all();
        $result->transform(function (Category $item) use ($all_categories) {
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

    public function getWithPaginate(Category $category = null)
    {

        return $this->getInstance()->paginate(12);
    }

}
