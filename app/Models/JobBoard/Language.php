<?php

namespace App\Models\JobBoard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

use App\Traits\StateActiveTrait;

class Language extends Model implements Auditable
{

    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use StateActiveTrait;

    protected $connection = 'pgsql-job-board';
    protected $table = 'job_board.languages';

    protected $fillable = [];
    protected $guarded = [
        'state',
    ];

    public function professional()
    {
        return $this->belongsTo(Professional::class);
    }

    public function writtenLevel()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function spokenLevel()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function readingLevel()
    {
        return $this->belongsTo(Catalogue::class);
    }
}