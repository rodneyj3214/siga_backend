<?php

namespace App\Models\Authentication;

// Laravel
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;

// Application
use Illuminate\Database\Eloquent\SoftDeletes;


class PasswordReset extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;


    protected $connection = 'pgsql-authentication';
    protected $table = 'authentication.password_resets';

    protected $fillable = ['username', 'is_valid', 'token'];
}

