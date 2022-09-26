<?php

namespace App\Services;

use App\Models\Catalog\PropertyName;
use Illuminate\Database\Eloquent\Collection;

class PropertyService
{

    public function findOrCreateValues(array $properties): Collection
    {
        $result = new Collection();
        if (empty($properties)) return $result;

        foreach ($properties as $property_name_id => $property_value){
            $property_name = PropertyName::find($property_name_id);
            $result->add($property_name->propertyValues()->firstOrCreate(['value' => $property_value]));
        }

        return $result;
    }
}
