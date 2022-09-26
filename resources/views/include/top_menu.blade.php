<div class="col-md-8 col-lg-8 col-sm-6 col-xs-6">
    <nav class="mainmenu__nav hidden-xs hidden-sm">
        <ul class="main__menu">
            <li class="drop"><a href="/">Home</a></li>
            <li class="drop"><a href="/{{ CATALOG_PATH }}">Catalog</a>
                <ul class="dropdown mega_dropdown">
                    <!-- Start Single Mega MEnu -->
                    @php /** @var \App\Models\Catalog\Category $item_menu */ @endphp
                    @php /** @var \Illuminate\Support\Collection $catalog_menu */ @endphp
                    @foreach($catalog_menu->split(2) as $group_item_menu)
                        <li>
                            <ul class="mega__item">
                                @foreach($group_item_menu as $item_menu)
                                    <li><a href="{{ $item_menu->url }}">{{ $item_menu->title }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                    <li>
                        <ul class="mega__item">
                            <li>
                                <div class="mega-item-img">
                                    <a href="/">
                                        <img src="/storage/images/system/feature-img/3.png" alt="">
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li><a href="about.html">about</a></li>
            <li><a href="contact.html">contact</a></li>
        </ul>
    </nav>
    <div class="mobile-menu clearfix visible-xs visible-sm">
        <nav id="mobile_dropdown">
            <ul>
                <li><a href="/">Home</a></li>
                <li><a href="/catalog">Catalog</a>
                    <ul>
                        @php /** @var \App\Models\Catalog\Category $item_menu */ @endphp
                        @php /** @var \Illuminate\Support\Collection $catalog_menu */ @endphp
                        @foreach($catalog_menu as $item_menu)
                            <li><a href="{{ $item_menu->url }}">{{ $item_menu->title }}</a></li>
                        @endforeach
                    </ul>
                </li>
                <li><a href="contact.html">contact</a></li>
            </ul>
        </nav>
    </div>
</div>
