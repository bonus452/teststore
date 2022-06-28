@foreach($catalog_menu as $menu_item)
    @if($last_level)
        <li><a href="{{ $menu_item->url }}"> {{ $menu_item->title }}</a></li>
    @else
        <div class="category-part-1 category-common mb--30">
            <h4 class="categories-subtitle"><a class="clear-color" href="{{ $menu_item->url }}">{{ $menu_item->title }}</a></h4>

            @if($menu_item->sub_categories->IsNotEmpty())
                <ul>
                    @include('include.catalog_partial_menu', ['catalog_menu' => $menu_item->sub_categories, 'last_level' => true])
                </ul>
            @endif
        </div>
    @endif

@endforeach
