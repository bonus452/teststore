<?php

namespace App\Http\Controllers\Admin\Catalog;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Shop\Product;
use App\Models\Shop\PropertyName;
use App\Traits\HasAdminCatalogRepository;
use Exception;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use HasAdminCatalogRepository;

    public function showFormCreate()
    {
        $perview_url = redirect()->back()->getTargetUrl();
        $selectedCategory = $this->categoryRepository->getFromUrl($perview_url);

        $categoriesTree = $this->categoryRepository->getForCombobox($selectedCategory);
        if (!is_null($selectedCategory)) {
            $breadcrumbs = $this->categoryRepository->getBreadcrumb($selectedCategory);
            return view('admin.catalog.product.create_form', compact('categoriesTree', 'breadcrumbs'));
        } else {
            return view('admin.catalog.product.create_form', compact('categoriesTree'));
        }
    }

    public function create(ProductRequest $request)
    {
        try {
            $product = $this->productService->store($request->except('offers'));
            $this->offerService->createMany($product, collect($request->input('offers')));
        } catch (Exception $exception) {
            return back()
                ->withInput()
                ->withErrors(['product' => $exception->getMessage()]);
        }
        return redirect()->route('admin.catalog.product.edit_form',
            compact('product'));
    }

    public function showFormUpdate(Product $product)
    {
        $categoriesTree = $this->categoryRepository->getForCombobox($product->category);
        $breadcrumbs = $this->productRepository->getBreadcrumb($product);
        return view('admin.catalog.product.edit_form',
            compact('product', 'categoriesTree', 'breadcrumbs'));
    }

    public function update(Product $product, Request $request)
    {
        try {
            $this->productService->update($product, $request->except('offers'));
            $this->offerService->sync($product, collect($request->input('offers')));
        } catch (Exception $exception) {
            return back()
                ->withInput()
                ->withErrors(['product' => $exception->getMessage()]);
        }
        return redirect()->route('admin.catalog.product.edit_form',
            compact('product'));
    }
}
