@extends('layouts.admin')

@php /** @var \App\Models\Sale\Payment $payment */ @endphp

@section('title', "Update payment {$payment->name}")
@section('h1', "Update payment {$payment->name}")

@section('content')

    @include('include.messages.top_error_message')

    <div class="nav-links">
        <a href="{{ route('admin.sale.payment.list') }}" class="btn btn-primary">Back to list</a>
        <a href="{{ route('admin.sale.payment.create_form') }}" class="btn btn-primary">Create new payment</a>

        @include('popups.confirm_delete', [
            'href' => route('admin.sale.payment.delete', $payment),
            'message' => 'Do you really want to delete this payment system?'
        ])
    </div>

    <div class="card card-primary card-tabs">

        <div class="card-header p-0 pt-1">
            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill"
                       href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home"
                       aria-selected="true">General</a>
                </li>
            </ul>
        </div>


        <!-- form start -->
        <form action="{{ route('admin.sale.payment.update', $payment) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('patch')

            <div class="card-body">
                <div class="tab-content" id="custom-tabs-one-tabContent" style="max-width: 500px">
                    <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel"
                         aria-labelledby="custom-tabs-one-home-tab">
                        <div class="card-body">

                            @include('include.form_blocks.input_text', [
                                'name' => 'name',
                                'label' => 'Name',
                                'placeholder' => 'Enter name',
                                'value' => old('name', $payment->name)
                            ])

                            @if(!empty($payment->getImageSystemPath()))
                                <label for="image">Change image</label>
                                <img src="{{ $payment->image }}" alt="{{ $payment->name }}" class="preview-image">
                                <br>
                            @else
                                <label for="image">Set image</label>
                            @endif

                            <div class="form-group">
                                <label for="img">Image</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="image" name="image">
                                        <label class="custom-file-label" for="image">Choose image</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
@endsection
