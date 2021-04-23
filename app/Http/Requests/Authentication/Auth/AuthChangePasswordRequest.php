<?php

namespace App\Http\Requests\Authentication\Auth;

use Illuminate\Foundation\Http\FormRequest;

class AuthChangePasswordRequest extends FormRequest
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
            ],
            'user.password' => [
                'required'
            ],
            'user.new_password' => [
                'required',
                'min:8',
                'max:30'
            ],
            'user.password_confirmation' => [
                'required',
                'same:user.new_password'
            ]
        ];
    }

    public function messages()
    {
        $messages = [
            'user.id.required' => 'El campo :attribute es obligatorio',
            'user.id.int' => 'El campo :attribute debe ser numérico',
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
            'user.id' => 'id del usuario',
            'user.password' => 'password',
            'user.new_password' => 'new password',
            'user.password_confirmation' => 'password confirmation',

        ];
        return $attributes;
    }
}
