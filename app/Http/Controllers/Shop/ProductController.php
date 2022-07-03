<?php

namespace App\Http\Controllers\Shop;

use App\Helpers\DataRefactor;
use App\Http\Controllers\Controller;
use App\Models\Shop\Category;
use App\Models\Shop\Product;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function list(Request $request, $category, $sub_categories = null)
    {

        $products_box = ProductRepository::getProductsForPage();

        $request_url = $request->getPathInfo();
        $category = CategoryRepository::getFromUrl($request_url);
        $breadcrumbs = CategoryRepository::getBreadcrumb($category);

        $inner_categories = $category->child()->get();

        if($request_url !== $category->url){
            abort( 404);
        }else{
            return view('shop.section', compact('category', 'breadcrumbs', 'inner_categories', 'products_box'));
        }
    }

    public function detail($category_id, $sub_categories = null, $product)
    {

        $product = ProductRepository::getForDetailPage($product);

        $breadcrumbs = ProductRepository::getBreadcrumb($product);

        return view('shop.detail', compact('product', 'breadcrumbs'));
    }

    public function index()
    {

        $products_box = ProductRepository::getForListPage();
        $category = new Category();
        $category->title = 'Catalog';
        $inner_categories = CategoryRepository::getRootCategories();
        return view('shop.section', compact('category', 'inner_categories', 'products_box'));
    }

}
