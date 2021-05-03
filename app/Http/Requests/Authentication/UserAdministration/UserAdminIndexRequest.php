<?php

namespace App\Http\Requests\Authentication\Auth\UserAdministration;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Authentication\AuthenticationFormRequest;

class UserAdminIndexRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [];
    }

    public function messages()
    {
        $messages = [];
        return AuthenticationFormRequest::messages($messages);
    }

    public function attributes()
    {
        $attributes = [];
        return AuthenticationFormRequest::attributes($attributes);
    }
}
