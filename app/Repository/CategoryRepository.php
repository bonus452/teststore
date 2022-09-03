<?php

namespace App\Repository;

use App\Models\Shop\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class CategoryRepository
{

    protected function getInstance()
    {
        return new Category();
    }

    public function getAllChildrenId(int $parent_id, Collection $categories = null): array
    {
        $categories = $categories ?? Category::all();
        $result = $this->getRecursiveChilds($categories, [$parent_id]);
        $result->add($parent_id);
        return $result->toArray();
    }

    private function getRecursiveChilds(Collection $categories, array $parents): Collection
    {
        $childs_id = $categories->whereIn('category_id', $parents)->pluck('id');
        if ($childs_id->isNotEmpty()) {
            $result = $this->getRecursiveChilds($categories, $childs_id->toArray());
            $childs_id = $result->merge($childs_id);
        }
        return $childs_id;
    }

    public function getFromUrl(string $href)
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

    public function getCategoriesFromUrl(string $url): Collection
    {
        $slugs = $this->explodeSlugsFromUrl($url);
        $categories = $this->getBySlugs($slugs);
        $result = $this->orderBySlugs($slugs, $categories);
        return $result;
    }

    private function explodeSlugsFromUrl(string $url): array
    {
        $url = trim($url, '/');
        $slugs = explode('/', $url);
        return $slugs;
    }

    private function getBySlugs(array $slugs) :Collection
    {
        $result = $this->getInstance()
            ->whereIn('slug', $slugs)
            ->get();
        return $result;
    }

    private function orderBySlugs(array $slugs, Collection $categories): Collection
    {
        $result = collect($slugs)->map(function ($slug) use ($categories) {
            return $categories
                ->where('slug', $slug)
                ->first();
        });
        return $result;
    }

    public function getCategoriesTree($category_id = 1): Collection
    {
        $categories = $this->getInstance()->all();
        return $this->buildTree($categories, $category_id);
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


    private function buildTree(Collection $all_categories, $category_id)
    {
        $found = $all_categories->where('category_id', $category_id);
        foreach ($found as &$cat) {
            $cat->setCustomProp('sub_categories', $this->buildTree($all_categories, $cat->id));
        }
        return $found;
    }

    public function getRootCategory(): Category
    {
        $result = (new Category())
            ->withoutGlobalScope('withoutroot')
            ->find(1);
        $result->title = 'Catalog';
        return $result;
    }

}
