<?php

namespace App\Http\Requests\JobBoard\Skill;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\JobBoard\JobBoardFormRequest;

class IndexSkillRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = ['professional_id' => ['required']];
        return JobBoardFormRequest::rules($rules);
    }

    public function messages()
    {
        $messages = [
            'professional_id.required' => 'El profesional es obligatorio',
        ];
        return JobBoardFormRequest::messages($messages);
    }
}
