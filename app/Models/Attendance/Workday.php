<?php

namespace App\Models\Attendance;

use App\Models\App\Observation;
use App\Traits\StatusActiveTrait;
use App\Traits\StatusDeletedTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

use App\Models\App\Catalogue;

class Workday extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use StatusActiveTrait;
    use StatusDeletedTrait;

    protected $connection = 'pgsql-attendance';

    public $data;
    public $catalogues;

    const WORK = "WORK";
    const LUNCH = "LUNCH";
    const TYPE_WORKDAYS = "TYPE_WORKDAYS";

    protected $fillable = [
        'start_time',
        'end_time',
        'description',
        'duration',
        'state',
    ];

    protected $casts = [
        'start_time' => 'datetime:H:i:s',
        'end_time' => 'datetime:H:i:s',
    ];

    public function attendance()
    {
        return $this->belongsTo(Attendance::class);
    }

    public function type()
    {
        return $this->belongsTo(Catalogue::class, 'type_id');
    }


    public function observations()
    {
        return $this->morphMany(Observation::class, 'observationable');
    }
}
