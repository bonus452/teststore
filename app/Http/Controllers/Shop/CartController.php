<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\PutCartRequest;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{

    private CartService $cartService;

    public function __construct()
    {
        $this->cartService = new CartService();
    }

    public function put(PutCartRequest $request)
    {
        $data = $request->validated();
        $this->cartService->put($data['id'], $data['quantity']);
        return response()->json(['status' => 'ok']);
    }

    public function update(PutCartRequest $request)
    {
        $data = $request->validated();
        $this->cartService->update($data['id'], $data['quantity']);

        $item = $this->cartService->getPosition($data['id']);
        $total = $this->cartService->getTotal();

        return response()
            ->json([
                'status' => 'ok',
                'total' => $total,
                'line' => view('include.cart.line', compact('item'))->render()
            ]);
    }

    public function delete(Request $request){
        $item_id = $request->input('id');
        $this->cartService->remove($item_id);
        $total = $this->cartService->getTotal();

        return response()->json(['status' => 'ok', 'total' => $total]);
    }

    public function list(Request $request){

        $items = $this->cartService->getList();
        $total = $this->cartService->getTotal();
        if ($request->ajax()){
            return view('shop.top_cart', compact('items', 'total'));
        }else{
            return view('shop.cart', compact('items', 'total'));
        }
    }

}
