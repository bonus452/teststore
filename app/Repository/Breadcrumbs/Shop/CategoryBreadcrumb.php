<?php

namespace App\Repository\Breadcrumbs\Shop;

use App\Interfaces\RowGetteble;
use App\Models\Shop\Category as Model;
use App\Repository\Breadcrumbs\CoreBreadcrumb;

class CategoryBreadcrumb extends CoreBreadcrumb
{

    protected function getClassName() : string
    {
        return Model::class;
    }

    public function getBreadcrumb(RowGetteble $model)
    {
        $url = trim($model->getRawOriginal('url'), '/');
        $slugs = explode('/', $url);
        $categories = $this->getInstance()
            ->whereIn('slug', $slugs)
            ->get();
        $result = collect($slugs)->map(function ($slug) use($categories){
            return $categories
                ->where('slug', $slug)
                ->first();
        });

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
        return $result;
    }

}
