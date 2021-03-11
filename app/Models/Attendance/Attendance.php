<?php

namespace App\Models\Attendance;

use App\Models\App\Institution;
use App\Models\App\Observation;
use App\Traits\StatusActiveTrait;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\App\Teacher;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

use App\Models\App\Catalogue;

class Attendance extends Model implements Auditable
{

    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use StatusActiveTrait;


    protected $connection = 'pgsql-attendance';

    protected $fillable = [
        'date',
        'state',
    ];

    protected $casts = [
        'date' => 'date:Y-m-d'
    ];

    public function attendanceable()
    {
        return $this->morphTo();
    }

    public function type()
    {
        return $this->belongsTo(Catalogue::class);
    }


    public function workdays()
    {
        return $this->hasMany(Workday::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    public function observations()
    {
        return $this->morphMany(Observation::class, 'observationable');
    }

}
