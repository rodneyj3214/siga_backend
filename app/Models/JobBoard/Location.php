<?php

namespace App\Models\JobBoard;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;


class Location extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $connection = 'pgsql-job-board';
    protected $fillable = [
        'code',
        'name',
        'type',
        'post_code'
    ];



    public function children()
    {
        return $this->hasMany(Location::class, 'parent_id');
    }
}
