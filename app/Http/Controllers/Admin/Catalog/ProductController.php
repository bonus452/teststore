<?php

namespace App\Http\Controllers\Admin\Catalog;

use App\Http\Controllers\Controller;
use App\Models\Shop\Product;
use App\Traits\HasAdminCatalogRepository;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use HasAdminCatalogRepository;

    public function showFormCreate(){
        $perview_url = redirect()->back()->getTargetUrl();
        $selectedCategory = $this->categoryRepository->getFromUrl($perview_url);

        $categoriesTree = $this->categoryRepository->getForCombobox($selectedCategory);
        $breadcrumbs = $this->categoryRepository->getBreadcrumb($selectedCategory);
        return view('admin.catalog.product.create_form', compact('categoriesTree', 'breadcrumbs'));
    }

    public function create(Request $request){
        dd(__METHOD__);
    }

    public function showFormUpdate(Product $product){
        dd(__METHOD__);
    }

    public function update(Product $product, Request $request){
        dd(__METHOD__);
    }
}
