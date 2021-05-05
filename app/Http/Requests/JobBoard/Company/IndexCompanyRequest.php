<?php


namespace App\Http\Requests\JobBoard\Company;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\JobBoard\JobBoardFormRequest;

class IndexCompanyRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'company_id' => [
                //'required',
                'integer'
            ],
        ];
        return JobBoardFormRequest::rules($rules);
    }

    public function messages()
    {
        $messages = [
           // 'company_id.required' => 'El campo :attribute es obligatorio',
            'company_id.integer' =>'El campo :attribute debe ser numérico',
        ];
        return JobBoardFormRequest::messages($messages);
    }

    public function attributes()
    {
        $attributes = [
            'company_id' => 'empresa-ID',
        ];
        return JobBoardFormRequest::attributes($attributes);
    }
}
