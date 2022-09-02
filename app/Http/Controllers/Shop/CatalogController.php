<?php

namespace App\Http\Controllers\Shop;

use App\Filters\ProductFilter;
use App\Http\Controllers\Controller;
use App\Models\Shop\Category;
use App\Models\Shop\Product;
use App\Repository\Breadcrumbs\Shop\CategoryBreadcrumb;
use App\Repository\Breadcrumbs\Shop\ProductBreadcrumb;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Repository\PropertyRepository;
use Illuminate\Http\Request;

class CatalogController extends Controller
{

    private $productRepository;
    private $categoryRepository;
    private $breadcrumbCategory;
    private $breadcrumbProduct;
    private $propertyRepository;

    public function __construct()
    {
        $this->productRepository = new ProductRepository();
        $this->categoryRepository = new CategoryRepository();
        $this->breadcrumbCategory = new CategoryBreadcrumb();
        $this->breadcrumbProduct = new ProductBreadcrumb();
        $this->propertyRepository = new PropertyRepository();
    }

    public function list(Request $request, ProductFilter $product_filter)
    {
        $request_url = $request->getPathInfo();
        $category = $this->categoryRepository->getFromUrl($request_url);
        if (!($category instanceof Category) || $request_url !== $category->url) {
            abort(404);
        }

        $products_box = $this->productRepository
            ->getPaginateWithSublevelProducts($product_filter, $category->id);
        $filter = $this->propertyRepository
            ->getFilterProperties($category, $product_filter);
        $inner_categories = $this->categoryRepository
            ->getChildrenWithCountProducts($category);
        if ($request->ajax()) {
            return view('include.catalog_section',
                compact(
                    'category',
                    'inner_categories',
                    'products_box',
                    'filter'));
        } else {
            $breadcrumbs = $this->breadcrumbCategory->getBreadcrumb($category);
            return view('shop.section',
                compact(
                    'category',
                    'breadcrumbs',
                    'inner_categories',
                    'products_box',
                    'filter'));
        }
    }

    public function detail(Request $request, string $sub_categories, string $product)
    {
        $product = $this->productRepository
            ->getForDetailPage($product);
        if ($product instanceof Product && $product->url === $request->getPathInfo()) {
            $breadcrumbs = $this->breadcrumbProduct
                ->getBreadcrumb($product);
            return view('shop.detail', compact('product', 'breadcrumbs'));
        } else {
            abort(404);
        }
    }

    public function index(Request $request, ProductFilter $product_filter)
    {
        $products_box = $this->productRepository
            ->getPaginateWithSublevelProducts($product_filter);
        $category = $this->categoryRepository
            ->getRootCategory();
        $inner_categories = $this->categoryRepository
            ->getChildrenWithCountProducts($category);
        $filter = $this->propertyRepository
            ->getFilterProperties($category, $product_filter);

        $view = $request->ajax() ? 'include.catalog_section' : 'shop.section';
        return view($view,
            compact(
                'category',
                'inner_categories',
                'products_box',
                'filter'));

    }

}
