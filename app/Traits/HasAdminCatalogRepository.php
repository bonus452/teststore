<?php

namespace App\Traits;

use App\Repository\Breadcrumbs\Admin\CategoryBreadcrumb;
use App\Repository\Breadcrumbs\Admin\ProductBreadcrumb;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Services\CategoryService;

trait HasAdminCatalogRepository
{
    private $productRepository;
    private $categoryRepository;
    private $categoryService;

    public function __construct()
    {
        $this->productRepository = new ProductRepository(new ProductBreadcrumb());
        $this->categoryRepository = new CategoryRepository(new CategoryBreadcrumb());
        $this->categoryService = new CategoryService();
    }
}
