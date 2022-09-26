@extends('layouts.admin')

@section('title', 'Catalog')
@section('h1', 'Catalog')

@section('content')

    @php /** @var \App\Models\Catalog\Category $item */ @endphp
    @php /** @var Illuminate\Contracts\Pagination\LengthAwarePaginator $items */ @endphp

    <div class="row">
        <div class="col-12">

            @include('include.messages.status_message')

            <div class="card">
                <div class="card-header">

                    <a href="{{ route('admin.catalog.product.create_form') }}" class="btn btn-primary">Create
                        product</a>
                    <a href="{{ route('admin.catalog.category.create_form') }}" class="btn btn-default">Create
                        category</a>

                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="table_search" class="form-control float-right"
                                   placeholder="Search">

                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                        <tr>

                            <th>ID</th>
                            <th></th>
                            <th>Title</th>
                            <th>Slug</th>
                            <th>Image</th>
                            <th>Count products</th>
                            <th>Date create</th>
                            <th>Date update</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($items as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>
                                    @if($item->type == 'category')
                                        <a href="{{ $item->getEditUrl() }}">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                    @elseif($item->type == 'product')
                                        <a href="{{ $item->url }}" target="_blank">
                                            <i class="far fa-eye"></i>
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ $item->getAdminUrl() }}">
                                        @if($item->type == 'category')
                                            <i class="fas fa-folder"></i>
                                        @elseif($item->type == 'product')
                                            <i class="far fa-file"></i>
                                        @endif
                                        {{ $item->title }}</a>&nbsp
                                </td>
                                <td> {{ $item->slug }}</td>
                                <td></td>
                                <td></td>
                                <td>{{ $item->created_at }}</td>
                                <td>{{ $item->updated_at }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <br>
                    {{ $items->onEachSide(1)->links('vendor.pagination.bootstrap-4') }}

                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>

@endsection
