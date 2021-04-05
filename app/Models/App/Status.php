<?php

namespace App\Models\App;

// Laravel
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

// Application
use App\Traits\StateActiveTrait;


class Status extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use StateActiveTrait;

    protected $connection = 'pgsql-app';
    protected $table = 'app.status';

    protected $fillable = ['code', 'name','state'];
}
