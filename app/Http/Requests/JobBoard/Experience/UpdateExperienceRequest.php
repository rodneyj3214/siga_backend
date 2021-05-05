<?php

namespace App\Http\Requests\JobBoard\Experience;
use App\Http\Requests\JobBoard\JobBoardFormRequest;

use Illuminate\Foundation\Http\FormRequest;

class UpdateExperienceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
    'professional.id' => [
        'required',
        'integer',
    ],
    'area.id' => [
        'required',
        'integer',
    ],
    'experience.employer' => [
        'required',
        'integer',
    ],
    'experience.position' => [
        'required',
        'integer',
    ],
    'experience.startDate' => [
        'required',
        'integer',
    ],
    'experience.endDate' => [
        'required',
        'integer',
    ],
    'experience.activities' => [
        'required',
        'bolean',
    ],
    'experience.reasonLeave' => [
        'required',
        'integer',
    ],
    'experience.isWorkin' => [
        'required',
        'integer',
    ]
];
return JobBoardFormRequest::rules($rules);

}

public function messages()
{
    $messages = [
        'professional.id.required' => 'El campo :attribute es obligatorio',
        'professional.id.integer' => 'El campo :attribute debe ser numérico',
        'area.id.required' => 'El campo :attribute es obligatorio',
        'area.id.integer' => 'El campo :attribute debe ser numérico',  
        'experience.employer.required' => 'El campo :attribute es obligatorio',
        'experience.employer.boolean' => 'El campo :attribute debe ser numérico',
        'experience.position.required' => 'El campo :attribute es obligatorio',
        'experience.position.boolean' => 'El campo :attribute debe ser numérico',
        'experience.startDate.required' => 'El campo :attribute es obligatorio',
        'experience.startDate.boolean' => 'El campo :attribute debe ser numérico',
        'experience.endDate.required' => 'El campo :attribute es obligatorio',
        'experience.end_date.boolean' => 'El campo :attribute debe ser numérico',          
        'experience.activities.required' => 'El campo :attribute es obligatorio',
        'experience.activities.min' => 'El campo :attribute debe tener al menos :min caracteres',
        'experience.reasonLeave.required' => 'El campo :attribute es obligatorio',
        'experience.reasonLeave.min' => 'El campo :attribute debe tener al menos :min caracteres',
        'experience.isWorking.required' => 'El campo :attribute es obligatorio',
        'experience.isWorking.min' => 'El campo :attribute debe tener al menos :min caracteres',
    
    ];
    return JobBoardFormRequest::messages($messages);
}

public function attributes()
{
    $attributes = [
        'professional.id' => 'profesional-ID',
        'area.id' => 'area-ID',
        'experience.employer' => 'nombre de empleadora',
        'experience.position' => 'posicion',
        'experience.startDate' => 'fecha inicio',
        'experience.endDate' => 'fercha fin',
        'experience.activities' => 'ocupaciones',
        'experience.reasonLeave' => 'razon dejar',
        'experience.isWorking' => 'está trabajando',
   
    ];
    return JobBoardFormRequest::attributes($attributes);
}
}

