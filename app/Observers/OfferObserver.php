<?php

namespace App\Observers;

use App\Models\Shop\Offer;

class OfferObserver
{
    public function deleting(Offer $offer)
    {
        $offer->properties()->detach();
    }
}
