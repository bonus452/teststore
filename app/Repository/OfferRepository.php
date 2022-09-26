<?php

namespace App\Repository;

use App\Helpers\OffersSelectBlock;
use App\Models\Catalog\Product;
use App\Models\Catalog\Offer as Model;
use Illuminate\Database\Eloquent\Collection;

class OfferRepository
{

    protected function getInstance(): Model
    {
        return new Model();
    }

    public function getOfferBlockCondition(Collection $offers, array $selectedProps = [])
    {
        $offersBlock = new OffersSelectBlock($offers);
        $result = $offersBlock->getCondition($selectedProps);
        return $result;
    }

    public function getSelectedOffer(Collection $offers, array $schema = [])
    {

        $selected_properties = OffersSelectBlock::getSelectedPropertiesFromSchema($schema);

        if (empty($selected_properties))
            return $offers->first();

        foreach ($offers as $offer) {
            $offer_props = OffersSelectBlock::getOfferProperties($offer);
            if (OffersSelectBlock::equalProperties($selected_properties, $offer_props)) {
                return $offer;
            }
        }

        throw new \Exception('No offer was found for the selected properties');

    }

    public function getProductOffers(int $product_id)
    {
        $result = $this->getInstance()
            ->where('product_id', $product_id)
            ->withProperties()
            ->get();
        return $result;
    }

}
