<?php

namespace App\Observers;

use App\Models\Shop\Image;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageObserver
{
    /**
     * Handle the Category "creating" event.
     *
     * @param \App\Models\Shop\Image $image
//     * @return \App\Models\Shop\Image  $category
     */
    public function creating(Image $image): Image
    {
        if ($image->src instanceof UploadedFile) {
            $image->src = $image->src->storePublicly('images/product_images', 'public');
        }
        return $image;
    }

    public function deleted(Image $image)
    {
        $is_windows = strripos(php_uname() ,'windows') !== false;
        $path = Storage::disk('public')->path($image->getRawOriginal('src'));
        $src = $is_windows ?
            Str::replace("/", "\\",  $path) :
            $path;

        if (File::exists($src)){
            File::delete($src);
        }
    }

}
