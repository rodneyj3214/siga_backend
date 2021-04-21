<?php

namespace App\Models\Web;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;



class ImagePages extends Model implements Auditable
{
    use Auditing;

    protected $connection = 'pgsql-web';
    protected $fillable = [
        'url',
        'name',
        'description',
        'order',
    ];

    public function imageable()
    {
        return $this->morphTo();
    }

    public function type()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function page()
    {
        return $this->belongsTo(Catalogue::class);
    }


}
