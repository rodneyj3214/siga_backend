<?php

namespace App\Http\Requests\JobBoard\Course;

use App\Http\Requests\JobBoard\JobBoardFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class CreateCourseRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'course.name' => [
                'required',
                'min:10',
                'max:200',
            ],
            'course.description' => [
                'required',
                'min:10',
                'max:1000',
            ],
            'course.start_date' => [
                'required',
            ],
            'course.end_date' => [
                'required',
            ],
            'course.hours' => [
                'required',
                'integer',
            ],
            'professional.id' => [
                'required',
                'integer',
            ],
            'type.id' => [
                'required',
                'integer',
            ],
            'institution.id' => [
                'required',
                'integer',
            ],
            'certification_type.id' => [
                'required',
                'integer',
            ],
            'area.id' => [
                'required',
                'integer',
            ]
        ];
        return JobBoardFormRequest::rules($rules);
    }

    public function messages()
    {
        $messages = [
            'course.name.required' => 'El campo :attribute es obligatorio',
            'course.name.min' => 'El campo :attribute debe tener al menos :min caracteres',
            'course.description.required' => 'El campo :attribute es obligatorio',
            'course.description.min' => 'El campo :attribute debe tener al menos :min caracteres',
            'course.start_date.required' => 'El campo :attribute es obligatorio',
            'course.end_date.required' => 'El campo :attribute es obligatorio',
            'course.hours.required' => 'El campo :attribute es obligatorio',
            'course.hours.integer' => 'El campo :attribute debe ser numérico',
            'professional.id.required' => 'El campo :attribute es obligatorio',
            'professional.id.integer' => 'El campo :attribute debe ser numérico',
            'type.id.required' => 'El campo :attribute es obligatorio',
            'type.id.integer' => 'El campo :attribute debe ser numérico',
            'institution.id.required' => 'El campo :attribute es obligatorio',
            'institution.id.integer' => 'El campo :attribute debe ser numérico',
            'certification_type.id.required' => 'El campo :attribute es obligatorio',
            'certification_type.id.integer' => 'El campo :attribute debe ser numérico',
            'area.id.required' => 'El campo :attribute es obligatorio',
            'area.id.integer' => 'El campo :attribute debe ser numérico',
        ];
        return JobBoardFormRequest::messages($messages);
    }

    public function attributes()
    {
        $attributes = [
            'course.name' => 'nombre',
            'course.description' => 'descripción',
            'course.start_date' => 'fecha inicial',
            'course.end_date' => 'fecha final', 
            'course.hours' => 'horas', 
            'professional.id' => 'profesional-id',
            'type.id' => 'tipo-id',
            'institution.id.id' => 'institución-id',
            'certification_type.id' => 'tipo certificación-id',
            'area.id' => 'area-id',
        ];
        return JobBoardFormRequest::attributes($attributes);
    }
}
