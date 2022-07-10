<?php

namespace App\Http\Controllers\Admin\Catalog;

use App\Http\Controllers\Controller;
use App\Models\Shop\Category;
use App\Traits\HasAdminCatalogRepository;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    use HasAdminCatalogRepository;

    public function index(){
        $items = $this->productRepository->getPaginateWithCategories();
        return view('admin.catalog.list', compact('items'));
    }

    public function list(Request $request, $sub_categories){
        $request_url = $request->getPathInfo();
        $category = $this->categoryRepository->getFromUrl($request_url);
        $items = $this->productRepository->getPaginateWithCategories($category);
        $breadcrumbs = $this->categoryRepository->getBreadcrumb($category);
        return view('admin.catalog.list', compact('items', 'breadcrumbs'));
    }

    public function editForm(Request $request, Category $category){
        $breadcrumbs = $this->categoryRepository->getBreadcrumb($category);
        return view('admin.catalog.category.edit_form', compact('category', 'breadcrumbs'));
    }

    public function createForm(Request $request){


        $category = Category::find(2);
        $breadcrumbs = $this->categoryRepository->getBreadcrumb($category);
        return view('admin.catalog.category.create_form', compact('category', 'breadcrumbs'));

    }

    public function create(Request $request){
        dd($request->all(), __METHOD__);
    }

}
