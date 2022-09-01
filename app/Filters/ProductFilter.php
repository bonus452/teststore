<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class ProductFilter extends QueryFilter
{

    protected function properties(array $properties)
    {
        foreach ($properties as $property_values) {
            $this->builder->where(function (Builder $query) use ($property_values) {
                $query->orwhereHas('offers', function (Builder $query) use ($property_values) {
                    $query->whereHas(
                        'properties',
                        function (Builder $query) use ($property_values) {
                            $query->whereIn('id', $property_values);
                        });
                })
                    ->orWhereHas('properties', function (Builder $query) use ($property_values) {
                        $query->whereIn('id', $property_values);
                    });
            });
        }
    }

    protected function price(array $prices){
        if (isset($prices['min']) && is_numeric($prices['min'])){
            $this->builder->whereRelation('offers', 'price', '>=', $prices['min']);
        }
        if (isset($prices['min']) && is_numeric($prices['max'])){
            $this->builder->whereRelation('offers', 'price', '<=', $prices['max']);
        }
    }

}
