<?php

namespace App\Repository;

use App\Filters\ProductFilter;
use App\Filters\QueryFilter;
use App\Models\Shop\Category;
use App\Models\Shop\Product;
use App\Models\Shop\PropertyValue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use IteratorAggregate;

class PropertyRepository
{

    public function getFilterProperties(Category $category, QueryFilter $filter): array
    {
        $categories_ids = (new CategoryRepository)->getAllChildsList($category->id);
        $not_filtered_products = Product::whereIn('category_id', $categories_ids)
            ->withProperties()
            ->get();
        $filter_properties = $this->getPropertiesFromProducts($not_filtered_products);

        if (empty(request()->input())) {
            return $this->presureProperties($filter_properties, $filter_properties);
        } else {
            $filtered_products = Product::whereIn('category_id', $categories_ids)
                ->withProperties()
                ->filter($filter)
                ->get();
            $filtered_properties = $this->getPropertiesFromProducts($filtered_products);

            return $this->presureProperties($filter_properties, $filtered_properties);
        }

    }

    public function getPropertiesFromProducts(IteratorAggregate $inner_products)
    {
        $result = [];
        $temp_mass_prices = new Collection();

        foreach ($inner_products as $product) {
            $setted_for_product = [];
            foreach ($product->properties as $property) {
                $result['properties'][$property->property_name->id] =
                    $result['properties'][$property->property_name->id] ?? array();
                $this->setDataProperty(
                    $result['properties'][$property->property_name->id],
                    $property,
                    $setted_for_product);
            }

            foreach ($product->offers as $offer) {
                $temp_mass_prices->add($offer->price);
                foreach ($offer->properties as $property) {
                    $result['properties'][$property->property_name->id] =
                        $result['properties'][$property->property_name->id] ?? array();
                    $this->setDataProperty(
                        $result['properties'][$property->property_name->id],
                        $property,
                        $setted_for_product);
                }
            }
        }

        $result['price'] = [
            'min' => intval($temp_mass_prices->min()),
            'max' => ceil($temp_mass_prices->max()),
        ];
        return $result;
    }

    private function setDataProperty(array &$mass_prop, PropertyValue $property, &$setted_for_product)
    {
        $mass_prop['name'] = $property->property_name->name;
        $mass_prop['values'] = $mass_prop['values'] ?? array();

        if (!in_array($property->value, array_column($mass_prop['values'], 'value'))) {
            $mass_prop['values'][$property->id]['value'] = $property->value;
        }
        $mass_prop['values'][$property->id]['count'] = $mass_prop['values'][$property->id]['count'] ?? 0;
        if (!in_array($property->id, $setted_for_product)) {
            $mass_prop['values'][$property->id]['count'] += 1;
            $setted_for_product[] = $property->id;
        }
    }

    public function presureProperties(array $before_filter, array $after_filtered): array
    {
        $request_inputs = request()->all();
        if(isset($before_filter['properties'])) {
            foreach ($before_filter['properties'] as $property_id => &$property) {
                foreach ($property['values'] as $value_id => &$value) {
                    $count_after_filter = $after_filtered['properties'][$property_id]['values'][$value_id]['count'] ?? 0;
                    $value['count'] = $count_after_filter;
                    $value['checked'] =
                        isset($request_inputs['properties'][$property_id][$value_id]) ? 'checked' : '';
                }
            }
        }

        $before_filter['setted_price']['max'] = $request_inputs['price']['max'] ?? $before_filter['price']['max'];
        $before_filter['setted_price']['min'] = $request_inputs['price']['min'] ?? $before_filter['price']['min'];


        return $before_filter;
    }

}
