<?php

namespace App\Models\Authentication;

// Laravel
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;

class Shortcut extends Model implements Auditable
{
    use HasFactory;
    use Auditing;

    protected $connection = 'pgsql-authentication';
    protected $table = 'authentication.shortcuts';

    protected $fillable = ['name', 'description', 'image', 'state'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function route()
    {
        return $this->belongsTo(Route::class);
    }

    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }
}
