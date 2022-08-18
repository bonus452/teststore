@extends('layouts.admin')

@section('title', 'Create new category')
@section('h1', 'Create new category')

@section('content')

    @php /** @var \App\Models\Shop\Category $selectedCategory */ @endphp

    @include('include.messages.top_error_message')

    <div class="nav-links">
        @if(isset($selectedCategory) && !is_null($selectedCategory))
            <a href="{{ $selectedCategory->getAdminUrl() }}" class="btn btn-primary">Back to list</a>
        @else
            <a href="{{ route('admin.catalog.index') }}" class="btn btn-primary">Back to list</a>
        @endif
        <a href="{{ route('admin.catalog.category.create') }}" class="btn btn-default">Add new category</a>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Create new category</h3>
        </div>
        <!-- /.card-header -->


        <!-- form start -->
        <form action="{{ route('admin.catalog.category.create') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">

                @include('include.form_blocks.input_text', [
                    'name' => 'title',
                    'label' => 'Title',
                    'placeholder' => 'Enter title',
                    'value' => old('title')
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
                        @php /** @var \App\Models\Shop\Category $innerCAtegory */ @endphp
                        @foreach($categoriesTree as $innerCAtegory)
                            <option value="{{ $innerCAtegory->id }}" {{ $innerCAtegory->getCustomProp('selected') }}> {{ $innerCAtegory->title }}</option>
                            @include('include.recursive_options', ['categories' => $innerCAtegory->getCustomProp('sub_categories'), 'level' => 1])
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="img">Image</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="img" name="img">
                            <label class="custom-file-label" for="img">Choose image</label>
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
