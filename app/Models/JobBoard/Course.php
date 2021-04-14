<?php

namespace App\Models\JobBoard;

use App\Models\JobBoard\Professional;
use Brick\Math\BigInteger;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use \OwenIt\Auditing\Auditable as Auditing;

use App\Traits\StateActive;
use App\Models\App\Catalogue;

/**
 * @property BigInteger id
 * @property string description
 * @property boolean state
 */
class Course extends Model implements Auditable
{

    use HasFactory;
    use Auditing;
    use StateActive;

    protected $connection = 'pgsql-job-board';
    protected $table = 'job_board.courses';

    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'hours',
        'state',
    ];

    protected $casts = [
        'start_date' => 'date:Y-m-d',
        'end_date' => 'date:Y-m-d'
    ];

    public static function getInstance($id)
    {
        $model = new Course();
        $model->id = $id;
        return $model;
    }

    // Relationships
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

    // Mutators
    public function setNameAttribute($value)
    {
        $this->attributes['description'] = strtoupper($value);
    }

    public function setDescriptionAttribute($value)
    {
        $this->attributes['name'] = strtoupper($value);
    }
}
