<?php

namespace App\models\Web;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;

class Resources extends Model implements Auditable

{
    use Auditing;
    protected $connection = 'pgsql-web';
    protected $fillable = [
        'type_id',

    ];

    public function resourceable()
    {
        return $this->morphTo();
    }


}
