<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Shop\Product;
use App\Repository\OfferRepository;
use App\Services\CartService;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    private OfferRepository $offerRepository;
    private CartService $cartService;

    public function __construct()
    {
        $this->offerRepository = new OfferRepository();
        $this->cartService = new CartService();
    }

    public function getOffersBlock(Request $request, int $product_id){
        $selected_properties = (array)$request->input('offer_properties');
        $offers = $this->offerRepository->getProductOffers($product_id);
        $offer_schema = $this->offerRepository->getOfferBlockCondition($offers, $selected_properties);
        $selected_offer = $this->offerRepository->getSelectedOffer($offers, $offer_schema);
        $selected_offer->setCustomProp(
            'in_cart',
            $this->cartService->isInCart($selected_offer)
        );
        return view('include.product_detail_page.offer_block', compact(
            'offer_schema',
            'selected_offer'));
    }
}
