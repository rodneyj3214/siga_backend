<?php

namespace App\Models\teacherEval;



use App\Models\App\Teacher;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\SoftDeletes;


class SelfResult extends Model implements Auditable
{
    use Auditing;
    use SoftDeletes;


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
