<?php

namespace App\Repository\Breadcrumbs\Admin;

use App\Repository\Breadcrumbs\Shop\CategoryBreadcrumb as ShopCategoryBreadcrumb;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class CategoryBreadcrumb extends ShopCategoryBreadcrumb
{

    function getBreadcrumb(Model $model): Collection
    {
        $result = parent::getBreadcrumb($model);
        $result->put(0, (object)[
            'title' => 'Admin',
            'url' => '/admin'
        ]);
        $result->put(1, (object)[
            'title' => 'Catalog',
            'url' => '/admin/' . CATALOG_PATH
        ]);
        return $result;
    }
}
