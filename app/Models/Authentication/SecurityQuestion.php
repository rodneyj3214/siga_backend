<?php

namespace App\Models\Authentication;

// Laravel
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

// Application
use Illuminate\Database\Eloquent\SoftDeletes;

class SecurityQuestion extends Model implements Auditable
{
    use HasFactory;
    use OwenIt\Auditing\Auditable;
    use SoftDeletes;

    protected $connection = 'pgsql-authentication';
    protected $table = 'authentication.security_questions';

    protected $fillable = ['name', 'state'];

    public function users()
    {
        $this->belongsToMany(User::class)->withPivot('answer')->withTimestamps();;
    }

}
