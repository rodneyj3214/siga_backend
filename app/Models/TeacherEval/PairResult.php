<?php

namespace App\Models\TeacherEval;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;

use App\Models\App\Authority;
use Illuminate\Database\Eloquent\SoftDeletes;


class PairResult extends Model implements Auditable
{
    use Auditing;
    use SoftDeletes;

    use HasFactory;

    protected $connection = 'pgsql-teacher-eval';

    protected $fillable = [];

    public function detailEvaluation()
    {
        return $this->belongsTo(DetailEvaluation::class);
    }
    public function answerQuestion()
    {
        return $this->belongsTo(AnswerQuestion::class);
    }

    public function authority()
    {
        return $this->belongsTo(Authority::class);
    }

}
