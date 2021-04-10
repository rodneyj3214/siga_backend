<?php

namespace App\Http\Requests\JobBoard\Skill;

use Illuminate\Foundation\Http\FormRequest;

class CreateSkillRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'skill.description' =>
                ['required',
                    'max:50',
                    'min:10',
                    // 'unique:pgsql-job-board.abilities,description'
                ],
            'professional.id' =>['required','integer'],
            'type.id' =>['required','integer']
        ];
    }

    public function messages()
    {
        return [
            'skill.description.required' => 'La descripción es requerida',
            'skill.description.min' => 'Mínimo 10 caracteres',
            'professional.id.integer' => 'Debe ser un campo numérico',
        ];
    }
}
