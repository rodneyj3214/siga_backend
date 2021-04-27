<?php

namespace App\Http\Requests\Authentication\Auth;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Authentication\AuthenticationFormRequest;

class ResetAttemptsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user.id' => [
                'required',
                'integer'
            ]
        ];
    }

    public function messages()
    {
        $messages = [
            'token.required' => 'El campo :attribute es obligatorio',
            'token.integer' => 'El campo :attribute debe ser numérico'
           
        ];
        return AuthenticationFormRequest::messages($messages);
    }

    public function attributes()
    {
        $attributes = [
            'token.id' => 'id de usuario',
           
        ];
        return AuthenticationFormRequest::attributes($attributes);
    }
}
