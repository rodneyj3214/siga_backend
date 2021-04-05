<?php

namespace App\Models\App;

use App\Traits\StateActiveTrait;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Setting extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use StateActiveTrait;


    protected $connection = 'pgsql-app';
    protected $table = 'app.settings';

    protected $fillable = [];
}
