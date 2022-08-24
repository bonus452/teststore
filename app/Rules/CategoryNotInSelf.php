<?php

namespace App\Rules;

use App\Repository\CategoryRepository;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Request;

class CategoryNotInSelf implements Rule
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
        $mass_url = explode('/', Request::url());
        $category_id = (int)end($mass_url);

        $inner_categories = (new CategoryRepository())->getAllChildsList($category_id);
        if (in_array($value, $inner_categories)){
            return false;
        }else{
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The category cannot be by itself';
    }
}
