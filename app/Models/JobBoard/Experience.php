<?php

namespace App\Models\JobBoard;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use \OwenIt\Auditing\Auditable as Auditing;
use App\Models\App\Catalogue;
use App\Models\App\File;
use App\Models\App\Image;

class Experience extends Model implements Auditable
{
    //use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected $connection = 'pgsql-job-board';

    protected $fillable = [
        'employer',
        'position',
        'start_date',
        'end_date',
        'activities',
        'reason_leave',
        'is_working',
    ];
    protected $casts = [
        'start_date' => 'date:Y-m-d',
        'end_date' => 'date:Y-m-d'
    ];
    
    protected $appends = ['full_description'];

    public static function getInstance($id)
    {
        $model = new Experience();
        $model->id = $id;
        return $model;
    }
    public function professional()
    {
        return $this->belongsTo(Professional::class);
    }
    public function area()
    {
        return $this->belongsTo(Catalogue::class);
    }
    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }


}
