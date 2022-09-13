<?php

namespace App\Repository;

use App\Helpers\OffersSelectBlock;
use App\Models\Shop\Product;

class OfferRepository
{

    public function getOfferBlockCondition(Product $product, array $selectedProps = [])
    {
        $offersBlock = new OffersSelectBlock($product->offers);
        $result = $offersBlock->getCondition($selectedProps);
        return $result;
    }

    public function getSelectedOffer(Product $product, array $schema = [])
    {

        $selected_properties = OffersSelectBlock::getSelectedPropertiesFromSchema($schema);

        if (empty($selected_properties))
            return $product->offers->first();

        foreach ($product->offers as $offer) {
            $offer_props = OffersSelectBlock::getOfferProperties($offer);
            if (OffersSelectBlock::equalProperties($selected_properties, $offer_props)){
                return $offer;
            }
        }

        throw new \Exception('No offer was found for the selected properties');

    }

}
