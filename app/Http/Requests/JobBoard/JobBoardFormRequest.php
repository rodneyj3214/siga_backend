<?php

namespace App\Http\Requests\JobBoard;

class JobBoardFormRequest
{
    public static function rules($rules = [])
    {
        return array_merge($rules, [
            'per_page' => ['integer', 'min:1', 'max:100']
        ]);
    }

    public static function messages($messages = [])
    {
        return array_merge($messages, [
            'per_page.min' => 'El número mínimo de registros por consulta es 1',
            'per_page.max' => 'El número máximo de registros por página es 100',
        ]);
    }
}
