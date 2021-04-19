<?php

namespace App\Http\Requests\Authentication\Auth;

use Illuminate\Foundation\Http\FormRequest;

class AuthUnlockUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'username' => 'required'
        ];
    }

    public function messages()
    {
        $messages = [
            'username.required' => 'El campo :attribute es obligatorio',
        ];
        return JobBoardFormRequest::messages($messages);
    }

    public function attributes()
    {
        $attributes = [
            'username' => 'username',
        ];
        return JobBoardFormRequest::attributes($attributes);
    }
}
