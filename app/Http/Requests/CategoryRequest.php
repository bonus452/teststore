<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Rules\CategoryNotInSelf;
use Auth;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    protected $container = 'category';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->checkPermissionTo('admin-panel');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'category_id' => [
                'bail',
                'required',
                'exists:categories,id',
                new CategoryNotInSelf()
            ],
            'seo_title' => 'nullable|string',
            'seo_description' => 'nullable|string',
            'seo_keywords' => 'nullable|string',
            'img' => 'mimes:jpeg,bmp,png'
        ];
    }

    public function messages()
    {
        return [
            'category_id.required' => 'Parent category does not specified',
            'img.mimes:jpeg,bmp,png' => 'Image must be a file of type: jpeg, bmp, png'
        ];
    }

}
