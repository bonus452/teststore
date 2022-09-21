<?php

namespace App\Traits;

use Cart;

trait CartId
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
}
