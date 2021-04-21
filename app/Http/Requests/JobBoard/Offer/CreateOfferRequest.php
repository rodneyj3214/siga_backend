<?php

namespace App\Http\Requests\JobBoard\Offer;

use App\Http\Requests\JobBoard\JobBoardFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class CreateOfferRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        // NOTA: offer.activities y offer.requirements son tipo json, que relgas deben estar?
        // NOTA: todo las relaciones deben ser requeridas?
        // NOTA: fechas que tipo de dato debe estar?
        // NOTA: pongo code como campo unico?
        $rules = [
            'offer.code' => [
                'required',
                'min:10',
                'max:1000',
            ],
            'offer.description' => [
                'required',
                'min:10',
                'max:1000',
            ],
            'offer.contact_name' => [
                'required',
                'min:10',
                'max:1000',
            ],
            'offer.contact_email' => [
                'required',
                'min:10',
                'max:1000',
            ],
            'offer.start_date' => [
                'required',
                'date',
            ],
            'offer.end_date' => [
                'required',
                'date',
            ],
            'offer.activities' => [
                'required',
            ],
            'offer.requirements' => [
                'required',
            ],
            'company.id' => [
                'required',
                'integer',
            ],
            'location.id' => [
                'required',
                'integer',
            ],
            'contractType.id' => [
                'required',
                'integer',
            ],
            'position.id' => [
                'required',
                'integer',
            ],
            'sector.id' => [
                'required',
                'integer',
            ],
            'workingDay.id' => [
                'required',
                'integer',
            ],
            'experienceTime.id' => [
                'required',
                'integer',
            ],
            'trainingHours.id' => [
                'required',
                'integer',
            ],
            'status.id' => [
                'required',
                'integer',
            ],
        ];
        return JobBoardFormRequest::rules($rules);
    }

    public function messages()
    {
        $messages = [
            'offer.code.required' => 'El campo : codigo es obligatorio',
            'offer.description.required' => 'El campo : descripcion es obligatorio',
            'offer.contact_name.required' => 'El campo : nombre es obligatorio',
            'offer.contact_email.required' => 'El campo : email es obligatorio',
            'offer.start_date.required' => 'El campo : fecho inicio es obligatorio',
            'offer.end_date.required' => 'El campo : fecho fin es obligatorio',
            'offer.activities.required' => 'El campo : actividades es obligatorio',
            'offer.requirements.required' => 'El campo : requerimientos es obligatorio',
            'company.id.required' => 'El campo : compañia es obligatorio',
            'location.id.required' => 'El campo : locacion es obligatorio',
            'contractType.id.required' => 'El campo : tipo de contacto es obligatorio',
            'position.id.required' => 'El campo : posision es obligatorio',
            'sector.id.required' => 'El campo : sector es obligatorio',
            'workingDay.id.required' => 'El campo : dia de trabajo es obligatorio',
            'experienceTime.id.required' => 'El campo : tiempo de experiencia es obligatorio',
            'trainingHours.id.required' => 'El campo : horas de entrenamiento es obligatorio',
            'status.id.required' => 'El campo : stado es obligatorio',
            'offer.code.min' => 'El campo : codigo debe tener al menos : 10 caracteres',
            'offer.description.min' => 'El campo : descripcion debe tener al menos : 10 caracteres',
            'offer.contact_name.min' => 'El campo : nombre debe tener al menos : 10 caracteres',
            'offer.contact_email.min' => 'El campo : email debe tener al menos : 10 caracteres',
            'offer.code.max' => 'El campo : codigo debe tener maximo : 1000 caracteres',
            'offer.description.max' => 'El campo : descripcion debe tener maximo : 1000 caracteres',
            'offer.contact_name.max' => 'El campo : nombre debe tener maximo : 1000 caracteres',
            'offer.contact_email.max' => 'El campo : email debe tener maximo : 1000 caracteres',
            'offer.start_date.date' => 'El campo : fecho inicio debe ser una fecha',
            'offer.end_date.date' => 'El campo : fecho fin debe ser una fecha',
            'company.id.integer' => 'El campo : compañia debe ser numérico',
            'location.id.integer' => 'El campo : locacion debe ser numérico',
            'contractType.id.integer' => 'El campo : tipo de contacto debe ser numérico',
            'position.id.integer' => 'El campo : posision debe ser numérico',
            'sector.id.integer' => 'El campo : sector debe ser numérico',
            'workingDay.id.integer' => 'El campo : dia de trabajo debe ser numérico',
            'experienceTime.id.integer' => 'El campo : tiempo de experiencia debe ser numérico',
            'trainingHours.id.integer' => 'El campo : horas de entrenamiento debe ser numérico',
            'status.id.integer' => 'El campo : stado debe ser numérico',
        ];
        return JobBoardFormRequest::messages($messages);
    }
}
