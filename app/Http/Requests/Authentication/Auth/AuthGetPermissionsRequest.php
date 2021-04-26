<?php

namespace App\Http\Requests\Authentication\Auth;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Authentication\AuthenticationFormRequest;

class AuthGetPermissionsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'role' => [
                'required',
                'integer'
            ],
            'institution' => [
                'required',
                'integer'
            ]
        ];
    }

    public function messages()
    {
        $messages = [
            'role.required' => 'El campo :attribute es obligatorio',
            'role.integer' => 'El campo :attribute debe ser numérico',
            'institution.required' => 'El campo :attribute es obligatorio',
            'institution.integer' => 'El campo :attribute debe ser numérico',
        ];
        return AuthenticationFormRequest::messages($messages);
    }

    public function attributes()
    {
        $attributes = [
            'role' => 'role',
            'institution' => 'institution',
        ];
        return AuthenticationFormRequest::attributes($attributes);
    }
}
