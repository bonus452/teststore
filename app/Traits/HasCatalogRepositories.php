<?php

namespace App\Traits;

use App\Repository\Breadcrumbs\Public\CategoryBreadcrumb;
use App\Repository\Breadcrumbs\Public\ProductBreadcrumb;
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
