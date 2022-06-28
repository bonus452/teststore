@php /** @var Illuminate\Support\Collection $breadcrumbs */ @endphp

<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        @foreach($breadcrumbs as $breadcrumb)
            <li class="breadcrumb-item @if($breadcrumb != $breadcrumbs->last()) active @endif">
                @if($breadcrumb != $breadcrumbs->last()) <a href="{{ $breadcrumb->url }}"> @endif
                    {{ $breadcrumb->title }}
                    @if($breadcrumb != $breadcrumbs->last()) </a> @endif
            </li>
        @endforeach
    </ol>
</div>
