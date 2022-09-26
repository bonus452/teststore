<?php

namespace App\Observers;

use App\Models\Catalog\Offer;

class OfferObserver
{
    public function deleting(Offer $offer)
    {
        $offer->properties()->detach();
    }
}
