@php /** @var \App\Models\Catalog\Product $product */ @endphp

<div class="modal-product product-information" data-product-id="{{ $product->id }}">
    <!-- Start product images -->
    <div class="product-images">
        <div class="main-image images">
            <img alt="big images" src="{{ $product->getFirstImageSrc() }}">
        </div>
    </div>
    <!-- end product images -->
    <div class="product-info">
        <h1>{{ $product->name }}</h1>
        <div class="rating__and__review">
            <ul class="rating">
                <li><span class="ti-star"></span></li>
                <li><span class="ti-star"></span></li>
                <li><span class="ti-star"></span></li>
                <li><span class="ti-star"></span></li>
                <li><span class="ti-star"></span></li>
            </ul>
            <div class="review">
                <a href="#">4 customer reviews</a>
            </div>
        </div>

        <div class="ajax-offer-block">
            <div class="loader-gif">
                <img style="margin: 70px;" src="{{ LOADER_GIF }}" alt="">
            </div>
            <script>
                $.ajax({
                    url: '{{ route('catalog.offers', $product->id) }}',
                    method: 'GET',
                    data: {modal: true},
                    success: function (result) {
                        $('.ajax-offer-block').html(result);
                    }
                });
            </script>
        </div>


    </div><!-- .product-info -->
</div><!-- .modal-product -->
