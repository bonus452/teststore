<div class="shopping__cart__inner">
    <div class="offsetmenu__close__btn">
        <a href="#"><i class="zmdi zmdi-close"></i></a>
    </div>
    <div class="shp__cart__wrap">

        @foreach($items as $item)
            <div class="shp__single__product cart-line">
                <div class="shp__pro__thumb">
                    <a href="{{ $item->attributes->href }}">
                        <img src="{{ $item->attributes->image }}" alt="product images">
                    </a>
                </div>
                <div class="shp__pro__details">
                    <h2><a href="{{ $item->attributes->href }}">{{ $item->name }}</a></h2>
                    <span class="quantity">QTY: {{ $item->quantity }}</span>
                    <span class="shp__price">{{ $item->price_format }}</span>
                </div>
                <div class="remove__btn">
                    <a href="#" class="remove-from-cart" title="Remove this item" data-id="{{ $item->id }}"><i class="zmdi zmdi-close"></i></a>
                </div>
            </div>
        @endforeach

    </div>
    <ul class="shoping__total">
        <li class="subtotal">Subtotal:</li>
        <li class="total__price ajax-total-price">{{ $total }}</li>
    </ul>
    <ul class="shopping__btn">
        <li><a href="{{ route('sale.cart.list') }}">View Cart</a></li>
        <li class="shp__checkout"><a href="checkout.html">Checkout</a></li>
    </ul>
</div>
