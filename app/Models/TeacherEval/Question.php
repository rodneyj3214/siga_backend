<?php

namespace App\Models\TeacherEval;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

use App\Models\App\Catalogue;
use App\Traits\StatusActiveTrait;


class Question extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use StatusActiveTrait;


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
