<?php

namespace App\Observers;

use App\Models\Sale\Delivery;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;

class DeliveryObserver
{
    public function creating(Delivery $delivery): Delivery
    {
        if ($delivery->image instanceof UploadedFile) {
            if ($delivery->image) {
                $delivery->image = $delivery->image->storePublicly('images/delivery_images', 'public');
            }
        }
        return $delivery;
    }

    public function updating(Delivery $delivery): Delivery
    {
        $old_img = $delivery->getImageSystemPath();
        if ($old_img) {
            File::delete($old_img);
        }
        if ($delivery->image instanceof UploadedFile) {
            if ($delivery->image) {
                $delivery->image = $delivery
                    ->image
                    ->storePublicly('images/delivery_images', 'public');
            }
        }
        return $delivery;
    }

    public function deleting(Delivery $delivery): Delivery
    {
        $old_img = $delivery->getImageSystemPath();
        if ($old_img) {
            File::delete($old_img);
        }
        return $delivery;
    }

}
