<?php

namespace App\Http\Requests;

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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'category_id' => 'exists:categories,id|required',
            'img' => 'mimes:jpeg,bmp,png',
            'slug' => 'nullable|string|max:200',
            'description' => 'nullable|string|max:30000'
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
