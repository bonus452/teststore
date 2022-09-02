<?php

namespace App\Repository\Breadcrumbs\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class ProductBreadcrumb extends CategoryBreadcrumb
{
    public function getBreadcrumb(Model $model): Collection
    {
        $result = parent::getBreadcrumb($model->category);
        $result->add((object)[
            'title' => $model->name,
            'url' => $model->category->url . '/product-edit/' . $model->slug
        ]);
        return $result;
    }


}
