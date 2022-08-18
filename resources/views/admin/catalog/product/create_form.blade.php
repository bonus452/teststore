@extends('layouts.admin')

@section('title', 'Create new product')
@section('h1', 'Create new product')

@section('content')

    @include('include.messages.top_error_message')


    <div class="nav-links">
        <a href="{{ back()->getTargetUrl() }}" class="btn btn-primary">Back to list</a>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Create new product</h3>
        </div>
        <!-- /.card-header -->


        <!-- form start -->
        <form action="{{ route('admin.catalog.product.create') }}" method="POST" enctype="multipart/form-data">


            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="edit-product-box col-md-6">

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

                        {{--                @include('include.form_blocks.input_text', [--}}
                        {{--                    'name' => 'price',--}}
                        {{--                    'label' => 'Price',--}}
                        {{--                    'placeholder' => 'Enter price',--}}
                        {{--                    'value' => old('price')--}}
                        {{--                ])--}}

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
                        <textarea class="form-control" rows="6" name="description" placeholder="Description ...">{{ old('description') }}</textarea>

                    </div>
                    <div class="col-md-6 card-body offers-block">
                        <h5>Product offers</h5>

                        @include('include.form_blocks.offer_card')


                        <div class="new-offer">
                            <button type="button" class="btn btn-block btn-dark btn-flat">Add new offer</button>
                        </div>

                    </div>
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </form>

    </div>

@endsection

@section('custom-scripts')
    @include('scripts.admin.start_state_for_offers')
@endsection
