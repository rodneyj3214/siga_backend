<?php

namespace App\Models\JobBoard;


use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Reference extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $connection = 'pgsql-job-board';


    protected $fillable = [
        'institution',
        'position',
        'contact',
        'phone',
        'state',
    ];

    public function professional()
    {
        return $this->belongsTo(Professional::class);
    }



}
