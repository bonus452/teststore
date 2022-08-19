<?php

namespace App\Http\Requests;

use App\Rules\ArticlesUnique;
use App\Rules\ImageExistInDB;
use App\Rules\PropertyExistInDB;
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

        $new_images = $this->new_images ?? array();
        $exists_images = $this->exists_images ?? array();
        $properties = $this->properties ?? array();

        if (is_array($properties)) {
            foreach ($properties as &$property) {
                if (empty($property)) {
                    unset($property);
                }
            }
        }

        $offers = $this->offers;
        foreach ($offers as &$offer) {
            $offer['properties'] = $offer['properties'] ?? array();
            if (is_array($offer['properties'])) {
                foreach ($offer['properties'] as &$property) {
                    if (empty($property)) {
                        unset($property);
                    }
                }
            }
        }
        $this->merge([
            'offers' => $offers,
            'properties' => $properties,
            'new_images' => $new_images,
            'exists_images' => $exists_images
        ]);
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
            'active' => 'required|boolean',
            'seo_title' => 'nullable|string',
            'seo_description' => 'nullable|string',
            'seo_keywords' => 'nullable|string',
            'properties.*' => 'string|max:255',
            'properties' => ['bail', 'array', new PropertyExistInDB()],
            'exists_images' => ['bail', 'array', new ImageExistInDB()],
            'new_images' => 'array',
            'new_images.*' => 'image',
            'offers' => [
                'bail',
                'array',
                'required',
                new ArticlesUnique()
            ],
            'offers.*.article' => [
                'required',
                'string',
                'max:255'
            ],
            'offers.*.price' => 'required|numeric|min:0|max:99999999',
            'offers.*.id' => 'exists:offers',
            'offers.*.properties.*' => 'string|max:255',
            'offers.*.properties' => ['bail', 'array', new PropertyExistInDB()],

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
