@extends('layouts.app')

@php /** @var \App\Models\Catalog\Category $category */ @endphp

@section('title', $category->seo_title ?: $category->title)

@isset($category->seo_description)
    @section('description', $category->seo_description)
@endif

@isset($category->seo_keywords)
    @section('keywords', $category->seo_keywords)
@endif

@section('h1', $category->title)


@section('content')
    <!-- Start Our ShopSide Area -->
    <section class="htc__shop__sidebar bg__white ptb--120">
        <div class="container" id="catalog-section">
            @include('include.catalog_section')
        </div>
    </section>
    <!-- End Our ShopSide Area -->

    <div id="quickview-wrapper">
        <!-- Modal -->
        <div class="modal fade" id="productModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal__container" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="loader-gif">
                            <img style="margin: 70px;" src="{{ LOADER_GIF }}" alt="">
                        </div>
                    </div><!-- .modal-body -->
                </div><!-- .modal-content -->
            </div><!-- .modal-dialog -->
        </div>
        <!-- END Modal -->
    </div>

@endsection
