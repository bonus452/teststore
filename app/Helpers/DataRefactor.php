<?php

namespace App\Helpers;

use App\Models\Shop\Category;
use App\Repository\CategoryRepository;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\Types\Static_;

class DataRefactor
{
    public static function refreshCategoriesUrl($category_id = 1)
    {
        $category_tree = (new CategoryRepository())->getCategoriesTree($category_id);
        $rootCategory = Category::find($category_id);
        $from_root_href = '';
        if (!is_null($rootCategory)) {
            $from_root_href = self::buildUrl($rootCategory);
            $rootCategory->update(['url' => $from_root_href]);
        }
        if ($category_tree->isNotEmpty()) {
            self::setCategoryUrl($category_tree, $from_root_href);
        }
    }

    private static function setCategoryUrl($categories, $url)
    {
        /** @var \App\Models\Shop\Category $category */

        foreach ($categories as $category) {
            $category->url = $url.'/'.$category->slug;
            $category->update();
            if ($category->sub_categories->isNotEmpty()) {
                self::setCategoryUrl($category->sub_categories, $category->getRawOriginal('url'));
            }
        }
    }

    private static function buildUrl(Category $category) : string
    {
        $parents = CategoryRepository::getParents($category);
        $result = '/' . $parents->pluck('slug')->implode('/');
        return $result;
    }

}
