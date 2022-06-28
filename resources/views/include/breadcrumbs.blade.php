@php /** @var Illuminate\Support\Collection $breadcrumbs */ @endphp

@if($breadcrumbs->count() > 1)
    <nav class="bradcaump-inner">
        @foreach($breadcrumbs as $item)
            @if($item != $breadcrumbs->last())
                <a class="breadcrumb-item"
                   href="{{ $item->url }}">{{ $item->title }}</a>
                <span class="brd-separetor">/</span>
            @else
                <span class="breadcrumb-item active">{{ $item->title }}</span>
            @endif
        @endforeach
    </nav>
@endif
