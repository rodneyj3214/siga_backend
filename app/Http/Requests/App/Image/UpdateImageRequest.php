<?php

namespace App\Http\Requests\App\Image;

use App\Http\Requests\App\AppFormRequest;
use App\Http\Requests\JobBoard\JobBoardFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateImageRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'image' => [
                'required',
                'mimes:jpg,jpeg,png',
                'max:1024'
            ],
        ];
        return AppFormRequest::rules($rules);
    }

    public function messages()
    {
        $messages = [
            'image.required' => 'La imagen es requerida',
            'image.mimes' => 'El formato no es permitido',
            'image.max' => 'El tamaño máximo permitido es 1MB',
        ];
        return AppFormRequest::messages($messages);
    }
}
