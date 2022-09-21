@extends('layouts.app')

@section('title', 'Cart')
@section('h1', 'Cart')

@php /** @var \Darryldecode\Cart\CartCollection $items */ @endphp

@section('content')

    <div class="cart-main-area ptb--120 bg__white">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    @if($items->isNotEmpty())
                        <form action="#">
                            <div class="table-content table-responsive">
                                <table>
                                    <thead>
                                    <tr>
                                        <th class="product-thumbnail">Image</th>
                                        <th class="product-name">Product</th>
                                        <th class="product-price">Price</th>
                                        <th class="product-quantity">Quantity</th>
                                        <th class="product-subtotal">Total</th>
                                        <th class="product-remove">Remove</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($items as $item)
                                        <tr class="cart-line">
                                            @include('include.cart.line')
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-md-8 col-sm-7 col-xs-12">
                                    <div class="buttons-cart">
                                        <a href="{{ route('catalog.index') }}">Continue Shopping</a>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-5 col-xs-12">
                                    <div class="cart_totals">
                                        <table>
                                            <tbody>
                                            <tr class="order-total">
                                                <th>Total</th>
                                                <td>
                                                    <strong><span class="amount ajax-total-price">{{ $total }}</span></strong>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <div class="wc-proceed-to-checkout">
                                            <br>
                                            <a href="checkout.html">Proceed to Checkout</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @else
                        <h2 class="h2-message">Your cart is empty. You can see <a href="{{ route('catalog.index') }}">catalog</a>
                            assortment and chose some products.</h2>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection
