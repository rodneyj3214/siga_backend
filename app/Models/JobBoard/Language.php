<?php

namespace App\Models\JobBoard;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use \OwenIt\Auditing\Auditable as Auditing;
use Brick\Math\BigInteger;
use App\Models\App\Catalogue;

/**
 * @property BigInteger id
 */
class Language extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected $connection = 'pgsql-job-board';
    protected $table = 'job_board.languages';

    public static function getInstance($id)
    {
        $model = new Language();
        $model->id = $id;
        return $model;
    }

    public function professional()
    {
        return $this->belongsTo(Professional::class);
    }

    public function language()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function writtenLevel()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function spokenLevel()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function readLevel()
    {
        return $this->belongsTo(Catalogue::class);
    }
}