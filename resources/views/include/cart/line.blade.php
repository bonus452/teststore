<td class="product-thumbnail">
    <a href="{{ $item->attributes->href }}">
        <img src="{{ $item->attributes->image }}" alt="product img">
    </a>
</td>
<td class="product-name">

    <a href="{{ $item->attributes->href }}">{{ $item->name }}</a>

    @if(!empty($item->attributes['properties']))
        <br>
        <br>
        <ul>
            @foreach($item->attributes['properties'] as $property)
                <li>
                    <b>{{ $property['name'] }}</b>: <span>{{ $property['value'] }}</span>
                </li>
            @endforeach
        </ul>
    @endif
</td>
<td class="product-price">
    <span class="amount">{{ $item->price_format }}</span>
</td>
<td class="product-quantity">
    <input data-id="{{ $item->id }}" type="number" min="1" value="{{ $item->quantity }}">
</td>
<td class="product-subtotal">{{ $item->subtotal }}</td>
<td class="product-remove">
    <a class="remove-from-cart" data-id="{{ $item->id }}" href="#">X</a>
</td>
