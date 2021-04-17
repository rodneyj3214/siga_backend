<?php

namespace App\Models\JobBoard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

use App\Traits\StateActiveTrait;

class AcademicFormation extends Model implements Auditable
{

    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use StateActiveTrait;

    protected $connection = 'pgsql-job-board';
    protected $table = 'job_board.academic_formations';

    protected $fillable = [
        'registration_date',
        'senescyt_code',
        'has_titling',
    ];

    protected $casts = [
        'registration_date' => 'datetime'
    ];

    public function professional()
    {
        return $this->belongsTo(Professional::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
