<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PutCartRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id' => 'exists:offers,id',
            'quantity' => 'numeric',
        ];
    }
}
