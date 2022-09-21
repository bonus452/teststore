<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Shop\Product;
use App\Repository\Breadcrumbs\Shop\ProductBreadcrumb;
use App\Repository\ProductRepository;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    private ProductRepository $productRepository;
    private ProductBreadcrumb $breadcrumbProduct;


    public function __construct()
    {
        $this->productRepository = new ProductRepository();
        $this->breadcrumbProduct = new ProductBreadcrumb();
    }

    public function detail(Request $request, string $sub_categories, string $product)
    {
        $product = $this->productRepository->getForDetailPage($product);

        if (!($product instanceof Product) || $product->url !== $request->getPathInfo()) {
            abort(404);
        }

        if ($request->ajax()){
            return view('shop.detail_ajax', compact('product'));
        }else{
            $breadcrumbs = $this->breadcrumbProduct->getBreadcrumb($product);
            return view('shop.detail', compact(
                'product',
                'breadcrumbs'));
        }

    }

}
