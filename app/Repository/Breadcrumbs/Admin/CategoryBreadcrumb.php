<?php

namespace App\Repository\Breadcrumbs\Admin;

use App\Interfaces\RowGetteble;
use App\Models\Shop\Category;
use App\Models\Shop\Category as Model;
use App\Repository\Breadcrumbs\CoreBreadcrumb;

class CategoryBreadcrumb extends CoreBreadcrumb
{

    protected function getClassName(): string
    {
        return Model::class;
    }

    function getBreadcrumb(RowGetteble $model)
    {
        $url = trim($model->getRawOriginal('url'), '/');
        $slugs = explode('/', $url);
        $categories = $this->getInstance()->whereIn('slug', $slugs)->get();
        $result = collect($slugs)->map(function ($slug) use($categories){
            $result = (object)$categories->where('slug', $slug)->first()->getAttributes();
            $result->url = '/admin/'.CATALOG_PATH.$result->url;
            return $result;
        });
        $this->addSubBreadcrumb($result);
        return $result;
    }

    private function addSubBreadcrumb(&$result){
        $result->prepend(
            (object)[
                'title' => 'Catalog',
                'url' => '/admin/'.CATALOG_PATH
            ]
        );
        $result->prepend(
            (object)[
                'title' => 'Admin',
                'url' => '/admin'
            ]
        );
    }
}
