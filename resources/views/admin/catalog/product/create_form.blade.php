@extends('layouts.admin')

@section('title', 'Create new product')
@section('h1', 'Create new product')

@section('content')

    @include('include.messages.top_error_message')


    <div class="nav-links">
        <a href="{{ back()->getTargetUrl() }}" class="btn btn-primary">Back to list</a>
    </div>


        <div class="card card-primary card-tabs">

            <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill"
                           href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home"
                           aria-selected="true">General</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill"
                           href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile"
                           aria-selected="false">SEO</a>
                    </li>
                </ul>
            </div>

            <!-- form start -->
            <form action="{{ route('admin.catalog.product.create') }}" method="POST" enctype="multipart/form-data">

                @csrf

                <div class="card-body">
                    <div class="tab-content" id="custom-tabs-one-tabContent">
                        <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel"
                             aria-labelledby="custom-tabs-one-home-tab">
                            <div class="card-body">
                                <div class="row">
                                    <div class="edit-product-box col-md-6">

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
                                                {{ old('active', true) ? 'checked' : '' }}
                                            >
                                            <label for="active" class="custom-control-label">Active</label>
                                        </div>

                                        @include('include.form_blocks.input_text', [
                                            'name' => 'name',
                                            'label' => 'Title',
                                            'placeholder' => 'Enter title',
                                            'value' => old('name')
                                        ])

                                        @include('include.form_blocks.input_text', [
                                            'name' => 'slug',
                                            'label' => 'Slug',
                                            'placeholder' => 'Enter slug',
                                            'value' => old('slug')
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
                                                  placeholder="Description ...">{{ old('description') }}</textarea>

                                    </div>
                                    <div class="col-md-6 card-body offers-block">
                                        <h5>Product offers</h5>

                                        @include('include.form_blocks.offer_card')


                                        <div class="new-offer">
                                            <button type="button" class="btn btn-block btn-dark btn-flat">Add new
                                                offer
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel"
                             aria-labelledby="custom-tabs-one-profile-tab">
                            @include('include.form_blocks.input_text', [
                                                        'name' => 'seo_title',
                                                        'label' => 'Title',
                                                        'placeholder' => 'Enter title',
                                                        'value' => old('seo_title')
                                                    ])

                            @include('include.form_blocks.input_text', [
                                'name' => 'seo_keywords',
                                'label' => 'Keywords',
                                'placeholder' => 'Enter keywords',
                                'value' => old('seo_keywords')
                            ])

                            <label for="description">Description</label>
                            <textarea class="form-control" rows="6" name="seo_description"
                                      placeholder="Description ...">{{ old('seo_description') }}</textarea>

                        </div>
                        <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel"
                             aria-labelledby="custom-tabs-one-profile-tab">
                            @include('include.form_blocks.admin_product_property')
                        </div>
                    </div>
                </div>


                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </form>

            <!-- /.card -->
        </div>

@endsection

@section('custom-scripts')
    @include('scripts.admin.start_state_for_offers')
@endsection
