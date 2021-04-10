<?php

namespace App\Http\Requests\JobBoard\Skill;

use App\Http\Requests\JobBoard\JobBoardFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class CreateSkillRequest extends FormRequest
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
            'professional.id' => [
                'required',
                'integer',
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
            'skill.description.required' => 'La descripción es obligatoria',
            'skill.description.min' => 'La descripción debe tener mínimo 10 caracteres',
            'professional.id.required' => 'El profesional es obligatorio',
            'professional.id.integer' => 'El ID del profesional debe ser numérico',
            'type.id.required' => 'El tipo es obligatorio',
            'type.id.integer' => 'El ID del tipo debe ser numérico',
        ];
        return JobBoardFormRequest::messages($messages);
    }
}
