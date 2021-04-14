<?php

namespace App\Http\Requests\jobBoard\Professional;

use Illuminate\Foundation\Http\FormRequest;

class CreateProfessionalRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }
    
    public function rules()
    {
        return [
            'professional.has_online_interview' =>
                ['required',
                    'max:50',
                    'min:10',
                    // 'unique:pgsql-job-board.professionals,has_online_interview'
                ],
            'user.id' =>['required','integer'],
            'type.id' =>['required','integer']
        ];
    }
    public function messages()
    {
        return [
            'professional.has_online_interview.required' => 'La descripción es requerida',
            'professional.has_online_interview.min' => 'Mínimo 10 caracteres',
            'user.id.integer' => 'Debe ser un campo',
        ];
    }
}

    

