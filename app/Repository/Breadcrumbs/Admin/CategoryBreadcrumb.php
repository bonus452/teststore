<?php

namespace App\Repository\Breadcrumbs\Admin;

use App\Interfaces\RowGetteble;
use App\Repository\Breadcrumbs\Shop\CategoryBreadcrumb as ShopCategoryBreadcrumb;

class CategoryBreadcrumb extends ShopCategoryBreadcrumb
{

    function getBreadcrumb(RowGetteble $model)
    {
        $result = parent::getBreadcrumb($model);
        $result->put(0, (object)[
            'title' => 'Admin',
            'url' => '/admin'
        ]);
        $result->put(1, (object)[
            'title' => 'Catalog',
            'url' => '/admin/'.CATALOG_PATH
        ]);
        return $result;
    }
}
