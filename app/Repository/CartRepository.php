<?php

namespace App\Repository;

use App\Models\Shop\Offer;
use App\Traits\CartId;
use Cart;

class CartRepository
{
    use CartId;

    public function isInCart(Offer $offer): bool
    {
        $this->setCartId();

        $cart_items_id = Cart::getContent()->pluck('id')->toArray();
        if (in_array($offer->id, $cart_items_id)) {
            return true;
        }

        return false;
    }

    public function checkProductsIsInCart(&$products)
    {
        /** @var \App\Models\Shop\Product $product */



        foreach ($products as &$product) {
            $product->firstOffer->setCustomProp(
                'in_cart',
                $this->isInCart($product->firstOffer)
            );
        }
    }

    public function getList()
    {
        $this->setCartId();
        $cart_items = Cart::getContent();
        $cart_items->transform(function ($item) {
            $this->prepareLine($item);
        });
        return Cart::getContent();
    }

    public function getTotal(): string
    {
        $this->setCartId();

        return priceFormat(Cart::getTotal());
    }

    public function getPosition($id)
    {
        $this->setCartId();

        $line = Cart::getContent()->where('id', $id)->first();
        $this->prepareLine($line);
        return $line;

    }

    private function prepareLine(&$item)
    {
        $item->subtotal = priceFormat($item->price * $item->quantity);
        $item->price_format = priceFormat($item->price);
    }
}
