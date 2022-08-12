<?php

namespace App\Http\Requests;

use App\Rules\ArticlesUnique;
use App\Rules\PropertyExist;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $offers = $this->offers;
        foreach ($offers as &$offer){
            $offer['properties'] = $offer['properties'] ?? array();
            foreach ($offer['properties'] as &$property){
                if(empty($property)){
                    unset($property);
                }
            }
        }
        $this->merge(['offers' => $offers]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'category_id' => 'exists:categories,id|required',
            'img' => 'mimes:jpeg,bmp,png',
            'slug' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:65535',
            'offers' => [
                'array',
                'required',
                new ArticlesUnique()
            ],
            'offers.*.article' => [
                'required',
                'string',
                'max:100'
            ],
            'offers.*.price' => 'required|numeric|min:0|max:99999999',
            'offers.*.id' => 'exists:offers',
            'offers.*.properties.*' => 'string|max:255',
            'offers.*.properties' => new PropertyExist(),

        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The title field is required.',
            'category_id.required' => 'Parent category does not specified',
            'img.mimes:jpeg,bmp,png' => 'Image must be a file of type: jpeg, bmp, png'
        ];
    }

}
