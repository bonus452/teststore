@extends('layouts.admin')

@php /** @var \App\Models\Shop\Product $product */ @endphp

@section('title', 'Update product "'.$product->name.'"')
@section('h1', 'Update product "'.$product->name.'"')

@section('content')

    @include('include.messages.top_error_message')

    <div class="nav-links">
        <a href="{{ $product->category->getAdminUrl() }}" class="btn btn-primary">Back to list</a>
        <a href="{{ route('admin.catalog.product.create') }}" class="btn btn-default">Add new product</a>
        <a href="{{ $product->url }}" class="btn btn-default" target="_blank"><i class="far fa-eye"></i></a>

        @include('popups.confirm', [
            'href' => route('admin.catalog.product.delete', $product),
            'message' => 'Are you sure you want to delete this product?'
        ])

    </div>

    <div class="card card-primary card-tabs">

        <div class="card-header p-0 pt-1">
            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-one-general-tab" data-toggle="pill"
                       href="#custom-tabs-one-general" role="tab" aria-controls="custom-tabs-one-general"
                       aria-selected="true">General</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-seo-tab" data-toggle="pill"
                       href="#custom-tabs-one-seo" role="tab" aria-controls="custom-tabs-one-seo"
                       aria-selected="false">SEO</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-property-tab" data-toggle="pill"
                       href="#custom-tabs-one-property" role="tab" aria-controls="custom-tabs-one-property"
                       aria-selected="false">Properties</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-images-tab" data-toggle="pill"
                       href="#custom-tabs-one-images" role="tab" aria-controls="custom-tabs-one-images"
                       aria-selected="false">Images</a>
                </li>
            </ul>
        </div>


        <!-- form start -->
        <form action="{{ route('admin.catalog.product.update', compact('product')) }}" method="POST"
              enctype="multipart/form-data">

            @method('patch')
            @csrf
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-one-tabContent">
                    <div class="tab-pane fade show active" id="custom-tabs-one-general" role="tabpanel"
                         aria-labelledby="custom-tabs-one-general-tab">
                        <div class="card-body">
                            <div class="row">
                                <div class="edit-product-box col-md-5">

                                    <div class="custom-control custom-checkbox div-active">
                                        <input class="custom-control-input"
                                               type="hidden"
                                               name="active"
                                               value="0">
                                        <input class="custom-control-input"
                                               type="checkbox"
                                               id="active"
                                               name="active"
                                               value="1"
                                            {{ old('active', $product->active) ? 'checked' : '' }}
                                        >
                                        <label for="active" class="custom-control-label">Active</label>
                                    </div>

                                    @include('include.form_blocks.input_text', [
                                        'name' => 'name',
                                        'label' => 'Title',
                                        'placeholder' => 'Enter title',
                                        'value' => old('name', $product->name)
                                    ])

                                    @include('include.form_blocks.input_text', [
                                        'name' => 'slug',
                                        'label' => 'Slug',
                                        'placeholder' => 'Enter slug',
                                        'value' => old('slug', $product->slug)
                                    ])

                                    <div class="form-group">
                                        <label for="category_id">Parent category</label>
                                        <select class="custom-select" id="category_id" name="category_id">
                                            @php /** @var \App\Models\Shop\Category $innerCategory */ @endphp
                                            @foreach($categoriesTree as $innerCategory)
                                                <option
                                                    value="{{ $innerCategory->id }}" {{ $innerCategory->getCustomProp('selected') }}> {{ $innerCategory->title }}</option>
                                                @include('include.recursive_options', ['categories' => $innerCategory->getCustomProp('sub_categories'), 'level' => 1])
                                            @endforeach
                                        </select>
                                    </div>
                                    {{--                <div class="form-group">--}}
                                    {{--                    <label for="img">Image</label>--}}
                                    {{--                    <div class="input-group">--}}
                                    {{--                        <div class="custom-file">--}}
                                    {{--                            <input type="file" class="custom-file-input" id="img" name="img">--}}
                                    {{--                            <label class="custom-file-label" for="img">Choose image</label>--}}
                                    {{--                        </div>--}}
                                    {{--                    </div>--}}
                                    {{--                </div>--}}
                                    <label for="description">Description</label>
                                    <textarea class="form-control" rows="6" name="description"
                                              placeholder="Description ...">{{ old('description', $product->description) }}</textarea>

                                </div>
                                <div class="col-md-7 card-body offers-block">
                                    <h5>Product offers</h5>

                                    @include('include.form_blocks.offer_card', compact('product'))


                                    <div class="new-offer">
                                        <button type="button" class="btn btn-block btn-dark btn-flat">Add new offer
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-one-seo" role="tabpanel"
                         aria-labelledby="custom-tabs-one-seo-tab">
                        @include('include.form_blocks.input_text', [
                            'name' => 'seo_title',
                            'label' => 'Title',
                            'placeholder' => 'Enter title',
                            'value' => old('seo_title', $product->seo_title)
                        ])

                        @include('include.form_blocks.input_text', [
                            'name' => 'seo_keywords',
                            'label' => 'Keywords',
                            'placeholder' => 'Enter keywords',
                            'value' => old('seo_keywords', $product->seo_keywords)
                        ])

                        <label for="description">Description</label>
                        <textarea class="form-control" rows="6" name="seo_description"
                                  placeholder="Description ...">{{ old('seo_description', $product->seo_description) }}</textarea>



                    </div>
                    <div class="tab-pane fade" id="custom-tabs-one-property" role="tabpanel"
                         aria-labelledby="custom-tabs-one-property-tab">
                        @include('include.form_blocks.admin_product_property')
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-one-images" role="tabpanel"
                         aria-labelledby="custom-tabs-one-images-tab">
                        @include('include.form_blocks.admin_product_images')
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>

    </div>

@endsection

@section('custom-scripts')
    @include('scripts.admin.start_state_for_offers')
@endsection
