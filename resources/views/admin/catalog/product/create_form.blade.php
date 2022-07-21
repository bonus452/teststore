@extends('layouts.admin')

@section('title', 'Create new product')
@section('h1', 'Create new product')

@section('content')

    @include('include.messages.top_error_message')

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
                                @php /** @var \App\Models\Shop\Category $innerCAtegory */ @endphp
                                @foreach($categoriesTree as $innerCAtegory)
                                    <option
                                        value="{{ $innerCAtegory->id }}" {{ $innerCAtegory->getCustomProp('selected') }}> {{ $innerCAtegory->title }}</option>
                                    @include('include.recursive_options', ['categories' => $innerCAtegory->getCustomProp('sub_categories'), 'level' => 1])
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
                    </div>
                    <div class="col-md-6 card-body">
                        <h5>Product offers</h5>

                        <div class="offer-block">
                            <div class="offer-main">
                                <div class="article"><span>Article</span>: R6554324</div>
                                <div class="price"><span>Price</span>: 1 543 $</div>
                            </div>
                            <div class="offer-props">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Properties</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body p-0">
                                        <table class="table table-sm">
                                            <tbody>
                                            <tr>
                                                <td class="prop-name">Color</td>
                                                <td>
                                                    <input type="text" class="form-control" name="color" value="red">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Size</td>
                                                <td>
                                                    <input type="text" class="form-control" name="size" value="XXL">
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                            </div>
                        </div>

                        <div class="offer-block">
                            <div class="offer-main">
                                <div class="article"></div>
                                <div class="price"></div>
                            </div>
                            <div class="offer-props">
                                <div class="prop-name"></div>
                                <div class="prop-value"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>

    </div>

@endsection
