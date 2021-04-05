<?php

namespace App\Models\TeacherEval;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

use App\Traits\StateActiveTrait;


class DetailEvaluation extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use StateActiveTrait;

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
