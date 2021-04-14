<?php

namespace App\Models\JobBoard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use \OwenIt\Auditing\Auditable as Auditing;

use App\Traits\StateActiveTrait;
use App\Models\App\Catalogue;

/**
 * @property boolean state
 * @property string description
 */
class Skill extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use StateActiveTrait;

    protected $connection = 'pgsql-job-board';
    protected $table = 'job_board.skills';

    protected $fillable = [
        'description',
        'state'
    ];


    // Relationships
    public function professional()
    {
        return $this->belongsTo(Professional::class);
    }

    public function type()
    {
        return $this->belongsTo(Catalogue::class);
    }

    // Mutators
    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = strtoupper($value);
    }

    // Scopes
    public function scopeDescription($query, $description)
    {
        if ($description){
            return $query->orWhere('description','ILIKE',"%$description%");
        }
    }
}
