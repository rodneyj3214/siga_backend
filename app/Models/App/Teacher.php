<?php

namespace App\Models\App;

// Laravel
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

// Traits State
use App\Traits\StateActiveTrait;


// Models
use App\Models\Authentication\User;
use App\Models\Attendance\Attendance;

class Teacher extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use StateActiveTrait;


    protected $connection = 'pgsql-app';
    protected $table = 'app.teachers';

    protected $fillable = ['state'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function attendances()
    {
        return $this->morphMany(Attendance::class, 'attendanceable');
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
