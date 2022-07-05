<?php

namespace App\Http\Controllers\Shop;

use App\Helpers\DataRefactor;
use App\Http\Controllers\Controller;
use App\Models\Shop\Category;
use App\Models\Shop\Product;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Illuminate\Http\Request;

class CatalogController extends Controller
{

    public function list(Request $request, $category, $sub_categories = null)
    {

        $request_url = $request->getPathInfo();
        $category = CategoryRepository::getFromUrl($request_url);
        $breadcrumbs = CategoryRepository::getBreadcrumb($category);
        $products_box = ProductRepository::getWithPaginate($category->id);
        $inner_categories = CategoryRepository::getChildrenWithCount($category);

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

        $products_box = ProductRepository::getWithPaginate();
        $category = CategoryRepository::getRootCategory();
        $inner_categories = CategoryRepository::getChildrenWithCount($category);
        return view('shop.section', compact('category', 'inner_categories', 'products_box'));
    }

}
