<?php

namespace App\Repository;
use App\Models\Shop\Category;
use App\Models\Shop\Category as Model;
use Illuminate\Support\Collection;


class CategoryRepository
{

    private static $instance;

    private static function getInstance() : Model
    {
        return static::$instance ?? (static::$instance = new Model());
    }

    public static function getFromUrl($href) : Model
    {
        $curent_slug = collect(explode('/', $href))->last();
        $result = Model::where('slug', $curent_slug)->first();
        return $result ?? new Model();
    }

    public static function getParents(Category $category) :Collection
    {
        $result[] = $category;
        while ($category = $category->parent){
            $result[] = $category;
        }
        return collect(array_reverse($result));
    }

    public static function getBreadcrumb(Category $category){
        $url = trim($category->getRawOriginal('url'), '/');
        $slugs = explode('/', $url);
        $categories = self::getInstance()->whereIn('slug', $slugs)->get();
        $result = collect($slugs)->map(function ($slug) use($categories){
            return $categories->where('slug', $slug)->first();
        });
        self::addSubBreadcrumb($result);
        return $result;
    }

    public static function getAllChildsList($parent_id, Collection $categories = null): array
    {
        $categories = $categories ?? self::getInstance()->all();
        $result = self::getChilds($categories, [$parent_id]);
        $result->add(['id' => $parent_id]);
        return $result->toArray();
    }

    public static function getCategoriesTree($pid = 1) :Collection
    {
        $categories = self::getInstance()->all();
        return self::buildTree($categories, $pid);
    }

    public static function getChildrenWithCount(Category $parent){
        $result = $parent->child()->get();
        $all_categories = self::getInstance()->all();
        $result->transform(function (Category $item) use($all_categories){
            $children = self::getAllChildsList($item->id, $all_categories);
            $count_products = ProductRepository::getCountByCategories($children);
            return $item->setCountProducts($count_products);
        });
        return $result;
    }

    public static function getRootCategory() : Category
    {
        $result = self::getInstance()
            ->withoutGlobalScope('withoutroot')
            ->find(1);
        $result->title = 'Catalog';
        return $result;
    }



    private static function addSubBreadcrumb(&$result){
        $result->prepend(
                (object)[
                    'title' => 'Catalog',
                    'url' => '/'.CATALOG_PATH
                ]
            );
        $result->prepend(
            (object)[
                'title' => 'Home',
                'url' => '/'
            ]
        );
    }

    private static function getChilds(Collection $categories, $parents) :Collection
    {
        $childs = $categories->whereIn('category_id', $parents)->pluck('id');
        if($childs->isNotEmpty()){
            $result = self::getChilds($categories, $childs->toArray());
            $childs = $result->merge($childs);
        }
        return $childs;
    }

    private static function buildTree(Collection $categories, $pid) {
        $found = $categories->where('category_id', $pid);
        foreach ($found as &$cat) {
            $cat->setSubCategories(self::buildTree($categories, $cat->id));
        }
        return $found;
    }

}
