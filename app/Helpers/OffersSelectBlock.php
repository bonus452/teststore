<?php

namespace App\Helpers;

use App\Models\Shop\Offer;
use Illuminate\Support\Collection;

class OffersSelectBlock
{
    private Collection $offers;
    private array $associate_ids_to_values;
    private array $associate_ids_to_property_names;

    public function __construct(Collection $offers)
    {
        $this->associate_ids_to_values = $this->associateIdsToValues($offers);
        $this->associate_ids_to_property_names = $this->associateIdsToPropertyNames($offers);
        $this->offers = $offers;

    }

    public function getCondition(array $selected_props): array
    {
        if($this->offers->isEmpty()){
            return [];
        }

        $selected_props = $this->searchMostSimilarPropsInOffers($selected_props);
        $schema = $this->makeSchema($selected_props);
        $this->prepareResult($schema, $selected_props);
        return $schema;
    }

    private function makeSchema($selected_props): array
    {
        $schema = [];
        $filter = [];
        foreach ($selected_props as $id_property => $property_value){
            $filtered_offers = $this->filterOffersByProperties($filter);
            $schema[$id_property] = $this->getValuesForLine($id_property, $filtered_offers);
            $filter[$id_property] = $property_value;
        }
        return $schema;
    }

    public static function getSelectedPropertiesFromSchema(array $schema): array
    {
        $result = [];
        foreach ($schema as $property_id => $line){
            foreach ($line['values'] as $value_id => $value){
                if($value['selected']){
                    $result[$property_id] = $value_id;
                    break;
                }
            }
        }

        return $result;
    }

    public static function equalProperties($selected_props, $offer_properties): bool
    {
        return !array_diff($selected_props, $offer_properties);
    }

    public static function getOfferProperties(Offer $offer): array
    {
        $result = [];
        foreach ($offer->properties as $property) {
            $result[$property->property_name->id] = $property->id;
        }
        return $result;
    }

    private function associateIdsToPropertyNames(Collection $offers): array
    {
        $result = [];
        foreach ($offers as $offer) {
            foreach ($offer->properties as $property) {
                $result[$property->property_name->id] = $property->property_name->name;
            }
        }
        return $result;
    }

    private function associateIdsToValues(Collection $offers): array
    {
        $result = [];
        foreach ($offers as $offer) {
            foreach ($offer->properties as $property) {
                $result[$property->id] = $property->value;
            }
        }
        return $result;
    }

    private function filterOffersByProperties($filter, $offers = null): Collection
    {
        $offers = $offers ?? $this->offers;

        $result = new Collection();
        foreach ($offers as $offer){
            $offer_properties = self::getOfferProperties($offer);
            if (self::equalProperties($filter, $offer_properties)){
                $result->add($offer);
            }
        }
        return $result;
    }

    private function getValuesForLine(int $id_property, $offers): array
    {
        $result = [];
        foreach ($offers as $offer){
            $mass_properties = self::getOfferProperties($offer);
            if (array_key_exists($id_property, $mass_properties)){
                $result[] = $mass_properties[$id_property];
            }
        }
        return array_unique($result);
    }

    private function searchMostSimilarPropsInOffers($selected_props): array
    {

        $result = $this->offers;

        foreach ($selected_props as $property_id => $value_id) {
            $filter[$property_id] = $value_id;
            $temp_result = $this->filterOffersByProperties($filter, $result);
            if($temp_result->isEmpty()){
                return $this->getOfferProperties($result->first());
            }else{
                $result = $temp_result;
            }

        }
        if ($result->isNotEmpty()){
            return $this->getOfferProperties($result->first());
        }else{
            throw new \Exception('Offers with selected properties not found');
        }

    }

    private function prepareResult(&$schema, $selected_values){
        $this->setPropertyNames($schema);
        $this->markSelectedItems($schema, $selected_values);
    }

    private function setPropertyNames(array &$schema){
        foreach ($schema as $property_id => &$line){
            $temp_line = [];
            $temp_line['name'] = $this->getPropertyNameById($property_id);
            foreach ($line as $property_value_id){
                $temp_line['values'][$property_value_id]['value'] = $this->getPropertyValueById($property_value_id);
            }
            $line = $temp_line;
        }
    }

    private function getPropertyNameById($property_id){
        if (isset($this->associate_ids_to_property_names[$property_id])){
            return $this->associate_ids_to_property_names[$property_id];
        }else{
            throw new \Exception("Property name with id {$property_id} not found");
        }
    }

    private function getPropertyValueById($property_value_id){
        if (isset($this->associate_ids_to_values[$property_value_id])){
            return $this->associate_ids_to_values[$property_value_id];
        }else{
            throw new \Exception("Property value with id {$property_value_id} not found");
        }
    }

    private function markSelectedItems(array &$schema, array $selected_values){
        foreach ($schema as $property_id => &$line_values_ids){
            foreach ($line_values_ids['values'] as $value_id => &$property) {
                if (isset($selected_values[$property_id]) && $value_id == $selected_values[$property_id]){
                    $property['selected'] = 'selected';
                }else{
                    $property['selected'] = '';
                }
            }
        }
    }

}
