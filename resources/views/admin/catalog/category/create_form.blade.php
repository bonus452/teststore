@extends('layouts.admin')

@section('title', 'Create new category')
@section('h1', 'Create new category')

@section('content')

    @php /** @var \App\Models\Catalog\Category $parent_category */ @endphp

    @include('include.messages.top_error_message')

    <div class="nav-links">
        @if(isset($parent_category) && !is_null($parent_category))
            <a href="{{ $parent_category->getAdminUrl() }}" class="btn btn-primary">Back to list</a>
        @else
            <a href="{{ route('admin.catalog.index') }}" class="btn btn-primary">Back to list</a>
        @endif
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
        <form action="{{ route('admin.catalog.category.create') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="card-body">
                <div class="tab-content" id="custom-tabs-one-tabContent">
                    <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel"
                         aria-labelledby="custom-tabs-one-home-tab">
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
                                    @php /** @var \App\Models\Catalog\Category $innerCAtegory */ @endphp
                                    @foreach($categoriesTree as $innerCAtegory)
                                        <option
                                            value="{{ $innerCAtegory->id }}" {{ $innerCAtegory->getCustomProp('selected') }}> {{ $innerCAtegory->title }}</option>
                                        @include('include.recursive_options', ['categories' => $innerCAtegory->getCustomProp('sub_categories'), 'level' => 1])
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="image">Image</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="image" name="image">
                                        <label class="custom-file-label" for="image">Choose image</label>
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
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </form>
    </div>
@endsection
