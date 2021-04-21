<?php

namespace App\Models\TeacherEval;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;

use App\Models\App\Catalogue;
use Illuminate\Database\Eloquent\SoftDeletes;

class Answer extends Model implements Auditable
{
    use Auditing;
    use HasFactory;
    use SoftDeletes;


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
