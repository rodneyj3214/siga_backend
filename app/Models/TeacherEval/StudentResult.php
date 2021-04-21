<?php

namespace App\Models\TeacherEval;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use App\Models\App\SubjectTeacher;
use App\Models\App\Student;


class StudentResult extends Model implements Auditable
{
    use Auditing;
    use HasFactory;

    protected $connection = 'pgsql-teacher-eval';

    public function subjectTeacher()
    {
        return $this->belongsTo(SubjectTeacher::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }


    public function answerQuestion()
    {
        return $this->belongsTo(AnswerQuestion::class);
    }

    public function evaluationType()
    {
        return $this->belongsTo(EvaluationType::class);
    }

    public function schoolPeriod()
    {
        return $this->belongsTo(SchoolPeriod::class);
    }

}
