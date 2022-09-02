
@php /** @var \App\Models\Shop\PropertyName $property */ @endphp

<tr class="prop-tr">
    <td class="prop-name">{{ $property->name }}</td>
    <td>
        <input type="text"
               list="list-values"
               autocomplete="off"
               data-prop-id="{{ $property->id }}"
               @isset($selected_value) value="{{ $selected_value }}" @endisset
               class="form-control"
               placeholder="Select value">

        <div list="list-values" class="list-values">
            @foreach($property->propertyValues as $propertyValue)
                <span>{{ $propertyValue->value }}</span>
            @endforeach
        </div>

        <button class="btn btn-block btn-danger btn-sm delete-btn-prop">X</button>
    </td>
</tr>
