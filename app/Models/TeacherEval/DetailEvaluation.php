<?php

namespace App\Models\TeacherEval;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;

use Illuminate\Database\Eloquent\SoftDeletes;

class DetailEvaluation extends Model implements Auditable
{
    use Auditing;
    use SoftDeletes;

    use HasFactory;

    protected $connection = 'pgsql-teacher-eval';

    protected $fillable = [
        'result'
    ];


    public function detailEvaluationable()
    {
        return $this->morphTo();
    }
    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class);
    }
}
