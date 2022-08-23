@php /** @var \App\Models\Shop\PropertyName $property */ @endphp

<div class="property-popup-block">

    <div class="error-box">

    </div>

    <input type="text"
           list="list-properties"
           class="form-control"
           autocomplete="off"
           id="property_name"
           placeholder="Select property or add new">

    <div list="list-properties">
        @foreach($properties as $property)
            <span>{{ $property->name }}</span>
        @endforeach
    </div>

    <button type="submit" class="btn btn-primary btn-add-prop-popup">Add</button>

</div>
