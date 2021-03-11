<?php

namespace App\Models\teacherEval;



use App\Models\App\Teacher;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\StatusActiveTrait;


class SelfResult extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use StatusActiveTrait;


    protected $connection = 'pgsql-teacher-eval';
    protected $table = 'teacher_eval.self_results';

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function answerQuestion()
    {
        return $this->belongsTo(AnswerQuestion::class);
    }
}
