<?php

namespace App\Rules;

use App\Models\Catalog\PropertyName;
use Illuminate\Contracts\Validation\Rule;

class PropertyExistInDB implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $property_ids = array_keys($value);
        if (empty($value) || PropertyName::whereIn('id', $property_ids)->exists()){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Some offer properties does not exist';
    }
}
