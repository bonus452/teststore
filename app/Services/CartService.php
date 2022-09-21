<?php

namespace App\Services;

use App\Models\Shop\Offer;
use App\Models\Shop\Product;
use Cart;
use Illuminate\Database\Eloquent\Collection;
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

        $offer = Offer::where('id', $offer_id)->withProperties()->first();
        Cart::add([
            'id' => $offer->id,
            'name' => $offer->product->name,
            'price' => $offer->price,
            'quantity' => (int)$quantity,
            'attributes' => [
                'image' => $offer->product->getFirstImageSrc(),
                'href' => $offer->product->url,
                'properties' => $this->propertiesToArray($offer->properties)
            ]
        ]);
    }

    public function update($id, $quantity): bool
    {
        $this->setCartId();
         return Cart::update($id,['quantity' => [
             'relative' => false,
             'value' => $quantity
         ]]);
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

    public function getList()
    {
        $this->setCartId();
        $cart_items = Cart::getContent();
        $cart_items->transform(function ($item){
            $this->prepareLine($item);
        });
        return Cart::getContent();
    }

    public function remove($item_id)
    {
        $this->setCartId();
        Cart::remove($item_id);
    }

    public function getTotal(){
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

    private function propertiesToArray(Collection $properties)
    {
        $result = [];
        foreach ($properties as $property){
            $result[$property->property_name->id]['name'] = $property->property_name->name;
            $result[$property->property_name->id]['value'] = $property->value;
        }
        return $result;
    }

    private function prepareLine(&$item)
    {
        $item->subtotal = priceFormat($item->price * $item->quantity);
        $item->price_format = priceFormat($item->price);
    }


}
