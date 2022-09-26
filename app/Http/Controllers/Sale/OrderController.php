<?php

namespace App\Http\Controllers\Sale;

use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function show(){



        return view('shop.order');
    }
}
