<?php

namespace App\Http\Controllers\Shop;

use App\Helpers\DataRefactor;
use App\Http\Controllers\Controller;
use App\Models\Shop\Category;
use App\Models\Shop\Product;
use App\Traits\HasCatalogRepositories;
use Illuminate\Http\Request;

class CatalogController extends Controller
{

    use HasCatalogRepositories;

    public function list(Request $request, $sub_categories)
    {

        $request_url = $request->getPathInfo();
        $category = $this->categoryRepository->getFromUrl($request_url);

        if(is_null($category) || $request_url !== $category->url){
            abort( 404);
        }else{
            $breadcrumbs = $this->categoryRepository->getBreadcrumb($category);
            $products_box = $this->productRepository->getPaginateWithSublevelsProducts($category->id);
            $inner_categories = $this->categoryRepository->getChildrenWithCount($category);
            return view('shop.section', compact('category', 'breadcrumbs', 'inner_categories', 'products_box'));
        }
    }

    public function detail($sub_categories, $product)
    {
        $product = $this->productRepository->getForDetailPage($product);
        if ($product instanceof Product){
            $breadcrumbs = $this->productRepository->getBreadcrumb($product);
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
