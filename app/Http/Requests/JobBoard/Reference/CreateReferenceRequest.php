<?php

namespace App\Http\Requests\JobBoard\Reference;

use App\Http\Requests\JobBoard\JobBoardFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class CreateReferenceRequest extends FormRequest
{
    private $regularExpresionEmail = '/^(([^<>()\[\]\\.,;:\s@”]+(\.[^<>()\[\]\\.,;:\s@”]+)*)|(“.+”))@((\[[0–9]{1,3}\.[0–9]{1,3}\.[0–9]{1,3}\.[0–9]{1,3}])|(([a-zA-Z\-0–9]+\.)+[a-zA-Z]{2,}))$/';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [
            'professional.id' => [
                'required',
                'integer'
            ],
            'reference.institution' => [
                'required',
                'min:5',
                'max:30'
            ],
            'reference.position' => [
                'required',
                'min:5',
                'max:30'
            ],
            'reference.contact_name' => [
                'required',
                'max:30'
            ],
            'reference.contact_phone' => [
                'required',
                'numeric',
            ],
            'reference.contact_email' => [
                'required',
                'regex:'.$this->regularExpresionEmail,
            ],
        ];

        return JobBoardFormRequest::rules($rules);
    }

    public function messages()
    {
        $messages = [
            'professional.id.required' => 'El campo :attribute es obligatorio',
            'professional.id.integer' => 'El campo :attribute debe ser numérico',
            'reference.institution.required' => 'El campo :attribute es obligatorio',
            'reference.institution.min' => 'El campo :attribute debe tener al menos :min caracteres',
            'reference.institution.max' => 'El campo :attribute debe tener máximo :max caracteres',
            'reference.position.required' => 'El campo :attribute es obligatorio',
            'reference.position.min' => 'El campo :attribute debe tener al menos :min caracteres',
            'reference.position.max' => 'El campo :attribute debe tener maximo :max caracteres',
            'reference.contact_name.required' => 'El campo :attribute es obligatorio',
            'reference.contact_name.max' => 'El campo :attribute debe tener máximo :max caracteres',
            'reference.contact_phone.required' => 'El campo :attribute es obligatorio',
            'reference.contact_phone.numeric' => 'El campo :attribute debe ser numérico',
            'reference.contact_email.required' => 'El campo :attribute es obligatorio',
            'reference.contact_email.regex' => 'El campo :attribute debe ser un email válido',
        ];
        return JobBoardFormRequest::messages($messages);
    }

    public function attributes()
    {
        $attributes = [
            'professional.id' => 'profesional-ID',
            'reference.institution' => 'institución',
            'reference.position' => 'posición',
            'reference.contact_name' => 'nombre de contacto',
            'reference.contact_phone' => 'teléfono de contacto',
            'reference.contact_email' => 'email de contacto',
        ];
        return JobBoardFormRequest::attributes($attributes);
    }

}
