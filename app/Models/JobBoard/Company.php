<?php

namespace App\Models\JobBoard;

<<<<<<< HEAD
use App\Traits\StateActiveTrait;
=======
>>>>>>> 33d8fa6204c5bd9235b88ab1a6eefe2fb7bf288a
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\Authentication\User;
<<<<<<< HEAD
=======
use App\Models\App\Catalogue;
>>>>>>> 33d8fa6204c5bd9235b88ab1a6eefe2fb7bf288a

class Company extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
<<<<<<< HEAD
    use StateActiveTrait;
=======
>>>>>>> 33d8fa6204c5bd9235b88ab1a6eefe2fb7bf288a

    protected $connection = 'pgsql-job-board';
    protected $table = 'job_board.companies';


    protected $fillable = [
        'trade_name',
        'comercial_activity',
<<<<<<< HEAD
        'web_page'
=======
        'web',
>>>>>>> 33d8fa6204c5bd9235b88ab1a6eefe2fb7bf288a
    ];



    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

<<<<<<< HEAD
=======

>>>>>>> 33d8fa6204c5bd9235b88ab1a6eefe2fb7bf288a
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function type()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function activityType()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function personType()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function professionals()
    {
        return $this->belongsToMany(Professional::class)->withTimestamps();
    }
}
