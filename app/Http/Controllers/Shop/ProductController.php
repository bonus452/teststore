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

//        $selected_properties = (array)$request->input('offer_properties');
//        $offer_schema = $this->offerRepository->getOfferBlockCondition($product, $selected_properties);
//        $selected_offer = $this->offerRepository->getSelectedOffer($product, $offer_schema);
//
//        $selected_offer->setCustomProp(
//            'in_cart',
//            $this->cartService->isInCart($selected_offer)
//        );

//        if ($request->ajax()){
//            return view('include.product_detail_page.offer_block', compact(
//                'product',
//                'offer_schema',
//                'selected_offer'));
//        }else{
            $breadcrumbs = $this->breadcrumbProduct
                ->getBreadcrumb($product);
            return view('shop.detail', compact(
                'product',
                'breadcrumbs'));
//        }
    }

}
