@extends('layouts.app')

@php /** @var \App\Models\Shop\Product $product */ @endphp

@section('title', $product->seo_title ?: $product->name)
@section('description', $product->seo_description ?: $product->description)

@if($product->seo_keywords)
    @section('keywords', $product->seo_keywords)
@endif

@section('h1', $product->name)

@section('content')

    <!-- Start Product Details -->
    <section class="htc__product__details pt--100 pb--100 bg__white product-information" data-product-id="{{ $product->id }}">
        <div class="container">
            <div class="scroll-active">
                <div class="row">
                    <div class="col-md-7 col-lg-7 col-sm-5 col-xs-12">
                        @if($product->images->isNotEmpty())
                            <div class="product__details__container product-details-5">

                                <div id="mainCarousel" class="carousel w-10/12 max-w-5xl mx-auto">
                                    @foreach($product->images as $image)
                                        <div
                                            class="carousel__slide"
                                            data-src="{{ $image->src }}"
                                            data-fancybox="gallery">
                                            <img src="{{ $image->src }}"/>
                                        </div>
                                    @endforeach

                                </div>

                                <div id="thumbCarousel" class="carousel max-w-xl mx-auto">
                                    @foreach($product->images as $image)
                                        <div class="carousel__slide">
                                            <img class="panzoom__content" src="{{ $image->src }}"/>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            @include('scripts.public.galery_slider_scripts')
                        @endif
                    </div>
                    <div class="sidebar-active col-md-5 col-lg-5 col-sm-7 col-xs-12 xmt-30">
                        <div class="htc__product__details__inner">
                            <div class="pro__detl__title">
                                <h2>{{ $product->name }}</h2>
                            </div>

                            <div class="ajax-offer-block">
                                <script>
                                    $.ajax({
                                            url: '{{ route('catalog.offers', $product->id) }}',
                                            method: 'GET',
                                            success: function (result) {
                                                $('.ajax-offer-block').html(result);
                                            }
                                        });
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Product Details -->
    <!-- Start Product tab -->
    <section class="htc__product__details__tab bg__white pb--120">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                    <ul class="product__deatils__tab mb--60" role="tablist">
                        @if(!empty($product->description))
                            <li role="presentation" class="active">
                                <a href="#description" role="tab" data-toggle="tab">Description</a>
                            </li>
                        @endif

                        @if($product->properties->isNotEmpty())
                            <li role="presentation">
                                <a href="#sheet" role="tab" data-toggle="tab">Characteristics</a>
                            </li>
                        @endif
                        {{--                        <li role="presentation">--}}
                        {{--                            <a href="#reviews" role="tab" data-toggle="tab">Reviews</a>--}}
                        {{--                        </li>--}}
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="product__details__tab__content">
                        <!-- Start Single Content -->
                        @if(!empty($product->description))
                            <div role="tabpanel" id="description" class="product__tab__content fade in active">
                                <div class="product__description__wrap">
                                    <div class="product__desc">
                                        <h2 class="title__6">Details</h2>

                                        <p>{{ $product->description }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <!-- End Single Content -->
                        <!-- Start Single Content -->
                        @if($product->properties->isNotEmpty())
                            <div role="tabpanel" id="sheet" class="product__tab__content fade">
                                <div class="pro__feature">
                                    <h2 class="title__6">Characteristics</h2>
                                    <ul class="feature__list">
                                        @foreach($product->properties as $property)
                                            <li><strong>{{ $property->property_name->name }}
                                                    :</strong> {{ $property->value }}</li>

                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- End Product tab -->
@endsection
