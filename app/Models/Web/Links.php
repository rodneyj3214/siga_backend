<?php

namespace App\Models\Web;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;

class Links extends Model implements Auditable

{
    use Auditing;
    protected $connection = 'pgsql-web';
    protected $fillable = [
        'image',
        'url',
        'icon',

    ];

    public function linkable()
    {
        return $this->morphTo();
    }


}
