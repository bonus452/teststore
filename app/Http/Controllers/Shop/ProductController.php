<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Shop\Category;
use App\Helpers\DataRefactor;
use App\Repository\CategoryRepository;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function list(Request $request, $category, $sub_categories = null)
    {
        $request_url = $request->getPathInfo();
        $category = CategoryRepository::getFromUrl($request_url);
        $breadcrumbs = CategoryRepository::getBreadcrumb($category);

        $inner_categories = $category->child()->get();

        if($request_url !== $category->url){
            abort( 404);
        }else{
            return view('shop.section', compact('category', 'breadcrumbs', 'inner_categories'));
        }
    }

    public function detail($category_id, $product, $sub_categories = null)
    {
        dd(__METHOD__, $category_id, $sub_categories, $product);
    }

    public function index()
    {
        $category = new Category();
        $category->title = 'Catalog';
        $inner_categories = CategoryRepository::getRootCategories();
        return view('shop.section', compact('category', 'inner_categories'));
    }

}
