<?php

namespace App\Repository\Breadcrumbs\Admin;

use App\Interfaces\RowGetteble;

class ProductBreadcrumb extends CategoryBreadcrumb
{
    public function getBreadcrumb(RowGetteble $model)
    {
        $url = trim($model->category->getRawOriginal('url'), '/');
        $slugs = explode('/', $url);
        $categories = $this->getInstance()->whereIn('slug', $slugs)->get();
        $result = collect($slugs)->map(function ($slug) use($categories){
            $result = (object)$categories->where('slug', $slug)->first()->getAttributes();
            $result->url = '/admin/'.CATALOG_PATH.$result->url;
            return $result;
        });
        $this->addSubBreadcrumb($result, $model);
        return $result;
    }

    private function addSubBreadcrumb(&$result, $model){
        $result->add(
            (object)[
                'title' => $model->name,
                'url' => $model->getAdminUrl()
            ]
        );
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
