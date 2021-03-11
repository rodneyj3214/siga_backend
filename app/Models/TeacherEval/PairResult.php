<?php

namespace App\Models\TeacherEval;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

use App\Models\App\Authority;
use App\Traits\StatusActiveTrait;
use App\Traits\StatusDeletedTrait;

class PairResult extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use StatusActiveTrait;
    use StatusDeletedTrait;
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
