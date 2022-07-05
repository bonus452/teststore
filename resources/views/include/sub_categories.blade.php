@if($inner_categories->isNotEmpty())
    <div class="htc__shop__cat">
        <h4 class="section-title-4">PRODUCT CATEGORIES</h4>
        <ul class="sidebar__list">
            @php /** @var \App\Models\Shop\Category $category */ @endphp
            @foreach($inner_categories as $category)
                <li><a href="{{ $category->url }}">{{ $category->title }} <span>{{ $category->getCountProducts() }}</span></a></li>
            @endforeach
        </ul>
    </div>
@endif
