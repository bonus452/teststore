@php /** @var \App\Models\Shop\Offer $selected_offer */ @endphp
@php /** @var \App\Models\Shop\Product $product */ @endphp

<div class="offer-block">

    <div class="pro__dtl__rating">
        <ul class="pro__rating">
            <li><span class="ti-star"></span></li>
            <li><span class="ti-star"></span></li>
            <li><span class="ti-star"></span></li>
            <li><span class="ti-star"></span></li>
            <li><span class="ti-star"></span></li>
        </ul>
        <span class="rat__qun">(Based on 0 Ratings)</span>
    </div>
    <ul class="pro__dtl__prize">
        <li>{{ $selected_offer->getPriceFormat() }}</li>
    </ul>

    <div class="offers-props">
        @foreach($offer_schema as $property_id => $line)
            <div class="pro__dtl__size">
                <h2 class="title__5">{{ $line['name'] }}</h2>
                <ul class="pro__choose__size" data-property-id="{{ $property_id }}">
                    @foreach($line['values'] as $property_value_id => $property_value)
                        <li><a href="#"
                               data-value-id="{{ $property_value_id }}"
                               class="active {{ $property_value['selected'] }}"
                            >{{ $property_value['value'] }}</a></li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>


    @if(!$selected_offer->getCustomProp('in_cart'))
        <div class="product-action-wrap">
            <div class="prodict-statas"><span>Quantity :</span></div>
            <div class="product-quantity">
                <form id='myform' method='POST' action='#'>
                    <div class="product-quantity">
                        <div class="cart-plus-minus">
                            <input class="cart-plus-minus-box" type="number" name="quantity"
                                   value="1">
                            <div class="dec qtybutton">-</div>
                            <div class="inc qtybutton">+</div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <ul class="pro__dtl__btn">
        @if($selected_offer->getCustomProp('in_cart'))
            <li class="buy__now__btn"><a class="in-cart" href="{{ route('sale.cart.list') }}">in cart</a></li>
        @else
            <li class="buy__now__btn"><a href="#" class="buy-btn" data-id="{{ $selected_offer->id }}">buy now</a></li>
        @endif
    </ul>
    <div class="pro__social__share">
        <h2>Share :</h2>
        <ul class="pro__soaial__link">
            <li><a href="#"><i class="zmdi zmdi-twitter"></i></a></li>
            <li><a href="#"><i class="zmdi zmdi-instagram"></i></a></li>
            <li><a href="#"><i class="zmdi zmdi-facebook"></i></a></li>
            <li><a href="#"><i class="zmdi zmdi-google-plus"></i></a></li>
        </ul>
    </div>

</div>


