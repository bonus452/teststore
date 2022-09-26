<?php

namespace App\Rules;

use App\Models\Catalog\Offer;
use Illuminate\Contracts\Validation\Rule;

class ArticlesUnique implements Rule
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
        $articles = array_column($value, 'article');
        $offer_ids = array_column($value, 'id');
        if(count($articles) !== count(array_unique($articles))){
            return false;
        }

        return (new Offer())
            ->whereIn('article', $articles)
            ->whereNotIn('id', $offer_ids)->exists() === false;

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Offers articles must be unique';
    }
}
