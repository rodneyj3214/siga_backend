<?php

namespace App\Models\JobBoard;


use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Ability extends Model implements Auditable
{

    use \OwenIt\Auditing\Auditable;

    protected $connection = 'pgsql-job-board';
    protected $fillable = [
        'description'
    ];

    public function professional()
    {
        return $this->belongsTo(Professional::class);
    }

    public function category()
    {
        return $this->belongsTo(Catalogue::class);
    }



}
