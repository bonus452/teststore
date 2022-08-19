
@php /** @var \App\Models\Shop\Product $product */ @endphp
@php /** @var \App\Models\Shop\Image $image */ @endphp

<label for="img">Images</label>
<br>

<div class="images-block">

    @isset($product)
        @foreach($product->images as $image)
            <div class="image-block">
                <button class="btn btn-block btn-danger btn-sm delete-image">X</button>
                <img src="{{ $image->src }}" alt="">
                <input type="hidden" name="exists_images[{{ $image->id }}]" value="{{ $image->id }}">
            </div>
        @endforeach
    @endisset


</div>

<div class="form-group input-images-block">

    <div class="input-group">
        <div class="custom-file">
            <input type="file" multiple class="custom-file-input" id="img" name="new_images[]">
            <label class="custom-file-label" for="img">Choose images</label>
        </div>
    </div>
</div>
