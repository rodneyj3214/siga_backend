<?php

namespace App\Http\Requests\JobBoard\Skill;

use App\Http\Requests\JobBoard\JobBoardFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSkillRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        $rules = [
            'skill.description' => [
                'required',
                'min:10',
                'max:1000',
            ],
            'type.id' => [
                'required',
                'integer',
            ]
        ];
        return JobBoardFormRequest::rules($rules);
    }

    public function messages()
    {
        $messages = [
            'skill.description.required' => 'El campo :attribute es obligatorio',
            'skill.description.min' => 'El campo :attribute debe tener al menos :min caracteres',
            'type.id.required' => 'El campo :attribute es obligatorio',
            'type.id.integer' => 'El campo :attribute debe ser numérico',
        ];
        return JobBoardFormRequest::messages($messages);
    }

    public function attributes()
    {
        $attributes = [
            'skill.description' => 'descripción',
            'type.id' => 'tipo-id',
        ];
        return JobBoardFormRequest::attributes($attributes);
    }
}
