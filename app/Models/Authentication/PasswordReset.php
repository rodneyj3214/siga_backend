<?php

namespace App\Models\Authentication;

// Laravel
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

// Application
use App\Traits\StateActiveTrait;


class PasswordReset extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use StateActiveTrait;


    protected $connection = 'pgsql-authentication';
    protected $table = 'authentication.password_resets';

    protected $fillable = ['username', 'is_valid', 'token'];
}

