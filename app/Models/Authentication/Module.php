<?php

namespace App\Models\Authentication;

// Laravel
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

// Application
use Illuminate\Database\Eloquent\SoftDeletes;



class Module extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;


    protected $connection = 'pgsql-authentication';
    protected $table = 'authentication.modules';

    protected $fillable = ['state'];


}
