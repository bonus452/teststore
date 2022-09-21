<?php

namespace App\Services;

use App\Models\Shop\Offer;
use App\Models\Shop\Product;
use Illuminate\Database\Eloquent\Collection as ElCollection;
use Illuminate\Support\Collection;

class OfferService
{

    protected PropertyService $propertyService;

    public function __construct()
    {
        $this->propertyService = new PropertyService();
    }

    public function createMany(Product $product, Collection $offers): ElCollection
    {
        $result = new ElCollection();
        foreach ($offers as $arr_offer) {
            $offer = $product->offers()->create($arr_offer);
            if(isset($arr_offer['properties'])){
                $property_values = $this->propertyService->findOrCreateValues($arr_offer['properties']);
                $offer->properties()->sync($property_values);
            }
            $result->add($offer);
        }
        return $result;
    }

    private function updateMany(Collection $offers): void
    {
        $db_offers = Offer::whereIn('id', $offers->pluck('id'))->get();
        foreach ($offers as $offer) {
            $db_offer = $db_offers->find($offer['id']);
            $db_offer->update($offer);
            if(isset($offer['properties'])) {
                $property_values = $this->propertyService->findOrCreateValues($offer['properties']);
                $db_offer->properties()->sync($property_values);
            }
        }
    }

    public function sync(Product $product, Collection $offers): void
    {
        $must_update_offers = $offers->whereNotNull('id');
        $product->offers()
            ->whereNotIn('id', $must_update_offers->pluck('id'))
            ->delete();
        $this->updateMany($must_update_offers);
        $this->createMany($product, $offers->whereNull('id'));
    }
}
