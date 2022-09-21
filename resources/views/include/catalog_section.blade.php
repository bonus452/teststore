<div class="row">
    <div class="col-md-12" style="padding: 0px;">
        <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
            @include('include.catalog_filter')
        </div>
        <div class="col-md-9 col-lg-9 col-sm-12 col-xs-12 smt-30">
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                    <div class="producy__view__container">
                        <!-- Start Short Form -->
                        <div class="product__list__option">
                            <div class="order-single-btn">
                                <select class="select-color selectpicker">
                                    <option>Sort by newness</option>
                                    <option>Match</option>
                                    <option>Updated</option>
                                    <option>Title</option>
                                    <option>Category</option>
                                    <option>Rating</option>
                                </select>
                            </div>
                            <div class="shp__pro__show">
                                <span>{{ $products_box->info }}</span>
                            </div>
                        </div>
                        <!-- End Short Form -->
                        <!-- Start List And Grid View -->
                        <ul class="view__mode" role="tablist">
                            <li role="presentation" class="grid-view active"><a href="#grid-view" role="tab"
                                                                                data-toggle="tab"><i
                                        class="zmdi zmdi-grid"></i></a></li>
                            <li role="presentation" class="list-view"><a href="#list-view" role="tab"
                                                                         data-toggle="tab"><i
                                        class="zmdi zmdi-view-list"></i></a></li>
                        </ul>
                        <!-- End List And Grid View -->
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="shop__grid__view__wrap another-product-style">
                    <!-- Start Single View -->
                    <div role="tabpanel" id="grid-view"
                         class="single-grid-view tab-pane fade in active clearfix">
                        <!-- Start Single Product -->
                        @if($products_box->products->isNotEmpty())
                            @php /** @var \App\Models\Shop\Product $product */ @endphp
                            @foreach($products_box->products as $product)
                                <div class="col-md-4 col-lg-4 col-sm-4 col-xs-12">
                                    <div class="product">
                                        <div class="product__inner">
                                            <div class="pro__thumb">
                                                <a href="{{ $product->url }}">
                                                    <img src="{{ $product->getFirstImageSrc() }}"
                                                         alt="product images">
                                                </a>
                                            </div>
                                            <div class="product__hover__info">
                                                <ul class="product__action">
                                                    <li>
                                                        <a data-toggle="modal"
                                                           data-target="#productModal"
                                                           title="Quick View"
                                                           class="quick-view modal-view detail-link"
                                                           href="#">
                                                            <span class="ti-search"></span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="product__details">
                                            <h2><a href="{{ $product->url }}">{{ $product->name }}</a></h2>
                                            <ul class="product__price">
                                                <li class="new__price">
                                                    {{ !is_null($product->offers->first()) ? $product->offers->first()->getPriceFormat() : '' }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            {{ $products_box->products->onEachSide(1)->links('vendor.pagination.bootstrap-4') }}
                        @endif


                    </div>
                    <!-- End Single View -->
                    <!-- Start Single View -->
                    <div role="tabpanel" id="list-view" class="single-grid-view tab-pane fade clearfix">

                        @if($products_box->products->isNotEmpty())
                            @foreach($products_box->products as $product)

                                <!-- Start List Content-->
                                <div class="single__list__content clearfix">
                                    <div class="col-md-3 col-lg-3 col-sm-4 col-xs-12">
                                        <div class="list__thumb">
                                            <a href="{{ $product->url }}">
                                                <img src="{{ $product->getFirstImageSrc() }}"
                                                     alt="list images">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-9 col-lg-9 col-sm-8 col-xs-12">
                                        <div class="list__details__inner">
                                            <h2><a href="product-details.html">{{ $product->name }}</a></h2>
                                            <p>{{ $product->description }}</p>
                                            <span
                                                class="product__price">{{ !is_null($product->offers->first()) ? $product->offers->first()->getPriceFormat() : '' }}</span>
                                            <div class="shop__btn">
                                                <a class="htc__btn" href="cart.html"><span
                                                        class="ti-shopping-cart"></span>Add to Cart</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End List Content-->
                            @endforeach
                        @endif
                    </div>
                    <!-- End Single View -->
                </div>
            </div>
        </div>

        <div class="loading-mask" style="display: none;">
            <div class="ajax-loading"></div>
        </div>
    </div>
</div>

@include('scripts.public.catalog_section_scripts')
