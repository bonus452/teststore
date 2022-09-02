<?php

namespace App\Helpers;

use App\Models\Shop\Category;
use App\Repository\CategoryRepository;
use Illuminate\Support\Collection as BaseCollection;

class DataCategoryRefresher
{
    public static function refreshUrls(int $category_id = 1): void
    {
        $category_tree = (new CategoryRepository())->getCategoriesTree($category_id);
        $start_href = self::buildUrlForCategory($category_id);
        if ($category_tree->isNotEmpty()) {
            self::setCategoryUrl($category_tree, $start_href);
        }
    }

    private static function setCategoryUrl(BaseCollection $categories, string $url): void
    {
        /** @var \App\Models\Shop\Category $category */

        foreach ($categories as $category) {

            $category->url = $url . '/' . $category->slug;
            $category->update();

            if ($category->getCustomProp('sub_categories')->isNotEmpty()) {
                self::setCategoryUrl(
                    $category->getCustomProp('sub_categories'),
                    $category->getRawOriginal('url')
                );
            }
        }
    }

    private static function buildUrlForCategory(int $category_id): string
    {
        $category = Category::find($category_id);
        $url = '';
        if ($category instanceof Category) {
            $parents = (new CategoryRepository())->getParents($category);
            $url = '/' . $parents->pluck('slug')->implode('/');
        }
        return $url;
    }

}
