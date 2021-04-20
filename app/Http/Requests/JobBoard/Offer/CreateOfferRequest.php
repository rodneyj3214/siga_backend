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
            'offer.code.required' => 'El campo :offer.code es obligatorio',
            'offer.description.required' => 'El campo :offer.description es obligatorio',
            'offer.contact_name.required' => 'El campo :offer.contact_name es obligatorio',
            'offer.contact_email.required' => 'El campo :offer.contact_email es obligatorio',
            'offer.start_date.required' => 'El campo :offer.start_date es obligatorio',
            'offer.end_date.required' => 'El campo :offer.end_date es obligatorio',
            'offer.activities.required' => 'El campo :offer.activities es obligatorio',
            'offer.requirements.required' => 'El campo :offer.requirements es obligatorio',
            'company.id.required' => 'El campo :company.id es obligatorio',
            'location.id.required' => 'El campo :location.id es obligatorio',
            'contractType.id.required' => 'El campo :contractType.id es obligatorio',
            'position.id.required' => 'El campo :position.id es obligatorio',
            'sector.id.required' => 'El campo :sector.id es obligatorio',
            'workingDay.id.required' => 'El campo :workingDay.id es obligatorio',
            'experienceTime.id.required' => 'El campo :experienceTime.id es obligatorio',
            'trainingHours.id.required' => 'El campo :trainingHours.id es obligatorio',
            'status.id.required' => 'El campo :status.id es obligatorio',
            'offer.code.min' => 'El campo :offer.code debe tener al menos :min caracteres',
            'offer.description.min' => 'El campo :offer.description debe tener al menos :min caracteres',
            'offer.contact_name.min' => 'El campo :offer.contact_name debe tener al menos :min caracteres',
            'offer.contact_email.min' => 'El campo :offer.contact_email debe tener al menos :min caracteres',
            'offer.code.max' => 'El campo :offer.code debe tener maximo :max caracteres',
            'offer.description.max' => 'El campo :offer.description debe tener maximo :max caracteres',
            'offer.contact_name.max' => 'El campo :offer.contact_name debe tener maximo :max caracteres',
            'offer.contact_email.max' => 'El campo :offer.contact_email debe tener maximo :max caracteres',
            'offer.start_date.date' => 'El campo :offer.start_date debe ser una fecha',
            'offer.end_date.date' => 'El campo :offer.end_date debe ser una fecha',
            'company.id.integer' => 'El campo :company.id debe ser numérico',
            'location.id.integer' => 'El campo :location.id debe ser numérico',
            'contractType.id.integer' => 'El campo :contractType.id debe ser numérico',
            'position.id.integer' => 'El campo :position.id debe ser numérico',
            'sector.id.integer' => 'El campo :sector.id debe ser numérico',
            'workingDay.id.integer' => 'El campo :workingDay.id debe ser numérico',
            'experienceTime.id.integer' => 'El campo :experienceTime.id debe ser numérico',
            'trainingHours.id.integer' => 'El campo :trainingHours.id debe ser numérico',
            'status.id.integer' => 'El campo :status.id debe ser numérico',
        ];
        return JobBoardFormRequest::messages($messages);
    }

    public function attributes()
    {
        $attributes = [
            'offer.code' => 'codigo',
            'offer.description' => 'descripción',
            'offer.contact_name' => 'nombre-contacto',
            'offer.contact_email' => 'email-contacto',
            'offer.start_date' => 'fecha-inicio',
            'offer.end_date' => 'fecha-fin',
            'offer.activities' => 'actividades',
            'offer.requirements' => 'requerimientos',
            'company.id' => 'compania-id',
            'location.id' => 'locacion-id',
            'contractType.id' => 'tipo-contrato-id',
            'position.id' => 'posicion-id',
            'sector.id' => 'sector-id',
            'workingDay.id' => 'dia-trabajo-id',
            'experienceTime.id' => 'tiempo-expreriencia-id',
            'trainingHours.id' => 'horas-entrenamiento-id',
            'status.id' => 'estado-id',
        ];
        return JobBoardFormRequest::attributes($attributes);
    }
}
