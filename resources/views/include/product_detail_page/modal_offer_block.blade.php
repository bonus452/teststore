<div class="price-box-3">
    <div class="s-price-box">
        <span class="new-price">{{ $selected_offer->getPriceFormat() }}</span>
    </div>
</div>

<div class="offers-props">
    @foreach($offer_schema as $property_id => $line)
        <div class="select__size">
            <h2>{{ $line['name'] }}</h2>
            <ul class="color__list" data-property-id="{{ $property_id }}">
                @foreach($line['values'] as $property_value_id => $property_value)
                    <li class="l__size">
                        <a data-value-id="{{ $property_value_id }}" class="active {{ $property_value['selected'] }}"
                           href="#">
                            {{ $property_value['value'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endforeach
</div>

<div class="social-sharing">
    <div class="widget widget_socialsharing_widget">
        <h3 class="widget-title-modal">Share this product</h3>
        <ul class="social-icons">
            <li><a target="_blank" title="rss" href="#" class="rss social-icon"><i class="zmdi zmdi-rss"></i></a></li>
            <li><a target="_blank" title="Linkedin" href="#" class="linkedin social-icon"><i
                        class="zmdi zmdi-linkedin"></i></a></li>
            <li><a target="_blank" title="Pinterest" href="#" class="pinterest social-icon"><i
                        class="zmdi zmdi-pinterest"></i></a></li>
            <li><a target="_blank" title="Tumblr" href="#" class="tumblr social-icon"><i
                        class="zmdi zmdi-tumblr"></i></a></li>
            <li><a target="_blank" title="Pinterest" href="#" class="pinterest social-icon"><i
                        class="zmdi zmdi-pinterest"></i></a></li>
        </ul>
    </div>
</div>
<input type="hidden" name="quantity" value="1">
@if($selected_offer->getCustomProp('in_cart'))
    <div class="addtocart-btn">
        <a class="in-cart" href="#">in cart</a>
    </div>
@else
    <div class="addtocart-btn">
        <a class="buy-btn" href="#" data-id="{{ $selected_offer->id }}">buy now</a>
    </div>
@endif
