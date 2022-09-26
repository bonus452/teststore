<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait ImagePath
{
    public function getImageAttribute($value)
    {
        $result = $value instanceof UploadedFile
            ? $value
            : '/storage/'. $value;
        return $result;
    }

    public function getImageSystemPath()
    {
        $src = $this->getRawOriginal('image');
        if (!empty($src)){
            $is_windows = strripos(php_uname() ,'windows') !== false;
            $path = Storage::disk('public')->path($src);
            return $is_windows ?
                Str::replace("/", "\\",  $path) :
                $path;
        }else{
            return false;
        }
    }
}
