<?php

namespace App\Models\Authentication;

// Laravel
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class UserUnlock extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $connection = 'pgsql-authentication';

    protected $fillable = ['username', 'is_valid', 'token'];
}

