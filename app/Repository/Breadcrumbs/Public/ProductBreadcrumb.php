<?php

namespace App\Repository\Breadcrumbs\Public;

use App\Interfaces\RowGetteble;

class ProductBreadcrumb extends CategoryBreadcrumb
{
    public function getBreadcrumb(RowGetteble $model)
    {
        $result = parent::getBreadcrumb($model->category);
        $result->add((object)[
            'title' => $model->name,
            'url' => $model->category->url . '/detail-product/' . $model->slug
        ]);
        return $result;
    }
}
