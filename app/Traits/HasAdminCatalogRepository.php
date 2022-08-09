<?php

namespace App\Traits;

use App\Repository\Breadcrumbs\Admin\CategoryBreadcrumb;
use App\Repository\Breadcrumbs\Admin\ProductBreadcrumb;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Services\CategoryService;
use App\Services\OfferService;
use App\Services\ProductService;

trait HasAdminCatalogRepository
{
    private $productRepository;
    private $categoryRepository;
    private $categoryService;
    private $productService;
    private $offerService;

    public function __construct()
    {
        $this->productRepository = new ProductRepository(new ProductBreadcrumb());
        $this->categoryRepository = new CategoryRepository(new CategoryBreadcrumb());
        $this->categoryService = new CategoryService();
        $this->productService = new ProductService();
        $this->offerService = new OfferService();
    }
}
