<?php

namespace App\Http\Requests\JobBoard\Skill;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSkillRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            //
        ];
    }
}
