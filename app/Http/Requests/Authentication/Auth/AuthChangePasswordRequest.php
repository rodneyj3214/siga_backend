<?php

namespace App\Http\Requests\Authentication\Auth;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Authentication\AuthenticationFormRequest;

class AuthChangePasswordRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'password_old' => [
                'required'
            ],
            'password' => [
                'required',
                'min:8',
                'max:30'
            ],
            'password_confirmation' => [
                'required',
                'same:password'
            ]
        ];
        return AuthenticationFormRequest::messages($messages);
    }

    public function messages()
    {
        $messages = [
            'user.password.required' => 'El campo :attribute es obligatorio',
            'user.new_password.required' => 'El campo :attribute es obligatorio',
            'user.new_password.min' => 'El campo :attribute debe tener al menos :min caracteres',
            'user.new_password.max' => 'El campo :attribute debe tener maximo :max caracteres',
            'user.password_confirmation.required' => 'El campo :attribute es obligatorio',
            'user.password_required.same' => 'El campo :attribute coincide',
        ];
        return $messages;
    }

    public function attributes()
    {
        $attributes = [
            'user.password' => 'password',
            'user.new_password' => 'new password',
            'user.password_confirmation' => 'password confirmation',

        ];
        return AuthenticationFormRequest::attributes($attributes);
    }
}
