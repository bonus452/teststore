<?php

namespace App\Http\Controllers\Admin\Catalog;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Shop\Product;
use App\Repository\Breadcrumbs\Admin\CategoryBreadcrumb;
use App\Repository\Breadcrumbs\Admin\ProductBreadcrumb;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Services\OfferService;
use App\Services\ProductService;
use Exception;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    private $productRepository;
    private $categoryRepository;
    private $breadcrumbCategory;
    private $breadcrumbProduct;
    private $productService;
    private $offerService;

    public function __construct()
    {
        $this->productRepository = new ProductRepository();
        $this->categoryRepository = new CategoryRepository();
        $this->breadcrumbCategory = new CategoryBreadcrumb();
        $this->breadcrumbProduct = new ProductBreadcrumb();
        $this->productService = new ProductService();
        $this->offerService = new OfferService();
    }

    public function showFormCreate()
    {

        $perview_url = redirect()->back()->getTargetUrl();
        $selectedCategory = $this->categoryRepository->getFromUrl($perview_url);
        $categoriesTree = $this->categoryRepository->getForCombobox($selectedCategory, false);

        if (!is_null($selectedCategory)) {
            $breadcrumbs = $this->breadcrumbCategory->getBreadcrumb($selectedCategory);
            return view('admin.catalog.product.create_form',
                compact('categoriesTree', 'breadcrumbs'));
        } else {
            return view('admin.catalog.product.create_form',
                compact('categoriesTree'));
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
        return redirect()
            ->route('admin.catalog.product.edit_form', compact('product'))
            ->with(RESULT_MESSAGE, __('success.product_created'));
    }

    public function showFormUpdate(Product $product)
    {
        $product = $this->productRepository->getForDetailPage($product->slug);
        $categoriesTree = $this->categoryRepository->getForCombobox($product->category, false);
        $breadcrumbs = $this->breadcrumbProduct->getBreadcrumb($product);
        return view('admin.catalog.product.edit_form',
            compact('product', 'categoriesTree', 'breadcrumbs'));
    }

    public function update(Product $product, ProductRequest $request)
    {
        try {
            $this->productService->update($product, $request->except('offers'));
            $this->offerService->sync($product, collect($request->input('offers')));
        } catch (Exception $exception) {
            return back()
                ->withInput()
                ->withErrors(['product' => $exception->getMessage()]);
        }
        return redirect()
            ->route('admin.catalog.product.edit_form', compact('product'))
            ->with(RESULT_MESSAGE, __('success.product_updated'));
    }

    public function delete(Product $product)
    {
        $url = $product->category->getAdminUrl();

        try {
            if ($product->delete()) {
                return redirect($url)->with(RESULT_MESSAGE, __('success.product_deleted'));
            } else {
                return back()->withErrors(['category' => __('fail.category_delete')]);
            }
        }catch (Exception $exception){
            Log::error($exception);
            return back()->withErrors(['category' => __('fail.category_delete')]);

        }

    }

}
