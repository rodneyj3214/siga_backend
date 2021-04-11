<?php

namespace App\Models\JobBoard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

use App\Traits\StateActiveTrait;
use App\Models\JobBoard\Professional;
use App\Models\App\Catalogue;

class Course extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use StateActiveTrait;

    protected $connection = 'pgsql-job-board';
    protected $table = 'job_board.courses';

    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'hours',
        'state'
    ];

    protected $casts = [
        'start_date' => 'date:Y-m-d',
        'end_date' => 'date:Y-m-d'
    ];

    public function professional()
    {
        return $this->belongsTo(Professional::class);
    }

    public function institution()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function eventType()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function certificationType()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function areaType()
    {
        return $this->belongsTo(Catalogue::class);
    }

}
