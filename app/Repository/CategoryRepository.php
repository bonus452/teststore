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

    public static function getCategoriesTree($pid = 1) :Collection
    {
        $arr = self::getInstance()->all();
        return self::buildTree($arr, $pid);
    }

    private static function buildTree($arr, $pid) {
        $found = $arr->filter(function($item) use ($pid){
            return $item->category_id == $pid;
        });
        foreach ($found as &$cat) {
            $cat->sub_categories = self::buildTree($arr, $cat->id);
        }
        return $found;
    }

    public static function getRootCategories()
    {
        return self::getInstance()->where('category_id', 1)->get();
    }

}
