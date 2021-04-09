<?php

namespace App\Http\Requests\JobBoard\Ability;

use Illuminate\Foundation\Http\FormRequest;

class CreateAbilityRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ability.description' =>
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
            'ability.description.required' => 'La descripción es requerida',
            'ability.description.min' => 'Mínimo 10 caracteres',
            'professional.id.integer' => 'Debe ser un campo numérico',
        ];
    }
}
