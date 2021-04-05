<?php

namespace App\Models\Authentication;

// Laravel
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Passport\Client as PassportClient;
use OwenIt\Auditing\Contracts\Auditable;

// Traits State
use App\Traits\StateActiveTrait;


class Client extends PassportClient implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use StateActiveTrait;


    public function username()
    {
        return 'username';
    }
}
