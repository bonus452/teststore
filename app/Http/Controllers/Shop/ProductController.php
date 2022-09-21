<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Shop\Product;
use App\Repository\Breadcrumbs\Shop\ProductBreadcrumb;
use App\Repository\OfferRepository;
use App\Repository\ProductRepository;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{

    private $productRepository;
    private $offerRepository;
    private $breadcrumbProduct;
    private CartService $cartService;


    public function __construct()
    {
        $this->productRepository = new ProductRepository();
        $this->breadcrumbProduct = new ProductBreadcrumb();
        $this->offerRepository = new OfferRepository();
        $this->cartService = new CartService();
    }

    public function detail(Request $request, string $sub_categories, string $product)
    {
        $product = $this->productRepository->getForDetailPage($product);

        if (!($product instanceof Product) || $product->url !== $request->getPathInfo()) {
            abort(404);
        }
        $breadcrumbs = $this->breadcrumbProduct->getBreadcrumb($product);

        return view('shop.detail', compact(
            'product',
            'breadcrumbs'));
    }

}
