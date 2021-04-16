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
            'user.id' => 'required|int',
            'user.password' => 'required',
            'user.new_password' => 'required|min:8|max:30',
            'user.password_confirmation' => 'required|same:user.new_password',
        ];
    }
}
