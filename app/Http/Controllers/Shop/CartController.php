<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\PutCartRequest;
use App\Services\CartService;
use Cart;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{

    private CartService $cartService;

    public function __construct()
    {
        $this->cartService = new CartService();
    }

    public function put(PutCartRequest $request)
    {
        $session_id = Session::getId();

        $data = $request->validated();
        $this->cartService->put($data['id'], $data['quantity']);

        $cart = Cart::getContent();

        return response()->json(['status' => 'ok']);
    }
}
