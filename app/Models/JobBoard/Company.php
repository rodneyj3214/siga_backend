<?php

namespace App\Models\JobBoard;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\Authentication\User;
use App\Models\App\Catalogue;


class Company extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;

    protected $connection = 'pgsql-job-board';
    protected $table = 'job_board.companies';


    protected $fillable = [
        'trade_name',
        'comercial_activity',
        'web',
    ];

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

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
