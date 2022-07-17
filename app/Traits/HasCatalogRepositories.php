<?php

namespace App\Traits;

use App\Repository\Breadcrumbs\Shop\CategoryBreadcrumb;
use App\Repository\Breadcrumbs\Shop\ProductBreadcrumb;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;

trait HasCatalogRepositories
{
    private $productRepository;
    private $categoryRepository;

    public function __construct()
    {
        $this->productRepository = new ProductRepository(new ProductBreadcrumb());
        $this->categoryRepository = new CategoryRepository(new CategoryBreadcrumb());
    }
}
