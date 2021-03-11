<?php

namespace App\Models\App;

// Laravel
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

// Application
use App\Models\Authentication\User;
use App\Traits\StatusActiveTrait;


class AdministrativeStaff extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use StatusActiveTrait;


    protected $connection = 'pgsql-app';
    protected $table = 'app.administrative_staff';

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
