<div class="product-props">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Properties</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body p-0">
            <table class="table table-sm">
                <tbody>
                @isset($product)
                    @foreach($product->properties as $property)
                        @include('include.form_blocks.property_line', [
                            'property_name' => $property->property_name,
                            'selected_value' => $property->value
                        ])
                    @endforeach
                @endisset

                <tr class="tr-btn-add-prop">
                    <td colspan="2">
                        <button
                            type="button"
                            class="btn btn-block btn-secondary btn-sm btn-add-prop"
                            href="{{ route('admin.catalog.property.get_properties') }}"
                            data-context="product-props"
                            data-title="Add property to product">
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
