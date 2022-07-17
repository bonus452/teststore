@extends('layouts.app')

@php /** @var \App\Models\Shop\Category $category */ @endphp

@section('title', $category->title)
@section('h1', $category->title)


@section('content')
    <!-- Start Our ShopSide Area -->
    <section class="htc__shop__sidebar bg__white ptb--120">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
                    <div class="htc__shop__left__sidebar">
                        <!-- Start Range -->
                        <div class="htc-grid-range">
                            <h4 class="section-title-4">FILTER BY PRICE</h4>
                            <div class="content-shopby">
                                <div class="price_filter s-filter clear">
                                    <form action="#" method="GET">
                                        <div id="slider-range"></div>
                                        <div class="slider__range--output">
                                            <div class="price__output--wrap">
                                                <div class="price--output">
                                                    <span>Price :</span><input type="text" id="amount" readonly>
                                                </div>
                                                <div class="price--filter">
                                                    <a href="#">Filter</a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- End Range -->
                        @include('include.sub_categories')
                        <!-- Start Color Cat -->
                        <div class="htc__shop__cat">
                            <h4 class="section-title-4">CHOOSE COLOUR</h4>
                            <ul class="sidebar__list">
                                <li class="black"><a href="#"><i class="zmdi zmdi-circle"></i>Black<span>3</span></a>
                                </li>
                                <li class="blue"><a href="#"><i class="zmdi zmdi-circle"></i>Blue <span>4</span></a>
                                </li>
                                <li class="brown"><a href="#"><i class="zmdi zmdi-circle"></i>Brown <span>3</span></a>
                                </li>
                                <li class="red"><a href="#"><i class="zmdi zmdi-circle"></i>Red <span>6</span></a></li>
                                <li class="orange"><a href="#"><i class="zmdi zmdi-circle"></i>Orange
                                        <span>10</span></a></li>
                            </ul>
                        </div>
                        <!-- End Color Cat -->
                        <!-- Start Size Cat -->
                        <div class="htc__shop__cat">
                            <h4 class="section-title-4">PRODUCT CATEGORIES</h4>
                            <ul class="sidebar__list">
                                <li><a href="#">xl <span>3</span></a></li>
                                <li><a href="#">l <span>4</span></a></li>
                                <li><a href="#">lm <span>3</span></a></li>
                                <li><a href="#">ml <span>6</span></a></li>
                                <li><a href="#">m <span>10</span></a></li>
                                <li><a href="#">ml <span>3</span></a></li>
                            </ul>
                        </div>
                        <!-- End Size Cat -->
                        <!-- Start Tag Area -->
                        <div class="htc__shop__cat">
                            <h4 class="section-title-4">Tags</h4>
                            <ul class="htc__tags">
                                <li><a href="#">All</a></li>
                                <li><a href="#">Clothing</a></li>
                                <li><a href="#">Kids</a></li>
                                <li><a href="#">Accessories</a></li>
                                <li><a href="#">Stationery</a></li>
                                <li><a href="#">Homelife</a></li>
                                <li><a href="#">Appliances</a></li>
                                <li><a href="#">Clothing</a></li>
                                <li><a href="#">Baby</a></li>
                                <li><a href="#">Beauty</a></li>
                            </ul>
                        </div>
                        <!-- End Tag Area -->
                    </div>
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
                                                            <img src="/storage/images/system/product/1.png"
                                                                 alt="product images">
                                                        </a>
                                                    </div>
                                                    <div class="product__hover__info">
                                                        <ul class="product__action">
                                                            <li><a data-toggle="modal" data-target="#productModal"
                                                                   title="Quick View"
                                                                   class="quick-view modal-view detail-link"
                                                                   href="#"><span
                                                                        class="ti-plus"></span></a></li>
                                                            <li><a title="Add To Cart" href="cart.html"><span
                                                                        class="ti-shopping-cart"></span></a></li>
                                                            <li><a title="Wishlist" href="wishlist.html"><span
                                                                        class="ti-heart"></span></a></li>
                                                        </ul>
                                                    </div>
                                                </div>

                                                <div class="product__details">
                                                    <h2><a href="{{ $product->url }}">{{ $product->name }}</a></h2>
                                                    <ul class="product__price">
                                                        <li class="old__price">$16.00</li>
                                                        <li class="new__price">${{ !is_null($product->offers->first()) ? $product->offers->first()->price : '' }}</li>
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
                                                        <img src="/storage/images/system/product/1.png"
                                                             alt="list images">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-md-9 col-lg-9 col-sm-8 col-xs-12">
                                                <div class="list__details__inner">
                                                    <h2><a href="product-details.html">{{ $product->name }}</a></h2>
                                                    <p>{{ $product->description }}</p>
                                                    <span
                                                        class="product__price">${{ !is_null($product->offers->first()) ? $product->offers->first()->price : '' }}</span>
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
            </div>
        </div>
    </section>
    <!-- End Our ShopSide Area -->
@endsection
