<?php

namespace App\models\Web;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;

class Texts extends Model implements Auditable
{
    use Auditing;
    protected $connection = 'pgsql-web';
    protected $fillable = [
        'type_id',

    ];

    public function textable()
    {
        return $this->morphTo();
    }


}
