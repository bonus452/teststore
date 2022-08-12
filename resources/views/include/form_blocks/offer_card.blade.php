@php /** @var \App\Models\Shop\Product $product */ @endphp

@if(isset($product) && $product->offers->isNotEmpty())

    @foreach($product->offers as $offer)
        <div class="offer-block">
            <div class="offer-main">
                <div class="article"><span>Article</span>:
                    <div class="text-value" style="display: none;">
                        {{ $offer->article }}
                    </div>
                    <input type="text" class="form-control article" value="{{ $offer->article }}">
                </div>
                <div class="price"><span>Price</span>:
                    <div class="text-value" style="display: none;">
                        {{ $offer->price }}
                    </div>
                    <input type="number" step="0.01" class="form-control price" value="{{ $offer->price }}">$
                </div>

                <input type="hidden" class="offer-id" value="{{ $offer->id }}">

                <button class="btn btn-block btn-danger btn-sm delete-btn">X</button>
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
                            @foreach($offer->properties as $property)
                                @include('include.form_blocks.property_line', [
                                    'property_name' => $property->property_name,
                                    'selected_value' => $property->value
                                ])
                            @endforeach

                            <tr class="tr-btn-add-prop">
                                <td colspan="2">
                                    <button
                                        type="button"
                                        class="btn btn-block btn-secondary btn-sm btn-add-prop"
                                        href="{{ route('admin.catalog.property.get_properties') }}"
                                        data-width="350"
                                        data-height="150"
                                        data-title="Add property to offer">
                                        Add property
                                    </button>
                                </td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    @endforeach
@else
    <div class="offer-block">
        <div class="offer-main">
            <div class="article"><span>Article</span>:
                <div class="text-value" style="display: none;">
                </div>
                <input type="text" class="form-control article" value="">
            </div>
            <div class="price"><span>Price</span>:
                <div class="text-value" style="display: none;">
                </div>
                <input type="number" step="0.01" class="form-control price" value="">$
            </div>

            <button class="btn btn-block btn-danger btn-sm delete-btn">X</button>
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

                        <tr class="tr-btn-add-prop">
                            <td colspan="2">
                                <button
                                    type="button"
                                    class="btn btn-block btn-secondary btn-sm btn-add-prop"
                                    href="{{ route('admin.catalog.property.get_properties') }}"
                                    data-width="350"
                                    data-height="150"
                                    data-title="Add property to offer">
                                    Add property
                                </button>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
@endif



