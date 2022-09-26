<?php

namespace App\Http\Controllers\Catalog;

use App\Http\Controllers\Controller;
use App\Repository\CartRepository;
use App\Repository\OfferRepository;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    private OfferRepository $offerRepository;
    private CartRepository $cartRepository;

    public function __construct()
    {
        $this->offerRepository = new OfferRepository();
        $this->cartRepository = new CartRepository();
    }

    public function getOffersBlock(Request $request, int $product_id){
        $selected_properties = (array)$request->input('offer_properties');
        $offers = $this->offerRepository->getProductOffers($product_id);
        $offer_schema = $this->offerRepository->getOfferBlockCondition($offers, $selected_properties);
        $selected_offer = $this->offerRepository->getSelectedOffer($offers, $offer_schema);
        $selected_offer->setCustomProp(
            'in_cart',
            $this->cartRepository->isInCart($selected_offer)
        );

        if ($request->input('modal'))
            $view = 'include.product_detail_page.modal_offer_block';
        else
            $view = 'include.product_detail_page.offer_block';

        return view($view, compact(
            'offer_schema',
            'selected_offer'));
    }
}
