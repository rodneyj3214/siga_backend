<?php

namespace App\Http\Requests\JobBoard\Offer;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\JobBoard\JobBoardFormRequest;

class IndexOfferRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'company.id' => [
                'required',
                'integer',
            ],
        ];
        return JobBoardFormRequest::rules($rules);
    }

    public function messages()
    {
        $messages = [
            'company.id.required' => 'El campo :company.id es obligatorio',
            'company.id.integer' => 'El campo :company.id debe ser numérico',
        ];
        return JobBoardFormRequest::messages($messages);
    }

    public function attributes()
    {
        $attributes = [
            'company.id' => 'compania-id',
        ];
        return JobBoardFormRequest::attributes($attributes);
    }
}
