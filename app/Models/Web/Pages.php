<?php

namespace App\models\Web;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;

class Pages extends Model implements Auditable

{
    use Auditing;
    protected $connection = 'pgsql-web';
    protected $fillable = [
        'title',
        'subtitle',
        'description',

    ];

    public function pageable()
    {
        return $this->morphTo();
    }


}
