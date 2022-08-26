<?php

namespace App\Repository\Breadcrumbs\Admin;

use App\Interfaces\RowGetteble;

class ProductBreadcrumb extends CategoryBreadcrumb
{
    public function getBreadcrumb(RowGetteble $model)
    {
        $result = parent::getBreadcrumb($model->category);
        $result->add((object)[
            'title' => $model->name,
            'url' => $model->category->url . '/product-edit/' . $model->slug
        ]);
        return $result;
    }



}
