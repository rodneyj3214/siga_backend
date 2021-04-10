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
            'skill.description.required' => 'La descripción es obligatoria',
            'skill.description.min' => 'La descripción debe tener mínimo 10 caracteres',
            'type.id.required' => 'El tipo es obligatorio',
            'type.id.integer' => 'El ID del tipo debe ser numérico',
        ];
        return JobBoardFormRequest::messages($messages);
    }
}
