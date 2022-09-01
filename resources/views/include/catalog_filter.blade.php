<form action="{{ $category->url }}" class="htc__shop__left__sidebar" id="product_filter">


    @isset($filter['price'])

        <!-- Start Range -->
        <div class="htc-grid-range">
            <h4 class="section-title-4">FILTER BY PRICE</h4>
            <div class="content-shopby">
                <div class="price_filter s-filter clear">
                    <div id="slider-range"></div>
                    <div class="slider__range--output">
                        <div class="price__output--wrap">
                            <div class="price--output">
                                <span>Price :</span><span data-max-price="{{ $filter['price']['max'] }}"
                                                          data-min-price="{{ $filter['price']['min'] }}" type="text"
                                                          id="amount" readonly></span>
                                <input type="hidden" id="price_min" name="price[min]"
                                       value="{{ $filter['setted_price']['min'] }}">
                                <input type="hidden" id="price_max" name="price[max]"
                                       value="{{ $filter['setted_price']['max'] }}">
                            </div>
                            <div class="price--filter">
                                <a id="send-filter" href="#">Filter</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Range -->

    @endisset

    @include('include.sub_categories')

    @isset($filter['properties'])

        @foreach($filter['properties'] as $property_name_id => $property)
            <div class="htc__shop__cat">
                <h4 class="section-title-4">{{ $property['name'] }}</h4>
                <ul class="sidebar__list">
                    @foreach($property['values'] as $property_id => $value)
                        <li>
                            <input type="checkbox"
                                   name="properties[{{ $property_name_id }}][{{ $property_id }}]"
                                   value="{{ $property_id }}"
                                   id="{{ $property_id }}"
                                   {{ $value['checked'] }}
                                   @if($value['count'] <= 0) disabled @endif>
                            <label for="{{ $property_id }}">
                                {{ $value['value'] }} @if(!$value['checked']) <span>{{ $value['count'] }}</span> @endisset
                            </label>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach

    @endisset






</form>
