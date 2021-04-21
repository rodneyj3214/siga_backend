<?php

namespace App\models\Web;

use Illuminate\Database\Eloquent\Model;

use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;

class Menus extends Model implements Auditable

{
    use Auditing;
    protected $connection = 'pgsql-web';
    protected $fillable = [

        'name',
        'parent_id',
        'type_id',
        'state_id',

    ];


}
