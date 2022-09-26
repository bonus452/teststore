@extends('layouts.admin')

@section('title', 'Payments')
@section('h1', 'Payments')

@section('content')

    <div class="row">
        <div class="col-12">

            @include('include.messages.status_message')

            <div class="card">
                <div class="card-header">

                    <a href="{{ route('admin.sale.payment.create_form') }}" class="btn btn-primary">Create
                        payment</a>

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

                            <th style="width: 30px;">ID</th>
                            <th style="width: 10px;"></th>
                            <th style="width: 70%;">Name</th>
                            <th>Date create</th>
                            <th>Date update</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($items as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>
                                    <a href="{{ route('admin.sale.payment.update_form', ['payment' => $item->id]) }}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                                <td>{{ $item->name }}</td>
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
