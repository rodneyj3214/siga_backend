<?php

namespace App\Models\Community;

use Illuminate\Database\Eloquent\Model;

class SpecificAim extends Model
{
    protected $connection = 'pgsql-community';
    protected $casts=[
        'verifications'=>'array',
    ];
}
