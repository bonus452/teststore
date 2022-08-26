<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Shop\Category;
use App\Models\Shop\Product;
use App\Repository\Breadcrumbs\Shop\CategoryBreadcrumb;
use App\Repository\Breadcrumbs\Shop\ProductBreadcrumb;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Illuminate\Http\Request;

class CatalogController extends Controller
{

    private $productRepository;
    private $categoryRepository;
    private $breadcrumbCategory;
    private $breadcrumbProduct;

    public function __construct()
    {
        $this->productRepository = new ProductRepository();
        $this->categoryRepository = new CategoryRepository();
        $this->breadcrumbCategory = new CategoryBreadcrumb();
        $this->breadcrumbProduct = new ProductBreadcrumb();
    }

    public function list(Request $request, $sub_categories)
    {

        $request_url = $request->getPathInfo();
        $category = $this->categoryRepository->getFromUrl($request_url);

        if(is_null($category) || $request_url !== $category->url){
            abort( 404);
        }else{
            $breadcrumbs = $this->breadcrumbCategory->getBreadcrumb($category);
            $products_box = $this->productRepository->getPaginateWithSublevelsProducts($category->id);
            $inner_categories = $this->categoryRepository->getChildrenWithCount($category);
            return view('shop.section', compact('category', 'breadcrumbs', 'inner_categories', 'products_box'));
        }
    }

    public function detail($sub_categories, $product)
    {
        $product = $this->productRepository->getForDetailPage($product);
        if ($product instanceof Product){
            $breadcrumbs = $this->breadcrumbProduct->getBreadcrumb($product);
            return view('shop.detail', compact('product', 'breadcrumbs'));
        }else{
            abort(404);
        }
    }

    public function index()
    {
        $test = new Category();
        $test->where('slug', 'reilly')->get();

        $products_box = $this->productRepository->getPaginateWithSublevelsProducts();
        $category = $this->categoryRepository->getRootCategory();
        $inner_categories = $this->categoryRepository->getChildrenWithCount($category);
        return view('shop.section', compact('category', 'inner_categories', 'products_box'));
    }

}
