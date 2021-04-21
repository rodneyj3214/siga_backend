<?php

namespace App\Models\TeacherEval;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;

use App\Models\App\Catalogue;

class EvaluationType extends Model implements Auditable
{
    use Auditing;
    use HasFactory;

    protected $connection = 'pgsql-teacher-eval';

    protected $fillable = [
        'name',
        'code',
        'percentage',
        'global_percentage',
    ];



    public function parent()
    {
        return $this->belongsTo(EvaluationType::class, 'parent_id');
    }
    public function status()
    {
        return $this->belongsTo(Catalogue::class,'status_id');
    }

}
