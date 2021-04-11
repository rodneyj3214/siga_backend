<?php

namespace App\Models\Authentication;

// Laravel
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

// Application
use App\Traits\StateActive;


class PasswordReset extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use StateActive;


    protected $connection = 'pgsql-authentication';
    protected $table = 'authentication.password_resets';

    protected $fillable = ['username', 'is_valid', 'token'];
}

