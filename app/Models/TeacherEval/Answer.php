<?php

namespace App\Models\TeacherEval;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

use App\Models\App\Catalogue;
use App\Traits\StateActiveTrait;


class Answer extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use StateActiveTrait;


    protected $connection = 'pgsql-teacher-eval';
    protected $table = 'teacher_eval.answers';

    protected $fillable = [
        'code',
        'order',
        'name',
        'value',
    ];



    public function questions()
    {
        return $this->belongsToMany(Question::class)->withTimestamps();
    }

    public function status()
    {
        return $this->belongsTo(Catalogue::class);
    }

}
