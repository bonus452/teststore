<?php

namespace App\Http\Controllers\Shop;

use App\Filters\ProductFilter;
use App\Http\Controllers\Controller;
use App\Models\Shop\Category;
use App\Repository\Breadcrumbs\Shop\CategoryBreadcrumb;
use App\Repository\CartRepository;
use App\Repository\CatalogRepository;
use App\Repository\CategoryRepository;
use App\Repository\PropertyRepository;
use Illuminate\Http\Request;

class CatalogController extends Controller
{

    private $categoryRepository;
    private $breadcrumbCategory;
    private $propertyRepository;
    private $catalogRepository;
    private $cartRepository;

    public function __construct()
    {
        $this->categoryRepository = new CategoryRepository();
        $this->breadcrumbCategory = new CategoryBreadcrumb();
        $this->propertyRepository = new PropertyRepository();
        $this->catalogRepository = new CatalogRepository();
        $this->cartRepository = new CartRepository();
    }

    public function list(Request $request, ProductFilter $product_filter)
    {

        $request_url = $request->getPathInfo();
        $category = $this->categoryRepository->getFromUrl($request_url);
        if (!($category instanceof Category) || $request_url !== $category->url) {
            abort(404);
        }

        $products_box = $this->catalogRepository
            ->getFilteredPaginateSublevelProducts($product_filter, $category->id);
        $this->cartRepository
            ->checkProductsIsInCart($products_box->products);
        $filter = $this->propertyRepository
            ->getFilterProperties($category, $product_filter);
        $inner_categories = $this->catalogRepository
            ->getCategoriesWithCountProducts($category);
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

    public function index(Request $request, ProductFilter $product_filter)
    {
        $products_box = $this->catalogRepository
            ->getFilteredPaginateSublevelProducts($product_filter);
        $this->cartRepository
            ->checkProductsIsInCart($products_box->products);
        $category = $this->categoryRepository
            ->getRootCategory();
        $inner_categories = $this->catalogRepository
            ->getCategoriesWithCountProducts($category);
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
