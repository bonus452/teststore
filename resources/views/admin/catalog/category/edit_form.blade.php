@extends('layouts.admin')

@php /** @var \App\Models\Shop\Category $category */ @endphp

@section('title', 'Edit ' . $category->title)
@section('h1', 'Edit ' . $category->title)

@section('content')

    @include('include.messages.top_error_message')
    @include('include.messages.status_message')

    <div class="nav-links">
        <a href="{{ !is_null($category->parent) ? $category->parent->getAdminUrl() : route('admin.catalog.index') }}"
           class="btn btn-primary">Back to list</a>
        <a href="{{ route('admin.catalog.category.create') }}" class="btn btn-default">Add new category</a>
        <a href="{{ $category->url }}" class="btn btn-default" target="_blank"><i class="far fa-eye"></i></a>

        @include('popups.confirm', [
            'href' => route('admin.catalog.category.delete', $category),
            'message' => 'Category can has products or subcategories. They are also delete with this category. Delete the category anyway?'
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
            </ul>
        </div>


        <!-- form start -->
        <form action="{{ route('admin.catalog.category.update', $category) }}" method="POST"
              enctype="multipart/form-data">
            @csrf
            @method('patch')
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-one-tabContent">
                    <div class="tab-pane fade show active" id="custom-tabs-one-general" role="tabpanel"
                         aria-labelledby="custom-tabs-one-general-tab">
                        <div class="card-body">

                            @include('include.form_blocks.input_text', [
                                'name' => 'title',
                                'label' => 'Title',
                                'placeholder' => 'Enter title',
                                'value' => old('title', $category->title)
                            ])

                            @include('include.form_blocks.input_text', [
                                'name' => 'slug',
                                'label' => 'Slug',
                                'placeholder' => 'Enter slug',
                                'value' => old('slug', $category->slug)
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
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-one-seo" role="tabpanel"
                         aria-labelledby="custom-tabs-one-seo-tab">
                        @include('include.form_blocks.input_text', [
                            'name' => 'seo_title',
                            'label' => 'Title',
                            'placeholder' => 'Enter title',
                            'value' => old('seo_title', $category->seo_title)
                        ])

                        @include('include.form_blocks.input_text', [
                            'name' => 'seo_keywords',
                            'label' => 'Keywords',
                            'placeholder' => 'Enter keywords',
                            'value' => old('seo_keywords', $category->seo_keywords)
                        ])

                        <label for="description">Description</label>
                        <textarea class="form-control" rows="6" name="seo_description"
                                  placeholder="Description ...">{{ old('seo_description', $category->seo_description) }}</textarea>


                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
@endsection
