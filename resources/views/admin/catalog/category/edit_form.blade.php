@extends('layouts.admin')

@php /** @var \App\Models\Shop\Category $category */ @endphp

@section('title', 'Edit ' . $category->title)
@section('h1', 'Edit ' . $category->title)

@section('content')



    @include('include.messages.top_error_message')

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Create new category</h3>
        </div>
        <!-- /.card-header -->


        <!-- form start -->
        <form action="{{ route('admin.catalog.category.update', $category) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('patch')
            <div class="card-body">

                @include('include.form_blocks.input_text', [
                    'name' => 'title',
                    'label' => 'Title',
                    'placeholder' => 'Enter title',
                    'value' => old('title') ?? $category->title
                ])

                @include('include.form_blocks.input_text', [
                    'name' => 'slug',
                    'label' => 'Slug',
                    'placeholder' => 'Enter slug',
                    'value' => old('slug') ?? $category->slug
                ])

                <div class="form-group">
                    <label for="category_id">Parent category</label>
                    <select class="custom-select" id="category_id" name="category_id">
                        @php /** @var \App\Models\Shop\Category $innerCategory */ @endphp
                        @foreach($categoriesTree as $innerCategory)
                            <option value="{{ $innerCategory->id }}" {{ $innerCategory->getCustomProp('selected') }}> {{ $innerCategory->title }}</option>
                            @include('include.recursive_options', ['categories' => $innerCategory->getCustomProp('sub_categories'), 'level' => 1])
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    @if(!empty($category->img_path_system))
                        <label for="img">Change image</label>
                        <img src="{{ $category->img }}" alt="{{ $category->title }}" class="preview-image">
                        <br>
                    @else
                        <label for="img">Set image</label>
                    @endif

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
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
@endsection
