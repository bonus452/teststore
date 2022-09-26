<?php

namespace App\Observers;

use App\Models\Sale\Payment;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;

class PaymentObserver
{
    public function creating(Payment $payment): Payment
    {
        if ($payment->image instanceof UploadedFile) {
            if ($payment->image) {
                $payment->image = $payment->image->storePublicly('images/payment_images', 'public');
            }
        }
        return $payment;
    }

    public function updating(Payment $payment): Payment
    {
        $old_img = $payment->getImageSystemPath();
        if ($old_img) {
            File::delete($old_img);
        }
        if ($payment->image instanceof UploadedFile) {
            if ($payment->image) {
                $payment->image = $payment
                    ->image
                    ->storePublicly('images/payment_images', 'public');
            }
        }
        return $payment;
    }

    public function deleting(Payment $delivery): Payment
    {
        $old_img = $delivery->getImageSystemPath();
        if ($old_img) {
            File::delete($old_img);
        }
        return $delivery;
    }
}
