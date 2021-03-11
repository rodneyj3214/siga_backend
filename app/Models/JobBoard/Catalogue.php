<?php

namespace App\Models\JobBoard;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;


class Catalogue extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $connection = 'pgsql-job-board';
    protected $fillable = [
        'code',
        'name',
        'type',
        'icon'
    ];



    public function children()
    {
        return $this->hasMany(Catalogue::class, 'parent_id');
    }
}
