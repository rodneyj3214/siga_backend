<?php

namespace App\Models\TeacherEval;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;

use App\Models\App\Catalogue;
use Illuminate\Database\Eloquent\SoftDeletes;


class Question extends Model implements Auditable
{
    use Auditing;
    use HasFactory;
    use SoftDeletes;


    protected $connection = 'pgsql-teacher-eval';

    protected $fillable = [
        'code',
        'order',
        'name',
        'description',
    ];

    public function evaluationType()
    {
        return $this->belongsTo(EvaluationType::class);
    }



    public function type()
    {
        return $this->belongsTo(Catalogue::class, 'type_id');
    }

    public function answers()
    {
        return $this->belongsToMany(Answer::class)->withPivot('id')->withTimestamps();
    }

    public function status()
    {
        return $this->belongsTo(Catalogue::class, "status_id");
    }

}
