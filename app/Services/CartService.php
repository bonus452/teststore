<?php

namespace App\Services;

use App\Models\Catalog\Offer;
use App\Traits\CartId;
use Cart;
use Illuminate\Database\Eloquent\Collection;

class CartService
{
    use CartId;

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

    public function remove($item_id)
    {
        $this->setCartId();
        Cart::remove($item_id);
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




}
