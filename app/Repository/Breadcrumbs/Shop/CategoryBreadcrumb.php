<?php

namespace App\Repository\Breadcrumbs\Shop;

use App\Models\Catalog\Category;
use App\Repository\Breadcrumbs\CoreBreadcrumb;
use App\Repository\CategoryRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class CategoryBreadcrumb extends CoreBreadcrumb
{

    protected function getClassName(): string
    {
        return Category::class;
    }

    public function getBreadcrumb(Model $model): Collection
    {
        $result = (new CategoryRepository())->getCategoriesFromUrl($model->getRawOriginal('url'));
        $result->prepend(
            (object)[
                'title' => 'Catalog',
                'url' => '/' . CATALOG_PATH
            ]
        );
        $result->prepend(
            (object)[
                'title' => 'Home',
                'url' => '/'
            ]
        );
        return $result;
    }

}
