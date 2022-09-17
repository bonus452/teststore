<?php

namespace App\Services;

use App\Models\Shop\Offer;
use App\Models\Shop\Product;
use Cart;
use Illuminate\Support\Facades\Session;

class CartService
{
    private $cart_id;

    private function setCartId()
    {
        if ($this->cart_id)
            return;

        if ($user = auth()->user()) {
            $cart_id = $user->id;
        } else {
            $cart_id = session()->getId();
        }
        Cart::session($cart_id);
    }

    public function put($offer_id, $quantity)
    {
        $this->setCartId();

        $offer = Offer::find($offer_id);
        Cart::add([
            'id' => $offer->id,
            'name' => $offer->product->name,
            'price' => $offer->price,
            'quantity' => (int)$quantity,
        ]);
    }

    public function isInCart(Offer $offer): bool
    {
        $this->setCartId();

        $cart_items_id = Cart::getContent()->pluck('id')->toArray();
        if (in_array($offer->id, $cart_items_id)) {
            return true;
        }

        return false;
    }


}
