<?php

namespace App\Models\App;

// Laravel
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

// Traits State
use App\Traits\StateActive;


class Position extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use StateActive;


    protected $connection = 'pgsql-app';
    protected $table = 'app.positions';

    protected $fillable = [];
}
