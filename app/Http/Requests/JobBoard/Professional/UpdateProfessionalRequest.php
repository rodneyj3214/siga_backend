<?php

namespace App\Http\Requests\JobBoard\Professional;

use App\Http\Requests\JobBoard\JobBoardFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfessionalRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        $rules = [
        
            'professional.has_travel' => [
                'required',
                'boolean',
            ],
            'professional.has_disability' => [
                'required',
                'boolean',
            ],
            'professional.has_familiar_disability' => [
                'required',
                'boolean',
            ],
            'professional.identification_familiar_disability' => [
                'required',
                'boolean',
            ],
            'professional.has_catastrophic_illness' => [
                'required',
                'boolean',
            ],
            'professional.has_familiar_catastrophic_illness' => [
                'required',
                'boolean',
            ],
            'professional.about_me' => [
                'required',
                'min:20',
            ]
        ];
        return JobBoardFormRequest::rules($rules);
    }

    public function messages()
    {
        $messages = [
            'professional.has_travel.required' => 'El campo :attribute es obligatorio',
            'professional.has_travel.boolean' => 'El campo :attribute debe ser numérico',
           'professional.has_disability.required' => 'El campo :attribute es obligatorio',
            'professional.has_disability.boolean' => 'El campo :attribute debe ser numérico',
            'professional.has_familiar_disability.required' => 'El campo :attribute es obligatorio',
            'professional.has_familiar_disability.boolean' => 'El campo :attribute debe ser numérico',
           'professional.identification_familiar_disability.required' => 'El campo :attribute es obligatorio',
            'professional.identification_familiar_disability.boolean' => 'El campo :attribute debe ser numérico',
           'professional.has_catastrophic_illness.required' => 'El campo :attribute es obligatorio',
            'professional.has_catastrophic_illness.boolean' => 'El campo :attribute debe ser numérico',
            'professional.has_familiar_catastrophic_illness.required' => 'El campo :attribute es obligatorio',
            'professional.has_familiar_catastrophic_illness.boolean' => 'El campo :attribute debe ser numérico',          
            'professional.about_me.required' => 'El campo :attribute es obligatorio',
            'professional.about_me.min' => 'El campo :attribute debe tener al menos :min caracteres',
        ];
        return JobBoardFormRequest::messages($messages);
    }

    public function attributes()
    {
        $attributes = [
            
            'professional.has_travel' => 'puede viajar',
            'professional.has_disability' => 'tiene discapacidad',
            'professional.has_familiar_disability' => 'tiene discapacidad familiar',
            'professional.identification_familiar_disability' => 'identificacion de discapacidad familiar',
            'professional.has_catastrophic_illness' => 'tiene una enfermedad catastrofica',
            'professional.has_familiar_catastrophic_illness' => 'tiene un  familiar con enfermedad catastrofica ',
            'professional.abou_me' => 'acerca de mì',
        ];
        return JobBoardFormRequest::attributes($attributes);
    }
}
