@extends('layouts.app')

@php /** @var \App\Models\Shop\Category $category */ @endphp

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
@endsection
